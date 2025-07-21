<?php
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
            <a href="login.html" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <main class="dashboard-main">
        <div class="welcome-card">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>

            <div class="mini-card">
                <a href="inventario.php" class="card">
                    <h3>📦 Inventario</h3>
                    <p>Controla las piezas y existencias.</p>
                </a>
            </div>

            <div class="mini-card">
                <a href="secciones.php" class="card">
                    <h3>📂 Secciones</h3>
                    <p>Organiza las categorías de productos.</p>
                </a>
            </div>

            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <div class="mini-card">
                    <a href="usuarios.php" class="card">
                        <h3>👥 Usuarios</h3>
                        <p>Gestiona los usuarios del sistema.</p>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
