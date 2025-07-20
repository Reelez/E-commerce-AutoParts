<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'rastro_autos';
    private $username = 'root';
    private $password = '123root';
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //echo "✅ Conexión exitosa a la base de datos.";
        } catch (PDOException $e) {
            die("❌ Error de conexión: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
