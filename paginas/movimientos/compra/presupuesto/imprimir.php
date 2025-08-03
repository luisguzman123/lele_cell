<?php
require_once '../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT c.id_presupuesto, c.fecha, c.observacion, c.total, c.estado, p.nombre_proveedor FROM presupuesto_cabecera c JOIN proveedor p ON p.id_proveedor=c.id_proveedor WHERE c.id_presupuesto = :id");
$query->execute(['id'=>$id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if(!$cab){
    die('Presupuesto no encontrado');
}
$qdet = $conexion->conectar()->prepare("SELECT d.id_detalle, d.cantidad, d.precio, p.nombre FROM presupuesto_detalle d JOIN producto p ON p.id_producto=d.id_producto WHERE d.id_presupuesto=:id");
$qdet->execute(['id'=>$id]);
$det = $qdet->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Presupuesto #<?= $cab->id_presupuesto ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f6fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .budget-card {
      max-width: 900px;
      margin: 40px auto;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
      background-color: #fff;
      overflow: hidden;
    }
    .budget-header {
      background: linear-gradient(90deg, #1d3557, #457b9d);
      color: #fff;
      padding: 20px;
    }
    .budget-header h3, .budget-header h5 {
      margin: 0;
    }
    .budget-body {
      padding: 30px;
    }
    .budget-meta .col-md-4 {
      margin-bottom: 15px;
    }
    .budget-meta p {
      margin: 0;
      font-size: 0.95rem;
    }
    .badge-total {
      font-size: 1rem;
      background-color: #e63946;
      color: #fff;
      padding: 0.5em 0.75em;
      border-radius: 0.25rem;
    }
    .status-badge {
      text-transform: uppercase;
      font-size: 0.85rem;
      padding: 0.4em 0.8em;
      border-radius: 0.25rem;
    }
    .status-Pendiente { background-color: #f6c23e; color: #856404; }
    .status-Aprobado  { background-color: #1cc88a; color: #155724; }
    .status-Rechazado { background-color: #e74a3b; color: #721c24; }

    .table thead {
      background-color: #f1f3f5;
    }
    .table tbody tr:hover {
      background-color: #f9fbfd;
    }
    .text-right { text-align: right; }
  </style>
</head>
<body>
  <div class="budget-card">
    <div class="budget-header d-flex justify-content-between align-items-center">
      <div>
        <h3>Presupuesto</h3>
        <small>#<?= $cab->id_presupuesto ?></small>
      </div>
      <div>
        <span class="badge-total">Total: <?= number_format($cab->total,0,'','.') ?> Gs.</span>
      </div>
    </div>
    <div class="budget-body">
      <div class="row budget-meta">
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
        <table class="table table-bordered mb-0 align-middle">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">#</th>
              <th>Producto</th>
              <th class="text-center" style="width: 100px;">Cantidad</th>
              <th class="text-right" style="width: 120px;">Precio</th>
              <th class="text-right" style="width: 140px;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($det) === 0): ?>
              <tr>
                <td colspan="5" class="text-center py-4">Sin productos</td>
              </tr>
            <?php else: ?>
              <?php foreach($det as $i => $d): ?>
              <tr>
                <td class="text-center"><?= $i+1 ?></td>
                <td><?= htmlspecialchars($d->nombre) ?></td>
                <td class="text-center"><?= intval($d->cantidad) ?></td>
                <td class="text-right"><?= number_format($d->precio,0,'','.') ?></td>
                <td class="text-right"><?= number_format($d->precio * $d->cantidad,0,'','.') ?></td>
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
