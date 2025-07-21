<?php
require_once 'conexion.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre']);
    $correo    = trim($_POST['correo']);
    $usuario   = trim($_POST['usuario']);
    $password  = trim($_POST['password']);
    $confirmar = trim($_POST['confirmar']);

    // Validación básica
    if ($password !== $confirmar) {
        echo "<script>alert('❌ Las contraseñas no coinciden');history.back();</script>";
        exit;
    }

    // Hash de la contraseña
    $hash = password_hash($password, PASSWORD_BCRYPT);

    // Rol por defecto
    $rol = 'cliente';

    try {
        // Preparar la consulta
        $stmt = $conn->prepare("INSERT INTO clientes 
            (nombre, correo, usuario, password, rol, creado_en) 
            VALUES (:nombre, :correo, :usuario, :password, :rol, NOW())");

        // Asignar valores a los parámetros
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
        $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('✅ Registro exitoso. Puedes iniciar sesión ahora.');window.location.href='../FrontEnd/admin/login.html';</script>";
        } else {
            echo "<script>alert('❌ Error al registrar el usuario.');history.back();</script>";
        }
    } catch (PDOException $e) {
        // Corregir el error con la función addslashes()
        echo "<script>alert('❌ Error en la base de datos: " . addslashes($e->getMessage()) . "');history.back();</script>";
    }
}
?>
