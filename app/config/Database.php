<?php
require_once 'config.php';

class Database
{
    private static $instancia = null;
    private $conexion;

    private function __construct()
    {
        try {
            // Configuramos la conexión con soporte para caracteres UTF-8 (acentos y eñes)
            $this->conexion = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASS
            );

            // Activamos el manejo de errores para desarrollo
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Configuramos para que devuelva los datos como objetos por defecto
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Error crítico de conexión: " . $e->getMessage());
        }
    }

    // Método estático para obtener la conexión (Singleton)
    public static function conectar()
    {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia->conexion;
    }
}
