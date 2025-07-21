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
    <div class="container" data-rol="<?php echo $_SESSION['rol']; ?>">
        <h1>👥 Gestión de Usuarios</h1>

        <!-- Formulario de Creación de Usuario -->
        <form id="formUsuario" class="user-form">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="usuario" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            
            <select name="rol" id="rol" required>
                <option value="empleado">Empleado</option>
                <option value="admin">Administrador</option>
            </select>

            <fieldset id="fieldsetPermisos">
                <legend>Permisos</legend>
                <!-- Aquí se llenarán los permisos según el rol -->
            </fieldset>

            <button type="submit">Agregar Usuario</button>
        </form>

        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
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

    <script>
        // Obtener el rol del contenedor HTML
        const rol = document.querySelector('.container').getAttribute('data-rol');

        // Script para manejar la carga dinámica de los permisos
        document.addEventListener("DOMContentLoaded", function() {
            const rolSelect = document.getElementById('rol');
            const fieldsetPermisos = document.getElementById('fieldsetPermisos');
            
            // Llenar permisos cuando el rol cambie
            rolSelect.addEventListener('change', function() {
                const rol = rolSelect.value;
                actualizarPermisos(rol);
            });

            // Función para actualizar los permisos según el rol
            function actualizarPermisos(rol) {
                // Limpiar el campo de permisos
                fieldsetPermisos.innerHTML = '<legend>Permisos</legend>';

                if (rol === 'admin') {
                    // Si el rol es admin, mostrar todos los permisos (sin "movimientos")
                    fieldsetPermisos.innerHTML += `
                        <label><input type="checkbox" name="permisos[]" value="inventario" checked> Inventario</label><br>
                        <label><input type="checkbox" name="permisos[]" value="secciones" checked> Secciones</label><br>
                        <label><input type="checkbox" name="permisos[]" value="usuarios" checked> Usuarios</label><br>
                    `;
                } else if (rol === 'empleado') {
                    // Si el rol es empleado, mostrar solo permisos para inventario y secciones
                    fieldsetPermisos.innerHTML += `
                        <label><input type="checkbox" name="permisos[]" value="inventario" checked> Inventario</label><br>
                        <label><input type="checkbox" name="permisos[]" value="secciones" checked> Secciones</label><br>
                    `;
                }
            }

            // Llenar los permisos por defecto según el rol actual
            actualizarPermisos(rol);
        });
    </script>
</body>
</html>
