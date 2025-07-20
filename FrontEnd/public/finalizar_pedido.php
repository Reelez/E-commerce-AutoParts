<?php
require_once '../../BackEnd/proteger.php';
require_once '../../BackEnd/conexion.php';

session_start();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die("❌ No hay productos en el carrito.");
}

$usuario_id = $_SESSION['usuario_id']; // Asume que ya guardas el ID al iniciar sesión
$carrito = $_SESSION['carrito'];

$db = new Database();
$conn = $db->getConnection();

try {
    $conn->beginTransaction();

    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    // Insertar pedido
    $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (:usuario_id, :total)");
    $stmt->execute(['usuario_id' => $usuario_id, 'total' => $total]);
    $pedido_id = $conn->lastInsertId();

    // Insertar detalles
    $stmtDetalle = $conn->prepare("INSERT INTO pedidos_detalles (pedido_id, pieza_id, cantidad, precio_unitario, subtotal) VALUES (:pedido_id, :pieza_id, :cantidad, :precio_unitario, :subtotal)");

    foreach ($carrito as $id => $item) {
        $subtotal = $item['precio'] * $item['cantidad'];
        $stmtDetalle->execute([
            'pedido_id' => $pedido_id,
            'pieza_id' => $id,
            'cantidad' => $item['cantidad'],
            'precio_unitario' => $item['precio'],
            'subtotal' => $subtotal
        ]);
    }

    $conn->commit();
    unset($_SESSION['carrito']);

    echo "<script>alert('✅ Pedido realizado correctamente.'); window.location.href='inventario_publico.php';</script>";
} catch (Exception $e) {
    $conn->rollBack();
    die("❌ Error al realizar pedido: " . $e->getMessage());
}
?>
