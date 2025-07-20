<?php
require_once '../BackEnd/CRUD/seccionesCRUD.php';
header('Content-Type: application/json');

$crud = new SeccionesCRUD();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
    $orden = $_GET['orden'] ?? '';
    $estado = $_GET['estado'] ?? '';
    echo json_encode($crud->obtenerInventario($orden, $estado));
    break;





    case 'PUT':
    parse_str(file_get_contents("php://input"), $put_vars);
    $id = $put_vars['id'] ?? null;
    $campo = $put_vars['campo'] ?? '';
    $valor = $put_vars['valor'] ?? '';

    $success = false;
    if ($id && $campo && $valor !== '') {
        $success = $crud->actualizarInventario($id, $campo, $valor);
    }

    echo json_encode(['success' => $success]);
    break;


    default:
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
