<?php
session_start();
$error = '';
if (isset($_GET['error']) && $_GET['error'] == 1) {
    $error = "Usuario o contraseña incorrecta";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Textil Camila - Acceso</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/proyectofinal/assets/css/login.css" />
</head>
<body>

<div class="login-card">
  <h2 class="login-title">Textil Camila</h2>


  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="/proyectofinal/controllers/login.php">
    <div class="mb-3">
      <label for="username" class="form-label">Correo corporativo</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="admin@gmail.com" required />
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña" required />
    </div>
    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>