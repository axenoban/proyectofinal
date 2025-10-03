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
            $usuario_id = $_SESSION['usuario_id'] ?? 1; // cambia esto si ya usás sesión real
            $cliente_id = $_POST['cliente_id'];
            $hora_entrega = $_POST['hora_entrega'] ?? null;
            $total = $_POST['total'];
            $metodo = $_POST['metodo'];
            $comentarios = $_POST['comentarios'] ?? '';
            $detalle = json_decode($_POST['detalle_json'], true);

            if (!$cliente_id || empty($detalle)) {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
                exit;
            }

            $pedido_id = $pedidoModel->guardarPedido($usuario_id, $cliente_id, $hora_entrega, $total, $metodo, $comentarios, $detalle);

            echo json_encode(['status' => 'ok', 'pedido_id' => $pedido_id]);
            exit;
        }

        include __DIR__ . '/../views/pedido/crear.php';
        break;


    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pedido = $pedidoModel->obtenerPedidoPorId($id);
            // Solo se permite eliminar si el pedido está en estado "pendiente"
            if ($pedido && $pedido['estado'] === 'pendiente') {
                $pedidoModel->eliminarPedido($id);
                echo "<script>alert('Pedido eliminado correctamente');window.location.href='PedidoController.php?action=index';</script>";
            } else {
                echo "<script>alert('No se puede eliminar este pedido');window.location.href='PedidoController.php?action=index';</script>";
            }
        }
        exit;

    case 'entregar':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pedido = $pedidoModel->obtenerPedidoPorId($id);
            if ($pedido && $pedido['estado'] === 'pendiente' || $pedido['estado'] === 'en preparación') {
                $pedidoModel->actualizarEstadoPedido($id, 'entregado');
                echo "<script>alert('Pedido marcado como entregado');window.location.href='PedidoController.php?action=index';</script>";
            } else {
                echo "<script>alert('Este pedido no puede ser entregado');window.location.href='PedidoController.php?action=index';</script>";
            }
        }
        exit;

    case 'anular':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pedido = $pedidoModel->obtenerPedidoPorId($id);
            if ($pedido && $pedido['estado'] === 'pendiente') {
                $pedidoModel->actualizarEstadoPedido($id, 'anulado');
                echo "<script>alert('Pedido anulado correctamente');window.location.href='PedidoController.php?action=index';</script>";
            } else {
                echo "<script>alert('Este pedido no puede ser anulado');window.location.href='PedidoController.php?action=index';</script>";
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
            echo "<script>alert('No se puede editar este pedido');window.location.href='PedidoController.php?action=index';</script>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = $_SESSION['usuario_id'] ?? 1;
            $cliente_id = $_POST['cliente_id'];
            $hora_entrega = $_POST['hora_entrega'] ?? null;
            $total = $_POST['total'];
            $metodo = $_POST['metodo'];
            $comentarios = $_POST['comentarios'] ?? '';
            $detalle = json_decode($_POST['detalle_json'], true);

            if (!$cliente_id || empty($detalle)) {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
                exit;
            }

            $pedidoModel->actualizarPedido($id, $cliente_id, $hora_entrega, $total, $metodo, $comentarios, $detalle);

            echo "<script>alert('Pedido actualizado correctamente');window.location.href='PedidoController.php?action=index';</script>";
            exit;
        }

        include __DIR__ . '/../views/pedido/editar.php';
        break;

    default:
        header('Location: PedidoController.php?action=index');
        exit;
}
