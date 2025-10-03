<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<?php if (!isset($clientes) || !is_array($clientes)) { $clientes = []; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Clientes Textil Camila</title>
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
    <h2>Boutiques y clientes</h2>
    <a href="/proyectofinal/controllers/ClienteController.php?action=create" class="btn btn-success">
      <i class="bi bi-person-plus-fill"></i> Nuevo cliente
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped datatable" style="width:100%">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Email</th>
          <th>Dirección</th>

          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clientes as $cliente): ?>
          <tr>
            <td><?= htmlspecialchars($cliente['nombre'] ?? '') ?></td>
            <td><?= htmlspecialchars($cliente['telefono'] ?? '') ?></td>
            <td><?= htmlspecialchars($cliente['email'] ?? '') ?></td>
            <td><?= htmlspecialchars($cliente['direccion'] ?? '') ?></td>
            <td>
              <a href="/proyectofinal/controllers/ClienteController.php?action=edit&id=<?= $cliente['id'] ?>" class="btn btn-sm btn-warning me-1" title="Editar">
                <i class="bi bi-pencil-square"></i>
              </a>
              <a href="/proyectofinal/controllers/ClienteController.php?action=delete&id=<?= $cliente['id'] ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Seguro que quieres eliminar este cliente?');">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<!-- Scripts DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>