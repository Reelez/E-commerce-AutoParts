<?php
require_once '../BackEnd/CRUD/usuarioCRUD.php';
header('Content-Type: application/json'); // Aseguramos que la respuesta sea JSON

$crud = new UsuariosCRUD();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        try {
            echo json_encode($crud->obtenerUsuarios());
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error al obtener usuarios: ' . $e->getMessage()]);
        }
        break;

    case 'POST':
        try {
            // Recibimos los datos del formulario
            $nombre = $_POST['nombre'];
            $usuario = $_POST['usuario'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $rol = $_POST['rol'];  // Valor del rol (admin o empleado)
            
            // Si no hay permisos seleccionados, los dejamos vacíos
            $permisos = isset($_POST['permisos']) ? array_fill_keys($_POST['permisos'], true) : [];
            $permisosJSON = json_encode($permisos);

            // Verificamos que todos los campos necesarios estén presentes
            if (empty($nombre) || empty($usuario) || empty($password) || empty($rol)) {
                echo json_encode(['success' => false, 'message' => 'Faltan datos en el formulario']);
                exit;
            }

            // Agregar usuario a la base de datos, pasando los permisos en JSON
            if ($crud->agregarUsuario($nombre, $usuario, $password, $rol, $permisosJSON)) {
                echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear usuario']);
            }
        } catch (Exception $e) {
            // Capturamos cualquier excepción y la mostramos como JSON
            echo json_encode(['success' => false, 'message' => 'Excepción: ' . $e->getMessage()]);
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

    default:
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        break;
}
?>
