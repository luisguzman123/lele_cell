<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT c.id_presupuesto_venta, c.nro_presupuesto, c.fecha_emision, c.fecha_vencimiento, c.estado, CONCAT(cl.nombre,' ',cl.apellido) as cliente FROM presupuesto_venta_cabecera c JOIN cliente cl ON cl.id_cliente=c.id_cliente WHERE c.id_presupuesto_venta = :id");
$query->execute(['id'=>$id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if(!$cab){
    die('Presupuesto no encontrado');
}
$qdet = $conexion->conectar()->prepare("SELECT d.id_presupuesto_venta_detalle, d.cantidad, d.precio, p.nombre FROM presupuesto_venta_detalle d JOIN producto p ON p.id_producto=d.id_producto WHERE d.id_presupuesto_venta=:id");
$qdet->execute(['id'=>$id]);
$det = $qdet->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Presupuesto Venta #<?= htmlspecialchars($cab->id_presupuesto_venta) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { background-color: #f4f6fa; font-family: 'Poppins', sans-serif; color: #343a40; }
    .budget-card { max-width: 900px; margin: 40px auto; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); background-color: #fff; overflow: hidden; }
    .budget-header { background: linear-gradient(90deg, #1d3557, #457b9d); color: #fff; padding: 24px 32px; display: flex; justify-content: space-between; align-items: center; }
    .budget-header h3 { font-weight: 600; margin: 0; font-size: 1.75rem; }
    .budget-body { padding: 32px; }
    .budget-meta .col-md-4 { margin-bottom: 16px; }
    .budget-meta p { margin: 0; font-size: 0.95rem; }
    .table thead th { background-color: #f4f6fa; border-bottom: 2px solid #343a40; font-weight: 600; }
    .table tbody tr:nth-child(even) { background-color: #fafafa; }
    .no-products { padding: 50px 0; font-style: italic; color: #999; }
    @media print { body { background: #fff; } .budget-card { box-shadow: none; margin: 0; } }
  </style>
</head>
<body>
  <div class="budget-card">
    <div class="budget-header">
      <div>
        <h3>Presupuesto Venta</h3>
        <small>#<?= htmlspecialchars($cab->id_presupuesto_venta) ?></small>
      </div>
      <div>
        <span class="badge bg-danger">
          Total: <?= number_format(array_reduce($det, function($c,$i){return $c+$i->precio*$i->cantidad;},0),0,'','.') ?> Gs.
        </span>
      </div>
    </div>
    <div class="budget-body">
      <div class="row budget-meta">
        <div class="col-md-4">
          <p><strong>Emisión:</strong> <?= htmlspecialchars($cab->fecha_emision) ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Vencimiento:</strong> <?= htmlspecialchars($cab->fecha_vencimiento) ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Cliente:</strong> <?= htmlspecialchars($cab->cliente) ?></p>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th class="text-center" style="width:60px;">#</th>
              <th>Producto</th>
              <th class="text-center" style="width:100px;">Cantidad</th>
              <th class="text-end" style="width:120px;">Precio</th>
              <th class="text-end" style="width:140px;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($det) === 0): ?>
            <tr>
              <td colspan="5" class="text-center no-products">Sin productos</td>
            </tr>
            <?php else: foreach ($det as $i => $d): ?>
            <tr>
              <td class="text-center"><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($d->nombre) ?></td>
              <td class="text-center"><?= intval($d->cantidad) ?></td>
              <td class="text-end"><?= number_format($d->precio,0,'','.') ?></td>
              <td class="text-end"><?= number_format($d->precio * $d->cantidad,0,'','.') ?></td>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>window.print();</script>
</body>
</html>
