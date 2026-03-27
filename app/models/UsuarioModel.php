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
}
