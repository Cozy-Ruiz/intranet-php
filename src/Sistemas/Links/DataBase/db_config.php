
<?php
class Database {
    private static $host = getenv('LINKS_DB_HOST').":".getenv('LINKS_DB_PORT'); // Cambia esto según tu configuración
    private static $dbname = "master_ge";
    private static $username = getenv('LINKS_DB_USER'); // Usuario de MySQL
    private static $password = getenv('LINKS_DB_PASS'); // Contraseña de MySQL
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}


?>