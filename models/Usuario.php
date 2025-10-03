<?php
require_once 'conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }
    
    public function login($username, $password) {
    $sql = "SELECT * FROM usuarios WHERE username = :username AND estado = 'activo'";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

    // Verifica si username existe (para crear)
    public function existsUsername($username) {
        $stmt = $this->conn->prepare("SELECT 1 FROM usuarios WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetchColumn() !== false;
    }

    // Verifica si username existe para otro id (para editar)
    public function existsUsernameExceptId($username, $id) {
        $stmt = $this->conn->prepare("SELECT 1 FROM usuarios WHERE username = :username AND id != :id LIMIT 1");
        $stmt->execute(['username' => $username, 'id' => $id]);
        return $stmt->fetchColumn() !== false;
    }

    // Crear usuario
    public function create($username, $password, $nombre, $rol, $estado = 'activo') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (username, password, nombre, rol, estado) VALUES (:username, :password, :nombre, :rol, :estado)");
        return $stmt->execute([
            'username' => $username,
            'password' => $hash,
            'nombre' => $nombre,
            'rol' => $rol,
            'estado' => $estado
        ]);
    }

    // Obtener todos los usuarios
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT id, username, nombre, rol, estado FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener usuario por ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, nombre, rol, estado FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar usuario (sin cambiar contraseña)
    public function update($id, $username, $nombre, $rol, $estado) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET username = :username, nombre = :nombre, rol = :rol, estado = :estado WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'username' => $username,
            'nombre' => $nombre,
            'rol' => $rol,
            'estado' => $estado
        ]);
    }

    // Actualizar contraseña
    public function updatePassword($id, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'password' => $hash
        ]);
    }

    // Eliminar usuario
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}