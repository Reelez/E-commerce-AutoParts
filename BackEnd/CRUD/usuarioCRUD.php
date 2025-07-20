<?php
require_once 'conexion.php';
require_once '../Validations/validarDatos.php';

class UsuarioCRUD {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crearUsuario($nombre, $usuario, $password, $rol) {
        $nombre = sanitizarEntrada($nombre);
        $usuario = sanitizarEntrada($usuario);
        $rol = sanitizarEntrada($rol);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, usuario, password, rol) VALUES (:nombre, :usuario, :password, :rol)");
        return $stmt->execute([
            'nombre' => $nombre,
            'usuario' => $usuario,
            'password' => $passwordHash,
            'rol' => $rol
        ]);
    }

    public function obtenerUsuarios() {
        $stmt = $this->conn->query("SELECT id, nombre, usuario, rol FROM usuarios");
        return $stmt->fetchAll();
    }

    public function actualizarUsuario($id, $nombre, $rol) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET nombre=:nombre, rol=:rol WHERE id=:id");
        return $stmt->execute([
            'nombre' => sanitizarEntrada($nombre),
            'rol' => sanitizarEntrada($rol),
            'id' => $id
        ]);
    }

    public function eliminarUsuario($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id=:id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
