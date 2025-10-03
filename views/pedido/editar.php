<?php require_once __DIR__ . '/../../includes/control.php'; ?>
<?php if (!isset($clientes)) { $clientes = []; } ?>
<?php if (!isset($detalle) || !is_array($detalle)) { $detalle = []; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar orden Textil Camila</title>
  <?php require_once __DIR__ . '/../../includes/header.php'; ?>
  <link rel="stylesheet" href="/proyectofinal/assets/css/dashboard.css" />
  <link rel="stylesheet" href="/proyectofinal/assets/css/navbar.css" />
</head>
<body>

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-4">
  <h4 class="mb-4">Editar orden #<?= $pedido['id'] ?></h4>

  <form id="formPedido">
    <div class="row g-2 align-items-end">
      <div class="col-md-3">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" class="form-select form-select-sm" required>
          <?php foreach ($clientes as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $c['id'] == $pedido['cliente_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Canal</label>
        <select name="metodo" class="form-select form-select-sm" required>
          <?php
            $canales = [
              'tienda' => 'Venta en tienda',
              'delivery' => 'Entrega programada',
              'mayorista' => 'Mayorista'
            ];
          ?>
          <?php foreach ($canales as $valor => $texto): ?>
            <option value="<?= $valor ?>" <?= $valor == $pedido['metodo_pedido'] ? 'selected' : '' ?>>
              <?= $texto ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Hora</label>
        <input type="time" name="hora_entrega" value="<?= $pedido['hora_entrega'] ?>" class="form-control form-control-sm" />
      </div>
      <div class="col-md-5">
        <label class="form-label">Notas internas</label>
        <input type="text" name="comentarios" value="<?= htmlspecialchars($pedido['comentarios']) ?>" class="form-control form-control-sm" placeholder="Especificaciones de confección, color, etc." />
      </div>
    </div>

    <hr class="my-4">
    <h6>Modificar detalle de productos</h6>

    <div class="row g-2 mb-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">Producto</label>
        <select id="selectPlato" class="form-select form-select-sm"></select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Cantidad</label>
        <input type="number" id="cantidad" class="form-control form-control-sm" value="1" min="1" />
      </div>
      <div class="col-md-3">
        <button type="button" class="btn btn-success btn-sm w-100" onclick="agregarAlCarrito()">Agregar</button>
      </div>
    </div>

    <table class="table table-bordered table-sm" id="tablaCarrito">
      <thead class="table-light">
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Total</th>
          <th>Quitar</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <div><strong>Total:</strong> Bs. <span id="totalVisible">0.00</span></div>
      <button type="submit" class="btn btn-primary btn-sm">Actualizar orden</button>
    </div>

    <input type="hidden" name="detalle_json" id="detalle_json">
    <input type="hidden" name="total" id="total">
  </form>
</div>

<script>
let carrito = <?= json_encode($detalle) ?>;
carrito = carrito.map(p => ({
  plato_id: p.plato_id,
  nombre: p.nombre,
  cantidad: parseInt(p.cantidad),
  precio: parseFloat(p.precio_unitario),
  total: parseFloat(p.cantidad) * parseFloat(p.precio_unitario)
}));

function cargarPlatos() {
  fetch('/proyectofinal/controllers/PlatoController.php?action=json')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("selectPlato");
      select.innerHTML = '<option value="">Selecciona un producto</option>';
      data.forEach(p => {
        let opt = document.createElement("option");
        opt.value = p.id;
        opt.text = p.nombre + " - Bs. " + parseFloat(p.precio).toFixed(2);
        opt.dataset.precio = p.precio;
        opt.dataset.nombre = p.nombre;
        select.appendChild(opt);
      });
      renderCarrito();
    });
}

function agregarAlCarrito() {
  const select = document.getElementById("selectPlato");
  const plato_id = select.value;
  const nombre = select.selectedOptions[0]?.dataset.nombre || '';
  const cantidad = parseInt(document.getElementById("cantidad").value);
  const precio = parseFloat(select.selectedOptions[0].dataset.precio);
  if (!plato_id || cantidad <= 0) return;

  carrito.push({ plato_id, nombre, cantidad, precio, total: cantidad * precio });
  renderCarrito();
  select.value = '';
  document.getElementById("cantidad").value = 1;
}

function quitar(index) {
  carrito.splice(index, 1);
  renderCarrito();
}

function renderCarrito() {
  const tbody = document.querySelector("#tablaCarrito tbody");
  tbody.innerHTML = "";
  let total = 0;

  carrito.forEach((item, i) => {
    total += item.total;
    let fila = `<tr>
      <td>${item.nombre}</td>
      <td>${item.cantidad}</td>
      <td>Bs. ${item.precio.toFixed(2)}</td>
      <td>Bs. ${item.total.toFixed(2)}</td>
      <td><button class="btn btn-sm btn-danger" onclick="quitar(${i})">X</button></td>
    </tr>`;
    tbody.innerHTML += fila;
  });

  document.getElementById("detalle_json").value = JSON.stringify(carrito);
  document.getElementById("total").value = total.toFixed(2);
  document.getElementById("totalVisible").textContent = total.toFixed(2);
}

document.getElementById("formPedido").addEventListener("submit", function(e) {
  e.preventDefault();
  let form = new FormData(this);
  fetch(`/proyectofinal/controllers/PedidoController.php?action=edit&id=<?= $pedido['id'] ?>`, {
    method: 'POST',
    body: form
  }).then(res => res.text()).then(html => document.write(html));
});

window.addEventListener("DOMContentLoaded", cargarPlatos);
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>