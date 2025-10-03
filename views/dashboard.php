<?php require_once __DIR__ . '/../includes/control.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel Textil Camila</title>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css">
    <link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css">
</head>

<body>

    <?php require_once __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="dashboard-hero">
            <h1>Bienvenida al panel Textil Camila</h1>
            <p>Gestiona clientes, colecciones, productos y órdenes de confección desde un solo lugar.</p>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <a href="../controllers/ClienteController.php?action=index" class="text-decoration-none">
                    <div class="card text-center p-4 dash-card">
                        <div class="card-body">
                            <i class="bi bi-people-fill"></i>
                            <h5 class="card-title">Clientes</h5>
                            <p class="card-text">Controla datos de boutiques aliadas y compradores frecuentes.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="../controllers/PlatoController.php?action=index" class="text-decoration-none">
                    <div class="card text-center p-4 dash-card">
                        <div class="card-body">
                            <i class="bi bi-shop"></i>
                            <h5 class="card-title">Productos</h5>
                            <p class="card-text">Actualiza el catálogo textil: blusas, sacos, vestidos y accesorios.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="../controllers/CategoriaController.php?action=index" class="text-decoration-none">
                    <div class="card text-center p-4 dash-card">
                        <div class="card-body">
                            <i class="bi bi-collection"></i>
                            <h5 class="card-title">Colecciones</h5>
                            <p class="card-text">Organiza cada temporada en categorías claras y fáciles de ubicar.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <a href="../views/factura/factura_list.php" class="text-decoration-none">
                    <div class="card text-center p-4 dash-card">
                        <div class="card-body">
                            <i class="bi bi-receipt"></i>
                            <h5 class="card-title">Facturas</h5>
                            <p class="card-text">Genera comprobantes listos para enviar a tus clientes.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="../controllers/PedidoController.php?action=index" class="text-decoration-none">
                    <div class="card text-center p-4 dash-card">
                        <div class="card-body">
                            <i class="bi bi-card-checklist"></i>
                            <h5 class="card-title">Órdenes</h5>
                            <p class="card-text">Haz seguimiento al avance de confección y entregas.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="../controllers/UsuarioController.php?action=index" class="text-decoration-none">
                    <div class="card text-center p-4 dash-card">
                        <div class="card-body">
                            <i class="bi bi-person-gear"></i>
                            <h5 class="card-title">Usuarios</h5>
                            <p class="card-text">Administra accesos del equipo comercial y de producción.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>






    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>