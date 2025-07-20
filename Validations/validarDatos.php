<?php
// Sanitiza y valida diferentes tipos de datos

// ✅ Elimina espacios, etiquetas HTML y convierte caracteres especiales
function sanitizarEntrada($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// ✅ Sanitiza arrays completas (útil para $_POST, $_GET)
function sanitizarArray($array) {
    $resultado = [];
    foreach ($array as $key => $value) {
        $resultado[$key] = sanitizarEntrada($value);
    }
    return $resultado;
}

// ✅ Valida campos de texto (solo letras, números y espacios)
function validarCampoTexto($campo, $min = 3, $max = 100) {
    $pattern = "/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,-]{" . $min . "," . $max . "}$/u";
    return preg_match($pattern, $campo);
}


// ✅ Valida números enteros
function validarNumeroEntero($numero, $min = 0, $max = PHP_INT_MAX) {
    return filter_var($numero, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => $min, 'max_range' => $max]
    ]) !== false;
}

// ✅ Valida números decimales (como precios)
function validarNumeroDecimal($numero, $min = 0, $max = PHP_FLOAT_MAX) {
    return filter_var($numero, FILTER_VALIDATE_FLOAT) !== false && $numero >= $min && $numero <= $max;
}

// ✅ Valida emails
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// ✅ Valida URLs (opcional para imágenes)
function validarURL($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

// ✅ Valida longitud de cadenas
function validarLongitud($cadena, $min = 3, $max = 255) {
    $length = mb_strlen($cadena);
    return $length >= $min && $length <= $max;
}
?>
