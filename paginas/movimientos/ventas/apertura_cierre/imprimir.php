<?php
session_start();
require_once '../../../../conexion/db.php';

$caja = isset($_GET['caja']) ? intval($_GET['caja']) : 0;
$hasInputs = isset(
    $_GET['monto_apertura'],
    $_GET['efectivo'],
    $_GET['tarjeta'],
    $_GET['transferencia'],
    $_GET['total']
);

$db = new DB();
$pdo = $db->conectar();

if (!isset($_SESSION['id_usuario'])) {
    if (isset($_SESSION['usuario'])) {
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE usuario = :usuario");
        $stmt->execute(['usuario' => $_SESSION['usuario']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
        }
    }
}
$idUsuario = $_SESSION['id_usuario'] ?? 0;

if ($hasInputs) {
    $registros = [
        (object) [
            'fecha' => date('Y-m-d H:i:s'),
            'accion' => 'ARQUEO',
            'usuario' => $_SESSION['usuario'] ?? '',
            'monto_apertura' => intval($_GET['monto_apertura']),
            'efectivo' => intval($_GET['efectivo']),
            'tarjeta' => intval($_GET['tarjeta']),
            'transferencia' => intval($_GET['transferencia']),
            'total' => intval($_GET['total'])
        ]
    ];
} else {
    $stmt = $pdo->prepare("SELECT cr.fecha, cr.accion, cr.monto_apertura, cr.efectivo, cr.tarjeta, cr.transferencia, cr.total, u.usuario FROM caja_registro cr JOIN usuario u ON u.id_usuario = cr.id_usuario WHERE cr.id_caja = :id_caja AND cr.id_usuario = :id_usuario ORDER BY cr.fecha DESC");
    $stmt->execute([
        'id_caja' => $caja,
        'id_usuario' => $idUsuario
    ]);
    $registros = $stmt->fetchAll(PDO::FETCH_OBJ);
}
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
                <th>Usuario</th>
                <th>Monto Apertura</th>
                <th>Efectivo</th>
                <th>Tarjeta</th>
                <th>Transferencia</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($registros) === 0): ?>
            <tr><td colspan="8" class="text-center">Sin registros</td></tr>
        <?php else: ?>
            <?php foreach ($registros as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r->fecha) ?></td>
                <td><?= htmlspecialchars($r->accion) ?></td>
                <td><?= htmlspecialchars($r->usuario ?? '') ?></td>
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
