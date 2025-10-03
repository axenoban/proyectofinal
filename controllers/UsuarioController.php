<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../includes/control.php';

$usuarioModel = new Usuario();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $usuario = $usuarioModel->getAll();
        include __DIR__ . '/../views/usuario/usuario.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];

            if ($usuarioModel->existsUsername($username)) {
                $error = "El usuario ya existe. Por favor, elige otro.";
                include __DIR__ . '/../views/usuario/FormUsuario.php';
                exit;
            }

            $usuarioModel->create($username, $password, $nombre, $rol);
            header('Location: UsuarioController.php?action=index');
            exit;
        }

        include __DIR__ . '/../views/usuario/FormUsuario.php';
        break;

    case 'edit':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: UsuarioController.php?action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $estado = $_POST['estado'];
            $password = $_POST['password'] ?? '';

            if ($usuarioModel->existsUsernameExceptId($username, $id)) {
                $error = "El usuario ya existe. Por favor, elige otro.";
                $usuario = $usuarioModel->getById($id);
                include __DIR__ . '/../views/usuario/EditUsuario.php';
                exit;
            }

            $usuarioModel->update($id, $username, $nombre, $rol, $estado);

            if (!empty($password)) {
                $usuarioModel->updatePassword($id, $password);
            }

            header('Location: UsuarioController.php?action=index');
            exit;
        }

        $usuario = $usuarioModel->getById($id);
        include __DIR__ . '/../views/usuario/EditUsuario.php';
        break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $usuarioModel->delete($id);
        }
        header('Location: UsuarioController.php?action=index');
        exit;

    default:
        header('Location: UsuarioController.php?action=index');
        exit;
}
