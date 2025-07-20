<?php
require_once '../BackEnd/CRUD/movimientosCRUD.php';
require_once '../Validations/validarDatos.php';
require_once '../BackEnd/proteger.php';

$movimientos = new MovimientosCRUD();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($movimientos->obtenerMovimientos());
        break;

    case 'POST':
        $data = sanitizarArray($_POST);
        if ($movimientos->agregarMovimiento($data['id_parte'], $data['tipo'], $data['cantidad'], $data['descripcion'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $put_vars);
        if ($movimientos->actualizarMovimiento($put_vars['id'], $put_vars['tipo'], $put_vars['cantidad'], $put_vars['descripcion'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $del_vars);
        if ($movimientos->eliminarMovimiento($del_vars['id'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;
}
?>
