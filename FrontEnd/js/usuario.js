document.addEventListener('DOMContentLoaded', () => {
    cargarUsuarios();

    document.getElementById('formUsuario').addEventListener('submit', e => {
        e.preventDefault();
        const form = new FormData(e.target);

        fetch('../../API/usuariosAPI.php', {
            method: 'POST',
            body: form
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            cargarUsuarios();
            e.target.reset();
        });
    });
});

function cargarUsuarios() {
    fetch('../../API/usuariosAPI.php')
        .then(res => res.json())
        .then(data => {
            const tabla = document.getElementById('tablaUsuarios');
            tabla.innerHTML = '';
            data.forEach(user => {
                const permisos = Object.keys(user.permisos).filter(p => user.permisos[p]).join(', ');
                tabla.innerHTML += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.usuario}</td>
                        <td>${user.rol}</td>
                        <td>${permisos}</td>
                        <td>
                            <button onclick="eliminarUsuario(${user.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function habilitarEdicion(id) {
    document.querySelectorAll(`#fila-${id} input, #fila-${id} select`).forEach(el => {
        el.disabled = false;
    });
    document.getElementById(`btn-editar-${id}`).style.display = 'none';
    document.getElementById(`btn-guardar-${id}`).style.display = 'inline-block';
}

function guardarCambios(id) {
    const fila = document.querySelector(`#fila-${id}`);
    const nombre = fila.querySelector('.nombre').value;
    const usuario = fila.querySelector('.usuario').value;
    const password = fila.querySelector('.password').value; // opcional
    const rol = fila.querySelector('.rol').value;
    const permisos = Array.from(fila.querySelectorAll('.permiso:checked')).map(e => e.value);

    fetch('../../API/usuariosAPI.php', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id, nombre, usuario, password, rol, permisos })
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            alert('Usuario actualizado');
            cargarUsuarios();
        } else {
            alert('Error al actualizar');
        }
    });
}


function eliminarUsuario(id) {
    if (confirm('¿Seguro que quieres eliminar este usuario?')) {
        fetch(`../../API/usuariosAPI.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                cargarUsuarios();
            });
    }
}
