<?php 
require_once '../../BackEnd/proteger.php';
// Evitar warning si no existe 'nombre' en la sesión
$nombreUsuario = isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Invitado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Público</title>
    <link rel="stylesheet" href="../css/publico.css?v=5">
</head>
<body>
    <!-- Header transparente -->
    <header class="header">
        <div class="header-left">
            <span class="usuario">👋 Bienvenido, <?php echo $nombreUsuario; ?></span>
        </div>
        <div class="header-center">
            <h1>🚗 Inventario de Partes de Autos</h1>
        </div>
        <div class="header-right">
            <a href="carrito.php" class="cart-btn">
                🛒 <span id="cart-count">
                    <?php echo isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0; ?>
                </span>
            </a>
            <a href="../../BackEnd/logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <!-- Contenido principal -->
    <div class="container">
        <div id="gridProductos" class="grid-productos"></div>
    </div>

    <!-- JS para cargar productos -->
    <script>
    fetch('../../API/inventarioAPI.php')
    .then(res => res.json())
    .then(data => {
        console.log('Datos recibidos:', data); // Agregar log para verificar los datos recibidos
        const grid = document.getElementById('gridProductos');
        grid.innerHTML = '';
        
        // Verificar si data es un array
        if (Array.isArray(data)) {
            data.forEach(p => {
                grid.innerHTML += `
                    <a href="detalle_pieza.php?id=${p.id}" class="card-link">
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
                    </a>
                `;
            });
        } else {
            // Si la respuesta no es un array, mostrar un error
            grid.innerHTML = '<p>Error: La respuesta no es un array.</p>';
        }
    })
    .catch(error => {
        console.error('Error cargando inventario:', error);
        document.getElementById('gridProductos').innerHTML = '<p>Error al cargar inventario.</p>';
    });

    </script>
</body>
</html>
