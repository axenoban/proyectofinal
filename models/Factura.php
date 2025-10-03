<?php
require_once 'Conexion.php';

class Factura extends Conexion
{
    public function __construct()
    {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    // Método para guardar la factura en la base de datos
    public function guardarFactura($pedido_id, $numero_factura, $cliente_nombre, $direccion, $subtotal, $impuesto, $total, $forma_pago)
    {
        $sql = "INSERT INTO facturas (pedido_id, numero_factura, cliente_nombre, direccion, subtotal, impuesto, total, forma_pago)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$pedido_id, $numero_factura, $cliente_nombre, $direccion, $subtotal, $impuesto, $total, $forma_pago]);
        return $this->conn->lastInsertId();
    }

    public function obtenerTodasLasFacturas()
    {
        $sql = "SELECT * FROM facturas";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // Método para actualizar el estado de la factura (por ejemplo, marcar como 'emitida' o 'anulada')
    public function actualizarEstadoFactura($factura_id, $estado)
    {
        $sql = "UPDATE facturas SET estado = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$estado, $factura_id]);
        return true;
    }

    // Método para obtener una factura por su ID
    public function obtenerFacturaPorId($id)
    {
        $sql = "SELECT * FROM facturas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Método para obtener todos los detalles de una factura por el ID del pedido
    public function obtenerDetalleFactura($pedido_id)
    {
        $sql = "SELECT * FROM detalle_pedidos dp
                JOIN platos p ON dp.plato_id = p.id
                WHERE dp.pedido_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$pedido_id]);
        return $stmt->fetchAll();
    }
}
