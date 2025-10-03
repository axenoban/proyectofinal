<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<?php require_once __DIR__ . '/../../models/Pedido.php'; ?>
<?php $pedidoModel = new Pedido(); ?>
<?php $pedidos = $pedidoModel->obtenerTodos(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Pedidos</title>
    <?php require_once __DIR__ . '/../../includes/header.php'; ?>
    <link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
    <link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />

    <style>
        table.datatable th,
        table.datatable td {
            white-space: nowrap;
            min-width: 100px;
        }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Lista de Pedidos</h2>
            <a href="/proyectofinal/controllers/PedidoController.php?action=create" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Nuevo Pedido
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Método</th>
                        <th>Total (Bs)</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pedidos) === 0): ?>
                        <tr>
                            <td colspan="8" class="text-center">No hay pedidos registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pedidos as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= htmlspecialchars($p['cliente']) ?></td>
                                <td><?= htmlspecialchars($p['usuario']) ?></td>
                                <td><?= htmlspecialchars($p['fecha']) ?></td>
                                <td><?= htmlspecialchars($p['metodo_pedido']) ?></td>
                                <td><?= number_format($p['total'], 2) ?></td>
                                <td><?= htmlspecialchars($p['estado']) ?></td>
                                <td>
                                    <a href="/proyectofinal/controllers/PedidoController.php?action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>

                                    <?php if ($p['estado'] === 'pendiente'): ?>
                                        <a href="/proyectofinal/controllers/PedidoController.php?action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este pedido?');">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </a>
                                        <a href="/proyectofinal/controllers/PedidoController.php?action=anular&id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary">
                                            <i class="bi bi-x-circle"></i> Anular
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($p['estado'] === 'pendiente' || $p['estado'] === 'en preparación'): ?>
                                        <a href="/proyectofinal/controllers/PedidoController.php?action=entregar&id=<?= $p['id'] ?>" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Entregado
                                        </a>
                                    <?php endif; ?>
                                    <a href="/proyectofinal/controllers/FacturaController.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-primary" target="_blank" title="Imprimir">
                                        <i class="bi bi-printer"></i> PDF
                                    </a>
                                    <a href="/proyectofinal/controllers/PagoController.php?action=pagar&id=<?= $p['id'] ?>" class="btn btn-sm btn-success">
                                        <i class="bi bi-cash"></i> Pagar
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>

</html>