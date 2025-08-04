<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT sc.id_servicio, sc.fecha_inicio, sc.fecha_fin, sc.estado, sc.observaciones, sc.id_presupuesto, CONCAT(c.nombre,' ',c.apellido) as cliente, t.nombre_tecnico FROM servicio_cabecera sc JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente LEFT JOIN tecnico t ON t.id_tecnico = sc.id_tecnico WHERE sc.id_servicio = :id");
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
$total_general = $total_presupuesto + $total_repuesto;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Servicio #<?= htmlspecialchars($cab->id_servicio) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body onload="window.print()">
  <div class="container mt-4">
    <h3 class="text-center mb-4">SERVICIO N° <?= htmlspecialchars($cab->id_servicio) ?></h3>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($cab->cliente) ?></p>
    <p><strong>Presupuesto:</strong> <?= htmlspecialchars($cab->id_presupuesto) ?></p>
    <p><strong>Técnico:</strong> <?= htmlspecialchars($cab->nombre_tecnico ?? '') ?></p>
    <p><strong>Fecha Inicio:</strong> <?= htmlspecialchars($cab->fecha_inicio) ?> - <strong>Fecha Fin:</strong> <?= htmlspecialchars($cab->fecha_fin) ?></p>
    <p><strong>Estado:</strong> <?= htmlspecialchars($cab->estado) ?></p>
    <?php if(!empty($cab->observaciones)): ?>
      <p><strong>Observaciones:</strong> <?= htmlspecialchars($cab->observaciones) ?></p>
    <?php endif; ?>
    <table class="table table-bordered mt-4">
      <thead class="table-light">
        <tr><th>Tarea</th><th>Horas</th><th>Observaciones</th></tr>
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
    <table class="table table-bordered mt-4">
      <thead class="table-light">
        <tr><th>Repuesto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr>
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
    <p><strong>Total Presupuesto:</strong> <?= number_format($total_presupuesto,0,',','.') ?></p>
    <p><strong>Total Repuestos:</strong> <?= number_format($total_repuesto,0,',','.') ?></p>
    <p><strong>Total General:</strong> <?= number_format($total_general,0,',','.') ?></p>
  </div>
</body>
</html>
