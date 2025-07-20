<?php
require_once '../../BackEnd/proteger.php';
require_once '../../BackEnd/conexion.php';
require_once '../../BackEnd/tcpdf/tcpdf.php';

$db = new Database();
$conn = $db->getConnection();

$nombreUsuario = isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Invitado';
$fecha = date('Y-m-d H:i:s');

// ✅ Obtener el carrito
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
if (empty($carrito)) {
    die("🛒 El carrito está vacío.");
}

// ✅ Traer los productos comprados
$placeholders = implode(',', array_fill(0, count($carrito), '?'));
$stmt = $conn->prepare("SELECT * FROM inventario_partes WHERE id IN ($placeholders)");
$stmt->execute(array_keys($carrito));
$productos = $stmt->fetchAll();

// 🧮 Calcular subtotal, ITBMS y total
$subtotal = 0;
$stockError = false;
foreach ($productos as $producto) {
    $cantidad = $carrito[$producto['id']];
    $subtotal += $producto['costo'] * $cantidad;

    // ✅ Validar stock disponible
    if ($producto['unidades'] < $cantidad) {
        $stockError = true;
    }
}

if ($stockError) {
    die("❌ No hay suficiente stock para uno o más productos.");
}

$itbms = $subtotal * 0.07; // 📌 7% impuesto
$totalPagar = $subtotal + $itbms;

// ✅ Actualizar inventario
foreach ($productos as $producto) {
    $cantidad = $carrito[$producto['id']];
    $stmtUpdate = $conn->prepare("UPDATE inventario_partes SET unidades = unidades - ? WHERE id = ?");
    $stmtUpdate->execute([$cantidad, $producto['id']]);
}

// 📄 Crear PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistema de Inventario');
$pdf->SetTitle('Factura de Compra');
$pdf->SetHeaderData('', 0, 'Factura de Compra', "Cliente: $nombreUsuario\nFecha: $fecha", [255, 112, 67], [255, 255, 255]);
$pdf->setHeaderFont(['helvetica', '', 12]);
$pdf->setFooterFont(['helvetica', '', 10]);
$pdf->SetMargins(15, 30, 15);
$pdf->AddPage();

// 🖋️ Título
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Detalle de la Compra', 0, 1, 'C');
$pdf->Ln(5);

// 📝 Tabla de productos
$pdf->SetFont('helvetica', '', 12);
$html = '<table border="1" cellpadding="5">
<tr style="background-color:#FF7043; color:#fff;">
    <th>Producto</th>
    <th>Descripción</th>
    <th>Precio Unitario</th>
    <th>Cantidad</th>
    <th>Total</th>
</tr>';

foreach ($productos as $p) {
    $cantidad = $carrito[$p['id']];
    $total = $p['costo'] * $cantidad;
    $html .= '<tr>
        <td>' . htmlspecialchars($p['nombre_parte']) . '</td>
        <td>' . htmlspecialchars($p['descripcion']) . '</td>
        <td>$' . number_format($p['costo'], 2) . '</td>
        <td>' . $cantidad . '</td>
        <td>$' . number_format($total, 2) . '</td>
    </tr>';
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// 💵 Mostrar costos
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 8, "Subtotal: $" . number_format($subtotal, 2), 0, 1, 'R');
$pdf->Cell(0, 8, "ITBMS (7%): $" . number_format($itbms, 2), 0, 1, 'R');

$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, "Total a Pagar: $" . number_format($totalPagar, 2), 0, 1, 'R');

// 🧹 Vaciar carrito
unset($_SESSION['carrito']);

// 📤 Mostrar PDF
$pdf->Output('factura_' . date('Ymd_His') . '.pdf', 'I');
?>
