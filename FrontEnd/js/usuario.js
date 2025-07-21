document.addEventListener('DOMContentLoaded', () => {
    cargarUsuarios();

    // Evento del formulario para agregar usuario
    document.getElementById('formUsuario').addEventListener('submit', e => {
        e.preventDefault();
        const form = new FormData(e.target);

        fetch('../../API/usuarioAPI.php', {  // Ruta correcta a la API
            method: 'POST',
            body: form
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                e.target.reset();
                cargarUsuarios();
            }
        });
    });
});

// Función para cargar los usuarios en la tabla
function cargarUsuarios() {
    fetch('../../API/usuarioAPI.php') // Cambiar a la ruta correcta de la API
        .then(res => res.json())
        .then(data => {
            const tabla = document.getElementById('tablaUsuarios');
            tabla.innerHTML = ''; // Limpiar la tabla

            data.forEach(user => {
                // Obtener permisos de usuario
                const permisos = Object.keys(user.permisos)
                    .filter(p => user.permisos[p])
                    .join(', ');

                // Agregar fila con datos correctamente distribuidos
                tabla.innerHTML += `
                    <tr id="fila-${user.id}">
                        <td>${user.id}</td>
                        <td>${user.usuario}</td> <!-- Asegurarse de que el nombre del usuario esté aquí -->
                        <td>${user.rol}</td>
                        <td>${permisos}</td>
                        <td>
                            <button onclick="eliminarUsuario(${user.id})" class="btn-delete">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
        });
}

// Función para eliminar usuarios
function eliminarUsuario(id) {
    if (confirm('¿Seguro que quieres eliminar este usuario?')) {
        fetch(`../../API/usuarioAPI.php?id=${id}`, { method: 'DELETE' }) // Ruta a la API de eliminar usuario
            .then(res => res.json())
            .then(data => {
                alert(data.message); // Muestra el mensaje del servidor
                if (data.success) {
                    cargarUsuarios(); // Recarga la tabla de usuarios
                }
            })
            .catch(error => alert('Error al eliminar usuario: ' + error));
    }
}
