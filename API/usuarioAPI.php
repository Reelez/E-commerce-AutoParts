<?php
require_once '../BackEnd/CRUD/usuariosCRUD.php';
header('Content-Type: application/json');

$crud = new UsuariosCRUD();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($crud->obtenerUsuarios());
        break;

        
        case 'PUT':
    parse_str(file_get_contents("php://input"), $put_vars);
    $id = $put_vars['id'];
    $nombre = $put_vars['nombre'];
    $usuario = $put_vars['usuario'];
    $rol = $put_vars['rol'];
    $permisos = json_encode($put_vars['permisos']);

    $password = $put_vars['password'] ?? null;
    $hashedPassword = $password ? password_hash($password, PASSWORD_BCRYPT) : null;

    $success = $crud->editarUsuario($id, $nombre, $usuario, $hashedPassword, $rol, $permisos);
    echo json_encode(['success' => $success]);
    break;


    case 'POST':
        $usuario = $_POST['usuario'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $rol = $_POST['rol'];
        $permisos = isset($_POST['permisos']) ? array_fill_keys($_POST['permisos'], true) : [];
        $permisosJSON = json_encode($permisos);

        if ($crud->agregarUsuario($usuario, $password, $rol, $permisosJSON)) {
            echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear usuario']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        if ($crud->eliminarUsuario($id)) {
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar usuario']);
        }
        break;
}
?>
