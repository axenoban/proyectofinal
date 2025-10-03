<?php
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../includes/control.php';

$pedidoModel = new Pedido();
$clienteModel = new Cliente();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $pedidos = $pedidoModel->obtenerTodos();
        include __DIR__ . '/../views/pedido/pedido.php';
        break;

    case 'create':
        $clientes = $clienteModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = isset($_SESSION['user']['id']) ? (int) $_SESSION['user']['id'] : null;
            if (!$usuario_id) {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Sesión expirada. Vuelve a iniciar sesión.']);
                exit;
            }
            $cliente_id = (int) ($_POST['cliente_id'] ?? 0);
            $hora_entrega = isset($_POST['hora_entrega']) && $_POST['hora_entrega'] !== '' ? $_POST['hora_entrega'] : null;
            $total = $_POST['total'];
            $metodo = trim($_POST['metodo'] ?? '');
            $comentarios = trim($_POST['comentarios'] ?? '');
            $comentarios = $comentarios === '' ? null : $comentarios;
            $detalle = json_decode($_POST['detalle_json'] ?? '[]', true) ?: [];

            $metodosPermitidos = ['tienda', 'delivery', 'mayorista'];
            if (!$cliente_id || empty($detalle) || !in_array($metodo, $metodosPermitidos, true)) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Selecciona un cliente, un canal válido y agrega al menos un producto.']);
                exit;
            }

            $pedido_id = $pedidoModel->guardarPedido($usuario_id, $cliente_id, $hora_entrega, $total, $metodo, $comentarios, $detalle);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'ok', 'pedido_id' => $pedido_id]);
            exit;
        }

        include __DIR__ . '/../views/pedido/crear.php';
        break;


    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pedido = $pedidoModel->obtenerPedidoPorId($id);
            // Solo se permite eliminar si la orden está en estado "pendiente"
            if ($pedido && $pedido['estado'] === 'pendiente') {
                $pedidoModel->eliminarPedido($id);
                echo "<script>alert('Orden eliminada correctamente');window.location.href='PedidoController.php?action=index';</script>";
            } else {
                echo "<script>alert('No se puede eliminar esta orden');window.location.href='PedidoController.php?action=index';</script>";
            }
        }
        exit;

    case 'entregar':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pedido = $pedidoModel->obtenerPedidoPorId($id);
            if ($pedido && ($pedido['estado'] === 'pendiente' || $pedido['estado'] === 'en confección')) {
                $pedidoModel->actualizarEstadoPedido($id, 'listo');
                echo "<script>alert('Orden marcada como lista para entrega');window.location.href='PedidoController.php?action=index';</script>";
            } else {
                echo "<script>alert('Esta orden no puede marcarse como lista');window.location.href='PedidoController.php?action=index';</script>";
            }
        }
        exit;

    case 'anular':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pedido = $pedidoModel->obtenerPedidoPorId($id);
            if ($pedido && $pedido['estado'] === 'pendiente') {
                $pedidoModel->actualizarEstadoPedido($id, 'cancelado');
                echo "<script>alert('Orden cancelada correctamente');window.location.href='PedidoController.php?action=index';</script>";
            } else {
                echo "<script>alert('Esta orden no puede cancelarse');window.location.href='PedidoController.php?action=index';</script>";
            }
        }
        exit;

    case 'edit':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: PedidoController.php?action=index');
            exit;
        }

        $pedido = $pedidoModel->obtenerPedidoPorId($id);
        $detalle = $pedidoModel->obtenerDetalle($id);
        $clientes = $clienteModel->getAll();

        if (!$pedido || $pedido['estado'] !== 'pendiente') {
            echo "<script>alert('No se puede editar esta orden');window.location.href='PedidoController.php?action=index';</script>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = isset($_SESSION['user']['id']) ? (int) $_SESSION['user']['id'] : null;
            if (!$usuario_id) {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Sesión expirada. Vuelve a iniciar sesión.']);
                exit;
            }
            $cliente_id = (int) ($_POST['cliente_id'] ?? 0);
            $hora_entrega = isset($_POST['hora_entrega']) && $_POST['hora_entrega'] !== '' ? $_POST['hora_entrega'] : null;
            $total = $_POST['total'];
            $metodo = trim($_POST['metodo'] ?? '');
            $comentarios = trim($_POST['comentarios'] ?? '');
            $comentarios = $comentarios === '' ? null : $comentarios;
            $detalle = json_decode($_POST['detalle_json'] ?? '[]', true) ?: [];

            $metodosPermitidos = ['tienda', 'delivery', 'mayorista'];
            if (!$cliente_id || empty($detalle) || !in_array($metodo, $metodosPermitidos, true)) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Selecciona un cliente, un canal válido y agrega al menos un producto.']);
                exit;
            }

            $pedidoModel->actualizarPedido($id, $cliente_id, $hora_entrega, $total, $metodo, $comentarios, $detalle);

            echo "<script>alert('Orden actualizada correctamente');window.location.href='PedidoController.php?action=index';</script>";
            exit;
        }

        include __DIR__ . '/../views/pedido/editar.php';
        break;

    default:
        header('Location: PedidoController.php?action=index');
        exit;
}
