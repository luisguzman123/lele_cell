<?php
require_once 'conexion/db.php';

$conexion = new DB();
$query = $conexion->conectar()->prepare("SELECT
        fc.id_factura_cabecera,
        fc.fecha,
        fc.nro_factura,
        fc.id_cliente,
        fc.estado,
        CONCAT(c.nombre, ' ', c.apellido) as razon_social,
        fc.condicion,
        SUM(fd.cantidad * fd.precio) as total
        FROM factura_cabecera fc
        JOIN cliente c 
        ON c.id_cliente = fc.id_cliente
        JOIN factura_detalle fd 
        ON fd.id_factura_cabecera =  fc.id_factura_cabecera
        where fc.id_factura_cabecera = :id");

$query->execute([
    "id" => $_GET['id']
]);

$cabecera = $query->fetch(PDO::FETCH_OBJ);

//print_r($cabecera);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Factura 001-001-0000006</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .section {
      border: 1px solid #000;
      margin-bottom: 8px;
    }
    .invoice-title {
      background: #e9ecef;
      text-align: center;
      padding: 4px 0;
      font-weight: bold;
      border-radius: 8px;
      margin-bottom: 8px;
    }
    .logo {
      max-height: 60px;
    }
    .table-sm th,
    .table-sm td {
      padding: .3rem;
    }
  </style>
</head>
<body>
  <div class="container my-4">

    <!-- Título KuDE -->
    <div class="invoice-title">KuDE de Factura electrónica</div>

    <!-- HEADER: logo + compañía  |  RUC / Timbrado + Nº factura -->
    <div class="row section p-3 align-items-center">
      <div class="col-md-7 d-flex align-items-center">
        <img src="logo-seguros.png" alt="La Consolidada S.A. de Seguros" class="logo me-3">
        <div>
          <h6 class="mb-0">LA CONSOLIDADA S.A. DE SEGUROS</h6>
          <small>Seguros Patrimoniales</small><br>
          <small>Avenida Aviadores Del Chaco 1669 C/ San Martín</small><br>
          <small>Tel.: +595 21 6191000 – Asunción, Paraguay</small>
        </div>
      </div>
      <div class="col-md-5 text-end">
        <p class="mb-1"><strong>RUC:</strong> 80019838-7</p>
        <p class="mb-1"><strong>N° de Timbrado:</strong> 14303768</p>
        <div class="mt-2">
          <h6 class="mb-1">FACTURA ELECTRÓNICA N°</h6>
          <h5 class="mb-0">001-001-0000006</h5>
        </div>
      </div>
    </div>

    <!-- DATOS FACTURA y CLIENTE -->
    <div class="row section p-3">
      <div class="col-md-6">
        <p class="mb-1"><strong>Fecha de Emisión:</strong> 2025-05-23</p>
        <p class="mb-1"><strong>Moneda:</strong> PYG – Guaraní</p>
        <p class="mb-1"><strong>Cond. de Venta:</strong> CREDITO</p>
        <p class="mb-1"><strong>Estado:</strong> ACTIVO</p>
      </div>
      <div class="col-md-6">
        <p class="mb-1"><strong>Nombre / Razón Social:</strong> LUIS GUZMAN</p>
        <p class="mb-1"><strong>CI / RUC Cliente:</strong> 1</p>
      </div>
    </div>

    <!-- TABLA DE ÍTEMS -->
    <div class="section p-0">
      <table class="table table-bordered table-sm mb-0">
        <thead class="table-light">
          <tr>
            <th rowspan="2">TIPO DE MERCADERÍA Y/O SERVICIOS</th>
            <th colspan="3" class="text-center">VALOR DE VENTA (Gs.)</th>
          </tr>
          <tr>
            <th class="text-center" style="width:20%;">EXENTA</th>
            <th class="text-center" style="width:20%;">5%</th>
            <th class="text-center" style="width:20%;">10%</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>-- sin ítems definidos --</td>
            <td class="text-end">—</td>
            <td class="text-end">—</td>
            <td class="text-end">12.000</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- SUBTOTAL y TOTAL -->
    <div class="row mt-2">
      <div class="col-md-6"></div>
      <div class="col-md-6 text-end">
        <p class="mb-1"><strong>SUBTOTAL:</strong> ₲ 12.000</p>
        <p class="mb-1"><strong>TOTAL A PAGAR:</strong> ₲ 12.000</p>
      </div>
    </div>

  </div>

  <!-- Bootstrap JS opcional -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
