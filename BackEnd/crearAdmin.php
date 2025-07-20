<?php
require_once 'conexion.php';

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Datos del usuario admin
    $nombre = "Administrador General";
    $usuario = "admin";
    $passwordPlano = "root2514";
    $rol = "admin";
    $hashPassword = password_hash($passwordPlano, PASSWORD_DEFAULT);

    // Eliminar usuario admin existente (si existe)
    $deleteStmt = $conn->prepare("DELETE FROM usuarios WHERE usuario = :usuario");
    $deleteStmt->execute(['usuario' => $usuario]);
    echo "🗑️ Usuario admin anterior eliminado (si existía)<br>";

    // Insertar nuevo usuario admin
    $insertStmt = $conn->prepare("INSERT INTO usuarios (nombre, usuario, password, rol, creado_en) 
        VALUES (:nombre, :usuario, :password, :rol, NOW())");
    $insertStmt->execute([
        'nombre' => $nombre,
        'usuario' => $usuario,
        'password' => $hashPassword,
        'rol' => $rol
    ]);

    echo "✅ Nuevo usuario admin creado:<br>";
    echo "Usuario: $usuario<br>";
    echo "Contraseña: $passwordPlano<br>";
    echo "Hash generado: $hashPassword<br>";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>

