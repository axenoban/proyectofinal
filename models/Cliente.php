<?php
require_once 'conexion.php';

class Cliente
{
    private $conn;

    public function __construct()
    {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    // Verificar si un cliente existe por email (puedes cambiar a telefono o nombre si quieres)
    public function existsCliente($email)
    {
        $stmt = $this->conn->prepare("SELECT 1 FROM clientes WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() !== false;
    }

    public function existsClienteExceptId($email, $id)
    {
        $stmt = $this->conn->prepare("SELECT 1 FROM clientes WHERE email = :email AND id != :id LIMIT 1");
        $stmt->execute(['email' => $email, 'id' => $id]);
        return $stmt->fetchColumn() !== false;
    }
    // Crear cliente
    public function create($nombre, $telefono, $email, $direccion, $fecha_nacimiento = null, $notas = null)
    {
        $stmt = $this->conn->prepare("INSERT INTO clientes (nombre, telefono, email, direccion, fecha_nacimiento, notas) VALUES (:nombre, :telefono, :email, :direccion, :fecha_nacimiento, :notas)");
        return $stmt->execute([
            'nombre' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'direccion' => $direccion,
            'fecha_nacimiento' => $fecha_nacimiento,
            'notas' => $notas
        ]);
    }

    // Obtener todos los clientes
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT id, nombre, telefono, email, direccion, fecha_nacimiento, notas FROM clientes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener cliente por ID
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, nombre, telefono, email, direccion, fecha_nacimiento, notas FROM clientes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar cliente
    public function update($id, $nombre, $telefono, $email, $direccion, $fecha_nacimiento = null, $notas = null)
    {
        $stmt = $this->conn->prepare("UPDATE clientes SET nombre = :nombre, telefono = :telefono, email = :email, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento, notas = :notas WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'direccion' => $direccion,
            'fecha_nacimiento' => $fecha_nacimiento,
            'notas' => $notas
        ]);
    }

    // Eliminar cliente
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM clientes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
