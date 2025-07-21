document.addEventListener("DOMContentLoaded", function () {
    const formInventario = document.getElementById("formInventario");
    const marcaSelect = document.getElementById("marca_auto");
    const modeloSelect = document.getElementById("modelo_auto");

    // Modelos por marca
    const modelosPorMarca = {
        'Toyota': ['Corolla', 'Hilux', 'RAV4'],
        'Honda': ['Civic', 'CR-V', 'Accord'],
        'Ford': ['Focus', 'Mustang', 'Explorer'],
        'Chevrolet': ['Spark', 'Silverado', 'Equinox']
    };

    // Evento para habilitar el campo modelo y cargar los modelos correspondientes
    marcaSelect.addEventListener('change', () => {
        const marca = marcaSelect.value;
        modeloSelect.innerHTML = '<option value="">Seleccione Modelo</option>';  // Limpiar opciones del modelo

        if (modelosPorMarca[marca]) {
            modelosPorMarca[marca].forEach(modelo => {
                const option = document.createElement('option');
                option.value = modelo;
                option.textContent = modelo;
                modeloSelect.appendChild(option);
            });
            modeloSelect.disabled = false;  // Habilitar el campo modelo si hay modelos disponibles
        } else {
            modeloSelect.disabled = true;  // Deshabilitar el campo modelo si no hay marca seleccionada
        }
    });

    // Manejar el envío del formulario
    formInventario.addEventListener("submit", function (event) {
        event.preventDefault(); // Evitar el comportamiento predeterminado de enviar el formulario

        const formData = new FormData(formInventario); // Obtener los datos del formulario

        fetch('../../API/inventarioAPI.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Obtener la respuesta del servidor
        .then(data => {
            // Verificar si la operación fue exitosa
            const notificacion = document.getElementById("notificacion");
            if (data.success) {
                // Mostrar notificación de éxito
                notificacion.textContent = data.message;
                notificacion.style.backgroundColor = "#28a745"; // Verde
                notificacion.style.display = "block";

                // Limpiar el formulario
                formInventario.reset();

                // Opcionalmente, puedes recargar el inventario o mantenerlo
            } else {
                // Mostrar error
                notificacion.textContent = data.message || 'Error al agregar la parte';
                notificacion.style.backgroundColor = "#dc3545"; // Rojo
                notificacion.style.display = "block";
            }

            // Después de 5 segundos, ocultar la notificación
            setTimeout(() => {
                notificacion.style.display = "none";
            }, 5000);
        })
        .catch(error => {
            console.error('Error al agregar la parte:', error);
        });
    });
});
