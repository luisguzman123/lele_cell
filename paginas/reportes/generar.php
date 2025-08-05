<?php
require_once '../../conexion/db.php';

$tipo = $_GET['tipo'] ?? '';
$modulo = $_GET['modulo'] ?? '';
$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';

$config = [
    'compras' => [
        'pedido_proveedor' => [
            'header' => 'pedido_proveedor_cabecera',
            'detail' => 'pedido_proveedor_detalle',
            'id' => 'id_pedido',
            'date' => 'fecha',
            'join' => 'JOIN proveedor p ON cab.id_proveedor = p.id_proveedor',
            'extra_select' => 'p.nombre_proveedor AS proveedor'
        ],
        'presupuesto' => [
            'header' => 'presupuesto_cabecera',
            'detail' => 'presupuesto_detalle',
            'id' => 'id_presupuesto',
            'date' => 'fecha',
            'join' => 'JOIN proveedor p ON cab.id_proveedor = p.id_proveedor',
            'extra_select' => 'p.nombre_proveedor AS proveedor'
        ],
        'orden_de_compra' => [
            'header' => 'orden_compra_cabecera',
            'detail' => 'orden_compra_detalle',
            'id' => 'id_orden',
            'date' => 'fecha',
            'join' => 'JOIN proveedor p ON cab.id_proveedor = p.id_proveedor',
            'extra_select' => 'p.nombre_proveedor AS proveedor'
        ],
        'factura_de_compra' => [
            'header' => 'compra_cabecera',
            'detail' => 'compra_detalle',
            'id' => 'id_compra',
            'date' => 'fecha',
            'join' => 'JOIN proveedor p ON cab.id_proveedor = p.id_proveedor',
            'extra_select' => 'p.nombre_proveedor AS proveedor'
        ],
    ],
    'ventas' => [
        'apertura_cierre' => [
            'header' => 'caja_registro',
            'detail' => null,
            'id' => 'id_registro',
            'date' => 'fecha'
        ],
        'facturacion' => [
            'header' => 'factura_cabecera',
            'detail' => 'factura_detalle',
            'id' => 'id_factura_cabecera',
            'date' => 'fecha'
        ],
        'presupuesto' => [
            'header' => 'presupuesto_venta_cabecera',
            'detail' => 'presupuesto_venta_detalle',
            'id' => 'id_presupuesto_venta',
            'date' => 'fecha_emision'
        ],
    ],
    'servicios' => [
        'recepcion' => [
            'header' => 'recepcion_cabecera',
            'detail' => 'recepcion_detalle',
            'id' => 'id_recepcion_cabecera',
            'date' => 'fecha'
        ],
        'diagnostico' => [
            'header' => 'diagnostico_cabecera',
            'detail' => 'diagnostico_detalle',
            'id' => 'id_diagnostico',
            'date' => 'fecha_diagnostico'
        ],
        'presupuesto_servicio' => [
            'header' => 'presupuesto_servicio_cabecera',
            'detail' => 'presupuesto_servicio_detalle',
            'id' => 'id_presupuesto_servicio',
            'date' => 'fecha_presupuesto'
        ],
        'servicio' => [
            'header' => 'servicio_cabecera',
            'detail' => 'servicio_detalle',
            'id' => 'id_servicio',
            'date' => 'fecha_inicio'
        ],
        'entrega' => [
            'header' => 'servicio_entrega',
            'detail' => 'servicio_entrega_pago',
            'id' => 'id_entrega',
            'date' => 'fecha_entrega'
        ],
        'garantia' => [
            'header' => 'servicio_garantia',
            'detail' => null,
            'id' => 'id_garantia',
            'date' => 'fecha_inicio'
        ],
    ],
];

$headers = [];
$columns = [];
$error = '';

if (isset($config[$tipo][$modulo])) {
    $db = new DB();
    $pdo = $db->conectar();
    $conf = $config[$tipo][$modulo];

    $join = $conf['join'] ?? '';
    $extra = $conf['extra_select'] ?? '';
    $select = 'cab.*' . ($extra ? ", $extra" : '');
    $sqlCab = "SELECT $select FROM {$conf['header']} cab $join WHERE cab.{$conf['date']} BETWEEN :desde AND :hasta";
    $stmt = $pdo->prepare($sqlCab);
    $stmt->execute(['desde' => $desde, 'hasta' => $hasta]);
    $headers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($headers) {
        $columns = array_keys($headers[0]);
        $columns = array_filter($columns, function($col) use ($conf) {
            return !(strpos($col, 'id_') === 0 && $col !== $conf['id']);
        });
    }
} else {
    $error = 'Módulo no soportado';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Reporte</title>
    <link rel="stylesheet" href="../../dist/css/adminlte.css" />
</head>
<body class="p-4">
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Reporte generado</h3>
            </div>
            <div class="card-body">
                <p><strong>Tipo:</strong> <?= htmlspecialchars($tipo) ?></p>
                <p><strong>Módulo:</strong> <?= htmlspecialchars($modulo) ?></p>
                <p><strong>Desde:</strong> <?= htmlspecialchars($desde) ?></p>
                <p><strong>Hasta:</strong> <?= htmlspecialchars($hasta) ?></p>

                <?php if ($error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php else: ?>
                    <?php if ($headers): ?>
                        <h4>Cabecera</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <?php foreach ($columns as $col): ?>
                                            <th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $col))) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($headers as $row): ?>
                                        <tr>
                                            <?php foreach ($columns as $col): ?>
                                                <td><?= htmlspecialchars($row[$col]) ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No se encontraron datos de cabecera.</p>
                    <?php endif; ?>

                    <?php if ($config[$tipo][$modulo]['detail']): ?>
                        <p>No se mostrará información de detalle en este reporte.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

