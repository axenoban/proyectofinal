<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<?php require_once __DIR__ . '/../../models/Factura.php'; ?>

<?php
$facturaModel = new Factura();
$facturaId = $_GET['id'] ?? null;
$factura = $facturaId ? $facturaModel->obtenerFacturaPorId($facturaId) : null;
if (!$factura) {
    die('Factura no encontrada.');
}
$detalle = $facturaModel->obtenerDetalleFactura($factura['pedido_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Factura Textil Camila</title>
  <?php require_once __DIR__ . '/../../includes/header.php'; ?>
  <link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
  <link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <h2>Factura N° <?= htmlspecialchars($factura['numero_factura']) ?></h2>

  <?php
    $estadoFactura = [
      'emitida' => 'Emitida',
      'anulada' => 'Anulada'
    ];
  ?>

  <table class="table table-bordered">
    <tr>
      <th>Cliente</th>
      <td><?= htmlspecialchars($factura['cliente_nombre']) ?></td>
    </tr>
    <tr>
      <th>Fecha</th>
      <td><?= $factura['fecha'] ?></td>
    </tr>
    <tr>
      <th>RUC</th>
      <td><?= htmlspecialchars($factura['cliente_ruc'] ?? 'N/A') ?></td>
    </tr>
    <tr>
      <th>Dirección</th>
      <td><?= htmlspecialchars($factura['direccion']) ?></td>
    </tr>
    <tr>
      <th>Forma de pago</th>
      <td><?= htmlspecialchars($factura['forma_pago'] ?? 'Pendiente') ?></td>
    </tr>
    <tr>
      <th>Subtotal</th>
      <td>Bs. <?= number_format($factura['subtotal'], 2) ?></td>
    </tr>
    <tr>
      <th>IVA (13%)</th>
      <td>Bs. <?= number_format($factura['impuesto'], 2) ?></td>
    </tr>
    <tr>
      <th>Total</th>
      <td>Bs. <?= number_format($factura['total'], 2) ?></td>
    </tr>
    <tr>
      <th>Estado</th>
      <td><?= htmlspecialchars($estadoFactura[$factura['estado']] ?? ucfirst($factura['estado'])) ?></td>
    </tr>
  </table>

  <h4>Detalle de productos:</h4>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($detalle as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['nombre']) ?></td>
          <td><?= $item['cantidad'] ?></td>
          <td>Bs. <?= number_format($item['precio_unitario'], 2) ?></td>
          <td>Bs. <?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>