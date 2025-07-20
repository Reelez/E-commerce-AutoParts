<?php
require_once '../conexion.php';
require_once '../../Validations/validarDatos.php';

class SeccionesCRUD {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function agregarSeccion($nombre, $descripcion) {
        $nombre = sanitizarEntrada($nombre);
        $descripcion = sanitizarEntrada($descripcion);

        $stmt = $this->conn->prepare("INSERT INTO secciones (nombre_seccion, descripcion) VALUES (:nombre, :descripcion)");
        return $stmt->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion
        ]);
    }

    public function obtenerSecciones() {
        $stmt = $this->conn->query("SELECT * FROM secciones");
        return $stmt->fetchAll();
    }

    public function actualizarSeccion($id, $nombre, $descripcion) {
        $stmt = $this->conn->prepare("UPDATE secciones 
                                    SET nombre_seccion=:nombre, descripcion=:descripcion 
                                    WHERE id=:id");
        return $stmt->execute([
            'nombre' => sanitizarEntrada($nombre),
            'descripcion' => sanitizarEntrada($descripcion),
            'id' => intval($id)
        ]);
    }

    public function eliminarSeccion($id) {
        $stmt = $this->conn->prepare("DELETE FROM secciones WHERE id=:id");
        return $stmt->execute(['id' => intval($id)]);
    }
}
?>
