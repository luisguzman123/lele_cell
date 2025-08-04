<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT sc.id_servicio, sc.fecha_inicio, sc.fecha_fin, sc.estado, sc.observaciones, sc.id_presupuesto, sc.total_general, CONCAT(c.nombre,' ',c.apellido) as cliente, t.nombre_tecnico FROM servicio_cabecera sc JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente LEFT JOIN tecnico t ON t.id_tecnico = sc.id_tecnico WHERE sc.id_servicio = :id");
$query->execute(['id'=>$id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if(!$cab){
    die('Servicio no encontrado');
}
$qdet = $conexion->conectar()->prepare("SELECT tarea, horas_trabajadas, observaciones FROM servicio_detalle WHERE id_servicio=:id");
$qdet->execute(['id'=>$id]);
$det = $qdet->fetchAll(PDO::FETCH_OBJ);

$qrep = $conexion->conectar()->prepare("SELECT r.nombre_repuesto, sr.cantidad, r.precio, (r.precio * sr.cantidad) AS subtotal FROM servicio_repuesto sr JOIN repuesto r ON r.id_repuesto = sr.id_repuesto WHERE sr.id_servicio = :id");
$qrep->execute(['id'=>$id]);
$reps = $qrep->fetchAll(PDO::FETCH_OBJ);

$qp = $conexion->conectar()->prepare("SELECT COALESCE(SUM(subtotal),0) AS total FROM presupuesto_servicio_detalle WHERE id_presupuesto_servicio = :id");
$qp->execute(['id'=>$cab->id_presupuesto]);
$total_presupuesto = $qp->fetch(PDO::FETCH_OBJ)->total ?? 0;
$total_repuesto = 0;
foreach ($reps as $r) {
    $total_repuesto += $r->subtotal;
}
$total_general = $cab->total_general;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Servicio #<?= htmlspecialchars($cab->id_servicio) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .documento {
      max-width: 900px;
      margin: 40px auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    h3 {
      border-bottom: 2px solid #0d6efd;
      padding-bottom: 10px;
      margin-bottom: 30px;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .resumen p {
      margin: 0;
    }
    .totales p {
      font-size: 1.1rem;
      margin: 5px 0;
    }
    .totales p strong {
      color: #0d6efd;
    }
  </style>
</head>
<body onload="window.print()">
  <div class="documento">
    <h3 class="text-center">SERVICIO N° <?= htmlspecialchars($cab->id_servicio) ?></h3>

    <div class="mb-4">
      <div class="row">
        <div class="col-md-6">
          <p><strong>Cliente:</strong> <?= htmlspecialchars($cab->cliente) ?></p>
          <p><strong>Presupuesto:</strong> <?= htmlspecialchars($cab->id_presupuesto) ?></p>
          <p><strong>Técnico:</strong> <?= htmlspecialchars($cab->nombre_tecnico ?? '') ?></p>
        </div>
        <div class="col-md-6">
          <p><strong>Fecha Inicio:</strong> <?= htmlspecialchars($cab->fecha_inicio) ?></p>
          <p><strong>Fecha Fin:</strong> <?= htmlspecialchars($cab->fecha_fin) ?></p>
          <p><strong>Estado:</strong> <?= htmlspecialchars($cab->estado) ?></p>
        </div>
      </div>
      <?php if(!empty($cab->observaciones)): ?>
        <div class="mt-2">
          <p><strong>Observaciones:</strong> <?= htmlspecialchars($cab->observaciones) ?></p>
        </div>
      <?php endif; ?>
    </div>

    <h5 class="mt-4 mb-3 text-primary">Tareas Realizadas</h5>
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Tarea</th>
          <th class="text-center">Horas</th>
          <th>Observaciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($det as $d): ?>
        <tr>
          <td><?= htmlspecialchars($d->tarea) ?></td>
          <td class="text-center"><?= htmlspecialchars($d->horas_trabajadas) ?></td>
          <td><?= htmlspecialchars($d->observaciones) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php if($reps): ?>
    <h5 class="mt-4 mb-3 text-primary">Repuestos Utilizados</h5>
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Repuesto</th>
          <th class="text-center">Cantidad</th>
          <th class="text-end">Precio</th>
          <th class="text-end">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($reps as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r->nombre_repuesto) ?></td>
          <td class="text-center"><?= intval($r->cantidad) ?></td>
          <td class="text-end"><?= number_format($r->precio,0,',','.') ?></td>
          <td class="text-end"><?= number_format($r->subtotal,0,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>

    <div class="totales mt-4">
      <p><strong>Total Presupuesto:</strong> Gs. <?= number_format($total_presupuesto,0,',','.') ?></p>
      <p><strong>Total Repuestos:</strong> Gs. <?= number_format($total_repuesto,0,',','.') ?></p>
      <p><strong>Total General:</strong> <span class="fw-bold fs-5 text-success">Gs. <?= number_format($total_general,0,',','.') ?></span></p>
    </div>
  </div>
</body>
</html>
