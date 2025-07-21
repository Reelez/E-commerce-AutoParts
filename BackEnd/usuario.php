<?php
require_once 'conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function login($usuario, $password) {
    $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1");
    $stmt->execute(['usuario' => $usuario]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];
        
        // Solo admin puede acceder a la gestión de usuarios
        if ($_SESSION['rol'] !== 'admin') {
            // Al hacer login con empleado, redirigir a una página sin opciones de administración
            header('Location: dashboard.php');
            exit();
        }
        
        return true;
    }
    return false;
}

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../FrontEnd/login.html");
        exit();
    }

    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['usuario']);
    }

    public function getRol() {
        session_start();
        return $_SESSION['rol'] ?? null;
    }
}
?>
