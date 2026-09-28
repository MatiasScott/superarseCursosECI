<?php
class UsuarioModel
{

    // Verificar si el email ya existe
    public function existeEmail($email)
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }


    // Verificar si la cédula/ruc ya existe
    public function existeCedula($cedula_ruc)
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE cedula_ruc = :cedula_ruc";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cedula_ruc' => $cedula_ruc]);
        return $stmt->fetchColumn() > 0;
    }
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    // Registrar un nuevo estudiante
    public function registrar($datos)
    {
        $sql = "INSERT INTO usuarios (cedula_ruc, nombre, apellido, email, password, telefono, rol) 
            VALUES (:cedula_ruc, :nombre, :apellido, :email, :pass, :tel, 'estudiante')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cedula_ruc' => $datos['cedula_ruc'],
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':email'    => $datos['email'],
            ':pass'     => password_hash($datos['password'], PASSWORD_BCRYPT),
            ':tel'      => isset($datos['telefono']) && $datos['telefono'] !== '' ? $datos['telefono'] : 'SIN-TELEFONO'
        ]);
    }

    // Buscar usuario por email para el Login
    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    // Obtener un usuario por su id
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Listar usuarios para el panel admin (con filtro por rol y búsqueda)
    public function listarUsuarios($rol = '', $busqueda = '')
    {
        $sql = "SELECT u.*, 
                       (SELECT COUNT(*) FROM inscripciones i WHERE i.id_usuario = u.id_usuario) AS total_inscripciones,
                       (SELECT COUNT(*) FROM inscripciones i2 WHERE i2.id_usuario = u.id_usuario AND i2.estado_pago = 'pagado') AS cursos_pagados
                FROM usuarios u
                WHERE 1 = 1";
        $params = [];

        if ($rol === 'admin' || $rol === 'estudiante') {
            $sql .= " AND u.rol = :rol";
            $params[':rol'] = $rol;
        }

        $busqueda = trim($busqueda);
        if ($busqueda !== '') {
            $sql .= " AND (u.nombre LIKE :b1
                          OR u.apellido LIKE :b2
                          OR u.email LIKE :b3
                          OR u.cedula_ruc LIKE :b4)";
            $params[':b1'] = '%' . $busqueda . '%';
            $params[':b2'] = '%' . $busqueda . '%';
            $params[':b3'] = '%' . $busqueda . '%';
            $params[':b4'] = '%' . $busqueda . '%';
        }

        $sql .= " ORDER BY u.rol ASC, u.nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Verificar si el email ya existe, ignorando un id (para edición)
    public function existeEmailExcepto($email, $id_usuario)
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email AND id_usuario <> :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email, ':id' => $id_usuario]);
        return $stmt->fetchColumn() > 0;
    }

    // Verificar si la cédula/RUC ya existe, ignorando un id (para edición)
    public function existeCedulaExcepto($cedula_ruc, $id_usuario)
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE cedula_ruc = :cedula_ruc AND id_usuario <> :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cedula_ruc' => $cedula_ruc, ':id' => $id_usuario]);
        return $stmt->fetchColumn() > 0;
    }

    // Crear un usuario (desde el panel admin, con rol elegible)
    public function crear($datos)
    {
        $sql = "INSERT INTO usuarios (cedula_ruc, nombre, apellido, email, password, telefono, rol)
                VALUES (:cedula_ruc, :nombre, :apellido, :email, :pass, :tel, :rol)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cedula_ruc' => $datos['cedula_ruc'],
            ':nombre'     => $datos['nombre'],
            ':apellido'   => $datos['apellido'],
            ':email'      => $datos['email'],
            ':pass'       => password_hash($datos['password'], PASSWORD_BCRYPT),
            ':tel'        => !empty($datos['telefono']) ? $datos['telefono'] : 'SIN-TELEFONO',
            ':rol'        => $datos['rol']
        ]);
    }

    // Actualizar un usuario. Si no se envía password, se conserva la actual.
    public function actualizar($datos)
    {
        $sql = "UPDATE usuarios
                SET cedula_ruc = :cedula_ruc,
                    nombre     = :nombre,
                    apellido   = :apellido,
                    email      = :email,
                    telefono   = :tel,
                    rol        = :rol";
        $params = [
            ':cedula_ruc' => $datos['cedula_ruc'],
            ':nombre'     => $datos['nombre'],
            ':apellido'   => $datos['apellido'],
            ':email'      => $datos['email'],
            ':tel'        => !empty($datos['telefono']) ? $datos['telefono'] : 'SIN-TELEFONO',
            ':rol'        => $datos['rol'],
            ':id'         => $datos['id_usuario']
        ];

        if (!empty($datos['password'])) {
            $sql .= ", password = :pass";
            $params[':pass'] = password_hash($datos['password'], PASSWORD_BCRYPT);
        }

        $sql .= " WHERE id_usuario = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar un usuario (las inscripciones y pagos se borran en cascada por la BDD)
    public function eliminar($id)
    {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Cuántas inscripciones tiene un usuario
    public function contarInscripciones($id)
    {
        $sql = "SELECT COUNT(*) FROM inscripciones WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return (int) $stmt->fetchColumn();
    }

    // Cuántos administradores quedan, opcionalmente excluyendo uno
    public function contarAdmins($excluir_id = null)
    {
        if ($excluir_id !== null) {
            $sql = "SELECT COUNT(*) FROM usuarios WHERE rol = 'admin' AND id_usuario <> :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $excluir_id]);
        } else {
            $sql = "SELECT COUNT(*) FROM usuarios WHERE rol = 'admin'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }
        return (int) $stmt->fetchColumn();
    }
}
