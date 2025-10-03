<?php
require_once 'conexion.php';

class Categoria {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    // Obtener todas las categorías
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT id, nombre, estado FROM categorias");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener categoría por ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, nombre, estado FROM categorias WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear categoría
    public function create($nombre, $estado = 'activo') {
        $stmt = $this->conn->prepare("INSERT INTO categorias (nombre, estado) VALUES (:nombre, :estado)");
        return $stmt->execute(['nombre' => $nombre, 'estado' => $estado]);
    }

    // Actualizar categoría
    public function update($id, $nombre, $estado) {
        $stmt = $this->conn->prepare("UPDATE categorias SET nombre = :nombre, estado = :estado WHERE id = :id");
        return $stmt->execute(['id' => $id, 'nombre' => $nombre, 'estado' => $estado]);
    }

    // Eliminar categoría
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM categorias WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Verificar si existe categoría por nombre (para evitar duplicados)
    public function existsByName($nombre, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->conn->prepare("SELECT 1 FROM categorias WHERE nombre = :nombre AND id != :id LIMIT 1");
            $stmt->execute(['nombre' => $nombre, 'id' => $excludeId]);
        } else {
            $stmt = $this->conn->prepare("SELECT 1 FROM categorias WHERE nombre = :nombre LIMIT 1");
            $stmt->execute(['nombre' => $nombre]);
        }
        return $stmt->fetchColumn() !== false;
    }
}