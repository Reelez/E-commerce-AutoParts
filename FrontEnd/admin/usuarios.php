<?php require_once '../../BackEnd/proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Usuarios</h1>
        <form id="formUsuario">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <select name="rol" required>
                <option value="admin">Admin</option>
                <option value="usuario">Usuario</option>
            </select>
            <button type="submit">Agregar Usuario</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaUsuarios"></tbody>
        </table>
    </div>
    <script src="js/usuarios.js"></script>
</body>
</html>
