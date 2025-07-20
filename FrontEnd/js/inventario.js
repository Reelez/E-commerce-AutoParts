const marcaSelect = document.getElementById('marca_auto');
const modeloSelect = document.getElementById('modelo_auto');

const modelosPorMarca = {
    'Toyota': ['Corolla', 'Hilux', 'RAV4'],
    'Honda': ['Civic', 'CR-V', 'Accord'],
    'Ford': ['Focus', 'Mustang', 'Explorer'],
    'Chevrolet': ['Spark', 'Silverado', 'Equinox']
};

marcaSelect.addEventListener('change', () => {
    const marca = marcaSelect.value;
    modeloSelect.innerHTML = '<option value="">Seleccione Modelo</option>';
    if (modelosPorMarca[marca]) {
        modelosPorMarca[marca].forEach(modelo => {
            const option = document.createElement('option');
            option.value = modelo;
            option.textContent = modelo;
            modeloSelect.appendChild(option);
        });
        modeloSelect.disabled = false;
    } else {
        modeloSelect.disabled = true;
    }
});

function cargarInventario() {
    fetch('/SemestralDes/API/inventarioAPI.php')
        .then(res => res.json())
        .then(data => {
            const tabla = document.getElementById('tablaInventario');
            tabla.innerHTML = '';
            data.forEach(p => {
                tabla.innerHTML += `
                    <tr>
                        <td>${p.id}</td>
                        <td>${p.nombre_parte}</td>
                        <td>${p.marca_auto}</td>
                        <td>${p.modelo_auto}</td>
                        <td>${p.anio}</td>
                        <td>$${p.costo.toFixed(2)}</td>
                        <td>${p.unidades}</td>
                        <td>
                            ${p.imagen ? `<img src="/SemestralDes/${p.imagen}" alt="Imagen" style="width:60px;height:60px;">` : 'Sin imagen'}
                        </td>
                        <td>
                            <button onclick="eliminar(${p.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
        });
}

// Evento para agregar parte
document.getElementById('formInventario').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/SemestralDes/API/inventarioAPI.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Parte agregada');
            this.reset();
            cargarInventario();
        } else {
            alert('Error al agregar parte');
        }
    });
});


function eliminar(id) {
    if (!id) {
        console.error('ID no definido al intentar eliminar');
        return;
    }
    fetch('/SemestralDes/API/inventarioAPI.php', {
        method: 'DELETE',
        body: new URLSearchParams({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Parte eliminada');
            cargarInventario();
        } else {
            alert('Error al eliminar');
        }
    });
}

cargarInventario();
