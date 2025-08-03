<?php
require_once '../../../../conexion/db.php';

$conexion = new DB();
$id_recepcion = $_GET['id'] ?? 0;

if (!$id_recepcion) {
    die("ID de recepción no especificado");
}

// Consulta de cabecera
$queryCabecera = $conexion->conectar()->prepare("
    SELECT rc.id_recepcion_cabecera, rc.fecha, rc.estado, 
           CONCAT(c.nombre, ' ', c.apellido) AS cliente_nombre, c.cedula AS cliente_cedula,
           e.marca, e.modelo
    FROM recepcion_cabecera rc
    JOIN cliente c ON c.id_cliente = rc.id_cliente
    JOIN equipo e ON e.id_equipo = rc.id_equipo
    WHERE rc.id_recepcion_cabecera = :id
");
$queryCabecera->execute(['id' => $id_recepcion]);
$cabecera = $queryCabecera->fetch(PDO::FETCH_OBJ);

if (!$cabecera) {
    die("Recepción no encontrada");
}

// Consulta de detalles
$queryDetalle = $conexion->conectar()->prepare("
    SELECT problema, obs 
    FROM recepcion_detalle 
    WHERE id_recepcion_cabecera = :id AND estado = 'ACTIVO'
");
$queryDetalle->execute(['id' => $id_recepcion]);
$detalles = $queryDetalle->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Etiqueta Recepción</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 10px;
      margin: 10px;
    }
    .label {
      width: 280px; /* ~7cm */
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
    <div class="title">RECEPCIÓN TÉCNICA</div>
    
    <div class="section">
      <p><span class="bold">ID:</span> #<?php echo $cabecera->id_recepcion_cabecera ?></p>
      <p><span class="bold">Fecha:</span> <?php echo $cabecera->fecha ?></p>
      <p><span class="bold">Estado:</span> <?php echo strtoupper($cabecera->estado) ?></p>
    </div>

    <div class="section">
      <p><span class="bold">Cliente:</span> <?php echo htmlspecialchars($cabecera->cliente_nombre) ?></p>
      <p><span class="bold">Cédula:</span> <?php echo htmlspecialchars($cabecera->cliente_cedula) ?></p>
    </div>

    <div class="section">
      <p><span class="bold">Equipo:</span> <?php echo htmlspecialchars($cabecera->marca . ' ' . $cabecera->modelo) ?></p>
    </div>

    <div class="section problem">
      <span class="bold">Problemas:</span><br>
      <?php if (count($detalles) === 0): ?>
        <em>Sin descripción</em>
      <?php else: ?>
        <ul style="padding-left: 12px; margin: 0;">
          <?php foreach ($detalles as $d): ?>
            <li><?php echo htmlspecialchars($d->problema) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
