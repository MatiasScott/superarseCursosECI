<?php
class PagoController
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

    /**
     * Muestra la pasarela de Payphone con el botón de pago
     * Los datos vienen desde la sesión establecida por InscripcionController
     */
    public function payphone()
    {
        // Verificar si viene desde el callback (success/failure)
        $status = $_GET['status'] ?? null;

        if ($status === 'success') {
            $this->pagoExitoso();
            exit();
        } elseif ($status === 'failure') {
            $this->pagoFallido();
            exit();
        }

        // Verificar que se haya iniciado el proceso de pago correctamente
        if (!isset($_SESSION['datos_pago_payphone'])) {
            echo "Acceso directo a la pasarela no permitido. Inicia el pago desde el curso.";
            exit();
        }

        // Recuperar datos de la sesión
        $datosPago = $_SESSION['datos_pago_payphone'];
        $clientTransactionId = $datosPago['clientTransactionId'];
        $fechaHora = date('Y-m-d H:i:s'); // Fecha y hora actual con segundos
        $amount = $datosPago['amount'];
        $amountWithoutTax = $datosPago['amountWithoutTax'];
        $tax = $datosPago['tax'];
        $referencia = $datosPago['referencia'];
        $curso = $datosPago['curso_titulo'];

        // Cargar la vista de la pasarela
        require_once '../app/views/pago/payphone.php';
    }

    /**
     * Muestra una página de éxito después del pago
     */
    private function pagoExitoso()
    {
        $id_transaccion = $_GET['id'] ?? null;
        $clientTransactionId = $_GET['clientTransactionId'] ?? null;

        if ($id_transaccion && $clientTransactionId) {
            // Actualizar el pago en la base de datos
            $sql = "UPDATE pagos 
                    SET payphone_id_transaccion = :payphone_id,
                        estado_pago = 'aprobado'
                    WHERE payphone_client_transaction_id = :client_id";
            
            $db = Database::conectar();
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':payphone_id' => $id_transaccion,
                ':client_id' => $clientTransactionId
            ]);

            // Obtener información de la inscripción y actualizar su estado
            $sqlInscripcion = "SELECT i.id_inscripcion, i.id_usuario, i.id_curso
                              FROM inscripciones i
                              JOIN pagos p ON i.id_inscripcion = p.id_inscripcion
                              WHERE p.payphone_client_transaction_id = :client_id";
            
            $stmt = $db->prepare($sqlInscripcion);
            $stmt->execute([':client_id' => $clientTransactionId]);
            $inscripcion = $stmt->fetch(PDO::FETCH_OBJ);

            if ($inscripcion) {
                // Actualizar estado de inscripción
                $sqlUpdateInscripcion = "UPDATE inscripciones 
                                        SET estado_pago = 'pagado',
                                            estado_academico = 'cursando'
                                        WHERE id_inscripcion = :id";
                $db->prepare($sqlUpdateInscripcion)->execute([':id' => $inscripcion->id_inscripcion]);

                // Descontar cupo del curso
                $sqlCupo = "UPDATE cursos 
                           SET cupos_disponibles = cupos_disponibles - 1 
                           WHERE id_curso = :id_curso AND cupos_disponibles > 0";
                $db->prepare($sqlCupo)->execute([':id_curso' => $inscripcion->id_curso]);
            }
        }

        // Limpiar sesión
        unset($_SESSION['datos_pago_payphone']);

        // Mostrar vista de éxito
        $mensaje = "¡Pago procesado exitosamente!";
        $tipo = "success";
        require_once '../app/views/pago/resultado.php';
    }

    /**
     * Muestra una página de error cuando el pago falla
     */
    private function pagoFallido()
    {
        // Limpiar sesión
        unset($_SESSION['datos_pago_payphone']);

        // Mostrar vista de error
        $mensaje = "El pago no pudo ser procesado. Por favor, intenta nuevamente.";
        $tipo = "error";
        require_once '../app/views/pago/resultado.php';
    }
}
