<?php
require_once '../../../../conexion/db.php';

$caja = isset($_GET['caja']) ? intval($_GET['caja']) : 0;
$db = new DB();
$pdo = $db->conectar();
$stmt = $pdo->prepare("SELECT fecha, accion, monto_apertura, efectivo, tarjeta, transferencia, total FROM caja_registro WHERE id_caja = :id_caja ORDER BY fecha DESC");
$stmt->execute(['id_caja' => $caja]);
$registros = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Caja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body onload="window.print()">
<div class="container mt-4">
    <h2 class="mb-3">Reporte de Caja <?= htmlspecialchars($caja) ?></h2>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Fecha</th>
                <th>Acción</th>
                <th>Monto Apertura</th>
                <th>Efectivo</th>
                <th>Tarjeta</th>
                <th>Transferencia</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($registros) === 0): ?>
            <tr><td colspan="7" class="text-center">Sin registros</td></tr>
        <?php else: ?>
            <?php foreach ($registros as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r->fecha) ?></td>
                <td><?= htmlspecialchars($r->accion) ?></td>
                <td class="text-end"><?= number_format($r->monto_apertura, 0, ',', '.') ?></td>
                <td class="text-end"><?= number_format($r->efectivo, 0, ',', '.') ?></td>
                <td class="text-end"><?= number_format($r->tarjeta, 0, ',', '.') ?></td>
                <td class="text-end"><?= number_format($r->transferencia, 0, ',', '.') ?></td>
                <td class="text-end"><?= number_format($r->total, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
