<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<?php require_once __DIR__ . '/../../models/Factura.php'; ?>

<?php
$facturaModel = new Factura();
$facturas = $facturaModel->obtenerTodasLasFacturas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lista de Facturas</title>
  <?php require_once __DIR__ . '/../../includes/header.php'; ?>
  <link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
  <link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <h2>Lista de Facturas</h2>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>N° Factura</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($facturas) === 0): ?>
        <tr><td colspan="5" class="text-center">No hay facturas registradas.</td></tr>
      <?php else: ?>
        <?php foreach ($facturas as $factura): ?>
          <tr>
            <td><?= htmlspecialchars($factura['numero_factura']) ?></td>
            <td><?= htmlspecialchars($factura['cliente_nombre']) ?></td>
            <td><?= $factura['fecha'] ?></td>
            <td><?= $factura['estado'] ?></td>
            <td>
              <a href="/proyectofinal/controllers/FacturaController.php?id=<?= $factura['id'] ?>" class="btn btn-sm btn-primary" target="_blank">
                <i class="bi bi-printer"></i> Generar PDF
              </a>
              <a href="/proyectofinal/controllers/FacturaController.php?action=view&id=<?= $factura['id'] ?>" class="btn btn-sm btn-info">
                <i class="bi bi-eye"></i> Ver Detalles
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>