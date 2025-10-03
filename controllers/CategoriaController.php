<?php
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../includes/control.php';

$categoriaModel = new Categoria();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $categorias = $categoriaModel->getAll();
        include __DIR__ . '/../views/categoria/categoria.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'] ?? 'activo';

            if ($categoriaModel->existsByName($nombre)) {
                $error = "La categoría con ese nombre ya existe.";
                include __DIR__ . '/../views/categoria/FormCategoria.php';
                exit;
            }

            $categoriaModel->create($nombre, $estado);
            header('Location: CategoriaController.php?action=index');
            exit;
        }

        include __DIR__ . '/../views/categoria/FormCategoria.php';
        break;

    case 'edit':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: CategoriaController.php?action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'] ?? 'activo';

            if ($categoriaModel->existsByName($nombre, $id)) {
                $error = "La categoría con ese nombre ya existe.";
                $categoria = $categoriaModel->getById($id);
                include __DIR__ . '/../views/categoria/EditCategoria.php';
                exit;
            }

            $categoriaModel->update($id, $nombre, $estado);
            header('Location: CategoriaController.php?action=index');
            exit;
        }

        $categoria = $categoriaModel->getById($id);
        include __DIR__ . '/../views/categoria/EditCategoria.php';
        break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $categoriaModel->delete($id);
        }
        header('Location: CategoriaController.php?action=index');
        exit;

    default:
        header('Location: CategoriaController.php?action=index');
        exit;
}