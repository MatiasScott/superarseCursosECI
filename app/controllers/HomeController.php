<?php
class HomeController
{
    private $modelo;

    public function __construct()
    {
        require_once '../app/models/CursoModel.php';
        $this->modelo = new CursoModel();
    }

    // Muestra la Landing Page principal
    public function index()
    {
        $cursos = $this->modelo->listarCursosPublicos();
        // Obtener modalidades para cada curso
        foreach ($cursos as $curso) {
            $curso->modalidades = $this->modelo->obtenerModalidadesPorCurso($curso->id_curso);
        }
        // Definimos el nombre del archivo CSS (sin la extensión .css)
        $css_especifico = 'home';

        require_once '../app/views/home/index.php';
    }

    // Ver detalle de un curso
    public function detalle($id)
    {
        $curso = $this->modelo->obtenerCursoPorId($id);

        if (!$curso) {
            // Si el curso no existe, redirigir al inicio
            header('Location: ' . URL_BASE);
            exit;
        }

        // Cargar modalidades del curso
        $modalidades = $this->modelo->obtenerModalidadesPorCurso($id);

        // Definimos el CSS para esta página
        $css_especifico = 'detalle';

        require_once '../app/views/home/detalle.php';
    }
}
