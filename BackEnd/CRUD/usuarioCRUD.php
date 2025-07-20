<?php
require_once 'conexion.php';
require_once '../Validations/validarDatos.php';

class UsuariosCRUD {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function obtenerUsuarios() {
        $stmt = $this->conn->query("SELECT id, usuario, rol, permisos FROM usuarios WHERE usuario != 'admin'");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($usuarios as &$u) {
            $u['permisos'] = json_decode($u['permisos'], true);
        }
        return $usuarios;
    }
    public function editarUsuario($id, $nombre, $usuario, $password, $rol, $permisos) {
    $query = "UPDATE usuarios SET nombre=?, usuario=?, rol=?, permisos=?";
    $params = [$nombre, $usuario, $rol, $permisos];

    if ($password) {
        $query .= ", password=?";
        $params[] = $password;
    }

    $query .= " WHERE id=?";
    $params[] = $id;

    $stmt = $this->conn->prepare($query);
    return $stmt->execute($params);
}


    public function agregarUsuario($usuario, $password, $rol, $permisos) {
    $stmt = $this->conn->prepare("INSERT INTO usuarios (usuario, password, rol, permisos) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$usuario, $password, $rol, $permisos]);
}


    public function eliminarUsuario($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
