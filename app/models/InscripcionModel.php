<?php
class InscripcionModel {
    // Eliminar inscripción por id
    public function eliminarInscripcionPorId($id_inscripcion)
    {
        // Elimina pagos relacionados primero
        $sqlPagos = "DELETE FROM pagos WHERE id_inscripcion = :id";
        $stmtPagos = $this->db->prepare($sqlPagos);
        $stmtPagos->execute([':id' => $id_inscripcion]);

        // Elimina la inscripción
        $sql = "DELETE FROM inscripciones WHERE id_inscripcion = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id_inscripcion]);
    }
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    // Verifica si el usuario existe
    public function usuarioExiste($id_usuario) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_usuario]);
        return $stmt->fetchColumn() > 0;
    }

    // 1. Crear la inscripción inicial (Estado: Pendiente)
    public function crearInscripcion($id_usuario, $id_curso, $modalidad = null, $horario = null)
    {
        if ($modalidad !== null || $horario !== null) {
            $sql = "INSERT INTO inscripciones (id_usuario, id_curso, modalidad, horario) VALUES (:user, :curso, :modalidad, :horario)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user' => $id_usuario,
                ':curso' => $id_curso,
                ':modalidad' => $modalidad,
                ':horario' => $horario
            ]);
        } else {
            $sql = "INSERT INTO inscripciones (id_usuario, id_curso) VALUES (:user, :curso)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user' => $id_usuario, ':curso' => $id_curso]);
        }
        return $this->db->lastInsertId();
    }

    // 2. Registrar el intento de pago
    public function registrarPago($datos)
    {
        $sql = "INSERT INTO pagos (
                id_inscripcion, 
                metodo_pago, 
                monto_pagado, 
                comprobante_archivo, 
                payphone_id_transaccion,
                payphone_client_transaction_id, 
                estado_pago, 
                tipo_verificacion
            ) VALUES (
                :id_ins, 
                :metodo, 
                :monto, 
                :comprobante, 
                :payphone_id,
                :client_id, 
                :estado, 
                :tipo
            )";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    // 3. Subir Nota y Certificado (Admin)
    public function finalizarCurso($id_inscripcion, $nota, $ruta_pdf)
    {
        $sql = "UPDATE inscripciones SET 
                nota_final = :nota, 
                certificado_path = :path, 
                estado_academico = 'aprobado' 
                WHERE id_inscripcion = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nota' => $nota, ':path' => $ruta_pdf, ':id' => $id_inscripcion]);
    }

    // Para el ADMIN: Ver quién pagó qué
    public function listarPagosPendientes()
    {
        $sql = "SELECT p.*, u.nombre as nombre_usuario, c.titulo as titulo_curso 
            FROM pagos p
            JOIN inscripciones i ON p.id_inscripcion = i.id_inscripcion
            JOIN usuarios u ON i.id_usuario = u.id_usuario
            JOIN cursos c ON i.id_curso = c.id_curso
            WHERE p.estado_pago = 'pendiente'";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    // Para el ESTUDIANTE: Ver su progreso
    public function listarPorEstudiante($id_usuario)
    {
        $sql = "SELECT 
                i.id_inscripcion, 
                i.estado_academico, 
                i.nota_final, 
                i.certificado_path, 
                i.modalidad,
                c.titulo as titulo_curso, 
                p.estado_pago,
                i.horario
            FROM inscripciones i
            JOIN cursos c ON i.id_curso = c.id_curso
            LEFT JOIN pagos p ON i.id_inscripcion = p.id_inscripcion
            WHERE i.id_usuario = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function confirmarPago($id_pago)
    {
        try {
            $this->db->beginTransaction();

            // 1. Obtener información de la inscripción y el curso
            $sqlInfo = "SELECT p.id_inscripcion, i.id_curso 
                    FROM pagos p 
                    JOIN inscripciones i ON p.id_inscripcion = i.id_inscripcion 
                    WHERE p.id_pago = :id_pago";
            $stmt1 = $this->db->prepare($sqlInfo);
            $stmt1->execute([':id_pago' => $id_pago]);
            $info = $stmt1->fetch(PDO::FETCH_OBJ);

            if (!$info) throw new Exception("No se encontró el registro del pago.");

            // 2. Actualizar tabla PAGOS (Cambiamos de 'pendiente' a 'aprobado')
            $sqlPago = "UPDATE pagos SET estado_pago = 'aprobado' WHERE id_pago = :id_pago";
            $this->db->prepare($sqlPago)->execute([':id_pago' => $id_pago]);

            // 3. Actualizar tabla INSCRIPCIONES (Sincronizamos el estado_pago y estado_academico)
            $sqlInsc = "UPDATE inscripciones SET 
                        estado_pago = 'pagado', 
                        estado_academico = 'cursando' 
                    WHERE id_inscripcion = :id_ins";
            $this->db->prepare($sqlInsc)->execute([':id_ins' => $info->id_inscripcion]);


            // 4. DESCONTAR CUPO GENERAL DEL CURSO
            $sqlCupo = "UPDATE cursos SET cupos_disponibles = cupos_disponibles - 1 
                    WHERE id_curso = :id_curso AND cupos_disponibles > 0";
            $stmtCupo = $this->db->prepare($sqlCupo);
            $stmtCupo->execute([':id_curso' => $info->id_curso]);

            // 5. DESCONTAR CUPO DE LA MODALIDAD (si aplica)
            // Obtener modalidad de la inscripción
            $sqlModalidad = "SELECT modalidad FROM inscripciones WHERE id_inscripcion = :id_inscripcion";
            $stmtMod = $this->db->prepare($sqlModalidad);
            $stmtMod->execute([':id_inscripcion' => $info->id_inscripcion]);
            $modalidad = $stmtMod->fetchColumn();
            if ($modalidad) {
                // Descontar cupo de la modalidad correspondiente
                $sqlCupoMod = "UPDATE cursos_modalidades SET cupos = cupos - 1 
                    WHERE id_curso = :id_curso AND LOWER(nombre) = LOWER(:modalidad) AND cupos > 0";
                $stmtCupoMod = $this->db->prepare($sqlCupoMod);
                $stmtCupoMod->execute([
                    ':id_curso' => $info->id_curso,
                    ':modalidad' => $modalidad
                ]);
                // Verificar si realmente se descontó el cupo de modalidad
                if ($stmtCupoMod->rowCount() == 0) {
                    throw new Exception("No hay cupos disponibles en la modalidad seleccionada.");
                }
            }

            // 6. Verificar si realmente se descontó el cupo general
            if ($stmtCupo->rowCount() == 0) {
                throw new Exception("No hay cupos disponibles o el curso no existe.");
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            // Opcional: imprimir el error para debuggear
            // die($e->getMessage()); 
            return false;
        }
    }

    public function actualizarNotaCertificado($id, $nota, $estado, $archivo)
    {
        if ($archivo) {
            $sql = "UPDATE inscripciones SET nota_final = :nota, estado_academico = :estado, certificado_path = :archivo WHERE id_inscripcion = :id";
            $params = [':nota' => $nota, ':estado' => $estado, ':archivo' => $archivo, ':id' => $id];
        } else {
            $sql = "UPDATE inscripciones SET nota_final = :nota, estado_academico = :estado WHERE id_inscripcion = :id";
            $params = [':nota' => $nota, ':estado' => $estado, ':id' => $id];
        }

        return $this->db->prepare($sql)->execute($params);
    }

    public function listarPagosPorUsuario($id_usuario)
    {
        $sql = "SELECT p.*, c.titulo as titulo_curso 
            FROM pagos p
            JOIN inscripciones i ON p.id_inscripcion = i.id_inscripcion
            JOIN cursos c ON i.id_curso = c.id_curso
            WHERE i.id_usuario = :id
            ORDER BY p.fecha_pago DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarTodasParaAdmin()
    {
        // Usamos p.estado_pago = 'aprobado' que es el valor de tu ENUM en la tabla pagos
        $sql = "SELECT i.*, u.nombre as nombre_usuario, u.apellido as apellido_usuario, c.titulo as titulo_curso 
            FROM inscripciones i
            JOIN usuarios u ON i.id_usuario = u.id_usuario
            JOIN cursos c ON i.id_curso = c.id_curso
            JOIN pagos p ON i.id_inscripcion = p.id_inscripcion
            WHERE p.estado_pago = 'aprobado'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarInscritosHoy()
    {
        $sql = "SELECT COUNT(*) as total 
                FROM inscripciones 
                WHERE DATE(fecha_inscripcion) = CURDATE()";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? $result->total : 0;
    }

    public function calcularIngresosMes()
    {
        $sql = "SELECT SUM(monto_pagado) as total 
                FROM pagos 
                WHERE MONTH(fecha_pago) = MONTH(CURDATE()) 
                AND YEAR(fecha_pago) = YEAR(CURDATE()) 
                AND estado_pago = 'aprobado'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? $result->total : 0;
    }

    public function obtenerUltimasInscripciones($limite = 5)
    {
        $sql = "SELECT i.*, u.nombre as nombre_usuario, c.titulo as titulo_curso, p.estado_pago 
                FROM inscripciones i
                JOIN usuarios u ON i.id_usuario = u.id_usuario
                JOIN cursos c ON i.id_curso = c.id_curso
                LEFT JOIN pagos p ON i.id_inscripcion = p.id_inscripcion
                ORDER BY i.fecha_inscripcion DESC
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
