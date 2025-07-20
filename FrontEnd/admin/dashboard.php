<?php
$requireAdmin = true;
require_once '../../BackEnd/proteger.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rastro Autos</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <header class="navbar">
        <div class="navbar-left">
            <h1>Rastro Autos</h1>
        </div>
        <div class="navbar-right">
            <span>👤 <?php echo htmlspecialchars($_SESSION['usuario']); ?> (<?php echo htmlspecialchars($_SESSION['rol']); ?>)</span>
            <a href="../../BackEnd/logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <main class="dashboard-main">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>
        <div class="cards-container">
            <a href="usuarios.php" class="card">
                <h3>Usuarios</h3>
                <p>Gestionar Usuarios</p>
            </a>
            <a href="inventario.php" class="card">
                <h3>Inventario</h3>
                <p>Gestionar Inventario</p>
            </a>
            <a href="movimientos.php" class="card">
                <h3>Movimientos</h3>
                <p>Gestionar Movimientos</p>
            </a>
            <a href="secciones.php" class="card">
                <h3>Secciones</h3>
                <p>Gestionar Secciones</p>
            </a>
        </div>
    </main>
</body>
</html>
