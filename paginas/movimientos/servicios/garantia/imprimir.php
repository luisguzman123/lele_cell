<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT sg.id_garantia, sg.fecha_inicio, sg.duracion_dias, sg.estado, sc.id_servicio, CONCAT(c.nombre,' ',c.apellido) as cliente FROM servicio_garantia sg JOIN servicio_cabecera sc ON sc.id_servicio = sg.id_servicio JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente WHERE sg.id_garantia=:id");
$query->execute(['id'=>$id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if(!$cab){
    die('Garantía no encontrada');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Garantía Servicio #<?= htmlspecialchars($cab->id_garantia) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body onload="window.print();">
  <div class="container mt-4">
    <h3 class="text-center">Garantía de Servicio</h3>
    <hr>
    <p><strong>N° Garantía:</strong> <?= $cab->id_garantia ?></p>
    <p><strong>Servicio:</strong> <?= $cab->id_servicio ?> - <?= htmlspecialchars($cab->cliente) ?></p>
    <p><strong>Fecha Inicio:</strong> <?= $cab->fecha_inicio ?></p>
    <p><strong>Duración:</strong> <?= $cab->duracion_dias ?> días</p>
    <p><strong>Estado:</strong> <?= $cab->estado ?></p>
  </div>
</body>
</html>
