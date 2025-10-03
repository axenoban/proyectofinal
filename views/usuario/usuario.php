<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<?php if (!isset($usuario) || !is_array($usuario)) { $usuario = []; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Equipo Textil Camila</title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />

<style>
table.datatable th, table.datatable td { white-space: nowrap; min-width: 100px; }
</style>
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Equipo y accesos</h2>
    <a href="/proyectofinal/controllers/UsuarioController.php?action=create" class="btn btn-success">
      <i class="bi bi-person-plus-fill"></i> Nuevo usuario
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped datatable" style="width:100%">
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Nombre</th>
          <th>Rol</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if(count($usuario) === 0): ?>
          <tr><td colspan="5" class="text-center">No hay usuarios registrados.</td></tr>
        <?php else: ?>
          <?php foreach ($usuario as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['username']) ?></td>
              <td><?= htmlspecialchars($user['nombre']) ?></td>
              <td><?= htmlspecialchars($user['rol']) ?></td>
              <td><?= htmlspecialchars($user['estado']) ?></td>
              <td>
                <a href="/proyectofinal/controllers/UsuarioController.php?action=edit&id=<?= $user['id'] ?>" class="btn btn-sm btn-warning me-1" title="Editar">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="/proyectofinal/controllers/UsuarioController.php?action=delete&id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Seguro que quieres eliminar?');">
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