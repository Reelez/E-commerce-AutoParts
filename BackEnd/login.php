<?php
require_once 'conexion.php';

session_start();

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    $db = new Database();
    $conn = $db->getConnection();

    // Primero, consultamos en la tabla de 'usuarios' (para admin y empleados)
    $sqlUsuarios = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmtUsuarios = $conn->prepare($sqlUsuarios);
    $stmtUsuarios->execute([$usuario]);

    if ($stmtUsuarios->rowCount() > 0) {
        // Si encontramos un administrador o empleado
        $row = $stmtUsuarios->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Iniciar sesión
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['rol'] = $row['rol']; // Definir el rol en la sesión

            // Redirigir según el rol
            if ($_SESSION['rol'] === 'admin') {
                header('Location: ../FrontEnd/admin/dashboard.php');
            } else if ($_SESSION['rol'] === 'empleado') {
                // Redirigir a dashboard para el empleado (con solo los módulos correspondientes)
                header('Location: ../FrontEnd/admin/dashboard.php'); // Redirigir a dashboard de empleado
            }
            exit();
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos');window.location.href='../FrontEnd/admin/login.html';</script>";
            exit();
        }
    } else {
        // Si no lo encontramos en la tabla de usuarios, buscamos en la tabla de clientes
        $sqlClientes = "SELECT * FROM clientes WHERE usuario = ?";
        $stmtClientes = $conn->prepare($sqlClientes);
        $stmtClientes->execute([$usuario]);

        if ($stmtClientes->rowCount() > 0) {
            // Si encontramos un cliente
            $row = $stmtClientes->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña
            if (password_verify($password, $row['password'])) {
                // Iniciar sesión
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['rol'] = $row['rol']; // Definir el rol en la sesión (cliente)

                // Redirigir al inventario público si es cliente
                header('Location: ../FrontEnd/public/inventario_publico.php');
                exit();
            } else {
                echo "<script>alert('Usuario o contraseña incorrectos');window.location.href='../FrontEnd/admin/login.html';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Usuario no encontrado');window.location.href='../FrontEnd/admin/login.html';</script>";
            exit();
        }
    }
}
?>
