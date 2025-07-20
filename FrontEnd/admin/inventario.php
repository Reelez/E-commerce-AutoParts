<?php require_once '../../BackEnd/proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Inventario</title>
    <link rel="stylesheet" href="../css/inventario.css">
</head>
<body>
    <div class="container">
        <h1>Inventario de Partes de Autos</h1>
        <form id="formInventario" class="inventory-form" enctype="multipart/form-data">
            <div class="form-group">
                <select name="marca_auto" id="marca_auto" class="styled-select" required>
                    <option value="">Seleccione Marca</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Honda">Honda</option>
                    <option value="Ford">Ford</option>
                    <option value="Chevrolet">Chevrolet</option>
                </select>

                <select name="modelo_auto" id="modelo_auto" class="styled-select" required disabled>
                    <option value="">Seleccione Modelo</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="nombre_parte" placeholder="Nombre de la parte" required>
                <input type="number" name="anio" placeholder="Año" required>
                <input type="number" step="0.01" name="costo" placeholder="Costo ($)" required>
                <input type="number" name="unidades" placeholder="Unidades" required>
            </div>
            <div class="form-group">
                <textarea name="descripcion" placeholder="Descripción" rows="2"></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="imagen" accept="image/*">
            </div>
            <button type="submit" class="btn-primary">Agregar Parte</button>
        </form>
    </div>
    <script src="../js/inventario.js"></script>
</body>
</html>
