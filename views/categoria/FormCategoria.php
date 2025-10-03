<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' ?></title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <h2><?= isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' ?></h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="/proyectofinal/controllers/CategoriaController.php?action=<?= isset($categoria) ? 'edit&id=' . $categoria['id'] : 'create' ?>">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= htmlspecialchars($categoria['nombre'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select id="estado" name="estado" class="form-select" required>
        <option value="activo" <?= (isset($categoria['estado']) && $categoria['estado'] === 'activo') ? 'selected' : '' ?>>Activo</option>
        <option value="inactivo" <?= (isset($categoria['estado']) && $categoria['estado'] === 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary"><?= isset($categoria) ? 'Actualizar' : 'Crear' ?></button>
    <a href="/proyectofinal/controllers/CategoriaController.php?action=index" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>