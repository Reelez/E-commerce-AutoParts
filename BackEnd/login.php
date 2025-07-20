<?php
require_once 'usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    $userObj = new Usuario();

    if ($userObj->login($usuario, $password)) {
        // Redirigir según rol
        session_start();
        if ($_SESSION['rol'] === 'admin') {
            header('Location: ../FrontEnd/admin/dashboard.php');
        } else {
            header('Location: ../FrontEnd/publico/inventario_publico.php');
        }
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos');window.location.href='../FrontEnd/admin/login.html';</script>";
        exit();
    }
}
?>
