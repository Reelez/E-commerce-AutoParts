<?php require_once '../../BackEnd/proteger.php'; ?>
<?php if ($_SESSION['rol'] !== 'admin') { header('Location: dashboard.php'); exit; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../css/usuarios.css">
</head>
<body>
    <div class="container">
        <h1>👥 Gestión de Usuarios</h1>

        <form id="formUsuario" class="user-form">
    <input type="text" name="nombre" placeholder="Nombre completo" required>
    <input type="text" name="usuario" placeholder="Nombre de usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <select name="rol" required>
        <option value="empleado">Empleado</option>
        <option value="admin">Administrador</option>
    </select>
    <fieldset>
        <legend>Permisos</legend>
        <label><input type="checkbox" name="permisos[]" value="inventario"> Inventario</label>
        <label><input type="checkbox" name="permisos[]" value="movimientos"> Movimientos</label>
        <label><input type="checkbox" name="permisos[]" value="secciones"> Secciones</label>
    </fieldset>
    <button type="submit">Agregar Usuario</button>
</form>



        <table class="user-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th> <!-- Aquí debe salir el nombre del usuario -->
            <th>Rol</th>
            <th>Permisos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tablaUsuarios">
        <!-- Usuarios cargados vía JS -->
    </tbody>
</table>


    </div>

    <script src="../js/usuario.js"></script>
</body>
</html>
