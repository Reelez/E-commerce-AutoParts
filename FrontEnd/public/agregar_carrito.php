<?php
session_start();

// Validar método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

    if ($id <= 0 || $cantidad <= 0) {
        echo "<script>alert('❌ Datos inválidos.');history.back();</script>";
        exit;
    }

    // Inicializar carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Si la pieza ya está en el carrito, aumentar la cantidad
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id] += $cantidad;
    } else {
        $_SESSION['carrito'][$id] = $cantidad;
    }

    // Redirigir de vuelta al detalle con mensaje de éxito
    echo "<script>
        alert('✅ Pieza añadida al carrito.');
        window.location.href = 'detalle_pieza.php?id={$id}';
    </script>";
    exit;
} else {
    // Si no es POST, rechazar
    echo "<script>alert('❌ Acceso no permitido');window.location.href='inventario_publico.php';</script>";
    exit;
}
?>
