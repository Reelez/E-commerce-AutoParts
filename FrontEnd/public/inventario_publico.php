<?php require_once '../../BackEnd/proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Público</title>
    <link rel="stylesheet" href="../css/publico.css">
</head>
<body>
    <div class="container">
        <h1>🚗 Inventario de Partes de Autos</h1>
        <div id="gridProductos" class="grid-productos"></div>
    </div>

    <script>
        // Cargar inventario público en grid
        fetch('../../API/inventarioAPI.php')
            .then(res => res.json())
            .then(data => {
                const grid = document.getElementById('gridProductos');
                grid.innerHTML = '';
                data.forEach(p => {
                    grid.innerHTML += `
                        <div class="card">
                            <div class="card-img">
                                ${p.imagen ? `<img src="../../${p.imagen}" alt="${p.nombre_parte}">` : '<div class="no-img">Sin Imagen</div>'}
                            </div>
                            <div class="card-body">
                                <h2>${p.nombre_parte}</h2>
                                <p><strong>Marca:</strong> ${p.marca_auto}</p>
                                <p><strong>Modelo:</strong> ${p.modelo_auto}</p>
                                <p><strong>Año:</strong> ${p.anio}</p>
                                <p><strong>Precio:</strong> $${parseFloat(p.costo).toFixed(2)}</p>
                            </div>
                        </div>
                    `;
                });
            });
    </script>
</body>
</html>
