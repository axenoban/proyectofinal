<?php require_once __DIR__ . '/../includes/control.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BIENVENIDO</title>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css">
    <link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css">
</head>

<body>

    <?php require_once __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container mt-5">
        <h1>Bienvenido a FAST FOOD</h1>

    </div>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-4">
                <a href="../controllers/ClienteController.php?action=index">
                    <div class="card text-center p-3" id="card1">
                        <div class="card-body">
                            <h5 class="card-title text-center"><i class="bi bi-person-fill"></i> Clientes</h5>
                            <p class="card-text">Gestiona la información de los clientes, incluyendo datos de contacto.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="../controllers/PlatoController.php?action=index">
                    <div class="card text-center p-3" id="card2">
                        <div class="card-body">
                            <h5 class="card-title text-center"><i class="bi bi-fork-knife"></i> Platos</h5>
                            <p class="card-text">Administra el menú del restaurante con detalles de cada plato y sus ingredientes.</p>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-md-4">
                <a href="../controllers/CategoriaController.php?action=index">
                    <div class="card text-center p-3" id="card3">
                        <div class="card-body">
                            <h5 class="card-title text-center"><i class="bi bi-box"></i> Categorias</h5>
                            <p class="card-text">Clasifica los platos en categorías para facilitar la navegación y búsqueda.</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <a href="../controllers/PagoController.php?action=index">
                    <div class="card text-center p-3" id="card4">
                        <div class="card-body">
                            <h5 class="card-title text-center"><i class="bi bi-receipt"></i> Facturas</h5>
                            <p class="card-text">Genera y administra las facturas emitidas para cada pedido realizado.</p>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-md-4">
                <a href="../controllers/PedidoController.php?action=index">
                    <div class="card text-center p-3" id="card5">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-card-checklist"></i> Pedidos</h5>
                            <p class="card-text">Registra y supervisa los pedidos, desde la creación hasta la entrega final.</p>
                        </div>
                    </div>


            </div>
            <div class="col-md-4">
                <a href="../controllers/UsuarioController.php?action=index">
                    <div class="card text-center p-3" id="card6">
                        <div class="card-body">
                            <h5 class="card-title "><i class="bi bi-person-bounding-box"></i> Usuarios</h5>
                            <p class="card-text">Gestiona los usuarios del sistema con roles y permisos asignados.</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>






    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>