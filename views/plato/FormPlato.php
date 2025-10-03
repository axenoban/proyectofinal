<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Nuevo Plato</title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <h2>Nuevo Plato</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="/proyectofinal/controllers/PlatoController.php?action=create" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
      <label for="precio" class="form-label">Precio</label>
      <input type="number" step="0.01" min="0" id="precio" name="precio" class="form-control" required value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="categoria_id" class="form-label">Categoría</label>
      <select id="categoria_id" name="categoria_id" class="form-select" required>
        <option value="">Seleccione una categoría</option>
        <?php foreach ($categorias as $categoria): ?>
          <option value="<?= $categoria['id'] ?>" <?= (isset($_POST['categoria_id']) && $_POST['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($categoria['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select id="estado" name="estado" class="form-select" required>
        <option value="disponible" <?= (isset($_POST['estado']) && $_POST['estado'] == 'disponible') ? 'selected' : '' ?>>Disponible</option>
        <option value="agotado" <?= (isset($_POST['estado']) && $_POST['estado'] == 'agotado') ? 'selected' : '' ?>>Agotado</option>
        <option value="inactivo" <?= (isset($_POST['estado']) && $_POST['estado'] == 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="tiempo_preparacion" class="form-label">Tiempo de Preparación (minutos)</label>
      <input type="number" min="0" id="tiempo_preparacion" name="tiempo_preparacion" class="form-control" value="<?= htmlspecialchars($_POST['tiempo_preparacion'] ?? 0) ?>" />
    </div>


    <button type="submit" class="btn btn-primary">Crear Plato</button>
    <a href="/proyectofinal/controllers/PlatoController.php?action=index" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>