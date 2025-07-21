<?php 
require_once '../../BackEnd/proteger.php'; 
require_once '../../BackEnd/CRUD/inventarioCRUD.php';

// Crear instancia de InventarioCRUD para obtener las partes del inventario
$inventario = new InventarioCRUD();
$productos = $inventario->obtenerPartesActivas(); // Obtener solo los productos activos

// Evitar warning si no existe 'nombre' en la sesión
$nombreUsuario = isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Invitado';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Público</title>
    <link rel="stylesheet" href="../css/publico.css?v=5">
</head>
<body>
    <!-- Header transparente -->
    <header class="header">
        <div class="header-left">
            <span class="usuario">👋 Bienvenido, <?php echo $nombreUsuario; ?></span>
        </div>
        <div class="header-center">
            <h1>🚗 Inventario de Partes de Autos</h1>
        </div>
        <div class="header-right">
            <a href="carrito.php" class="cart-btn">
                🛒 <span id="cart-count">
                    <?php echo isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0; ?>
                </span>
            </a>
            <a href="../../FrontEnd/admin/login.html" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <!-- Contenido principal -->
    <div class="container">
        <div id="gridProductos" class="grid-productos">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <a href="detalle_pieza.php?id=<?php echo $producto['id']; ?>" class="card-link">
                        <div class="card">
                            <div class="card-img">
                                <?php echo $producto['imagen'] ? "<img src='../../{$producto['imagen']}' alt='{$producto['nombre_parte']}'>" : '<div class="no-img">Sin Imagen</div>'; ?>
                            </div>
                            <div class="card-body">
                                <h2><?php echo $producto['nombre_parte']; ?></h2>
                                <p><strong>Marca:</strong> <?php echo $producto['marca_auto']; ?></p>
                                <p><strong>Modelo:</strong> <?php echo $producto['modelo_auto']; ?></p>
                                <p><strong>Año:</strong> <?php echo $producto['anio']; ?></p>
                                <p><strong>Precio:</strong> $<?php echo number_format($producto['costo'], 2); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
