<?php
session_start();
require_once '../conexion/db.php';

$accion = $_POST['accion'] ?? '';
$idCaja = $_POST['caja'] ?? 0;
$montoApertura = $_POST['monto_apertura'] ?? 0;
$efectivo = $_POST['efectivo'] ?? 0;
$tarjeta = $_POST['tarjeta'] ?? 0;
$transferencia = $_POST['transferencia'] ?? 0;
$total = $montoApertura + $efectivo + $tarjeta + $transferencia;

$db = new DB();
$pdo = $db->conectar();

switch ($accion) {
    case 'abrir':
        $stmt = $pdo->prepare("INSERT INTO caja_registro(id_caja, monto_apertura, efectivo, tarjeta, transferencia, total, accion) VALUES (:id_caja, :monto_apertura, :efectivo, :tarjeta, :transferencia, :total, 'ABRIR')");
        $stmt->execute([
            'id_caja' => $idCaja,
            'monto_apertura' => $montoApertura,
            'efectivo' => $efectivo,
            'tarjeta' => $tarjeta,
            'transferencia' => $transferencia,
            'total' => $total
        ]);
        echo 'Caja abierta correctamente';
        break;
    case 'cerrar':
        $stmt = $pdo->prepare("INSERT INTO caja_registro(id_caja, monto_apertura, efectivo, tarjeta, transferencia, total, accion) VALUES (:id_caja, :monto_apertura, :efectivo, :tarjeta, :transferencia, :total, 'CERRAR')");
        $stmt->execute([
            'id_caja' => $idCaja,
            'monto_apertura' => $montoApertura,
            'efectivo' => $efectivo,
            'tarjeta' => $tarjeta,
            'transferencia' => $transferencia,
            'total' => $total
        ]);
        echo 'Caja cerrada correctamente';
        break;
    case 'arqueo':
        $stmt = $pdo->prepare("SELECT fecha, monto_apertura, efectivo, tarjeta, transferencia, total, accion FROM caja_registro WHERE id_caja = :id_caja ORDER BY fecha DESC");
        $stmt->execute(['id_caja' => $idCaja]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_OBJ));
        break;
    default:
        echo 'Acción no reconocida';
        break;
}
?>
