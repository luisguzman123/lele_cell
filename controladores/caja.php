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
    case 'estado':
        // Obtener el último registro de la caja para conocer su estado
        $stmt = $pdo->prepare("SELECT fecha, monto_apertura, accion FROM caja_registro WHERE id_caja = :id_caja ORDER BY fecha DESC LIMIT 1");
        $stmt->execute(['id_caja' => $idCaja]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res && $res['accion'] === 'ABRIR') {
            // Variables para acumular los montos por tipo de pago
            $efectivo = 0;
            $tarjeta = 0;
            $transferencia = 0;

            // Sumar pagos de facturación
            $stmtFact = $pdo->prepare(
                "SELECT UPPER(fc.tipo_pago) AS tipo_pago, SUM(fd.cantidad * fd.precio) AS total
                 FROM factura_cabecera fc
                 JOIN factura_detalle fd ON fd.id_factura_cabecera = fc.id_factura_cabecera
                 WHERE fc.estado <> 'ANULADO' AND fc.fecha = CURDATE()
                 GROUP BY fc.tipo_pago"
            );
            $stmtFact->execute();
            foreach ($stmtFact->fetchAll(PDO::FETCH_ASSOC) as $row) {
                switch ($row['tipo_pago']) {
                    case 'EFECTIVO':
                        $efectivo += $row['total'];
                        break;
                    case 'TARJETA':
                        $tarjeta += $row['total'];
                        break;
                    case 'TRANSFERENCIA':
                        $transferencia += $row['total'];
                        break;
                }
            }

            // Sumar pagos de servicios
            $stmtServ = $pdo->prepare(
                "SELECT UPPER(tipo_pago) AS tipo_pago, SUM(monto) AS total
                 FROM servicio_entrega_pago
                 WHERE DATE(fecha_pago) = CURDATE()
                 GROUP BY tipo_pago"
            );
            $stmtServ->execute();
            foreach ($stmtServ->fetchAll(PDO::FETCH_ASSOC) as $row) {
                switch ($row['tipo_pago']) {
                    case 'EFECTIVO':
                        $efectivo += $row['total'];
                        break;
                    case 'TARJETA':
                        $tarjeta += $row['total'];
                        break;
                    case 'TRANSFERENCIA':
                        $transferencia += $row['total'];
                        break;
                }
            }

            $res['efectivo'] = $efectivo;
            $res['tarjeta'] = $tarjeta;
            $res['transferencia'] = $transferencia;
            $res['total'] = $res['monto_apertura'] + $efectivo + $tarjeta + $transferencia;
        }

        echo json_encode($res ?: []);
        break;
    default:
        echo 'Acción no reconocida';
        break;
}
?>
