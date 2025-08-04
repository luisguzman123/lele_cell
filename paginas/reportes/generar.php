<?php
$tipo = $_GET['tipo'] ?? '';
$modulo = $_GET['modulo'] ?? '';
$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Reporte</title>
    <link rel="stylesheet" href="../../dist/css/adminlte.css" />
</head>
<body class="p-4">
    <h3>Reporte generado</h3>
    <p><strong>Tipo:</strong> <?php echo htmlspecialchars($tipo); ?></p>
    <p><strong>Módulo:</strong> <?php echo htmlspecialchars($modulo); ?></p>
    <p><strong>Desde:</strong> <?php echo htmlspecialchars($desde); ?></p>
    <p><strong>Hasta:</strong> <?php echo htmlspecialchars($hasta); ?></p>
</body>
</html>
