<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../FrontEnd/login.html');
    exit;
}

$pagina = basename($_SERVER['PHP_SELF']);
if ($_SESSION['rol'] !== 'admin') {
    $pagina = basename($_SERVER['PHP_SELF']);
    $permitidos = $_SESSION['permisos'];
    if (!isset($permitidos[$pagina]) || !$permitidos[$pagina]) {
        header('Location: dashboard.php');
        exit;
    }
}

?>
