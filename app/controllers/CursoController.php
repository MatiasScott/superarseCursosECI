<?php
class CursoController
{
    private $modelo;

    public function __construct()
    {
        require_once '../app/models/CursoModel.php';
        $this->modelo = new CursoModel();
    }

    // Muestra la Landing Page
    public function index()
    {
        $cursos = $this->modelo->listarCursosPublicos();
        // Asociar modalidades a cada curso
        if (!empty($cursos) && is_array($cursos)) {
            foreach ($cursos as &$curso) {
                $curso->modalidades = $this->modelo->obtenerModalidadesPorCurso($curso->id_curso);
            }
            unset($curso);
        }
        $css_especifico = 'home';
        require_once '../app/views/home/index.php';
    }

    // Ver detalle de un curso antes de comprar
    public function detalle($id)
    {
        $curso = $this->modelo->obtenerCursoPorId($id);
        $modalidades = $this->modelo->obtenerModalidadesPorCurso($id);

        if (!$curso) {
            // Si el curso no existe, podrías redirigir al inicio
            header('Location: ' . URL_BASE);
            exit;
        }

        // Definimos el CSS para esta página
        $css_especifico = 'detalle';

        require_once '../app/views/home/detalle.php';
    }

    // Guardar nuevo curso (Solo Admin)
    public function crear()
    {
        // Aquí iría la lógica de subir la imagen a public/img/cursos/
        // Y luego llamar a $this->modelo->crear($_POST);
    }
}
