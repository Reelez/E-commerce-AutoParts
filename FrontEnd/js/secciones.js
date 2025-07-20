document.addEventListener('DOMContentLoaded', () => {
    cargarInventario(); // carga todos al abrir

    document.getElementById('ordenar').addEventListener('change', () => {
        cargarInventario();
    });
    document.getElementById('filtroEstado').addEventListener('change', () => {
        cargarInventario();
    });
});

function toggleActivo(id, activo) {
    const nuevoEstado = activo ? 0 : 1;
    fetch('../../API/seccionesAPI.php', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&campo=activo&valor=${nuevoEstado}`
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            // Mostrar mensaje dinámico
            const msg = nuevoEstado ? "✅ Producto activado para el público" : "⛔ Producto desactivado para el público";
            mostrarNotificacion(msg);

            // Refrescar la tabla para reflejar el cambio visualmente
            setTimeout(() => {
                cargarInventario();
            }, 300); // pequeño retraso visual para que se note
        } else {
            alert('❌ Error al actualizar el estado');
        }
    });
}

function mostrarNotificacion(mensaje) {
    const noti = document.getElementById('notificacion');
    noti.textContent = mensaje;
    noti.classList.add('visible');

    setTimeout(() => {
        noti.classList.remove('visible');
    }, 2000);
}




function cargarInventario() {
    const orden = document.getElementById('ordenar').value;
    const estado = document.getElementById('filtroEstado').value;
    const buscar = document.getElementById('buscar').value.trim().toLowerCase();

    fetch(`../../API/seccionesAPI.php?orden=${encodeURIComponent(orden)}&estado=${encodeURIComponent(estado)}`)
        .then(res => res.json())
        .then(data => {
            const tabla = document.getElementById('tablaInventario');
            tabla.innerHTML = '';

            let filtrado = data;
            if (buscar !== '') {
                filtrado = data.filter(p =>
                    p.nombre_parte.toLowerCase().includes(buscar)
                );
            }

            filtrado.forEach(p => {
                tabla.innerHTML += `
                    <tr class="${p.activo == 0 ? 'fila-desactivada' : ''}">
                        <td>${p.id}</td>
                        <td>${p.nombre_parte}</td>
                        <td>${p.marca_auto}</td>
                        <td>${p.modelo_auto}</td>
                        <td>${p.anio}</td>
                        <td>${p.descripcion}</td>
                        <td>$${p.costo}</td>
                        <td>${p.unidades}</td>
                        <td><img src="../../${p.imagen}" width="60"></td>
                        <td>
                            ${p.activo == 1 ? '<span class="badge badge-activo">Activo</span>' : '<span class="badge badge-inactivo">Desactivado</span>'}
                        </td>
                        <td>
                            <button onclick="toggleActivo(${p.id}, ${p.activo})" class="btn-toggle ${p.activo ? 'btn-activo' : 'btn-inactivo'}">
                                ${p.activo ? 'Desactivar' : 'Activar'}
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
}

// Escuchar eventos de búsqueda en tiempo real
document.getElementById('buscar').addEventListener('input', () => {
    cargarInventario();
});

