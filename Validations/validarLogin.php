<?php
function validarLogin($usuario, $password) {
    $errores = [];

    // Validar usuario
    if (empty($usuario)) {
        $errores[] = "El campo usuario es obligatorio.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $usuario)) {
        $errores[] = "El usuario solo puede contener letras, números y guiones bajos (3-20 caracteres).";
    }

    // Validar contraseña
    if (empty($password)) {
        $errores[] = "El campo contraseña es obligatorio.";
    } elseif (strlen($password) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres.";
    }

    return $errores;
}
?>
