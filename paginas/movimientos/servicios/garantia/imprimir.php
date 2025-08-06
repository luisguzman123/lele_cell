<?php
session_start();
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
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }
    .garantia-card {
      max-width: 800px;
      margin: 40px auto;
      background: #ffffff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .garantia-title {
      border-bottom: 2px solid #343a40;
      padding-bottom: 10px;
      margin-bottom: 30px;
    }
    .garantia-info p {
      font-size: 16px;
      margin-bottom: 8px;
    }
    .firmas {
      margin-top: 60px;
      display: flex;
      justify-content: space-between;
      padding: 0 20px;
    }
    .firma {
      text-align: center;
      width: 45%;
    }
    .firma .linea {
      border-top: 1px solid #000;
      margin-bottom: 5px;
    }
    .firma .nombre {
      font-weight: bold;
    }
    .footer-info {
      font-size: 13px;
      color: #666;
      margin-top: 20px;
      text-align: center;
    }
  </style>
</head>
<body onload="window.print();">
  <div class="garantia-card">
    <div class="text-center garantia-title">
      <h3 class="mb-0">GARANTÍA DE SERVICIO</h3>
      <small>Comprobante N° <?= htmlspecialchars($cab->id_garantia) ?></small>
    </div>

    <div class="garantia-info">
      <p><strong>Servicio:</strong> <?= htmlspecialchars($cab->id_servicio) ?> - <?= htmlspecialchars($cab->cliente) ?></p>
      <p><strong>Fecha de Inicio:</strong> <?= htmlspecialchars($cab->fecha_inicio) ?></p>
      <p><strong>Duración:</strong> <?= htmlspecialchars($cab->duracion_dias) ?> días</p>
      <p><strong>Estado:</strong> <?= htmlspecialchars($cab->estado) ?></p>
    </div>

    <div class="firmas">
      <div class="firma">
        <div class="linea"></div>
        <div class="nombre"><?= htmlspecialchars($cab->cliente) ?></div>
        <small>Firma del Cliente</small>
      </div>
      <div class="firma">
        <div class="linea"></div>
        <div class="nombre"><?= htmlspecialchars($_SESSION['usuario']) ?>
</div>
        <small>Firma del Usuario</small>
      </div>
    </div>
    
    <div class="footer-info mt-5">
      <p>Este documento certifica que el servicio tiene una garantía válida por el período indicado.</p>
    </div>
  </div>
</body>
</html>
