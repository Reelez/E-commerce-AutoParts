<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if (isset($_SESSION['carrito'][$id])) {
        if ($action === 'increment') {
            $_SESSION['carrito'][$id]++;
        } elseif ($action === 'decrement') {
            $_SESSION['carrito'][$id]--;
            if ($_SESSION['carrito'][$id] <= 0) {
                unset($_SESSION['carrito'][$id]);
            }
        }
    }
}

header('Location: carrito.php');
exit;
?>
