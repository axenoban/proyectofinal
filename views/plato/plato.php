<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<?php if (!isset($platos) || !is_array($platos)) { $platos = []; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Catálogo Textil Camila</title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />

<style>
table.datatable th, table.datatable td {
  white-space: nowrap;
  min-width: 100px;
}
</style>
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<?php
  $estadoProductos = [
    'disponible' => 'Disponible',
    'agotado' => 'Agotado',
    'inactivo' => 'Inactivo'
  ];
?>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Catálogo de productos</h2>
    <a href="/proyectofinal/controllers/PlatoController.php?action=create" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Nuevo producto
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped datatable" style="width:100%">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Categoría</th>
          <th>Estado</th>
          <th>Tiempo confección (días)</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($platos) === 0): ?>
          <tr><td colspan="7" class="text-center">No hay productos registrados.</td></tr>
        <?php else: ?>
          <?php foreach ($platos as $plato): ?>
            <tr>
              <td><?= htmlspecialchars($plato['nombre']) ?></td>
              <td><?= htmlspecialchars($plato['descripcion']) ?></td>
              <td>$<?= number_format($plato['precio'], 2) ?></td>
              <td><?= htmlspecialchars($plato['categoria_nombre'] ?? 'Sin categoría') ?></td>
              <td><?= htmlspecialchars($estadoProductos[$plato['estado']] ?? ucfirst($plato['estado'])) ?></td>
              <td><?= htmlspecialchars($plato['tiempo_preparacion']) ?></td>
              <td>
                <a href="/proyectofinal/controllers/PlatoController.php?action=edit&id=<?= $plato['id'] ?>" class="btn btn-sm btn-warning me-1" title="Editar">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="/proyectofinal/controllers/PlatoController.php?action=delete&id=<?= $plato['id'] ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Seguro que quieres eliminar este producto?');">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>