<?php
require_once 'conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    private function ensureSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login($usuario, $password) {
        $this->ensureSession();

        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1");
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['nombre'] = $user['nombre']; // Guarda el nombre para mostrarlo en las vistas
            return true;
        }
        return false;
    }

    public function logout() {
        $this->ensureSession();
        session_unset();
        session_destroy();
        header("Location: ../FrontEnd/admin/login.html");
        exit();
    }

    public function isLoggedIn() {
        $this->ensureSession();
        return isset($_SESSION['usuario']);
    }

    public function getRol() {
        $this->ensureSession();
        return $_SESSION['rol'] ?? null;
    }
}
?>
