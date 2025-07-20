<?php
require_once '../BackEnd/CRUD/seccionesCRUD.php';
require_once '../Validations/validarDatos.php';
require_once '../BackEnd/proteger.php';

$secciones = new SeccionesCRUD();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($secciones->obtenerSecciones());
        break;

    case 'POST':
        $data = sanitizarArray($_POST);
        if ($secciones->agregarSeccion($data['nombre_seccion'], $data['descripcion'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $put_vars);
        if ($secciones->actualizarSeccion($put_vars['id'], $put_vars['nombre_seccion'], $put_vars['descripcion'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $del_vars);
        if ($secciones->eliminarSeccion($del_vars['id'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;
}
?>
