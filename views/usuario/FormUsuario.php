<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Nuevo usuario</title>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
<link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-5">
  <h2>Nuevo usuario</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="/proyectofinal/controllers/UsuarioController.php?action=create">
    <div class="mb-3">
      <label for="username" class="form-label">Usuario</label>
      <input type="text" id="username" name="username" class="form-control" required />
    </div>

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control" required />
    </div>

    <div class="mb-3">
      <label for="rol" class="form-label">Rol</label>
      <select id="rol" name="rol" class="form-select" required>
        <option value="admin">Admin</option>
        <option value="empleado">Empleado</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" id="password" name="password" class="form-control" required />
    </div>

    <button type="submit" class="btn btn-primary">Registrar usuario</button>
    <a href="/proyectofinal/controllers/UsuarioController.php?action=index" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>