<?php
session_start();
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = $_POST['password'] ?? '';

    $usuario = new Usuario();

    try {
        $user = $usuario->login($username, $password);
    } catch (Throwable $e) {
        $_SESSION['login_error'] = 'No se pudo validar tus credenciales. Verifica la base de datos.';
        header('Location: ../index.php');
        exit;
    }

    if ($user) {
        $_SESSION['user'] = $user;
        unset($_SESSION['login_error']);
        header('Location: ../views/dashboard.php');
        exit;
    }

    $_SESSION['login_error'] = 'Usuario o contraseña incorrecta.';
    header('Location: ../index.php');
    exit;
}

header('Location: ../index.php');
exit;
