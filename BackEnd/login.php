<?php
require_once 'usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    $userObj = new Usuario();

    // Intentar iniciar sesión
    if ($userObj->login($usuario, $password)) {
        session_start();

        // Redirigir según el rol
        if ($_SESSION['rol'] === 'admin') {
            header('Location: ../FrontEnd/admin/dashboard.php');
        } elseif ($_SESSION['rol'] === 'publico') {
            header('Location: ../FrontEnd/public/inventario_publico.php');
        } else {
            // Rol desconocido
            echo "<script>alert('⚠️ Rol no autorizado');window.location.href='../FrontEnd/admin/login.html';</script>";
        }
        exit();
    } else {
        // Credenciales incorrectas
        echo "<script>alert('❌ Usuario o contraseña incorrectos');window.location.href='../FrontEnd/admin/login.html';</script>";
        exit();
    }
}
?>
