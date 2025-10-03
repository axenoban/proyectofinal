<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<?php if (!isset($categorias) || !is_array($categorias)) { $categorias = []; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Lista de Categorías</title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />

<!-- DataTables CSS -->
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

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Lista de Categorías</h2>
    <a href="/proyectofinal/controllers/CategoriaController.php?action=create" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Nueva Categoría
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped datatable" style="width:100%">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if(count($categorias) === 0): ?>
          <tr><td colspan="3" class="text-center">No hay categorías registradas.</td></tr>
        <?php else: ?>
          <?php foreach ($categorias as $categoria): ?>
            <tr>
              <td><?= htmlspecialchars($categoria['nombre']) ?></td>
              <td><?= htmlspecialchars($categoria['estado']) ?></td>
              <td>
                <a href="/proyectofinal/controllers/CategoriaController.php?action=edit&id=<?= $categoria['id'] ?>" class="btn btn-sm btn-warning me-1" title="Editar">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="/proyectofinal/controllers/CategoriaController.php?action=delete&id=<?= $categoria['id'] ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Seguro que quieres eliminar esta categoría?');">
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