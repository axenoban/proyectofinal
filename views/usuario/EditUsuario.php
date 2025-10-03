<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Editar Usuario</title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <h2>Editar Usuario</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="/proyectofinal/controllers/UsuarioController.php?action=edit&id=<?= htmlspecialchars($usuario['id']) ?>">
    <div class="mb-3">
      <label for="username" class="form-label">Usuario</label>
      <input type="text" id="username" name="username" class="form-control" required value="<?= htmlspecialchars($usuario['username'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>" />
    </div>

    <div class="mb-3">
      <label for="rol" class="form-label">Rol</label>
      <select id="rol" name="rol" class="form-select" required>
        <option value="admin" <?= (isset($usuario) && $usuario['rol'] === 'admin') ? 'selected' : '' ?>>Admin</option>
        <option value="empleado" <?= (isset($usuario) && $usuario['rol'] === 'empleado') ? 'selected' : '' ?>>Empleado</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select id="estado" name="estado" class="form-select" required>
        <option value="activo" <?= (isset($usuario) && $usuario['estado'] === 'activo') ? 'selected' : '' ?>>Activo</option>
        <option value="inactivo" <?= (isset($usuario) && $usuario['estado'] === 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Nueva Contraseña (dejar vacío para no cambiar)</label>
      <input type="password" id="password" name="password" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    <a href="/proyectofinal/controllers/UsuarioController.php?action=index" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>