<?php
class InscripcionController
{
    private $modeloInscripcion;
    private $modeloCurso;

    public function __construct()
    {
        require_once '../app/models/InscripcionModel.php';
        require_once '../app/models/CursoModel.php';
        $this->modeloInscripcion = new InscripcionModel();
        $this->modeloCurso = new CursoModel();
    }

    // Punto de entrada único del formulario
    public function procesar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();

            // Si NO hay sesión, guardamos el POST y mandamos al login
            if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
                $_SESSION['registro_pendiente'] = $_POST;
                header("Location: " . URL_BASE . "usuario/acceso_inscripcion");
                exit;
            }

            // Validar que el usuario existe en la base de datos
            $id_usuario = $_SESSION['user_id'];
            $usuarioValido = $this->modeloInscripcion->usuarioExiste($id_usuario);
            if (!$usuarioValido) {
                echo '<div style="color:red;text-align:center;margin:2em auto;font-size:1.2em;">Error: El usuario no existe. Por favor, inicia sesión nuevamente.</div>';
                exit;
            }

            // Guardar modalidad y horario en sesión temporal para TODOS los cursos
            $id_curso = $_POST['id_curso'];
            $curso = $this->modeloCurso->obtenerCursoPorId($id_curso);
            $_SESSION['modalidad'] = $_POST['modalidad'] ?? null;
            $_SESSION['horario'] = $_POST['horario'] ?? null;
            $_SESSION['precio_modalidad'] = $_POST['precio_modalidad'] ?? $curso->precio;

            // Validar modalidad obligatoria
            if (empty($_POST['modalidad']) || empty($_POST['precio_modalidad'])) {
                $_SESSION['error_inscripcion'] = 'Debes seleccionar una modalidad para continuar.';
                header("Location: " . URL_BASE . "home/detalle/" . $_POST['id_curso']);
                exit;
            }

            $metodo = $_POST['metodo'];
            if ($metodo === 'transferencia') {
                $this->pagarTransferencia();
            } elseif ($metodo === 'payphone') {
                $this->iniciarPagoPayphone($id_curso);
            }
        }
    }

    private function pagarTransferencia()
    {
        $id_curso = $_POST['id_curso'];
        $id_usuario = $_SESSION['user_id'];
        $curso = $this->modeloCurso->obtenerCursoPorId($id_curso);

        // 1. Subir el comprobante
        $nombreArchivo = time() . "_" . $_FILES['comprobante']['name'];
        $rutaDestino = "../public/uploads/comprobantes/" . $nombreArchivo;

        if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $rutaDestino)) {
            // 2. Crear inscripción (con modalidad y horario si aplica)
            $modalidad = $_SESSION['modalidad'] ?? null;
            $horario = $_SESSION['horario'] ?? null;
            $precio = (!empty($_SESSION['precio_modalidad']))
            ? floatval($_SESSION['precio_modalidad'])
            : floatval($curso->precio);
            $id_ins = $this->modeloInscripcion->crearInscripcion($id_usuario, $id_curso, $modalidad, $horario);

            // 3. Registrar Pago Pendiente (según tu tabla 'pagos')
            $datosPago = [
                ':id_ins'      => $id_ins,
                ':metodo'      => 'transferencia',
                ':monto'       => $precio,
                ':comprobante' => $nombreArchivo,
                ':payphone_id' => null,
                ':client_id'   => null,
                ':estado'      => 'pendiente',
                ':tipo'        => 'manual'
            ];

            if ($this->modeloInscripcion->registrarPago($datosPago)) {
                unset($_SESSION['modalidad'], $_SESSION['horario'], $_SESSION['precio_modalidad']);
                header("Location: " . URL_BASE . "estudiante/mis_cursos?inscripcion=exitosa");
                exit;
            }
        }
    }

    public function iniciarPagoPayphone($id_curso)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $curso = $this->modeloCurso->obtenerCursoPorId($id_curso);
        $id_usuario = $_SESSION['user_id'];
        $clientTxId = uniqid('TX-');

        // Modalidad y horario si aplica
        $modalidad = $_SESSION['modalidad'] ?? null;
        $horario = $_SESSION['horario'] ?? null;
        $precio = $_SESSION['precio_modalidad'] ?? $curso->precio;

        // 1. Crear la inscripción primero (estado pendiente)
        $id_ins = $this->modeloInscripcion->crearInscripcion($id_usuario, $id_curso, $modalidad, $horario);

        // 2. Calcular montos (en centavos para Payphone)
        $amount = round($precio * 100); // Total en centavos
        $amountWithoutTax = round($precio * 100); // Sin impuestos por ahora
        $tax = 0; // IVA si aplica

        // 3. Registrar el intento de pago en la BDD
        $datosPago = [
            ':id_ins'   => $id_ins,
            ':metodo'   => 'payphone',
            ':monto'    => $precio,
            ':comprobante' => null,
            ':client_id' => $clientTxId,
            ':payphone_id' => null,
            ':estado'   => 'pendiente',
            ':tipo'     => 'automatica'
        ];
        $this->modeloInscripcion->registrarPago($datosPago);

        // 4. Guardar datos en sesión para la pasarela
        $_SESSION['datos_pago_payphone'] = [
            'clientTransactionId' => $clientTxId,
            'amount' => $amount,
            'amountWithoutTax' => $amountWithoutTax,
            'tax' => $tax,
            'referencia' => 'Inscripción curso: ' . $curso->titulo . ' / $' . number_format($precio, 2),
            'curso_titulo' => $curso->titulo,
            'id_inscripcion' => $id_ins
        ];

        unset($_SESSION['modalidad'], $_SESSION['horario'], $_SESSION['precio_modalidad']);

        // 5. Redirigir a la pasarela de pago
        header("Location: " . URL_BASE . "pago/payphone");
        exit;
    }

    public function confirmar()
    {
        // PayPhone envía el ID por GET al retornar
        $id_pago_payphone = $_GET['id'] ?? null;
        $client_tx_id = $_GET['clientTransactionId'] ?? null;

        if ($id_pago_payphone) {
            // Consultar el estado real del pago en PayPhone
            $ch = curl_init("https://pay.payphonetodoesposible.com/api/button/V2/Confirm");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['id' => (int)$id_pago_payphone, 'clientTransactionId' => $client_tx_id]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . PAYPHONE_TOKEN,
                'Content-Type: application/json'
            ]);

            $response = json_decode(curl_exec($ch));
            curl_close($ch);

            // Si el pago es aprobado (transactionStatus === 'Approved')
            if (isset($response->transactionStatus) && $response->transactionStatus == 'Approved') {

                // Aquí buscas el pago en tu BDD usando el clientTransactionId y lo apruebas
                // Luego descuentas el cupo usando tu modelo

                require_once '../app/views/home/pago_exitoso.php';
            } else {
                echo "El pago no fue aprobado o fue cancelado.";
            }
        }
    }
}
