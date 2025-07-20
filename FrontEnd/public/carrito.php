<?php
require_once '../../BackEnd/proteger.php';
require_once '../../BackEnd/conexion.php';

$db = new Database();
$conn = $db->getConnection();

$nombreUsuario = isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Invitado';

// Obtener IDs del carrito
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$productos = [];

if (!empty($carrito)) {
    $placeholders = implode(',', array_fill(0, count($carrito), '?'));
    $stmt = $conn->prepare("SELECT * FROM inventario_partes WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($carrito));
    $productos = $stmt->fetchAll();
}

// Calcular subtotal
$subtotal = 0;
foreach ($productos as $producto) {
    $cantidad = $carrito[$producto['id']];
    $subtotal += $producto['costo'] * $cantidad;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🛒 Mi Carrito</title>
    <link rel="stylesheet" href="../css/carrito.css?v=2">
</head>
<body>
<header class="header">
    <div class="header-left">
        <span class="usuario">👋 Bienvenido, <?php echo $nombreUsuario; ?></span>
    </div>
    <div class="header-center">
        <h1>🛒 Carrito de Compras</h1>
    </div>
    <div class="header-right">
        <a href="inventario_publico.php" class="btn-accion">← Volver al Inventario</a>
        <a href="../../BackEnd/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</header>

<div class="container">
    <?php if (empty($productos)): ?>
        <p class="empty">🛒 Tu carrito está vacío.</p>
    <?php else: ?>
        <?php foreach ($productos as $p): ?>
            <div class="cart-item">
                <img src="../../<?php echo htmlspecialchars($p['imagen']); ?>" alt="<?php echo htmlspecialchars($p['nombre_parte']); ?>">
                <div class="item-info">
                    <h2><?php echo htmlspecialchars($p['nombre_parte']); ?></h2>
                    <p><?php echo htmlspecialchars($p['descripcion']); ?></p>
                    <p><strong>Precio:</strong> $<?php echo number_format($p['costo'], 2); ?></p>
                    <div class="cantidad-controls">
                        <form method="post" action="actualizar_carrito.php">
                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                            <button type="submit" name="action" value="decrement" class="qty-btn">−</button>
                            <span><?php echo $carrito[$p['id']]; ?></span>
                            <button type="submit" name="action" value="increment" class="qty-btn">+</button>
                        </form>
                        <form method="post" action="eliminar_carrito.php" class="delete-form">
                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                            <button type="submit" class="delete-btn">🗑️ Eliminar</button>
                        </form>
                    </div>
                </div>
                <div class="item-total">
                    <strong>Total:</strong> $<?php echo number_format($p['costo'] * $carrito[$p['id']], 2); ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="summary">
            <h3>Subtotal (<?php echo array_sum($carrito); ?> productos): $<?php echo number_format($subtotal, 2); ?></h3>
            <a href="generar_factura.php" class="checkout-btn">Proceder al Pago</a>

        </div>
    <?php endif; ?>
</div>
</body>
</html>
