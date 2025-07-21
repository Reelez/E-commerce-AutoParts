<?php
require_once 'usuario.php';

$userObj = new Usuario();
$userObj->logout();

// Redirigir a la página de login después de cerrar sesión usando la ruta absoluta
header("Location: /E-commerce-AutoParts/FrontEnd/admin/login.html"); // Ruta absoluta
exit();
?>
