<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT c.id_orden, c.fecha, c.observacion, c.total, c.estado, p.nombre_proveedor FROM orden_compra_cabecera c JOIN proveedor p ON p.id_proveedor=c.id_proveedor WHERE c.id_orden = :id");
$query->execute(['id'=>$id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if(!$cab){
    die('Orden no encontrada');
}
$qdet = $conexion->conectar()->prepare("SELECT d.id_detalle, d.cantidad, d.precio, pr.nombre FROM orden_compra_detalle d JOIN producto pr ON pr.id_producto=d.id_producto WHERE d.id_orden=:id");
$qdet->execute(['id'=>$id]);
$det = $qdet->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Orden de Compra #<?= htmlspecialchars($cab->id_orden) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary:   #0d6efd;
      --accent:    #198754;
      --warning:   #ffc107;
      --danger:    #dc3545;
      --light-bg:  #f4f6fa;
      --dark-text: #343a40;
      --table-bg:  #fafafa;
    }
    body {
      background-color: var(--light-bg);
      font-family: 'Poppins', sans-serif;
      color: var(--dark-text);
      margin: 0;
      padding: 0;
    }
    .order-card {
      max-width: 900px;
      margin: 40px auto;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      background-color: #fff;
      overflow: hidden;
    }
    .order-header {
      background: linear-gradient(90deg, var(--primary), var(--accent));
      color: #fff;
      padding: 24px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .order-header h3 {
      font-weight: 600;
      margin: 0;
      font-size: 1.75rem;
    }
    .order-header small {
      display: block;
      font-size: 1rem;
      opacity: 0.85;
      margin-top: 4px;
    }
    .badge-total {
      background-color: var(--accent);
      color: #fff;
      font-weight: 600;
      padding: 0.6em 0.9em;
      border-radius: 0.25rem;
      font-size: 1rem;
    }
    .order-body {
      padding: 32px;
    }
    .order-meta .col-md-4 {
      margin-bottom: 16px;
    }
    .order-meta p {
      margin: 0;
      font-size: 0.95rem;
    }
    .order-meta p strong {
      color: var(--primary);
    }
    .status-badge {
      text-transform: uppercase;
      font-size: 0.8rem;
      padding: 0.4em 0.8em;
      border-radius: 0.25rem;
      display: inline-block;
      font-weight: 600;
    }
    .status-Pendiente  { background-color: var(--warning); color: #856404; }
    .status-Confirmada { background-color: var(--primary); color: #eef2ff; }
    .status-Anulada     { background-color: var(--danger);  color: #f8d7da; }

    .table {
      border: none;
    }
    .table thead th {
      background-color: var(--light-bg);
      border-bottom: 2px solid var(--dark-text);
      font-weight: 600;
      color: var(--dark-text);
    }
    .table tbody tr:nth-child(even) {
      background-color: var(--table-bg);
    }
    .table td, .table th {
      border: none;
      padding: 0.75rem 1rem;
    }
    .text-center { text-align: center; }
    .text-right  { text-align: right; }

    .no-products {
      padding: 50px 0;
      font-style: italic;
      color: #999;
    }
    @media print {
      body { background: #fff; }
      .order-card { box-shadow: none; margin: 0; }
    }
  </style>
</head>
<body>
  <div class="order-card">
    <div class="order-header">
      <div>
        <h3>Orden de Compra</h3>
        <small>#<?= htmlspecialchars($cab->id_orden) ?></small>
      </div>
      <div>
        <span class="badge-total">
          Total: <?= number_format($cab->total, 0, '', '.') ?> Gs.
        </span>
      </div>
    </div>
    <div class="order-body">
      <div class="row order-meta">
        <div class="col-md-4">
          <p><strong>Fecha:</strong> <?= htmlspecialchars($cab->fecha) ?></p>
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
        <p><strong>Observación:</strong><br>
           <?= nl2br(htmlspecialchars($cab->observacion)) ?>
        </p>
      </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
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
            <?php if (count($det) === 0): ?>
            <tr>
              <td colspan="5" class="text-center no-products">Sin productos</td>
            </tr>
            <?php else: foreach ($det as $i => $d): ?>
            <tr>
              <td class="text-center"><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($d->nombre) ?></td>
              <td class="text-center"><?= intval($d->cantidad) ?></td>
              <td class="text-right"><?= number_format($d->precio, 0, '', '.') ?></td>
              <td class="text-right"><?= number_format($d->precio * $d->cantidad, 0, '', '.') ?></td>
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
