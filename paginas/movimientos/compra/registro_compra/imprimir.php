<?php
require_once '../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT c.id_compra, c.fecha, c.observacion, c.total_exenta, c.total_iva5, c.total_iva10, c.total, c.estado, p.nombre_proveedor FROM compra_cabecera c LEFT JOIN proveedor p ON p.id_proveedor=c.id_proveedor WHERE c.id_compra = :id");
$query->execute(['id'=>$id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if(!$cab){
    die('Compra no encontrada');
}
$qdet = $conexion->conectar()->prepare("SELECT d.id_detalle, d.cantidad, d.precio, p.nombre, p.iva FROM compra_detalle d JOIN producto p ON p.id_producto=d.id_producto WHERE d.id_compra=:id");
$qdet->execute(['id'=>$id]);
$det = $qdet->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Compra #<?= $cab->id_compra ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f6fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .purchase-card {
      max-width: 900px;
      margin: 40px auto;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
      background-color: #fff;
      overflow: hidden;
    }
    .purchase-header {
      background: linear-gradient(135deg, #6610f2, #6f42c1);
      color: #fff;
      padding: 20px;
    }
    .purchase-header h3,
    .purchase-header h5 {
      margin: 0;
    }
    .purchase-body {
      padding: 30px;
    }
    .purchase-meta .col-md-4 {
      margin-bottom: 15px;
    }
    .purchase-meta p {
      margin: 0;
      font-size: 0.95rem;
    }
    .status-badge {
      text-transform: uppercase;
      font-size: 0.85rem;
      padding: 0.4em 0.8em;
      border-radius: 0.25rem;
    }
    .status-Pendiente { background-color: #ffc107; color: #856404; }
    .status-Recibida  { background-color: #198754; color: #fff; }
    .status-Anulada   { background-color: #dc3545; color: #fff; }

    .table thead {
      background-color: #e9ecef;
    }
    .table tbody tr:hover {
      background-color: #f8f9fa;
    }
    .text-center { text-align: center; }
    .text-right  { text-align: right; }

    .purchase-summary {
      margin-top: 20px;
    }
    .purchase-summary p {
      margin: .25rem 0;
      font-size: 1rem;
    }
    .purchase-summary .total {
      font-size: 1.25rem;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="purchase-card">
    <div class="purchase-header d-flex justify-content-between align-items-center">
      <div>
        <h3>Compra</h3>
        <small>#<?= $cab->id_compra ?></small>
      </div>
      <div>
        <span class="status-badge status-<?= htmlspecialchars($cab->estado) ?>">
          <?= htmlspecialchars($cab->estado) ?>
        </span>
      </div>
    </div>
    <div class="purchase-body">
      <div class="row purchase-meta">
        <div class="col-md-4">
          <p><strong>Fecha:</strong> <?= $cab->fecha ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Proveedor:</strong> <?= htmlspecialchars($cab->nombre_proveedor) ?></p>
        </div>
        <?php if (!empty($cab->observacion)): ?>
        <div class="col-md-4">
          <p><strong>Observación:</strong> <?= htmlspecialchars($cab->observacion) ?></p>
        </div>
        <?php endif; ?>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered mb-0 align-middle">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Producto</th>
              <th class="text-center" style="width: 100px;">Cantidad</th>
              <th class="text-right" style="width: 120px;">Precio</th>
              <th class="text-right" style="width: 120px;">Subtot.</th>
              <th class="text-center" style="width: 80px;">IVA%</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($det) === 0): ?>
            <tr>
              <td colspan="6" class="text-center py-4">Sin productos</td>
            </tr>
            <?php else: ?>
            <?php foreach ($det as $i => $d): ?>
            <tr>
              <td class="text-center"><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($d->nombre) ?></td>
              <td class="text-center"><?= intval($d->cantidad) ?></td>
              <td class="text-right"><?= number_format($d->precio,0,'','.') ?></td>
              <td class="text-right"><?= number_format($d->precio * $d->cantidad,0,'','.') ?></td>
              <td class="text-center"><?= intval($d->iva) ?>%</td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="purchase-summary text-end">
        <p><strong>Exenta:</strong> <?= number_format($cab->total_exenta,0,'','.') ?> Gs.</p>
        <p><strong>Gravada 5%:</strong> <?= number_format($cab->total_iva5,0,'','.') ?> Gs.</p>
        <p><strong>Gravada 10%:</strong> <?= number_format($cab->total_iva10,0,'','.') ?> Gs.</p>
        <p class="total"><strong>Total:</strong> <?= number_format($cab->total,0,'','.') ?> Gs.</p>
      </div>
    </div>
  </div>
<script>
            window.print();
        </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
