<?php
require_once __DIR__ . '/../models/Plato.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../includes/control.php';

$platoModel = new Plato();
$categoriaModel = new Categoria();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $platos = $platoModel->getAll();
        include __DIR__ . '/../views/plato/plato.php';
        break;

    case 'create':
        $categorias = $categoriaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'] ?? '';
            $precio = $_POST['precio'];
            $categoria_id = $_POST['categoria_id'];
            $estado = $_POST['estado'] ?? 'disponible';
            $tiempo_preparacion = $_POST['tiempo_preparacion'] ?? 0;

            $platoModel->create($nombre, $descripcion, $precio, $categoria_id, $estado, $tiempo_preparacion);

            header('Location: PlatoController.php?action=index');
            exit;
        }

        include __DIR__ . '/../views/plato/FormPlato.php';
        break;

    case 'edit':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: PlatoController.php?action=index');
            exit;
        }

        $categorias = $categoriaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'] ?? '';
            $precio = $_POST['precio'];
            $categoria_id = $_POST['categoria_id'];
            $estado = $_POST['estado'] ?? 'disponible';
            $tiempo_preparacion = $_POST['tiempo_preparacion'] ?? 0;

            $platoModel->update($id, $nombre, $descripcion, $precio, $categoria_id, $estado, $tiempo_preparacion);

            header('Location: PlatoController.php?action=index');
            exit;
        }

        $plato = $platoModel->getById($id);
        include __DIR__ . '/../views/plato/EditPlato.php';
        break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $platoModel->delete($id);
        }
        header('Location: PlatoController.php?action=index');
        exit;

    case 'json':
        $platos = $platoModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($platos);
        exit;

    default:
        header('Location: PlatoController.php?action=index');
        exit;
}