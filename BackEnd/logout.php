<?php
require_once 'usuario.php';

$userObj = new Usuario();
$userObj->logout();

// Redirigir a la página de login después de cerrar sesión
header("Location: ../FrontEnd/admin/login.html");
exit();

?>
