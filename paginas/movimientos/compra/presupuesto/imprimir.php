<?php
require_once '../../../../conexion/db.php';
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
  <title>Presupuesto #<?= htmlspecialchars($cab->id_presupuesto) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #1d3557;
      --accent:  #457b9d;
      --success: #2a9d8f;
      --warning: #f4a261;
      --danger:  #e63946;
      --light:   #f4f6fa;
      --dark:    #343a40;
    }
    body {
      background-color: var(--light);
      font-family: 'Poppins', sans-serif;
      color: var(--dark);
      margin: 0; padding: 0;
    }
    .budget-card {
      max-width: 900px;
      margin: 40px auto;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      background-color: #fff;
      overflow: hidden;
    }
    .budget-header {
      background: linear-gradient(90deg, var(--primary), var(--accent));
      color: #fff;
      padding: 24px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .budget-header h3 {
      font-weight: 600;
      margin: 0;
      font-size: 1.75rem;
    }
    .budget-header small {
      display: block;
      font-size: 1rem;
      opacity: 0.85;
      margin-top: 4px;
    }
    .badge-total {
      background-color: var(--danger);
      color: #fff;
      font-weight: 600;
      padding: 0.6em 0.9em;
      border-radius: 0.25rem;
      font-size: 1rem;
    }
    .budget-body {
      padding: 32px;
    }
    .budget-meta .col-md-4 {
      margin-bottom: 16px;
    }
    .budget-meta p {
      margin: 0;
      font-size: 0.95rem;
    }
    .budget-meta p strong {
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
    .status-Pendiente { background-color: var(--warning); color: #856404; }
    .status-Aprobado  { background-color: var(--success); color: #155724; }
    .status-Rechazado { background-color: var(--danger);  color: #721c24; }

    .table {
      border: none;
    }
    .table thead th {
      background-color: var(--light);
      border-bottom: 2px solid var(--dark);
      font-weight: 600;
      color: var(--dark);
    }
    .table tbody tr:nth-child(even) {
      background-color: #fafafa;
    }
    .table td, .table th {
      border: none;
      padding: 0.75rem 1rem;
    }
    .text-right { text-align: right; }

    .no-products {
      padding: 50px 0;
      font-style: italic;
      color: #999;
    }
    @media print {
      body { background: #fff; }
      .budget-card { box-shadow: none; margin: 0; }
    }
  </style>
</head>
<body>
  <div class="budget-card">
    <div class="budget-header">
      <div>
        <h3>Presupuesto</h3>
        <small>#<?= htmlspecialchars($cab->id_presupuesto) ?></small>
      </div>
      <div>
        <span class="badge-total">
          Total: <?= number_format($cab->total, 0, '', '.') ?> Gs.
        </span>
      </div>
    </div>
    <div class="budget-body">
      <div class="row budget-meta">
        <div class="col-md-4">
          <p><strong>Fecha:</strong> <?= htmlspecialchars($cab->fecha) ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Cliente/Proveedor:</strong> <?= htmlspecialchars($cab->nombre_proveedor) ?></p>
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

  <script>window.print();</script>
</body>
</html>
