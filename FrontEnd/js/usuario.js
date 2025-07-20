document.addEventListener('DOMContentLoaded', cargarUsuarios);

function cargarUsuarios() {
    fetch('../API/usuariosAPI.php')
    .then(res => res.json())
    .then(data => {
        const tabla = document.getElementById('tablaUsuarios');
        tabla.innerHTML = '';
        data.forEach(u => {
            tabla.innerHTML += `
                <tr>
                    <td>${u.id}</td>
                    <td>${u.nombre}</td>
                    <td>${u.usuario}</td>
                    <td>${u.rol}</td>
                    <td>
                        <button onclick="eliminarUsuario(${u.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    });
}

document.getElementById('formUsuario').addEventListener('submit', e => {
    e.preventDefault();
    const form = new FormData(e.target);
    fetch('../API/usuariosAPI.php', {
        method: 'POST',
        body: form
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Usuario agregado');
            cargarUsuarios();
            e.target.reset();
        } else {
            alert('Error al agregar usuario');
        }
    });
});

function eliminarUsuario(id) {
    fetch('../API/usuariosAPI.php', {
        method: 'DELETE',
        body: new URLSearchParams({id})
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Usuario eliminado');
            cargarUsuarios();
        } else {
            alert('Error al eliminar');
        }
    });
}
