<?php
require_once '../vendor/autoload.php';
require_once '../models/Pedido.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['id'])) {
    die("ID de pedido no proporcionado.");
}

$pedido_id = $_GET['id'];
$pedidoModel = new Pedido();
$pedido = $pedidoModel->obtenerPedidoPorId($pedido_id);
$detalle = $pedidoModel->obtenerDetalle($pedido_id);

if (!$pedido) {
    die("Pedido no encontrado.");
}

// Preparar HTML para PDF
ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2 { text-align: center; margin: 0; }
    .info, .detalle { width: 100%; margin-top: 10px; }
    .info td { padding: 3px; }
    .detalle { border-collapse: collapse; }
    .detalle th, .detalle td { border: 1px solid #000; padding: 4px; text-align: left; }
    .detalle th { background: #f0f0f0; }
    .total { text-align: right; margin-top: 10px; font-size: 14px; }
  </style>
</head>
<body>

<h2>Factura Pedido N° <?= $pedido['id'] ?></h2>

<table class="info">
  <tr>
    <td><strong>Cliente:</strong> <?= htmlspecialchars($pedido['cliente']) ?></td>
    <td><strong>Fecha:</strong> <?= $pedido['fecha'] ?></td>
  </tr>
  <tr>
    <td><strong>Dirección:</strong> <?= htmlspecialchars($pedido['direccion']) ?></td>
    <td><strong>Usuario:</strong> <?= htmlspecialchars($pedido['usuario']) ?></td>
  </tr>
  <tr>
    <td><strong>Método:</strong> <?= $pedido['metodo_pedido'] ?></td>
    <td><strong>Estado:</strong> <?= $pedido['estado'] ?></td>
  </tr>
</table>

<table class="detalle">
  <thead>
    <tr>
      <th>Plato</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php $total = 0; ?>
    <?php foreach ($detalle as $item): ?>
      <tr>
        <td><?= htmlspecialchars($item['nombre']) ?></td>
        <td><?= $item['cantidad'] ?></td>
        <td>Bs. <?= number_format($item['precio_unitario'], 2) ?></td>
        <td>Bs. <?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?></td>
      </tr>
      <?php $total += $item['cantidad'] * $item['precio_unitario']; ?>
    <?php endforeach; ?>
  </tbody>
</table>

<p class="total"><strong>Total:</strong> Bs. <?= number_format($total, 2) ?></p>

</body>
</html>
<?php
$html = ob_get_clean();

// Configurar DOMPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("pedido_{$pedido_id}.pdf", ["Attachment" => false]);