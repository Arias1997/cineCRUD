<?php

class Database
{
    private $host = "127.0.0.1";
    private $puerto = "3307";
    private $db_name = "cine";
    private $usuario = "root";
    private $password = "";
    private $conexion;

    public function __construct()
    {
        $archivoLocal = __DIR__ . "/database.local.php";

        if (is_file($archivoLocal)) {
            $configuracion = require $archivoLocal;

            if (!is_array($configuracion)) {
                throw new RuntimeException("La configuración local de la base de datos debe devolver un arreglo.");
            }

            $this->host = $configuracion['host'] ?? $this->host;
            $this->puerto = $configuracion['puerto'] ?? $this->puerto;
            $this->db_name = $configuracion['db_name'] ?? $this->db_name;
            $this->usuario = $configuracion['usuario'] ?? $this->usuario;
            $this->password = $configuracion['password'] ?? $this->password;
        }
    }

    public function getConexion()
    {
        $this->conexion = null;

        try {
            $this->conexion = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->puerto . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->usuario,
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }

        return $this->conexion;
    }
}