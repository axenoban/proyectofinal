<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Editar cliente</title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <h2>Editar cliente</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="/proyectofinal/controllers/ClienteController.php?action=edit&id=<?= htmlspecialchars($cliente['id']) ?>">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= htmlspecialchars($cliente['nombre'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono</label>
      <input type="text" id="telefono" name="telefono" class="form-control" value="<?= htmlspecialchars($cliente['telefono'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección</label>
      <textarea id="direccion" name="direccion" class="form-control" rows="2"><?= htmlspecialchars($cliente['direccion'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
      <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
      <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($cliente['fecha_nacimiento'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="notas" class="form-label">Notas</label>
      <textarea id="notas" name="notas" class="form-control" rows="2"><?= htmlspecialchars($cliente['notas'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar cliente</button>
    <a href="/proyectofinal/controllers/ClienteController.php?action=index" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>