<?php
require_once(__DIR__ . '/../conexion.php');

class InventarioCRUD {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function agregarParte($nombre, $marca, $modelo, $anio, $descripcion, $costo, $unidades, $imagen) {
    try {
        $sql = "INSERT INTO inventario_partes 
                (nombre_parte, marca_auto, modelo_auto, anio, descripcion, costo, unidades, imagen) 
                VALUES (:nombre, :marca, :modelo, :anio, :descripcion, :costo, :unidades, :imagen)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':unidades', $unidades);
        $stmt->bindParam(':imagen', $imagen);

        return $stmt->execute();  // Ejecutar la consulta
    } catch (PDOException $e) {
        error_log("Error en agregarParte: " . $e->getMessage());
        return false;
    }
}



    public function obtenerPartes() {
    $sql = "SELECT * FROM inventario_partes";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function eliminarParte($id) {
        $sql = "DELETE FROM inventario_partes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function filtrarPartes($nombre, $marca, $modelo) {
    $sql = "SELECT * FROM inventario_partes WHERE 1=1";
    $params = [];

    if (!empty($nombre)) {
        $sql .= " AND nombre_parte LIKE :nombre";
        $params[':nombre'] = "%$nombre%";
    }
    if (!empty($marca)) {
        $sql .= " AND marca_auto = :marca";
        $params[':marca'] = $marca;
    }
    if (!empty($modelo)) {
        $sql .= " AND modelo_auto = :modelo";
        $params[':modelo'] = $modelo;
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function actualizarParte($id, $nombre, $marca, $modelo, $anio, $descripcion, $costo, $unidades, $imagen) {
        $sql = "UPDATE inventario_partes SET 
                    nombre_parte = :nombre, 
                    marca_auto = :marca, 
                    modelo_auto = :modelo, 
                    anio = :anio, 
                    descripcion = :descripcion, 
                    costo = :costo, 
                    unidades = :unidades, 
                    imagen = :imagen 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':unidades', $unidades);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    public function obtenerPartesActivas() {
    $stmt = $this->conn->query("SELECT * FROM inventario_partes WHERE activo = 1 ORDER BY nombre_parte ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>