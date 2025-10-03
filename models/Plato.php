<?php
require_once 'conexion.php';

class Plato
{
    private $conn;

    public function __construct()
    {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.categoria_id, c.nombre AS categoria_nombre,
                       p.estado, p.tiempo_preparacion
                FROM platos p
                LEFT JOIN categorias c ON p.categoria_id = c.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM platos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre, $descripcion, $precio, $categoria_id, $estado, $tiempo_preparacion)
    {
        $sql = "INSERT INTO platos (nombre, descripcion, precio, categoria_id, estado, tiempo_preparacion)
                VALUES (:nombre, :descripcion, :precio, :categoria_id, :estado, :tiempo_preparacion)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'categoria_id' => $categoria_id,
            'estado' => $estado,
            'tiempo_preparacion' => $tiempo_preparacion
        ]);
    }

    public function update($id, $nombre, $descripcion, $precio, $categoria_id, $estado, $tiempo_preparacion)
    {
        $sql = "UPDATE platos SET nombre = :nombre, descripcion = :descripcion, precio = :precio,
                categoria_id = :categoria_id, estado = :estado, tiempo_preparacion = :tiempo_preparacion
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'categoria_id' => $categoria_id,
            'estado' => $estado,
            'tiempo_preparacion' => $tiempo_preparacion
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM platos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function getDisponibles()
    {
        $stmt = $this->conn->prepare("SELECT * FROM platos WHERE estado = 'disponible'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
