<?php
require_once '../../../../conexion/db.php';

$conexion = new DB();
$id_diagnostico = $_GET['id'] ?? 0;

if (!$id_diagnostico) {
    die("ID de diagnóstico no especificado");
}

$queryCabecera = $conexion->conectar()->prepare("SELECT dc.id_diagnostico, dc.fecha_diagnostico, dc.costo_estimado, dc.estado_diagnostico, dc.observaciones, rc.id_recepcion_cabecera, CONCAT(c.nombre, ' ', c.apellido) AS cliente_nombre, e.marca, e.modelo FROM diagnostico_cabecera dc JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente JOIN equipo e ON e.id_equipo = rc.id_equipo WHERE dc.id_diagnostico = :id");
$queryCabecera->execute(['id' => $id_diagnostico]);
$cabecera = $queryCabecera->fetch(PDO::FETCH_OBJ);

if (!$cabecera) {
    die("Diagnóstico no encontrado");
}

$queryDetalle = $conexion->conectar()->prepare("SELECT descripcion_prueba, resultado, observaciones FROM diagnostico_detalle WHERE id_diagnostico = :id");
$queryDetalle->execute(['id' => $id_diagnostico]);
$detalles = $queryDetalle->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Etiqueta Diagnóstico</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 10px;
      margin: 10px;
    }
    .label {
      width: 280px;
      border: 1px solid #000;
      padding: 8px;
    }
    .title {
      text-align: center;
      font-weight: bold;
      font-size: 12px;
      margin-bottom: 6px;
    }
    .section {
      margin-bottom: 6px;
    }
    .section p {
      margin: 2px 0;
    }
    .problem {
      font-size: 9px;
      border-top: 1px dashed #000;
      margin-top: 4px;
      padding-top: 4px;
    }
    .bold {
      font-weight: bold;
    }
  </style>
</head>
<body onload="window.print()">
  <div class="label">
    <div class="title">DIAGNÓSTICO TÉCNICO</div>
    <div class="section">
      <p><span class="bold">ID:</span> #<?php echo $cabecera->id_diagnostico ?></p>
      <p><span class="bold">Fecha:</span> <?php echo $cabecera->fecha_diagnostico ?></p>
      <p><span class="bold">Estado:</span> <?php echo strtoupper($cabecera->estado_diagnostico) ?></p>
      <p><span class="bold">Recepción:</span> <?php echo $cabecera->id_recepcion_cabecera ?></p>
    </div>
    <div class="section">
      <p><span class="bold">Cliente:</span> <?php echo htmlspecialchars($cabecera->cliente_nombre) ?></p>
      <p><span class="bold">Equipo:</span> <?php echo htmlspecialchars($cabecera->marca . ' ' . $cabecera->modelo) ?></p>
      <p><span class="bold">Costo:</span> <?php echo $cabecera->costo_estimado ?></p>
      <p><span class="bold">Obs:</span> <?php echo htmlspecialchars($cabecera->observaciones) ?></p>
    </div>
    <div class="section problem">
      <span class="bold">Pruebas:</span><br>
      <?php if (count($detalles) === 0): ?>
        <em>Sin descripción</em>
      <?php else: ?>
        <ul style="padding-left: 12px; margin: 0;">
          <?php foreach ($detalles as $d): ?>
            <li><?php echo htmlspecialchars($d->descripcion_prueba . ' - ' . $d->resultado) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
