<?php
require_once(__DIR__ . '/../conexion.php');
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

public function agregarUsuario($nombre, $usuario, $password, $rol, $permisos) {
    // Validamos que el rol sea uno de los valores válidos
    if ($rol !== 'admin' && $rol !== 'empleado') {
        echo json_encode(['success' => false, 'error' => 'Rol inválido']);
        return false;
    }

    // Validar que los permisos estén correctamente formateados como JSON
    if (!is_string($permisos)) {
        echo json_encode(['success' => false, 'error' => 'Permisos no son un JSON válido']);
        return false;
    }

    try {
        // Preparar la consulta SQL para insertar el usuario
        $stmt = $this->conn->prepare("INSERT INTO usuarios (usuario, password, rol, permisos) VALUES (?, ?, ?, ?)");
        // Ejecutar la consulta con los valores del formulario
        $stmt->execute([$usuario, $password, $rol, $permisos]);

        return true; // Si todo va bien, se retorna true
    } catch (PDOException $e) {
        // Capturamos errores de SQL
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        return false;
    }
}

        public function eliminarUsuario($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
