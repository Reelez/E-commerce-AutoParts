<?php require_once '../../BackEnd/proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Movimientos</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Movimientos de Inventario</h1>
        <form id="formMovimiento">
            <input type="number" name="id_parte" placeholder="ID de la Parte" required>
            <select name="tipo" required>
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
            </select>
            <input type="number" name="cantidad" placeholder="Cantidad" required>
            <textarea name="descripcion" placeholder="Descripción"></textarea>
            <button type="submit">Registrar Movimiento</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Parte</th><th>Tipo</th><th>Cantidad</th><th>Descripción</th><th>Fecha</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaMovimientos"></tbody>
        </table>
    </div>
    <script src="js/movimientos.js"></script>
</body>
</html>
