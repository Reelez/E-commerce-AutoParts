const marcaSelect = document.getElementById('marca_auto');
const modeloSelect = document.getElementById('modelo_auto');

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
        modeloSelect.disabled = false;  // Habilitar el campo modelo
    } else {
        modeloSelect.disabled = true;  // Deshabilitar el campo modelo si no hay marca seleccionada
    }
});
