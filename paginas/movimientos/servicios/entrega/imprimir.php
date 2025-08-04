<?php
require_once '../../../../conexion/db.php';
$conexion = new DB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('ID no valido');
}
$query = $conexion->conectar()->prepare("SELECT se.id_entrega, se.fecha_entrega, se.firmado_por, sc.id_servicio, CONCAT(c.nombre,' ',c.apellido) AS cliente FROM servicio_entrega se JOIN servicio_cabecera sc ON se.id_servicio = sc.id_servicio JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente WHERE se.id_entrega = :id");
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
</head>
<body onload="window.print()">
  <div class="container mt-4">
    <h3 class="text-center mb-4">ENTREGA N° <?= htmlspecialchars($cab->id_entrega) ?></h3>
    <p><strong>Servicio:</strong> <?= htmlspecialchars($cab->id_servicio) ?></p>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($cab->cliente) ?></p>
    <p><strong>Fecha Entrega:</strong> <?= htmlspecialchars($cab->fecha_entrega) ?></p>
    <?php if(!empty($cab->firmado_por)): ?>
    <p><strong>Firmado por:</strong> <?= htmlspecialchars($cab->firmado_por) ?></p>
    <?php endif; ?>
  </div>
</body>
</html>
