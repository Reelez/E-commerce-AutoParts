document.addEventListener('DOMContentLoaded', cargarMovimientos);

function cargarMovimientos() {
    fetch('../API/movimientosAPI.php')
    .then(res => res.json())
    .then(data => {
        const tabla = document.getElementById('tablaMovimientos');
        tabla.innerHTML = '';
        data.forEach(m => {
            tabla.innerHTML += `
                <tr>
                    <td>${m.id}</td>
                    <td>${m.nombre_parte}</td>
                    <td>${m.tipo}</td>
                    <td>${m.cantidad}</td>
                    <td>${m.descripcion}</td>
                    <td>${m.creado_en}</td>
                    <td><button onclick="eliminarMovimiento(${m.id})">Eliminar</button></td>
                </tr>
            `;
        });
    });
}

document.getElementById('formMovimiento').addEventListener('submit', e => {
    e.preventDefault();
    const form = new FormData(e.target);
    fetch('../API/movimientosAPI.php', {
        method: 'POST',
        body: form
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Movimiento registrado');
            cargarMovimientos();
            e.target.reset();
        } else {
            alert('Error al registrar movimiento');
        }
    });
});

function eliminarMovimiento(id) {
    fetch('../API/movimientosAPI.php', {
        method: 'DELETE',
        body: new URLSearchParams({id})
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Movimiento eliminado');
            cargarMovimientos();
        } else {
            alert('Error al eliminar');
        }
    });
}
