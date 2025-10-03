<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Editar Plato</title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <h2>Editar Plato</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="/proyectofinal/controllers/PlatoController.php?action=edit&id=<?= htmlspecialchars($plato['id']) ?>">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= htmlspecialchars($plato['nombre'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($plato['descripcion'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
      <label for="precio" class="form-label">Precio</label>
      <input type="number" step="0.01" min="0" id="precio" name="precio" class="form-control" required value="<?= htmlspecialchars($plato['precio'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="categoria_id" class="form-label">Categoría</label>
      <select id="categoria_id" name="categoria_id" class="form-select" required>
        <option value="">Seleccione una categoría</option>
        <?php foreach ($categorias as $categoria): ?>
          <option value="<?= $categoria['id'] ?>" <?= (isset($plato['categoria_id']) && $plato['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($categoria['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select id="estado" name="estado" class="form-select" required>
        <option value="disponible" <?= (isset($plato['estado']) && $plato['estado'] == 'disponible') ? 'selected' : '' ?>>Disponible</option>
        <option value="agotado" <?= (isset($plato['estado']) && $plato['estado'] == 'agotado') ? 'selected' : '' ?>>Agotado</option>
        <option value="inactivo" <?= (isset($plato['estado']) && $plato['estado'] == 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="tiempo_preparacion" class="form-label">Tiempo de Preparación (minutos)</label>
      <input type="number" min="0" id="tiempo_preparacion" name="tiempo_preparacion" class="form-control" value="<?= htmlspecialchars($plato['tiempo_preparacion'] ?? 0) ?>" />
    </div>

    <button type="submit" class="btn btn-primary">Actualizar Plato</button>
    <a href="/proyectofinal/controllers/PlatoController.php?action=index" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>