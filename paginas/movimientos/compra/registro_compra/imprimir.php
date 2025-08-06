<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT c.id_compra, c.fecha, c.observacion, c.nro_factura, c.timbrado, c.total_exenta, c.total_iva5, c.total_iva10, c.total, c.estado, p.nombre_proveedor FROM compra_cabecera c LEFT JOIN proveedor p ON p.id_proveedor=c.id_proveedor WHERE c.id_compra = :id");
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
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Compra #<?= htmlspecialchars($cab->id_compra) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #fff;
      font-family: 'Segoe UI', sans-serif;
      color: #000;
      margin: 0;
      padding: 0;
    }
    .purchase-card {
      max-width: 900px;
      margin: 40px auto;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: #fff;
      overflow: hidden;
    }
    .purchase-header {
      padding: 16px 24px;
      border-bottom: 1px solid #ccc;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .purchase-header h3 {
      margin: 0;
      font-size: 1.5rem;
      font-weight: 600;
    }
    .purchase-header small {
      display: block;
      font-size: 1rem;
      color: #555;
      margin-top: 4px;
    }
    .status-badge {
      display: inline-block;
      padding: 0.25em 0.5em;
      font-size: 0.85rem;
      border: 1px solid #333;
      border-radius: 0.25rem;
      background-color: #fff;
      color: #333;
      text-transform: uppercase;
      font-weight: 600;
    }
    .purchase-body {
      padding: 24px;
    }
    .purchase-meta .col-md-4 {
      margin-bottom: 16px;
    }
    .purchase-meta p {
      margin: 0;
      font-size: 0.95rem;
    }
    .purchase-meta p strong {
      font-weight: 600;
    }
    .table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 16px;
    }
    .table th,
    .table td {
      border: 1px solid #ccc !important;
      padding: 0.6rem;
    }
    .table thead th {
      background-color: #f8f8f8;
      border-bottom: 2px solid #333 !important;
      font-weight: 600;
      color: #000;
    }
    .text-center { text-align: center; }
    .text-right  { text-align: right; }
    .purchase-summary {
      margin-top: 24px;
      text-align: right;
    }
    .purchase-summary p {
      margin: 0.25rem 0;
      font-size: 1rem;
    }
    .purchase-summary .total {
      font-size: 1.25rem;
      font-weight: 600;
    }
    @media print {
      body { background: #fff; }
      .purchase-card { border: none; margin: 0; }
    }
  </style>
</head>
<body>
  <div class="purchase-card">
    <div class="purchase-header">
      <div>
        <h3>Compra</h3>
        <small>#<?= htmlspecialchars($cab->id_compra) ?></small>
      </div>
      <div>
        <span class="status-badge"><?= htmlspecialchars($cab->estado) ?></span>
      </div>
    </div>
    <div class="purchase-body">
      <div class="row purchase-meta">
        <div class="col-md-4">
          <p><strong>Fecha:</strong> <?= htmlspecialchars($cab->fecha) ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Nro. Factura:</strong> <?= htmlspecialchars($cab->nro_factura) ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Timbrado:</strong> <?= htmlspecialchars($cab->timbrado) ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Proveedor:</strong> <?= htmlspecialchars($cab->nombre_proveedor) ?></p>
        </div>
        <?php if (!empty($cab->observacion)): ?>
        <div class="col-md-4">
          <p><strong>Observación:</strong> <?= nl2br(htmlspecialchars($cab->observacion)) ?></p>
        </div>
        <?php endif; ?>
      </div>

      <div class="table-responsive">
        <table class="table mb-0 align-middle">
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
            <?php else: foreach ($det as $i => $d): ?>
            <tr>
              <td class="text-center"><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($d->nombre) ?></td>
              <td class="text-center"><?= intval($d->cantidad) ?></td>
              <td class="text-right"><?= number_format($d->precio, 0, '', '.') ?></td>
              <td class="text-right"><?= number_format($d->precio * $d->cantidad, 0, '', '.') ?></td>
              <td class="text-center"><?= intval($d->iva) ?>%</td>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>

      <div class="purchase-summary">
        <p><strong>Exenta:</strong> <?= number_format($cab->total_exenta, 0, '', '.') ?> Gs.</p>
        <p><strong>Gravada 5%:</strong> <?= number_format($cab->total_iva5, 0, '', '.') ?> Gs.</p>
        <p><strong>Gravada 10%:</strong> <?= number_format($cab->total_iva10, 0, '', '.') ?> Gs.</p>
        <p class="total"><strong>Total:</strong> <?= number_format($cab->total, 0, '', '.') ?> Gs.</p>
      </div>
    </div>
  </div>

  <script>window.print();</script>
</body>
</html>
