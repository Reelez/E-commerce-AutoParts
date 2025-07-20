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
?>
