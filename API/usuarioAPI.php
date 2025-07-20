<?php

require_once '../BackEnd/CRUD/usuarioCRUD.php';

require_once '../Validations/validarDatos.php';
require_once '../BackEnd/proteger.php';

$usuarioCRUD = new UsuarioCRUD();

// Determinar acción (GET, POST, PUT, DELETE)
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($usuarioCRUD->obtenerUsuarios());
        break;

    case 'POST':
        $nombre = sanitizarEntrada($_POST['nombre']);
        $usuario = sanitizarEntrada($_POST['usuario']);
        $password = $_POST['password'];
        $rol = sanitizarEntrada($_POST['rol']);

        if ($usuarioCRUD->crearUsuario($nombre, $usuario, $password, $rol)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $put_vars);
        $id = intval($put_vars['id']);
        $nombre = sanitizarEntrada($put_vars['nombre']);
        $rol = sanitizarEntrada($put_vars['rol']);

        if ($usuarioCRUD->actualizarUsuario($id, $nombre, $rol)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $del_vars);
        $id = intval($del_vars['id']);

        if ($usuarioCRUD->eliminarUsuario($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;
}
?>
