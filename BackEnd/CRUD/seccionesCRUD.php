<?php
require_once __DIR__ . '/../conexion.php';
require_once '../Validations/validarDatos.php';


class SeccionesCRUD {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
public function obtenerInventario($orden = '', $estado = ''): array {
    $query = "SELECT * FROM inventario_partes";
    $conditions = [];

    if ($estado !== '') {
        $conditions[] = "activo = " . intval($estado);
    }

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    if ($orden) {
        $allowed = ['nombre_parte ASC', 'nombre_parte DESC', 'costo ASC', 'costo DESC', 'unidades ASC', 'unidades DESC', 'id ASC', 'id DESC'];
        if (in_array($orden, $allowed)) {
            $query .= " ORDER BY $orden";
        }
    } else {
        $query .= " ORDER BY id ASC"; // default order if no filter
    }

    $stmt = $this->conn->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function actualizarInventario($id, $campo, $valor): bool {
    $allowedFields = ['activo']; // Solo permitir campo 'activo'
    if (!in_array($campo, $allowedFields)) {
        return false;
    }

    $stmt = $this->conn->prepare("UPDATE inventario_partes SET $campo=:valor WHERE id=:id");
    return $stmt->execute([
        'valor' => intval($valor),
        'id' => intval($id)
    ]);
}


    public function actualizarEstado($id, $activo): bool {
        $stmt = $this->conn->prepare("UPDATE inventario_partes SET activo = :activo WHERE id = :id");
        return $stmt->execute([
            'activo' => intval($activo),
            'id' => intval($id)
        ]);
    }

    public function obtenerPartesActivas(): array {
    $stmt = $this->conn->query("SELECT * FROM inventario_partes WHERE activo = 1 ORDER BY nombre_parte ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>
