<?php
class AdminController {
    // Eliminar inscripción completa
    public function eliminar_inscripcion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_inscripcion = $_POST['id_inscripcion'];
            if ($this->modeloInscripcion->eliminarInscripcionPorId($id_inscripcion)) {
                header("Location: " . URL_BASE . "admin/alumnos?msj=eliminado");
            } else {
                echo "Error al eliminar la inscripción.";
            }
        }
    }
    // Modificar nota y/o certificado desde el modal
    public function modificar_inscripcion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_inscripcion = $_POST['id_inscripcion'];
            $nota = isset($_POST['nota']) ? $_POST['nota'] : null;
            $nombre_archivo = null;
            $estado = ($nota !== null && $nota >= 7) ? 'aprobado' : 'reprobado';

            // Si se sube un nuevo certificado
            if (isset($_FILES['certificado']) && $_FILES['certificado']['error'] === UPLOAD_ERR_OK) {
                $directorio = dirname(__DIR__, 2) . "/public/uploads/certificados/";
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }
                $nombre_archivo = time() . "_" . basename($_FILES['certificado']['name']);
                $ruta_completa = $directorio . $nombre_archivo;
                if (!move_uploaded_file($_FILES['certificado']['tmp_name'], $ruta_completa)) {
                    die("Error al mover el archivo al servidor.");
                }
            }

            // Actualizar en la base de datos
            if ($this->modeloInscripcion->actualizarNotaCertificado($id_inscripcion, $nota, $estado, $nombre_archivo)) {
                header("Location: " . URL_BASE . "admin/alumnos?msj=modificado");
            } else {
                echo "Error al modificar la inscripción.";
            }
        }
    }
        // Eliminar curso
        public function eliminar_curso($id)
        {
            if ($this->modeloCurso->eliminarPorId($id)) {
                header("Location: " . URL_BASE . "admin/cursos?status=deleted");
                exit;
            } else {
                die("Error al eliminar el curso");
            }
        }
    private $modeloInscripcion;
    private $modeloCurso;
    private $modeloUsuario;

    public function __construct()
    {
        // Seguridad: Solo admin
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header("Location: " . URL_BASE . "usuario/login");
            exit;
        }
        require_once '../app/models/CursoModel.php';
        require_once '../app/models/InscripcionModel.php';
        require_once '../app/models/UsuarioModel.php';
        $this->modeloCurso = new CursoModel();
        $this->modeloInscripcion = new InscripcionModel();
        $this->modeloUsuario = new UsuarioModel();
    }

    // ================= GESTIÓN DE USUARIOS =================

    // Listado con filtros por rol y búsqueda
    public function usuarios()
    {
        $filtro_rol = isset($_GET['rol']) ? $_GET['rol'] : '';
        $busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

        $usuarios = $this->modeloUsuario->listarUsuarios($filtro_rol, $busqueda);
        $total_admins = $this->modeloUsuario->contarAdmins();

        $css_especifico = 'admin';
        require_once '../app/views/admin/usuarios.php';
    }

    // Formulario de alta
    public function crear_usuario()
    {
        $css_especifico = 'admin';
        require_once '../app/views/admin/crear_usuario.php';
    }

    // Procesa el alta
    public function guardar_usuario()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: " . URL_BASE . "admin/usuarios");
            exit;
        }

        $datos = [
            'cedula_ruc' => trim($_POST['cedula_ruc'] ?? ''),
            'nombre'     => trim($_POST['nombre'] ?? ''),
            'apellido'   => trim($_POST['apellido'] ?? ''),
            'email'      => trim($_POST['email'] ?? ''),
            'password'   => $_POST['password'] ?? '',
            'telefono'   => trim($_POST['telefono'] ?? ''),
            'rol'        => ($_POST['rol'] ?? '') === 'admin' ? 'admin' : 'estudiante'
        ];

        $error = $this->validarUsuario($datos, null);
        if ($error !== null) {
            header("Location: " . URL_BASE . "admin/crear_usuario?" . $this->parametrosUsuario($datos, $error));
            exit;
        }

        if ($this->modeloUsuario->crear($datos)) {
            header("Location: " . URL_BASE . "admin/usuarios?msj=creado");
        } else {
            header("Location: " . URL_BASE . "admin/crear_usuario?error=" . urlencode("No se pudo crear el usuario."));
        }
        exit;
    }

    // Formulario de edición
    public function editar_usuario($id)
    {
        $usuario = $this->modeloUsuario->obtenerPorId($id);

        if (!$usuario) {
            header("Location: " . URL_BASE . "admin/usuarios?msj=no_encontrado");
            exit;
        }

        $total_inscripciones = $this->modeloUsuario->contarInscripciones($id);

        $css_especifico = 'admin';
        require_once '../app/views/admin/editar_usuario.php';
    }

    // Procesa la edición
    public function guardar_edicion_usuario()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: " . URL_BASE . "admin/usuarios");
            exit;
        }

        $id = intval($_POST['id_usuario'] ?? 0);
        $usuarioActual = $this->modeloUsuario->obtenerPorId($id);

        if (!$usuarioActual) {
            header("Location: " . URL_BASE . "admin/usuarios?msj=no_encontrado");
            exit;
        }

        $datos = [
            'id_usuario' => $id,
            'cedula_ruc' => trim($_POST['cedula_ruc'] ?? ''),
            'nombre'     => trim($_POST['nombre'] ?? ''),
            'apellido'   => trim($_POST['apellido'] ?? ''),
            'email'      => trim($_POST['email'] ?? ''),
            'password'   => $_POST['password'] ?? '',
            'telefono'   => trim($_POST['telefono'] ?? ''),
            'rol'        => ($_POST['rol'] ?? '') === 'admin' ? 'admin' : 'estudiante'
        ];

        $error = $this->validarUsuario($datos, $id);
        if ($error !== null) {
            header("Location: " . URL_BASE . "admin/editar_usuario/" . $id . "?" . $this->parametrosUsuario($datos, $error));
            exit;
        }

        // No dejar el sistema sin administradores
        if ($usuarioActual->rol === 'admin' && $datos['rol'] !== 'admin' && $this->modeloUsuario->contarAdmins($id) === 0) {
            header("Location: " . URL_BASE . "admin/editar_usuario/" . $id . "?error=" . urlencode("Debe existir al menos un administrador en el sistema."));
            exit;
        }

        if ($this->modeloUsuario->actualizar($datos)) {
            header("Location: " . URL_BASE . "admin/usuarios?msj=actualizado");
        } else {
            header("Location: " . URL_BASE . "admin/editar_usuario/" . $id . "?error=" . urlencode("No se pudo actualizar el usuario."));
        }
        exit;
    }

    // Elimina un usuario
    public function eliminar_usuario()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: " . URL_BASE . "admin/usuarios");
            exit;
        }

        $id = intval($_POST['id_usuario'] ?? 0);
        $usuario = $this->modeloUsuario->obtenerPorId($id);

        if (!$usuario) {
            header("Location: " . URL_BASE . "admin/usuarios?msj=no_encontrado");
            exit;
        }

        // No permitir borrarse a uno mismo
        if (isset($_SESSION['user_id']) && intval($_SESSION['user_id']) === $id) {
            header("Location: " . URL_BASE . "admin/usuarios?msj=error_propio");
            exit;
        }

        // No dejar el sistema sin administradores
        if ($usuario->rol === 'admin' && $this->modeloUsuario->contarAdmins($id) === 0) {
            header("Location: " . URL_BASE . "admin/usuarios?msj=error_ultimo_admin");
            exit;
        }

        if ($this->modeloUsuario->eliminar($id)) {
            header("Location: " . URL_BASE . "admin/usuarios?msj=eliminado");
        } else {
            header("Location: " . URL_BASE . "admin/usuarios?msj=error_eliminar");
        }
        exit;
    }

    // Valida los campos del usuario. Devuelve el mensaje de error o null si está bien.
    private function validarUsuario($datos, $id_usuario = null)
    {
        if ($datos['cedula_ruc'] === '') {
            return "La cédula/RUC es obligatoria.";
        }
        if (!preg_match('/^[0-9]{10,13}$/', $datos['cedula_ruc'])) {
            return "La cédula/RUC debe tener entre 10 y 13 dígitos.";
        }
        if ($datos['nombre'] === '' || $datos['apellido'] === '') {
            return "El nombre y el apellido son obligatorios.";
        }
        if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            return "El correo electrónico no es válido.";
        }
        if (empty($datos['password']) && $id_usuario === null) {
            return "La contraseña es obligatoria.";
        }
        if (!empty($datos['password']) && strlen($datos['password']) < 6) {
            return "La contraseña debe tener al menos 6 caracteres.";
        }
        if (!empty($datos['telefono']) && !preg_match('/^[0-9]{7,20}$/', $datos['telefono'])) {
            return "El teléfono debe contener solo dígitos (7 a 20).";
        }

        if ($id_usuario === null) {
            if ($this->modeloUsuario->existeEmail($datos['email'])) {
                return "El correo electrónico ya está registrado.";
            }
            if ($this->modeloUsuario->existeCedula($datos['cedula_ruc'])) {
                return "La cédula/RUC ya está registrada.";
            }
        } else {
            if ($this->modeloUsuario->existeEmailExcepto($datos['email'], $id_usuario)) {
                return "El correo electrónico ya pertenece a otro usuario.";
            }
            if ($this->modeloUsuario->existeCedulaExcepto($datos['cedula_ruc'], $id_usuario)) {
                return "La cédula/RUC ya pertenece a otro usuario.";
            }
        }

        return null;
    }

    // Arma los parámetros de la URL para reenviar los datos del formulario al redirigir
    private function parametrosUsuario($datos, $error)
    {
        $params = ['error' => $error];
        foreach (['cedula_ruc', 'nombre', 'apellido', 'email', 'telefono', 'rol'] as $campo) {
            if (isset($datos[$campo])) {
                $params[$campo] = $datos[$campo];
            }
        }
        return http_build_query($params);
    }

    public function dashboard()
    {
        // Obtenemos los datos de los modelos
        $cursos = $this->modeloCurso->listarCursos();
        $pagos = $this->modeloInscripcion->listarPagosPendientes();
        $inscritos = $this->modeloInscripcion->listarInscritosHoy();
        $ingresos = $this->modeloInscripcion->calcularIngresosMes();

        $data = [
            // Aquí sí usamos count porque queremos saber CUÁNTOS hay en la lista
            'total_cursos' => is_array($cursos) ? count($cursos) : 0,
            'pagos_pendientes' => is_array($pagos) ? count($pagos) : 0,
            'inscritos_hoy' => is_array($inscritos) ? count($inscritos) : 0,

            // AQUÍ ESTABA EL ERROR: 
            // 1. Ingresos ya es un número (ej: 150.50), NO uses count.
            'ingresos_mes' => $ingresos !== null ? (float)$ingresos : 0.00,

            // 2. Aquí queremos la LISTA de objetos, NO el número, para el foreach de la tabla.
            'ultimas_inscripciones' => $this->modeloInscripcion->obtenerUltimasInscripciones()
        ];

        require_once '../app/views/admin/dashboard.php';
    }

    public function cursos()
    {
        $cursos = $this->modeloCurso->listarCursos();
        // Para cada curso, obtener sus modalidades
        if (!empty($cursos) && is_array($cursos)) {
            foreach ($cursos as &$curso) {
                $curso->modalidades = $this->modeloCurso->obtenerModalidadesPorCurso($curso->id_curso);
            }
            unset($curso);
        }
        $css_especifico = 'admin';
        require_once '../app/views/admin/cursos.php';
    }

    public function pagos()
    {
        // Obtenemos los pagos con estado 'pendiente'
        $pagos_pendientes = $this->modeloInscripcion->listarPagosPendientes();
        $css_especifico = 'admin'; // Si tienes un admin.css
        require_once '../app/views/admin/pagos.php';
    }

    public function editar_curso($id)
    {
        $curso = $this->modeloCurso->obtenerCursoPorId($id);
        $modalidades = $this->modeloCurso->obtenerModalidadesPorCurso($id);
        $css_especifico = 'admin';
        require_once '../app/views/admin/editar_curso.php';
    }

    public function guardar_edicion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_curso = $_POST['id_curso'];
            $cursoActual = $this->modeloCurso->obtenerCursoPorId($id_curso);

            // Lógica de la imagen
            $directorioDestino = dirname(__DIR__, 2) . "/public/img/cursos/";


            // Si se sube una nueva imagen, usarla. Si no, mantener la actual.
            if (!empty($_FILES['imagen_portada']['name'])) {
                $nombreImagen = time() . "_" . basename($_FILES['imagen_portada']['name']);
                if (move_uploaded_file($_FILES['imagen_portada']['tmp_name'], $directorioDestino . $nombreImagen)) {
                    $imagen_portada_final = $nombreImagen;
                } else {
                    $imagen_portada_final = $_POST['imagen_portada_actual'] ?? $cursoActual->imagen_portada;
                }
            } else {
                $imagen_portada_final = $_POST['imagen_portada_actual'] ?? $cursoActual->imagen_portada;
            }

            // Calcular suma de cupos de modalidades
            $suma_cupos = 0;
            if (!empty($_POST['modalidades']) && is_array($_POST['modalidades'])) {
                foreach ($_POST['modalidades'] as $mod) {
                    $suma_cupos += isset($mod['cupos']) ? intval($mod['cupos']) : 0;
                }
            }
            $datos = [
                'id_curso'          => $id_curso,
                'titulo'            => $_POST['titulo'] ?? '',
                'descripcion_corta' => $_POST['descripcion_corta'] ?? '',
                'contenido_detallado' => $_POST['contenido_detallado'] ?? '',
                'objetivos'         => $_POST['objetivos'] ?? '',
                'programa'          => $_POST['programa'] ?? '',
                'requisitos'        => $_POST['requisitos'] ?? '',
                'incluye'           => $_POST['incluye'] ?? '',
                'cupos_totales'     => $suma_cupos,
                'cupos_disponibles' => $suma_cupos,
                'fecha_inicio'      => !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : $cursoActual->fecha_inicio,
                'fecha_fin'         => !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : $cursoActual->fecha_fin,
                'fecha_limite_inscripcion' => $_POST['fecha_limite_inscripcion'] ?? null,
                'imagen_portada'    => $imagen_portada_final,
                'estado'            => $_POST['estado'] ?? 'activo'
            ];

            if ($this->modeloCurso->actualizarCursoCompleto($datos)) {
                // Procesar modalidades dinámicamente desde el formulario
                $modalidades = [];
                $suma_cupos = 0;
                if (!empty($_POST['modalidades']) && is_array($_POST['modalidades'])) {
                    foreach ($_POST['modalidades'] as $mod) {
                        $cupos_mod = isset($mod['cupos']) ? intval($mod['cupos']) : 0;
                        $suma_cupos += $cupos_mod;
                        $modalidades[] = [
                            'id' => $mod['id'] ?? null,
                            'nombre' => $mod['nombre'] ?? '',
                            'precio' => $mod['precio'] ?? 0,
                            'descripcion' => $mod['descripcion'] ?? '',
                            'horarios' => $mod['horarios'] ?? '',
                            'cupos' => $cupos_mod
                        ];
                    }
                }
                // Ya no se valida contra cupos_totales, porque ahora se calcula automáticamente
                $this->modeloCurso->guardarModalidades($id_curso, $modalidades);
                header("Location: " . URL_BASE . "admin/cursos?status=updated");
            } else {
                die("Error al actualizar el curso");
            }
        }
    }

    public function aprobar_pago()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_pago = $_POST['id_pago'];

            require_once '../app/models/InscripcionModel.php';
            $modeloInscripcion = new InscripcionModel();

            if ($modeloInscripcion->confirmarPago($id_pago)) {
                // Redirigir de vuelta con un mensaje de éxito
                header("Location: " . URL_BASE . "admin/pagos?status=success");
            } else {
                echo "Error al procesar el pago.";
            }
        }
    }

    public function alumnos()
    {
        $inscripciones = $this->modeloInscripcion->listarTodasParaAdmin();
        $css_especifico = 'admin';
        require_once '../app/views/admin/alumnos.php';
    }

    public function calificar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_inscripcion = $_POST['id_inscripcion'];
            $nota = $_POST['nota'];
            $estado = ($nota >= 7) ? 'aprobado' : 'reprobado';

            $nombre_archivo = null;

            // Verificar si se subió un archivo
            if (isset($_FILES['certificado']) && $_FILES['certificado']['error'] === UPLOAD_ERR_OK) {
                $directorio = dirname(__DIR__, 2) . "/public/uploads/certificados/";

                // Crear carpeta si no existe
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombre_archivo = time() . "_" . basename($_FILES['certificado']['name']);
                $ruta_completa = $directorio . $nombre_archivo;

                if (!move_uploaded_file($_FILES['certificado']['tmp_name'], $ruta_completa)) {
                    die("Error al mover el archivo al servidor.");
                }
            }

            // Actualizar en la base de datos
            if ($this->modeloInscripcion->actualizarNotaCertificado($id_inscripcion, $nota, $estado, $nombre_archivo)) {
                header("Location: " . URL_BASE . "admin/alumnos?msj=actualizado");
            } else {
                echo "Error al actualizar la base de datos.";
            }
        }
    }

    public function crear_curso()
    {
        $css_especifico = 'admin';
        require_once '../app/views/admin/crear_curso.php';
    }

    public function guardar_curso()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Manejo de la imagen
            $imagen = 'default.jpg';
            if (!empty($_FILES['imagen_portada']['name'])) {
                $imagen = time() . "_" . $_FILES['imagen_portada']['name'];
                move_uploaded_file($_FILES['imagen_portada']['tmp_name'], "../public/img/cursos/" . $imagen);
            }

            // Calcular suma de cupos de modalidades
            $suma_cupos = 0;
            if (!empty($_POST['cupos_modalidad']) && is_array($_POST['cupos_modalidad'])) {
                foreach ($_POST['cupos_modalidad'] as $cupos_mod) {
                    $suma_cupos += intval($cupos_mod);
                }
            }
            $datos = [
                'titulo' => $_POST['titulo'] ?? '',
                'descripcion_corta' => $_POST['descripcion_corta'] ?? '',
                'contenido_detallado' => $_POST['contenido_detallado'] ?? '',
                'cupos_totales' => $suma_cupos,
                'cupos_disponibles' => $suma_cupos,
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'fecha_fin' => $_POST['fecha_fin'] ?? '',
                'fecha_limite_inscripcion' => $_POST['fecha_limite_inscripcion'] ?? '',
                'imagen_portada' => $imagen,
                'objetivos' => $_POST['objetivos'] ?? '',
                'programa' => $_POST['programa'] ?? '',
                'requisitos' => $_POST['requisitos'] ?? '',
                'incluye' => $_POST['incluye'] ?? '',
                'estado' => 'activo'
            ];


            if ($this->modeloCurso->insertarCurso($datos)) {
                // Obtener el id del curso recién insertado
                $id_curso = $this->modeloCurso->db->lastInsertId();
                $modalidades = [];
                $n = count($_POST['modalidad']);
                $suma_cupos = 0;
                for ($i = 0; $i < $n; $i++) {
                    $cupos_mod = isset($_POST['cupos_modalidad'][$i]) ? intval($_POST['cupos_modalidad'][$i]) : 0;
                    $suma_cupos += $cupos_mod;
                    $modalidades[] = [
                        'nombre' => $_POST['modalidad'][$i],
                        'precio' => $_POST['precio'][$i],
                        'descripcion' => $_POST['descripcion'][$i],
                        'horarios' => $_POST['horarios'][$i],
                        'cupos' => $cupos_mod
                    ];
                }
                // Ya no se valida contra cupos_totales, porque ahora se calcula automáticamente
                $this->modeloCurso->guardarModalidades($id_curso, $modalidades);
                header("Location: " . URL_BASE . "admin/cursos?msj=creado");
            } else {
                echo "Error al crear el curso";
            }
        }
    }
}
