<?php
require_once '../conexion.php';
require_once '../../Validations/validarDatos.php';

class MovimientosCRUD {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function agregarMovimiento($id_parte, $tipo, $cantidad, $descripcion) {
        $id_parte = intval($id_parte);
        $tipo = sanitizarEntrada($tipo); // "entrada" o "salida"
        $cantidad = intval($cantidad);
        $descripcion = sanitizarEntrada($descripcion);

        $stmt = $this->conn->prepare("INSERT INTO movimientos_inventario (id_parte, tipo, cantidad, descripcion)
                                      VALUES (:id_parte, :tipo, :cantidad, :descripcion)");
        return $stmt->execute([
            'id_parte' => $id_parte,
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'descripcion' => $descripcion
        ]);
    }

    public function obtenerMovimientos() {
        $stmt = $this->conn->query("SELECT m.id, p.nombre_parte, m.tipo, m.cantidad, m.descripcion, m.creado_en 
                                    FROM movimientos_inventario m
                                    JOIN inventario_partes p ON m.id_parte = p.id");
        return $stmt->fetchAll();
    }

    public function actualizarMovimiento($id, $tipo, $cantidad, $descripcion) {
        $stmt = $this->conn->prepare("UPDATE movimientos_inventario 
                                    SET tipo=:tipo, cantidad=:cantidad, descripcion=:descripcion 
                                    WHERE id=:id");
        return $stmt->execute([
            'tipo' => sanitizarEntrada($tipo),
            'cantidad' => intval($cantidad),
            'descripcion' => sanitizarEntrada($descripcion),
            'id' => intval($id)
        ]);
    }

    public function eliminarMovimiento($id) {
        $stmt = $this->conn->prepare("DELETE FROM movimientos_inventario WHERE id=:id");
        return $stmt->execute(['id' => intval($id)]);
    }
}
?>
