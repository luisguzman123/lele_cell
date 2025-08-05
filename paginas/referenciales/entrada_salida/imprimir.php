<?php
require_once '../../../conexion/db.php';

$conexion = new DB();

// Recibir id_entrada desde GET
$id_entrada = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_entrada <= 0) {
    die("ID de entrada no válido.");
}

// Consulta cabecera con proveedor (asumo tabla proveedores)
$query = $conexion->conectar()->prepare("
    SELECT epc.id_entrada, epc.fecha_entrada, epc.documento_referencia, epc.observaciones,
           epc.usuario_registro, epc.estado,
           p.nombre_proveedor
    FROM entrada_productos_cabecera epc
    JOIN proveedor p ON p.id_proveedor = epc.id_proveedor
    WHERE epc.id_entrada = :id_entrada
");

$query->execute(['id_entrada' => $id_entrada]);
$cabecera = $query->fetch(PDO::FETCH_OBJ);

if (!$cabecera) {
    die("Entrada no encontrada.");
}

// Consulta detalle productos (asumo tabla productos con nombre)
$query_detalle = $conexion->conectar()->prepare("
    SELECT d.id_entrada_detalle, d.cantidad, pr.nombre
    FROM entrada_salida_detalle d
    JOIN producto pr ON pr.id_producto = d.id_producto
    WHERE d.id_entrada = :id_entrada
    GROUP BY d.id_entrada 
");
$query_detalle->execute(['id_entrada' => $id_entrada]);
$detalles = $query_detalle->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Informe Entrada #<?= htmlspecialchars($cabecera->id_entrada) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #fff;
      font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
      color: #212529;
    }
    .invoice-title {
      background: #0b2545;
      color: #fff;
      text-align: center;
      padding: .75rem 0;
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }
    .card {
      border: 1px solid #dee2e6;
      border-radius: .25rem;
      margin-bottom: 1rem;
    }
    .card-header {
      background: #f8f9fa;
      color: #212529;
      font-weight: 600;
      font-size: 1rem;
      border-bottom: 1px solid #dee2e6;
      padding: .75rem 1rem;
    }
    .card-body {
      padding: 1rem;
    }
    .label {
      font-weight: 600;
      color: #0b2545;
    }
    .table thead {
      background-color: #f8f9fa;
      border-bottom: 2px solid #dee2e6;
    }
    .table thead th {
      color: #212529;
      font-weight: 600;
      padding: .75rem;
    }
    .table tbody td {
      padding: .75rem;
      vertical-align: middle;
    }
    .btn-print {
      position: fixed;
      top: 1rem;
      right: 1rem;
      background: #0b2545;
      border: none;
      color: #fff;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      font-size: 1.2rem;
      cursor: pointer;
      z-index: 1000;
    }
    .btn-print:hover {
      background: #091f3c;
    }
    @media print {
      .btn-print { display: none; }
    }
  </style>
</head>
<body>
  <button class="btn-print" onclick="window.print()" title="Imprimir">&#128438;</button>

  <div class="container my-4">
    <div class="invoice-title">Informe de Entrada de Productos</div>

    <div class="card">
      <div class="card-header">Información General</div>
      <div class="card-body row">
        <div class="col-md-6">
          <p><span class="label">Proveedor:</span> <?= htmlspecialchars($cabecera->nombre_proveedor) ?></p>
          <p><span class="label">Documento Ref.:</span> <?= htmlspecialchars($cabecera->documento_referencia ?: '-') ?></p>
          <p><span class="label">Observaciones:</span><br><?= nl2br(htmlspecialchars($cabecera->observaciones ?: '-')) ?></p>
        </div>
        <div class="col-md-6 text-md-end">
          <p><span class="label">ID Entrada:</span> <?= $cabecera->id_entrada ?></p>
          <p><span class="label">Fecha Entrada:</span> <?= $cabecera->fecha_entrada ?></p>
          <p><span class="label">Usuario Registro:</span> <?= htmlspecialchars($cabecera->usuario_registro) ?></p>
          <p><span class="label">Estado:</span> <?= htmlspecialchars($cabecera->estado) ?></p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">Detalle de Productos</div>
      <div class="card-body p-0">
        <table class="table mb-0">
          <thead>
            <tr>
              <th style="width: 5%;">#</th>
              <th>Producto</th>
              <th style="width: 15%;" class="text-center">Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($detalles) === 0): ?>
              <tr><td colspan="3" class="text-center py-3">No hay productos en esta entrada.</td></tr>
            <?php else: foreach($detalles as $i => $d): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($d->nombre) ?></td>
                <td class="text-center"><?= intval($d->cantidad) ?></td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
