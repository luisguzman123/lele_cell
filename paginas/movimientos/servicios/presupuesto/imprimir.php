<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT psc.id_presupuesto_servicio, psc.fecha_presupuesto, psc.validez_dias, psc.estado, psc.observaciones, CONCAT(c.nombre, ' ', c.apellido) as cliente FROM presupuesto_servicio_cabecera psc JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente WHERE psc.id_presupuesto_servicio = :id");
$query->execute(['id'=>$id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if(!$cab){
    die('Presupuesto no encontrado');
}
$qdet = $conexion->conectar()->prepare("SELECT concepto, cantidad, precio_unitario, subtotal FROM presupuesto_servicio_detalle WHERE id_presupuesto_servicio=:id");
$qdet->execute(['id'=>$id]);
$det = $qdet->fetchAll(PDO::FETCH_OBJ);
$total = 0;
foreach($det as $d){
    $total += $d->subtotal;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Presupuesto Servicio #<?= htmlspecialchars($cab->id_presupuesto_servicio) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary:   #1d3557;
      --accent:    #457b9d;
      --light-bg:  #f4f6fa;
      --dark-text: #343a40;
      --muted:     #6c757d;
      --border:    #dee2e6;
    }
    body {
      background-color: var(--light-bg);
      font-family: 'Poppins', sans-serif;
      color: var(--dark-text);
      margin: 0; padding: 0;
    }
    .budget-service-card {
      max-width: 900px;
      margin: 40px auto;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      background-color: #fff;
      overflow: hidden;
    }
    .budget-service-header {
      background: linear-gradient(90deg, var(--primary), var(--accent));
      color: #fff;
      padding: 24px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .budget-service-header h3 {
      font-weight: 600;
      margin: 0;
      font-size: 1.75rem;
    }
    .budget-service-header small {
      display: block;
      font-size: 1rem;
      opacity: 0.85;
      margin-top: 4px;
    }
    .badge-total {
      background-color: #e63946;
      color: #fff;
      font-weight: 600;
      padding: 0.6em 0.9em;
      border-radius: 0.25rem;
      font-size: 1rem;
    }
    .budget-service-body {
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
      background-color: var(--accent);
      color: #fff;
    }
    .status-Enviado   { background-color: #f6c23e; color: #856404; }
    .status-Aprobado  { background-color: #1cc88a; color: #155724; }
    .status-Rechazado { background-color: #e74a3b; color: #721c24; }

    .table {
      border: none;
      margin-top: 24px;
    }
    .table thead th {
      background-color: var(--light-bg);
      border-bottom: 2px solid var(--dark-text);
      font-weight: 600;
      color: var(--dark-text);
      padding: 0.75rem 1rem;
    }
    .table tbody tr:nth-child(even) {
      background-color: #fafafa;
    }
    .table td, .table th {
      border: none;
      padding: 0.75rem 1rem;
    }
    .text-center { text-align: center; }
    .text-right  { text-align: right; }

    .budget-summary {
      margin-top: 32px;
      text-align: right;
    }
    .budget-summary p {
      margin: 0.25rem 0;
      font-size: 1rem;
    }
    .budget-summary .total {
      font-size: 1.25rem;
      font-weight: 600;
    }

    .budget-notes {
      margin-top: 40px;
      font-size: 0.85rem;
      color: var(--muted);
      border-top: 1px solid var(--border);
      padding-top: 16px;
    }

    .budget-signature {
      margin-top: 40px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    .budget-signature .line {
      border-top: 1px solid var(--border);
      width: 250px;
      margin-left: 16px;
    }

    @media print {
      body { background: #fff; }
      .budget-service-card { box-shadow: none; margin: 0; }
    }
  </style>
</head>
<body>
  <div class="budget-service-card">
    <div class="budget-service-header">
      <div>
        <h3>Presupuesto Servicio</h3>
        <small>#<?= htmlspecialchars($cab->id_presupuesto_servicio) ?></small>
      </div>
      <div>
        <span class="badge-total">
          Total: <?= number_format($total, 0, '', '.') ?> Gs.
        </span>
      </div>
    </div>
    <div class="budget-service-body">
      <div class="row budget-meta">
        <div class="col-md-4">
          <p><strong>Fecha emisión:</strong> <?= htmlspecialchars($cab->fecha_presupuesto) ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Cliente:</strong> <?= htmlspecialchars($cab->cliente) ?></p>
        </div>
        <div class="col-md-4">
          <p><strong>Validez:</strong> <?= intval($cab->validez_dias) ?> días</p>
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

      <?php if (!empty($cab->observaciones)): ?>
      <div class="mb-4">
        <p><strong>Observaciones:</strong><br>
           <?= nl2br(htmlspecialchars($cab->observaciones)) ?>
        </p>
      </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">#</th>
              <th>Concepto</th>
              <th class="text-center" style="width: 120px;">Cantidad</th>
              <th class="text-right" style="width: 140px;">Precio Unit.</th>
              <th class="text-right" style="width: 160px;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($det) === 0): ?>
            <tr>
              <td colspan="5" class="text-center py-4">Sin conceptos</td>
            </tr>
            <?php else: foreach ($det as $i => $d): ?>
            <tr>
              <td class="text-center"><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($d->concepto) ?></td>
              <td class="text-center"><?= intval($d->cantidad) ?></td>
              <td class="text-right"><?= number_format($d->precio_unitario, 0, '', '.') ?></td>
              <td class="text-right"><?= number_format($d->subtotal, 0, '', '.') ?></td>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>

      <div class="budget-summary">
        <!--<p><strong>Subtotal:</strong> <?= number_format($cab->subtotal, 0, '', '.') ?> Gs.</p>-->
        <?php if(isset($cab->iva) && $cab->iva > 0): ?>
        <p><strong>IVA (<?= intval($cab->iva) ?>%):</strong> <?= number_format($cab->total_iva, 0, '', '.') ?> Gs.</p>
        <?php endif; ?>
        <p class="total"><strong>Total:</strong> <?= number_format($total, 0, '', '.') ?> Gs.</p>
      </div>

      <div class="budget-notes">
        <p><strong>Términos y condiciones:</strong> Este presupuesto es válido por <?= intval($cab->validez_dias) ?> días a partir de la fecha de emisión. Los trabajos se regirán por las condiciones de servicio acordadas. Cualquier modificación deberá ser confirmada por escrito.</p>
      </div>

      <div class="budget-signature">
        <div>Firma autorizado:</div>
        <div class="line"></div>
      </div>
    </div>
  </div>

  <script>window.print();</script>
</body>
</html>
