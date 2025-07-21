<?php
require_once 'conexion.php';

session_start();

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    $db = new Database();
    $conn = $db->getConnection();

    // Consulta para verificar si el usuario existe
    $sql = "SELECT * FROM clientes WHERE usuario = ?";

    try {
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usuario]); // Usar execute() con un arreglo para PDO

        // Verificar si el usuario existe
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña
            if (password_verify($password, $row['password'])) {
                // Iniciar sesión
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['rol'] = $row['rol']; // Definir el rol en la sesión

                // Redirigir según el rol del usuario
                if ($_SESSION['rol'] === 'admin') {
                    header('Location: ../FrontEnd/admin/dashboard.php');
                } else {
                    header('Location: ../FrontEnd/public/inventario_publico.php');
                }
                exit();
            } else {
                echo "<script>alert('Usuario o contraseña incorrectos');window.location.href='../FrontEnd/admin/login.html';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Usuario no encontrado');window.location.href='../FrontEnd/admin/login.html';</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>alert('❌ Error en la base de datos: " . $e->getMessage() . "');window.location.href='../FrontEnd/admin/login.html';</script>";
    }
}
?>
