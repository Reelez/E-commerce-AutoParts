<?php require_once '../../BackEnd/proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Secciones - Inventario</title>
    <link rel="stylesheet" href="../css/secciones.css">
</head>
<body>
    <div class="container">
        <h1>Secciones - Inventario</h1>
        <div id="notificacion" class="notificacion"></div>

        <div class="filter-section">
    <label for="buscar">Buscar producto:</label>
    <input type="text" id="buscar" placeholder="Escribe el nombre...">

    <label for="ordenar">Ordenar por:</label>
    <select id="ordenar" onchange="cargarInventario()">
        <option value="">-- Seleccionar --</option>
        <option value="nombre_parte ASC">Nombre (A-Z)</option>
        <option value="nombre_parte DESC">Nombre (Z-A)</option>
        <option value="costo ASC">Precio (menor a mayor)</option>
        <option value="costo DESC">Precio (mayor a menor)</option>
    </select>

    <label for="filtroEstado">Estado:</label>
    <select id="filtroEstado" onchange="cargarInventario()">
        <option value="">-- Todos --</option>
        <option value="1">Activos</option>
        <option value="0">Desactivados</option>
    </select>
</div>


        <table class="inventory-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Descripción</th>
                    <th>Costo</th>
                    <th>Unidades</th>
                    <th>Imagen</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaInventario">
                <!-- Las filas se llenarán con JS -->
            </tbody>
        </table>
    </div>
    <script src="../js/secciones.js"></script>
</body>
</html>
