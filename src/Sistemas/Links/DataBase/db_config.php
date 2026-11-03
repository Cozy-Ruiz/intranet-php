
<?php
class Database {
    private static $host = "192.1.172.9:3306"; // Cambia esto según tu configuración
    private static $dbname = "master_ge";
    private static $username = "GEA"; // Usuario de MySQL
    private static $password = "7b1QqK#m1F3m"; // Contraseña de MySQL
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