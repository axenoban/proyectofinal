<?php
require_once 'conexion.php';

class Pedido
{
    private $conn;

    public function __construct()
    {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }


    // Guarda pedido principal y su detalle
    public function guardarPedido($usuario_id, $cliente_id, $hora_entrega, $total, $metodo, $comentarios, $detalle)
    {
        $sql = "INSERT INTO pedidos (usuario_id, cliente_id, hora_entrega, total, metodo_pedido, comentarios)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuario_id, $cliente_id, $hora_entrega, $total, $metodo, $comentarios]);
        $pedido_id = $this->conn->lastInsertId();

        foreach ($detalle as $item) {
            $sql_det = "INSERT INTO detalle_pedidos (pedido_id, plato_id, cantidad, precio_unitario, observaciones)
                        VALUES (?, ?, ?, ?, ?)";
            $stmt_det = $this->conn->prepare($sql_det);
            $stmt_det->execute([
                $pedido_id,
                $item['plato_id'],
                $item['cantidad'],
                $item['precio'],
                $item['observaciones'] ?? ''
            ]);
        }

        return $pedido_id;
    }

    public function actualizarPedido($pedido_id, $cliente_id, $hora_entrega, $total, $metodo, $comentarios, $detalle)
    {
        // Actualiza datos del pedido
        $sql = "UPDATE pedidos SET cliente_id = ?, hora_entrega = ?, total = ?, metodo_pedido = ?, comentarios = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$cliente_id, $hora_entrega, $total, $metodo, $comentarios, $pedido_id]);

        // Elimina los detalles antiguos
        $sql_del = "DELETE FROM detalle_pedidos WHERE pedido_id = ?";
        $stmt_del = $this->conn->prepare($sql_del);
        $stmt_del->execute([$pedido_id]);

        // Inserta nuevos detalles
        foreach ($detalle as $item) {
            $sql_det = "INSERT INTO detalle_pedidos (pedido_id, plato_id, cantidad, precio_unitario, observaciones)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt_det = $this->conn->prepare($sql_det);
            $stmt_det->execute([
                $pedido_id,
                $item['plato_id'],
                $item['cantidad'],
                $item['precio'],
                $item['observaciones'] ?? ''
            ]);
        }

        return true;
    }

    public function actualizarEstadoPedido($pedido_id, $estado)
    {
        // Verifica que el estado sea uno de los valores posibles
        if (!in_array($estado, ['pendiente', 'en preparación', 'entregado', 'anulado'])) {
            return false; // Error si el estado no es válido
        }

        $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$estado, $pedido_id]);

        return true;
    }

    // Obtiene todos los pedidos (puede modificar según necesidades)
    public function obtenerTodos()
    {
        $sql = "SELECT p.*, c.nombre AS cliente, u.nombre AS usuario
                FROM pedidos p
                JOIN clientes c ON p.cliente_id = c.id
                JOIN usuarios u ON p.usuario_id = u.id
                ORDER BY p.fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtiene los platos de un pedido específico
    public function obtenerDetalle($pedido_id)
    {
        $sql = "SELECT d.*, pl.nombre
                FROM detalle_pedidos d
                JOIN platos pl ON d.plato_id = pl.id
                WHERE d.pedido_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$pedido_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtiene un solo pedido con datos de cliente y usuario
    public function obtenerPedidoPorId($pedido_id)
    {
        $sql = "SELECT p.*, c.nombre AS cliente, c.direccion, u.nombre AS usuario
                FROM pedidos p
                JOIN clientes c ON p.cliente_id = c.id
                JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$pedido_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminarPedido($id)
    {
        // Primero elimina los detalles del pedido
        $stmt1 = $this->conn->prepare("DELETE FROM detalle_pedidos WHERE pedido_id = ?");
        $stmt1->execute([$id]);

        // Luego elimina el pedido principal
        $stmt2 = $this->conn->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt2->execute([$id]);

        return true;
    }
}
