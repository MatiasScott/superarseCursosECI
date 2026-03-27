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

    public function __construct()
    {
        // Seguridad: Solo admin
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header("Location: " . URL_BASE . "usuario/login");
            exit;
        }
        require_once '../app/models/CursoModel.php';
        require_once '../app/models/InscripcionModel.php';
        $this->modeloCurso = new CursoModel();
        $this->modeloInscripcion = new InscripcionModel();
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
