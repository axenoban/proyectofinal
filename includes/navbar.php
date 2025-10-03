<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/proyectofinal/views/dashboard.php"><i class="bi bi-scissors"></i> Textil Camila</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/proyectofinal/views/dashboard.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/proyectofinal/controllers/PedidoController.php?action=index">Órdenes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/proyectofinal/views/factura/factura_list.php">Facturas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/proyectofinal/controllers/PlatoController.php?action=index">Productos</a>
        </li>
      </ul>

      <span class="navbar-text text-white me-3">
        Hola, <?= htmlspecialchars($_SESSION['user']['nombre'] ?? 'Invitado') ?>
      </span>

      <form action="/proyectofinal/controllers/logout.php" method="POST" class="d-flex">
        <button type="submit" class="btn btn-outline-light">Cerrar sesión</button>
      </form>
    </div>
  </div>
</nav>