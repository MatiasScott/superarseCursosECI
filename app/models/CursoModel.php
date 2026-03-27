<?php
class CursoModel {
        // Elimina un curso y sus modalidades asociadas
        public function eliminarPorId($id)
        {
            // Eliminar modalidades asociadas primero
            $sqlModalidades = "DELETE FROM cursos_modalidades WHERE id_curso = :id";
            $stmtMod = $this->db->prepare($sqlModalidades);
            $stmtMod->execute([':id' => $id]);

            // Eliminar el curso
            $sqlCurso = "DELETE FROM cursos WHERE id_curso = :id";
            $stmtCurso = $this->db->prepare($sqlCurso);
            return $stmtCurso->execute([':id' => $id]);
        }
    public $db;
    // Inserta o actualiza las modalidades de un curso (sobrescribe todas)
    public function guardarModalidades($id_curso, $modalidades)
    {
        // Elimina modalidades previas
        $sqlDel = "DELETE FROM cursos_modalidades WHERE id_curso = :id_curso";
        $stmtDel = $this->db->prepare($sqlDel);
        $stmtDel->execute([':id_curso' => $id_curso]);

        // Inserta cada modalidad (ahora con cupos)
        $sqlIns = "INSERT INTO cursos_modalidades (id_curso, nombre, precio, descripcion, horarios, cupos) VALUES (:id_curso, :nombre, :precio, :descripcion, :horarios, :cupos)";
        $stmtIns = $this->db->prepare($sqlIns);
        foreach ($modalidades as $mod) {
            $stmtIns->execute([
                ':id_curso' => $id_curso,
                ':nombre' => $mod['nombre'],
                ':precio' => $mod['precio'],
                ':descripcion' => $mod['descripcion'],
                ':horarios' => $mod['horarios'],
                ':cupos' => isset($mod['cupos']) ? intval($mod['cupos']) : 0
            ]);
        }
    }

    // Obtiene las modalidades de un curso
    public function obtenerModalidadesPorCurso($id_curso)
    {
        $sql = "SELECT * FROM cursos_modalidades WHERE id_curso = :id_curso";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_curso' => $id_curso]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    // Para la Landing Page (Solo activos y con fecha vigente)
    public function listarCursosPublicos()
    {
        // Mostrar todos los cursos activos, sin filtrar por fecha límite
        $sql = "SELECT * FROM cursos WHERE estado = 'activo'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Para el Admin: Ver todos
    public function listarTodoAdmin()
    {
        $sql = "SELECT *, (cupos_totales - cupos_disponibles) as inscritos FROM cursos";
        return $this->db->query($sql)->fetchAll();
    }

    // Crear nuevo curso (Admin)
    public function crear($datos)
    {
        $sql = "INSERT INTO cursos (titulo, descripcion_corta, contenido_detallado, cupos_totales, cupos_disponibles, fecha_inicio, fecha_fin, fecha_limite_inscripcion, imagen_portada) 
            VALUES (:titulo, :desc_c, :cont, :cupos, :cupos, :f_ini, :f_fin, :f_lim, :img)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo' => $datos['titulo'],
            ':desc_c' => $datos['descripcion_corta'],
            ':cont' => $datos['contenido_detallado'],
            ':cupos' => $datos['cupos_totales'],
            ':f_ini' => $datos['fecha_inicio'],
            ':f_fin' => $datos['fecha_fin'],
            ':f_lim' => $datos['fecha_limite_inscripcion'],
            ':img' => $datos['imagen_portada']
        ]);
    }

    // Obtener todos los cursos activos para la Landing Page
    public function obtenerCursos()
    {
        $sql = "SELECT * FROM cursos WHERE estado = 'activo' ORDER BY fecha_inicio ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Obtener detalles de un curso específico (para validar cupos y fechas)
    public function obtenerCursoPorId($id)
    {
        $sql = "SELECT * FROM cursos WHERE id_curso = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ); // Importante para que $curso->titulo funcione
    }

    // Método para descontar cupo (se usará al confirmar el pago)
    public function reducirCupo($id)
    {
        $sql = "UPDATE cursos SET cupos_disponibles = cupos_disponibles - 1 
                WHERE id_curso = :id AND cupos_disponibles > 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function listarCursos()
    {
        $sql = "SELECT DISTINCT * FROM cursos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function actualizarCursoCompleto($datos)
    {
        $sql = "UPDATE cursos SET 
                titulo = :titulo, 
                descripcion_corta = :desc_corta, 
                contenido_detallado = :contenido, 
                objetivos = :objetivos,
                programa = :programa,
                requisitos = :requisitos,
                incluye = :incluye,
                cupos_totales = :cupos_t, 
                fecha_inicio = :f_inicio, 
                fecha_fin = :f_fin, 
                fecha_limite_inscripcion = :f_limite, 
                imagen_portada = :imagen,
                estado = :estado
            WHERE id_curso = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo'     => $datos['titulo'],
            ':desc_corta' => $datos['descripcion_corta'],
            ':contenido'  => $datos['contenido_detallado'],
            ':objetivos'  => $datos['objetivos'],
            ':programa'   => $datos['programa'],
            ':requisitos' => $datos['requisitos'],
            ':incluye'    => $datos['incluye'],
            ':cupos_t'    => $datos['cupos_totales'],
            ':f_inicio'   => $datos['fecha_inicio'],
            ':f_fin'      => $datos['fecha_fin'],
            ':f_limite'   => $datos['fecha_limite_inscripcion'],
            ':imagen'     => $datos['imagen_portada'],
            ':estado'     => $datos['estado'],
            ':id'         => $datos['id_curso']
        ]);
    }

    public function insertarCurso($datos)
    {
        $sql = "INSERT INTO cursos (titulo, descripcion_corta, contenido_detallado, cupos_totales, cupos_disponibles, fecha_inicio, fecha_fin, fecha_limite_inscripcion, imagen_portada, objetivos, programa, requisitos, incluye, estado) 
            VALUES (:titulo, :descripcion_corta, :contenido_detallado, :cupos_totales, :cupos_disponibles, :fecha_inicio, :fecha_fin, :fecha_limite_inscripcion, :imagen_portada, :objetivos, :programa, :requisitos, :incluye, :estado)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo' => $datos['titulo'],
            ':descripcion_corta' => $datos['descripcion_corta'],
            ':contenido_detallado' => $datos['contenido_detallado'],
            ':cupos_totales' => $datos['cupos_totales'],
            ':cupos_disponibles' => $datos['cupos_disponibles'],
            ':fecha_inicio' => $datos['fecha_inicio'],
            ':fecha_fin' => $datos['fecha_fin'],
            ':fecha_limite_inscripcion' => $datos['fecha_limite_inscripcion'],
            ':imagen_portada' => $datos['imagen_portada'],
            ':objetivos' => $datos['objetivos'],
            ':programa' => $datos['programa'],
            ':requisitos' => $datos['requisitos'],
            ':incluye' => $datos['incluye'],
            ':estado' => $datos['estado'],
        ]);
    }
        // Insertar modalidades para un curso
    public function insertarModalidadesCurso($id_curso, $modalidades, $precios, $descripciones, $horarios)
    {
        $sql = "INSERT INTO cursos_modalidades (id_curso, nombre, precio, descripcion, horarios) VALUES (:id_curso, :nombre, :precio, :descripcion, :horarios)";
        $stmt = $this->db->prepare($sql);
        for ($i = 0; $i < count($modalidades); $i++) {
            $stmt->execute([
                ':id_curso' => $id_curso,
                ':nombre' => $modalidades[$i],
                ':precio' => $precios[$i],
                ':descripcion' => $descripciones[$i],
                ':horarios' => $horarios[$i]
            ]);
        }
    }
}
