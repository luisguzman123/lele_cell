<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('ID no valido');
}
$query = $conexion->conectar()->prepare(
    "SELECT se.id_entrega, se.fecha_entrega, se.id_servicio, se.monto_servicio, u.usuario, CONCAT(c.nombre,' ',c.apellido) AS cliente
     FROM servicio_entrega se
     JOIN usuario u ON u.id_usuario = se.id_usuario
     JOIN servicio_cabecera sc ON se.id_servicio = sc.id_servicio
     JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto
     JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico
     JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera
     JOIN cliente c ON c.id_cliente = rc.id_cliente
     WHERE se.id_entrega = :id"
);
$query->execute(['id' => $id]);
$cab = $query->fetch(PDO::FETCH_OBJ);
if (!$cab) {
    die('Entrega no encontrada');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Entrega #<?= htmlspecialchars($cab->id_entrega) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }
    .entrega-card {
      max-width: 800px;
      margin: 40px auto;
      background: #ffffff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .entrega-title {
      border-bottom: 2px solid #343a40;
      padding-bottom: 10px;
      margin-bottom: 30px;
    }
    .entrega-info p {
      font-size: 16px;
      margin-bottom: 8px;
    }
    .firma {
      margin-top: 60px;
      text-align: center;
    }
    .firma .linea {
      border-top: 1px solid #000;
      width: 300px;
      margin: 0 auto 5px;
    }
    .firma .nombre {
      font-weight: bold;
    }
  </style>
</head>
<body onload="window.print()">
  <div class="entrega-card">
    <div class="text-center entrega-title">
      <h3 class="mb-0">COMPROBANTE DE ENTREGA</h3>
      <small>Entrega N° <?= htmlspecialchars($cab->id_entrega) ?></small>
    </div>

    <div class="entrega-info">
      <p><strong>Servicio:</strong> <?= htmlspecialchars($cab->id_servicio) ?></p>
      <p><strong>Cliente:</strong> <?= htmlspecialchars($cab->cliente) ?></p>
      <p><strong>Monto del Servicio:</strong> Gs. <?= number_format($cab->monto_servicio, 0, ',', '.') ?></p>
      <p><strong>Fecha de Entrega:</strong> <?= htmlspecialchars($cab->fecha_entrega) ?></p>
      <p><strong>Usuario Responsable:</strong> <?= htmlspecialchars($cab->usuario) ?></p>
    </div>

    <div class="firma">
      <div class="linea"></div>
      <div class="nombre"><?= htmlspecialchars($cab->cliente) ?></div>
      <small>Firma del Cliente</small>
    </div>
  </div>
</body>
</html>
