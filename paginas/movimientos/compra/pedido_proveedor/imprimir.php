<?php
require_once '../../../conexion/db.php';
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
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Pedido a Proveedor #<?= $cab->id_pedido ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f6fa;
      font-family: Arial, sans-serif;
    }
    .invoice-card {
      max-width: 800px;
      margin: 40px auto;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      overflow: hidden;
      background-color: #fff;
    }
    .invoice-header {
      background: linear-gradient(90deg, #4e73df, #224abe);
      color: #fff;
      padding: 20px;
    }
    .invoice-header h3 {
      margin: 0;
    }
    .invoice-body {
      padding: 30px;
    }
    .invoice-meta p {
      margin-bottom: 6px;
    }
    .table thead {
      background-color: #f1f3f5;
    }
    .table tbody tr:hover {
      background-color: #f9fbfd;
    }
    .status-badge {
      text-transform: uppercase;
      font-size: 0.85rem;
      padding: 0.4em 0.8em;
      border-radius: 0.25rem;
    }
    .status-Pendiente { background-color: #f6c23e; color: #856404; }
    .status-Entregado { background-color: #1cc88a; color: #155724; }
    .status-Anulado   { background-color: #e74a3b; color: #721c24; }
  </style>
</head>
<body>
  <div class="invoice-card">
    <div class="invoice-header d-flex justify-content-between align-items-center">
      <h3>Pedido a Proveedor</h3>
      <h5>#<?= $cab->id_pedido ?></h5>
    </div>
    <div class="invoice-body">
      <div class="row invoice-meta">
        <div class="col-md-4">
          <p><strong>Fecha:</strong> <?= $cab->fecha ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Proveedor:</strong> <?= htmlspecialchars($cab->nombre_proveedor) ?></p>
        </div>
        <div class="col-md-4">
          <p>
            <strong>Estado:</strong>
            <span class="status-badge status-<?= htmlspecialchars($cab->estado) ?>">
              <?= htmlspecialchars($cab->estado) ?>
            </span>
          </p>
        </div>
      </div>
      <?php if (!empty($cab->observacion)): ?>
      <div class="mb-4">
        <p><strong>Observación:</strong> <?= htmlspecialchars($cab->observacion) ?></p>
      </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">#</th>
              <th>Producto</th>
              <th class="text-center" style="width: 120px;">Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($det) === 0): ?>
              <tr>
                <td colspan="3" class="text-center py-4">Sin productos</td>
              </tr>
            <?php else: ?>
              <?php foreach($det as $i => $d): ?>
              <tr>
                <td class="text-center"><?= $i+1 ?></td>
                <td><?= htmlspecialchars($d->nombre) ?></td>
                <td class="text-center"><?= intval($d->cantidad) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<script>
            window.print();
        </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
