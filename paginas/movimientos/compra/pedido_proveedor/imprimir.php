<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT c.id_pedido, c.fecha, c.observacion, c.estado, p.nombre_proveedor FROM pedido_proveedor_cabecera c JOIN proveedor p ON p.id_proveedor=c.id_proveedor WHERE c.id_pedido = :id");
$query->execute(['id'=>$id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if(!$cab){
    die('Pedido no encontrado');
}
$qdet = $conexion->conectar()->prepare("SELECT d.id_producto, p.nombre, d.cantidad FROM pedido_proveedor_detalle d JOIN producto p ON p.id_producto=d.id_producto WHERE d.id_pedido=:id");
$qdet->execute(['id'=>$id]);
$det = $qdet->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Pedido a Proveedor #<?= htmlspecialchars($cab->id_pedido) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #2c3e50;
      --secondary: #18bc9c;
      --light: #ecf0f1;
      --dark: #34495e;
    }
    body {
      background-color: var(--light);
      font-family: 'Poppins', sans-serif;
      color: var(--dark);
      margin: 0; padding: 0;
    }
    .invoice-card {
      max-width: 800px;
      margin: 40px auto;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      overflow: hidden;
      background-color: #fff;
    }
    .invoice-header {
      background-color: var(--primary);
      color: #fff;
      padding: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .invoice-header h3 {
      font-weight: 600;
      font-size: 1.75rem;
      margin: 0;
    }
    .invoice-header .invoice-number {
      font-size: 1.25rem;
      opacity: .9;
    }
    .invoice-body {
      padding: 30px;
    }
    .invoice-meta {
      margin-bottom: 30px;
    }
    .invoice-meta .meta-item {
      margin-bottom: 10px;
    }
    .invoice-meta .meta-item span {
      font-weight: 600;
      color: var(--primary);
    }
    .status-badge {
      text-transform: uppercase;
      font-size: 0.8rem;
      padding: 0.4em 0.9em;
      border-radius: 0.25rem;
      display: inline-block;
    }
    .status-Pendiente { background-color: #f39c12; color: #fff; }
    .status-Entregado { background-color: #27ae60; color: #fff; }
    .status-Anulado   { background-color: #c0392b; color: #fff; }
    table.table {
      border: none;
    }
    table.table thead th {
      background-color: var(--light);
      border-bottom: 2px solid var(--primary);
      color: var(--dark);
      font-weight: 600;
    }
    table.table tbody tr:nth-of-type(odd) {
      background-color: #fafafa;
    }
    table.table tbody td,
    table.table tbody th {
      border: none;
      padding: .75rem 1rem;
    }
    .no-products {
      padding: 50px 0;
      font-style: italic;
      color: #999;
    }
    @media print {
      .invoice-card { box-shadow: none; margin: 0; }
      body { background: #fff; }
    }
  </style>
</head>
<body>
  <div class="invoice-card">
    <div class="invoice-header">
      <h3>Pedido a Proveedor</h3>
      <div class="invoice-number">#<?= htmlspecialchars($cab->id_pedido) ?></div>
    </div>
    <div class="invoice-body">
      <div class="row invoice-meta">
        <div class="col-md-4 meta-item">
          Fecha: <span><?= htmlspecialchars($cab->fecha) ?></span>
        </div>
        <div class="col-md-4 meta-item">
          Proveedor: <span><?= htmlspecialchars($cab->nombre_proveedor) ?></span>
        </div>
        <div class="col-md-4 meta-item">
          Estado:
          <span class="status-badge status-<?= htmlspecialchars($cab->estado) ?>">
            <?= htmlspecialchars($cab->estado) ?>
          </span>
        </div>
      </div>

      <?php if (!empty($cab->observacion)): ?>
      <div class="mb-4">
        <strong>Observación:</strong>
        <p><?= nl2br(htmlspecialchars($cab->observacion)) ?></p>
      </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Producto</th>
              <th class="text-center">Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($det) === 0): ?>
            <tr>
              <td colspan="3" class="text-center no-products">Sin productos</td>
            </tr>
            <?php else: foreach ($det as $i => $d): ?>
            <tr>
              <td class="text-center"><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($d->nombre) ?></td>
              <td class="text-center"><?= intval($d->cantidad) ?></td>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    window.print();
  </script>
</body>
</html>
