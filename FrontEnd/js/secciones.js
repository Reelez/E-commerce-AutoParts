document.addEventListener('DOMContentLoaded', cargarSecciones);

function cargarSecciones() {
    fetch('../API/seccionesAPI.php')
    .then(res => res.json())
    .then(data => {
        const tabla = document.getElementById('tablaSecciones');
        tabla.innerHTML = '';
        data.forEach(s => {
            tabla.innerHTML += `
                <tr>
                    <td>${s.id}</td>
                    <td>${s.nombre_seccion}</td>
                    <td>${s.descripcion}</td>
                    <td><button onclick="eliminarSeccion(${s.id})">Eliminar</button></td>
                </tr>
            `;
        });
    });
}

document.getElementById('formSeccion').addEventListener('submit', e => {
    e.preventDefault();
    const form = new FormData(e.target);
    fetch('../API/seccionesAPI.php', {
        method: 'POST',
        body: form
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Sección agregada');
            cargarSecciones();
            e.target.reset();
        } else {
            alert('Error al agregar sección');
        }
    });
});

function eliminarSeccion(id) {
    fetch('../API/seccionesAPI.php', {
        method: 'DELETE',
        body: new URLSearchParams({id})
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Sección eliminada');
            cargarSecciones();
        } else {
            alert('Error al eliminar');
        }
    });
}
