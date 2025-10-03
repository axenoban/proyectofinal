<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../includes/control.php';

$clienteModel = new Cliente();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $clientes = $clienteModel->getAll();
        include __DIR__ . '/../views/cliente/cliente.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];
            $direccion = $_POST['direccion'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
            $notas = $_POST['notas'] ?? null;

            if ($clienteModel->existsCliente($email)) {
                $error = "El cliente con ese email ya existe.";
                include __DIR__ . '/../views/cliente/FormCliente.php';
                exit;
            }

            $clienteModel->create($nombre, $telefono, $email, $direccion, $fecha_nacimiento, $notas);
            header('Location: ClienteController.php?action=index');
            exit;
        }

        include __DIR__ . '/../views/cliente/FormCliente.php';
        break;

    case 'edit':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ClienteController.php?action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];
            $direccion = $_POST['direccion'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
            $notas = $_POST['notas'] ?? null;

            // Validar duplicado email excepto el cliente actual
            if ($clienteModel->existsClienteExceptId($email, $id)) {
                $error = "El cliente con ese email ya existe.";
                $cliente = $clienteModel->getById($id);
                include __DIR__ . '/../views/cliente/EditCliente.php';
                exit;
            }

            $clienteModel->update($id, $nombre, $telefono, $email, $direccion, $fecha_nacimiento, $notas);
            header('Location: ClienteController.php?action=index');
            exit;
        }

        $cliente = $clienteModel->getById($id);
        include __DIR__ . '/../views/cliente/EditCliente.php';
        break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $clienteModel->delete($id);
        }
        header('Location: ClienteController.php?action=index');
        exit;

    default:
        header('Location: ClienteController.php?action=index');
        exit;
}