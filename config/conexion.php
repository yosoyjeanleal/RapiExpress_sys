<?php
namespace RapiExpress\Config;

use PDO;
use PDOException;

abstract class Conexion
{
    private static ?PDO $instancia = null;

    final protected function __construct() {}

    public static function getConexion(): PDO
    {
        if (self::$instancia === null) {
            self::inicializarConexion();
        }
        return self::$instancia;
    }

    private static function inicializarConexion(): void
    {
        $host = 'localhost';
        $dbname = 'rapiexpress';
        $username = 'root';
        $password = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '$charset'"
        ];

        try {
            self::$instancia = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
            throw new \RuntimeException("Error al conectar con la base de datos.");
        }
    }

    public static function verificarEstructura(): bool
    {
        try {
            $pdo = self::getConexion();
            $stmt = $pdo->query("SHOW TABLES LIKE 'usuarios'");
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al verificar estructura: " . $e->getMessage());
            return false;
        }
    }
}