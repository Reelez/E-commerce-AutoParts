<?php require_once '../../BackEnd/proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Secciones</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Secciones del Auto</h1>
        <form id="formSeccion">
            <input type="text" name="nombre_seccion" placeholder="Nombre de la Sección" required>
            <textarea name="descripcion" placeholder="Descripción"></textarea>
            <button type="submit">Agregar Sección</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Sección</th><th>Descripción</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaSecciones"></tbody>
        </table>
    </div>
    <script src="js/secciones.js"></script>
</body>
</html>
