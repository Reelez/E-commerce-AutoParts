<?php
header('Content-Type: application/json');
error_reporting(E_ERROR | E_PARSE);  // Para suprimir los errores de PHP, pero puedes habilitarlo para debugging.

require_once '../BackEnd/CRUD/inventarioCRUD.php';
require_once '../Validations/validarDatos.php';
require_once '../BackEnd/proteger.php';

$inventario = new InventarioCRUD();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        try {
            // Recibimos los datos del formulario
            $data = sanitizarArray($_POST);  // Sanitizamos la entrada del formulario

            // Manejar la subida de imagen
            $imagenPath = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = realpath(__DIR__ . '/../img/');
                if (!$uploadDir) {
                    mkdir(__DIR__ . '/../img/', 0777, true);
                    $uploadDir = realpath(__DIR__ . '/../img/');
                }
                $fileName = uniqid() . "_" . basename($_FILES['imagen']['name']);
                $targetFile = $uploadDir . '/' . $fileName;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile)) {
                    $imagenPath = 'img/' . $fileName;
                } else {
                    echo json_encode(['success' => false, 'error' => 'Error al subir imagen']);
                    exit;
                }
            }

            // Intentar agregar el producto a la base de datos
            $success = $inventario->agregarParte(
                $data['nombre_parte'],
                $data['marca_auto'],
                $data['modelo_auto'],
                $data['anio'],
                $data['descripcion'],
                $data['costo'],
                $data['unidades'],
                $imagenPath
            );

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Parte agregada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al agregar parte']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
        break;
}
?>
