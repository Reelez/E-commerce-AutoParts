<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // No hay sesión iniciada
    header('Location: ../FrontEnd/login.html');
    exit();
}

// Opcional: Solo permitir admin en módulos admin
if (isset($requireAdmin) && $requireAdmin && $_SESSION['rol'] !== 'admin') {
    header('Location: ../FrontEnd/publico/inventario_publico.php');
    exit();
}
// Solo iniciar sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    header('Location: ../FrontEnd/login.html'); // Redirige a login si no está autenticado
    exit();
}
?>
