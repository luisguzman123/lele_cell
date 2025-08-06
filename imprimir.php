<?php
require_once 'conexion/db.php';

$conexion = new DB();

// Cabecera
$query = $conexion->conectar()->prepare("
    SELECT 
        fc.id_factura_cabecera,
        fc.fecha,
        fc.nro_factura,
        fc.condicion,
        fc.tipo_pago,
        fc.timbrado,
        fc.estado,
        CONCAT(c.nombre, ' ', c.apellido) AS razon_social,
        c.cedula AS ci_ruc_cliente
    FROM factura_cabecera fc
    JOIN cliente c ON c.id_cliente = fc.id_cliente
    WHERE fc.id_factura_cabecera = :id
");
$query->execute(["id" => $_GET['id']]);
$cabecera = $query->fetch(PDO::FETCH_OBJ);

// Detalle
$detalleStmt = $conexion->conectar()->prepare("
    SELECT 
        p.nombre AS producto,
        fd.cantidad,
        fd.precio,
        (fd.cantidad * fd.precio) AS subtotal
    FROM factura_detalle fd
    JOIN producto p ON p.id_producto = fd.id_producto
    WHERE fd.id_factura_cabecera = :id
");
$detalleStmt->execute(["id" => $_GET['id']]);
$detalles = $detalleStmt->fetchAll(PDO::FETCH_OBJ);

// Total
$total = 0;
foreach ($detalles as $item) {
    $total += $item->subtotal;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Factura <?= htmlspecialchars($cabecera->nro_factura) ?></title>
<style>
  /* Reset y tipografía */
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
    margin: 0;
    padding: 20px;
    color: #222;
  }
  .factura {
    max-width: 900px;
    margin: auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgb(0 0 0 / 0.12);
    overflow: hidden;
  }
  /* Cabecera */
  .factura-header {
    background-color: #101820; /* negro muy oscuro */
    color: #f0c419; /* amarillo dorado */
    padding: 30px 40px;
    display: flex;
    align-items: center;
    gap: 30px;
  }
  .factura-header img.logo {
    max-height: 110px;
    border-radius: 10px;
    background: #fff;
    padding: 10px;
  }
  .empresa-info {
    flex-grow: 1;
  }
  .empresa-info h1 {
    margin: 0 0 8px 0;
    font-weight: 900;
    font-size: 2.2rem;
    letter-spacing: 1.4px;
  }
  .empresa-info p {
    margin: 4px 0;
    font-weight: 600;
    font-size: 0.95rem;
  }
  .datos-factura {
    text-align: right;
    font-weight: 700;
    font-size: 0.95rem;
    line-height: 1.5;
  }
  .datos-factura p {
    margin: 3px 0;
  }
  /* Datos cliente y factura */
  .factura-body {
    padding: 30px 40px;
    display: flex;
    justify-content: space-between;
    gap: 30px;
  }
  .datos-seccion {
    flex: 1;
    background: #f7f8fa;
    border-radius: 8px;
    padding: 18px 25px;
    box-shadow: inset 0 0 5px rgb(0 0 0 / 0.05);
  }
  .datos-seccion h2 {
    margin-top: 0;
    font-size: 1.3rem;
    color: #101820;
    border-bottom: 2px solid #f0c419;
    padding-bottom: 6px;
    margin-bottom: 12px;
    font-weight: 700;
  }
  .datos-seccion p {
    margin: 8px 0;
    font-size: 1rem;
    color: #444;
  }
  /* Tabla detalle */
  table.detalle {
    width: 100%;
    border-collapse: collapse;
    margin: 0 40px 40px 40px;
    font-size: 1rem;
  }
  table.detalle thead tr {
    background: #101820;
    color: #f0c419;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1px;
  }
  table.detalle th, table.detalle td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
  }
  table.detalle th:nth-child(2),
  table.detalle td:nth-child(2) {
    text-align: center;
    width: 10%;
  }
  table.detalle th:nth-child(3),
  table.detalle td:nth-child(3),
  table.detalle th:nth-child(4),
  table.detalle td:nth-child(4) {
    text-align: right;
    width: 15%;
  }
  table.detalle tbody tr:nth-child(odd) {
    background: #f7f8fa;
  }
  table.detalle tbody tr:hover {
    background: #fff4b2;
    transition: background-color 0.3s ease;
  }
  /* Totales */
  .totales-container {
    max-width: 400px;
    margin-left: auto;
    margin-right: 40px;
    margin-bottom: 40px;
  }
  .totales-container table {
    width: 100%;
    border-collapse: collapse;
  }
  .totales-container th, .totales-container td {
    padding: 14px 20px;
    border: 1px solid #101820;
  }
  .totales-container th {
    background: #101820;
    color: #f0c419;
    font-size: 1.2rem;
    text-align: right;
  }
  .totales-container td {
    font-size: 1.2rem;
    font-weight: 700;
    text-align: right;
  }
  /* Pie de página */
  .factura-footer {
    text-align: center;
    font-size: 0.9rem;
    padding: 20px 0 40px;
    color: #666;
    border-top: 1px solid #ddd;
  }
  /* Añadido contenedor responsivo para la tabla */
.tabla-responsive {
  width: 100%;
  max-width: 100%; /* que nunca se pase del contenedor padre */
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  margin: 0 0 40px 0; /* quitar márgenes laterales */
}

table.detalle {
  width: 100%;
  max-width: 100%; /* evita que la tabla se salga */
  margin: 0 auto; /* centra la tabla si tiene un ancho fijo menor */
  border-collapse: collapse;
  font-size: 1rem;
}

</style>
</head>
<body>

<div class="factura">

  <header class="factura-header">
    <img src="dist/assets/img/Logo.png" alt="LR CELL S.A." class="logo" />
    <div class="empresa-info">
      <h1>LR CELL S.A.</h1>
      <p>Venta de repuestos de celulares y servicio técnico</p>
      <p>Itauguá</p>
      <p>Tel.: 0985 968 998</p>
    </div>
    <div class="datos-factura">
      <p><strong>RUC:</strong> 56958848-0</p>
      <p><strong>Timbrado:</strong> <?= htmlspecialchars($cabecera->timbrado) ?></p>
      <p><strong>N° Factura:</strong> <?= htmlspecialchars($cabecera->nro_factura) ?></p>
    </div>
  </header>

  <section class="factura-body">
    <div class="datos-seccion">
      <h2>Datos de la Factura</h2>
      <p><strong>Fecha de Emisión:</strong> <?= htmlspecialchars($cabecera->fecha) ?></p>
      <p><strong>Condición de Venta:</strong> <?= htmlspecialchars($cabecera->condicion) ?></p>
      <p><strong>Tipo de Pago:</strong> <?= htmlspecialchars($cabecera->tipo_pago) ?></p>
      <p><strong>Estado:</strong> <?= htmlspecialchars($cabecera->estado) ?></p>
    </div>
    <div class="datos-seccion">
      <h2>Datos del Cliente</h2>
      <p><strong>Nombre:</strong> <?= htmlspecialchars($cabecera->razon_social) ?></p>
      <p><strong>CI/RUC:</strong> <?= htmlspecialchars($cabecera->ci_ruc_cliente) ?></p>
    </div>
  </section>

    <div class="tabla-responsive">
  <table class="detalle">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Cant.</th>
        <th>Precio</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($detalles as $item): ?>
      <tr>
        <td><?= htmlspecialchars($item->producto) ?></td>
        <td class="text-center"><?= $item->cantidad ?></td>
        <td>₲ <?= number_format($item->precio, 0, ',', '.') ?></td>
        <td>₲ <?= number_format($item->subtotal, 0, ',', '.') ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
    
  <div class="totales-container">
    <table>
      <tr>
        <th>TOTAL A PAGAR:</th>
        <td>₲ <?= number_format($total, 0, ',', '.') ?></td>
      </tr>
    </table>
  </div>

  <footer class="factura-footer">
    Esta factura es válida como comprobante legal.<br>
    ¡Gracias por su preferencia!
  </footer>

</div>
 <script>
    window.print();
  </script>
</body>
</html>
