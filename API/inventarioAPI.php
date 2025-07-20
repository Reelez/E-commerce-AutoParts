<?php
header('Content-Type: application/json');
error_reporting(E_ERROR | E_PARSE);

require_once '../BackEnd/CRUD/inventarioCRUD.php';
require_once '../Validations/validarDatos.php';
require_once '../BackEnd/proteger.php';

$inventario = new InventarioCRUD();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        try {
            $partes = $inventario->obtenerPartes();
            echo json_encode($partes);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error al obtener partes: ' . $e->getMessage()]);
        }
        break;

    case 'POST':
        try {
            $data = sanitizarArray($_POST);

            // Manejar subida de imagen
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
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo guardar en la base de datos']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Excepción en POST: ' . $e->getMessage()]);
        }
        break;

    case 'DELETE':
        try {
            parse_str(file_get_contents("php://input"), $del_vars);
            $success = $inventario->eliminarParte($del_vars['id']);
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo eliminar']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Excepción en DELETE: ' . $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Método HTTP no soportado']);
        break;
}
?>
