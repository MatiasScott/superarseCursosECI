<?php
class UsuarioController
{
    private $modelo;

    public function __construct()
    {
        require_once '../app/models/UsuarioModel.php';
        $this->modelo = new UsuarioModel();
    }

    // Este método solo MUESTRA la vista
    public function login()
    {
        $css_especifico = 'login';
        require_once '../app/views/login.php';
    }

    // Este método PROCESA el formulario (lo que antes tenías dentro del if)
    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $user = $this->modelo->buscarPorEmail($email);

            if ($user && password_verify($pass, $user->password)) {
                $_SESSION['user_id'] = $user->id_usuario;
                $_SESSION['rol'] = $user->rol;
                $_SESSION['nombre'] = $user->nombre;

                // --- LÓGICA DE REDIRECCIÓN INTELIGENTE ---
                if ($user->rol == 'estudiante' && isset($_SESSION['registro_pendiente'])) {
                    $id_curso = $_SESSION['registro_pendiente']['id_curso'];
                    unset($_SESSION['registro_pendiente']); // Limpiamos la sesión

                    // Redirigimos de vuelta al curso para que finalice la inscripción
                    header("Location: " . URL_BASE . "curso/detalle/" . $id_curso . "?auth=success");
                    exit;
                }

                // Redirección normal si no hay pendientes
                $ruta = ($user->rol == 'admin') ? 'admin/pagos' : 'estudiante/mis_cursos';
                header("Location: " . URL_BASE . $ruta);
                exit;
                // -----------------------------------------

            } else {
                $error = "Credenciales incorrectas";
                $css_especifico = 'login';
                require_once '../app/views/login.php';
            }
        }
    }

    public function logout()
    {
        // Iniciar sesión si no está iniciada para poder destruirla
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Limpiar todas las variables de sesión
        $_SESSION = array();

        // Destruir la cookie de sesión si existe
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destruir la sesión físicamente en el servidor
        session_destroy();

        // Redirigir al login
        header("Location: " . URL_BASE);
        exit;
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recoger datos del formulario
            $datos = [
                'cedula_ruc' => trim($_POST['cedula_ruc']),
                'nombre'     => trim($_POST['nombre']),
                'apellido'   => trim($_POST['apellido']),
                'email'      => trim($_POST['email']),
                'password'   => $_POST['password'],
                'rol'        => 'estudiante'
            ];

            // Validar que el email no exista
            if ($this->modelo->existeEmail($datos['email'])) {
                $error = "El correo electrónico ya está registrado. Usa otro o inicia sesión.";
                $css_especifico = 'login';
                require_once '../app/views/usuario/registro.php';
                return;
            }

            // Validar que la cédula/ruc no esté vacía
            if (empty($datos['cedula_ruc'])) {
                $error = "El campo Cédula/RUC es obligatorio.";
                $css_especifico = 'login';
                require_once '../app/views/usuario/registro.php';
                return;
            }

            // Validar que la cédula/ruc no exista
            if ($this->modelo->existeCedula($datos['cedula_ruc'])) {
                $error = "La cédula/RUC ya está registrada. Usa otra o inicia sesión.";
                $css_especifico = 'login';
                require_once '../app/views/usuario/registro.php';
                return;
            }

            // Guardar en la base de datos a través del modelo
            $id_nuevo_usuario = $this->modelo->registrar($datos);

            if ($id_nuevo_usuario) {
                // Iniciamos la sesión automáticamente
                $_SESSION['user_id'] = $id_nuevo_usuario;
                $_SESSION['nombre']  = $datos['nombre'];
                $_SESSION['rol']     = 'estudiante';

                // --- Lógica de Retorno ---
                if (isset($_SESSION['registro_pendiente'])) {
                    $id_curso = $_SESSION['registro_pendiente']['id_curso'];
                    // Lo mandamos directo al curso para que pague
                    header("Location: " . URL_BASE . "curso/detalle/" . $id_curso);
                    exit;
                }

                // Si no tenía nada pendiente, va a su panel
                header("Location: " . URL_BASE . "estudiante/mis_cursos");
                exit;
            } else {
                // Manejar error (email duplicado, etc)
                $error = "No se pudo crear la cuenta. Intente con otro correo.";
                require_once '../app/views/usuario/registro.php';
            }
        }
    }

    public function acceso_inscripcion()
    {
        // Usamos la misma lógica que en tus otros métodos
        $css_especifico = 'login'; // Para que cargue los estilos de login.css que definimos
        require_once '../app/views/usuario/acceso_inscripcion.php';
    }

    public function registro()
    {
        $css_especifico = 'login';
        require_once '../app/views/usuario/registro.php';
    }
}
