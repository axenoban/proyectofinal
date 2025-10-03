<?php
session_start();
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario = new Usuario();
    $user = $usuario->login($username, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: ../views/dashboard.php');
        exit;
    } else {
        // Redirige a index.php con parámetro de error
        header('Location: ../index.php?error=1');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}