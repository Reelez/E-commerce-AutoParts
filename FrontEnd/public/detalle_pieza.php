<?php 
require_once '../../BackEnd/proteger.php';
require_once '../../BackEnd/conexion.php';

// Validar ID recibido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ ID inválido.");
}

$id = intval($_GET['id']);
$db = new Database();
$conn = $db->getConnection();

// Obtener datos de la pieza específica
$stmt = $conn->prepare("SELECT * FROM inventario_partes WHERE id = :id LIMIT 1");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$pieza = $stmt->fetch();

if (!$pieza) {
    die("❌ Pieza no encontrada.");
}

// Obtener nombre de usuario
$nombreUsuario = $_SESSION['nombre'] ?? 'Invitado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🔧 Detalles de la Pieza</title>
    <link rel="stylesheet" href="../css/detalle.css?v=3">
</head>
<body>
<header class="header">
    <div class="header-left">
        <span class="usuario">👋 Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></span>
    </div>
    <div class="header-center">
        <h1>🚗 Inventario de Partes de Autos</h1>
    </div>
    <div class="header-right">
        <a href="carrito.php" class="cart-btn">
            🛒 <span id="cart-count"><?php echo array_sum($_SESSION['carrito'] ?? []); ?></span>
        </a>
        <a href="../../BackEnd/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</header>

<div class="container">
    <div class="detalle-card">
        <div class="detalle-img">
            <img src="../../<?php echo htmlspecialchars($pieza['imagen']); ?>" alt="<?php echo htmlspecialchars($pieza['nombre_parte']); ?>">
        </div>
        <div class="detalle-info">
            <h2><?php echo htmlspecialchars($pieza['nombre_parte']); ?></h2>
            <p><strong>Marca:</strong> <?php echo htmlspecialchars($pieza['marca_auto']); ?></p>
            <p><strong>Modelo:</strong> <?php echo htmlspecialchars($pieza['modelo_auto']); ?></p>
            <p><strong>Año:</strong> <?php echo htmlspecialchars($pieza['anio']); ?></p>
            <p><strong>Precio:</strong> $<?php echo number_format($pieza['costo'], 2); ?></p>
            <p><strong>Unidades disponibles:</strong> <?php echo htmlspecialchars($pieza['unidades']); ?></p>
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($pieza['descripcion']); ?></p>

            <form method="post" action="agregar_carrito.php" class="form-carrito">
                <input type="hidden" name="id" value="<?php echo $pieza['id']; ?>">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" value="1" min="1" max="<?php echo $pieza['unidades']; ?>" required>
                <button type="submit" class="add-cart-btn">🛒 Añadir al Carrito</button>
            </form>

            <a href="inventario_publico.php" class="btn-volver">← Volver al Inventario</a>
        </div>
    </div>
</div>
</body>
</html>
