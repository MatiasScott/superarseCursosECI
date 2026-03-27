<?php
class EstudianteController {
    private $modeloInscripcion;
    private $modeloCurso;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Seguridad: Solo estudiantes entran aquí
        if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'estudiante') {
            header("Location: " . URL_BASE . "usuario/login");
            exit;
        }
        require_once '../app/models/InscripcionModel.php';
        require_once '../app/models/CursoModel.php';
        $this->modeloInscripcion = new InscripcionModel();
        $this->modeloCurso = new CursoModel();
    }

    // 1. VISTA: Mis Cursos (Solo los pagados/en curso)
    public function mis_cursos() {
        $id_usuario = $_SESSION['user_id'];
        $mis_inscripciones_all = $this->modeloInscripcion->listarPorEstudiante($id_usuario);
        // Paginación
        $por_pagina = 10;
        $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
        $total = count($mis_inscripciones_all);
        $total_paginas = ceil($total / $por_pagina);
        $inicio = ($pagina - 1) * $por_pagina;
        $mis_inscripciones = array_slice($mis_inscripciones_all, $inicio, $por_pagina);
        $css_especifico = 'estudiante';
        require_once '../app/views/estudiante/mis_cursos.php';
    }

    // 2. VISTA: Historial de Pagos (Detalle de transferencias y PayPhone)
    public function mis_pagos() {
        $id_usuario = $_SESSION['user_id'];
        $mis_pagos_all = $this->modeloInscripcion->listarPagosPorUsuario($id_usuario);
        // Paginación
        $por_pagina = 10;
        $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
        $total = count($mis_pagos_all);
        $total_paginas = ceil($total / $por_pagina);
        $inicio = ($pagina - 1) * $por_pagina;
        $mis_pagos = array_slice($mis_pagos_all, $inicio, $por_pagina);
        $css_especifico = 'estudiante';
        require_once '../app/views/estudiante/mis_pagos.php';
    }

    // Alias para compatibilidad con la URL /estudiante/pagos
    public function pagos() {
        $this->mis_pagos();
    }

    // 3. VISTA: Catálogo (Listado limpio para inscribirse a nuevos)
    public function catalogo() {
        $cursos = $this->modeloCurso->listarCursosPublicos();
        // Asociar precios de modalidad a cada curso
        if (!empty($cursos) && is_array($cursos)) {
            foreach ($cursos as &$curso) {
                $modalidades = $this->modeloCurso->obtenerModalidadesPorCurso($curso->id_curso);
                $curso->precio_intensivo = 0;
                $curso->precio_presencial = 0;
                $curso->precio_hibrida = 0;
                foreach ($modalidades as $mod) {
                    if (stripos($mod->nombre, 'intensivo') !== false) $curso->precio_intensivo = $mod->precio;
                    if (stripos($mod->nombre, 'presencial') !== false) $curso->precio_presencial = $mod->precio;
                    if (stripos($mod->nombre, 'híbrida') !== false || stripos($mod->nombre, 'hibrida') !== false) $curso->precio_hibrida = $mod->precio;
                }
            }
            unset($curso);
        }
        $css_especifico = 'estudiante';
        require_once '../app/views/estudiante/catalogo.php';
    }
    
    // 4. VISTA: Dashboard del estudiante
    public function dashboard() {
        $id_usuario = $_SESSION['user_id'];
        // Inscripciones activas
        $inscripciones = $this->modeloInscripcion->listarPorEstudiante($id_usuario);
        // Pagos por estado
        $pagos = $this->modeloInscripcion->listarPagosPorUsuario($id_usuario);
        $pagos_pendientes = array_filter($pagos, function($p) { return $p->estado_pago === 'pendiente'; });
        $pagos_aprobados = array_filter($pagos, function($p) { return $p->estado_pago === 'aprobado'; });
        $pagos_rechazados = array_filter($pagos, function($p) { return $p->estado_pago === 'rechazado'; });
        $css_especifico = 'estudiante';
        require_once '../app/views/estudiante/dashboard.php';
    }

        // 5. VISTA: Perfil del estudiante
        public function perfil() {
            $css_especifico = 'estudiante';
            require_once '../app/views/estudiante/perfil.php';
        }
}