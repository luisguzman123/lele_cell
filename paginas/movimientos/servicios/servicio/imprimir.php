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
  </div>
</body>
</html>
