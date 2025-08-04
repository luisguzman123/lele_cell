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

if (!isset($_SESSION['id_usuario'])) {
    if (isset($_SESSION['usuario'])) {
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE usuario = :usuario");
        $stmt->execute(['usuario' => $_SESSION['usuario']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
        } else {
            http_response_code(401);
            echo 'ID de usuario no disponible';
            exit;
        }
    } else {
        http_response_code(401);
        echo 'ID de usuario no disponible';
        exit;
    }
}
$idUsuario = $_SESSION['id_usuario'];

switch ($accion) {
    case 'abrir':
        $stmt = $pdo->prepare("INSERT INTO caja_registro(id_caja, id_usuario, monto_apertura, efectivo, tarjeta, transferencia, total, accion) VALUES (:id_caja, :id_usuario, :monto_apertura, :efectivo, :tarjeta, :transferencia, :total, 'ABRIR')");
        $stmt->execute([
            'id_caja' => $idCaja,
            'id_usuario' => $idUsuario,
            'monto_apertura' => $montoApertura,
            'efectivo' => $efectivo,
            'tarjeta' => $tarjeta,
            'transferencia' => $transferencia,
            'total' => $total
        ]);
        $_SESSION['id_apertura'] = $pdo->lastInsertId();
        echo 'Caja abierta correctamente';
        break;
    case 'cerrar':
        $stmt = $pdo->prepare("INSERT INTO caja_registro(id_caja, id_usuario, monto_apertura, efectivo, tarjeta, transferencia, total, accion) VALUES (:id_caja, :id_usuario, :monto_apertura, :efectivo, :tarjeta, :transferencia, :total, 'CERRAR')");
        $stmt->execute([
            'id_caja' => $idCaja,
            'id_usuario' => $idUsuario,
            'monto_apertura' => $montoApertura,
            'efectivo' => $efectivo,
            'tarjeta' => $tarjeta,
            'transferencia' => $transferencia,
            'total' => $total
        ]);
        unset($_SESSION['id_apertura']);
        echo 'Caja cerrada correctamente';
        break;
    case 'arqueo':
        $stmt = $pdo->prepare("SELECT fecha, monto_apertura, efectivo, tarjeta, transferencia, total, accion FROM caja_registro WHERE id_caja = :id_caja AND id_usuario = :id_usuario ORDER BY fecha DESC");
        $stmt->execute([
            'id_caja' => $idCaja,
            'id_usuario' => $idUsuario
        ]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_OBJ));
        break;
    case 'estado':
        // Obtener el último registro de la caja para conocer su estado
        $stmt = $pdo->prepare("SELECT id_registro, fecha, monto_apertura, accion FROM caja_registro WHERE id_caja = :id_caja AND id_usuario = :id_usuario ORDER BY fecha DESC LIMIT 1");
        $stmt->execute([
            'id_caja' => $idCaja,
            'id_usuario' => $idUsuario
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res && $res['accion'] === 'ABRIR') {
            $idRegistro = $res['id_registro'];
            // Variables para acumular los montos por tipo de pago
            $efectivo = 0;
            $tarjeta = 0;
            $transferencia = 0;

            // Sumar pagos de facturación
            $stmtFact = $pdo->prepare(
                "SELECT UPPER(fc.tipo_pago) AS tipo_pago, SUM(fd.cantidad * fd.precio) AS total
                 FROM factura_cabecera fc
                 JOIN factura_detalle fd ON fd.id_factura_cabecera = fc.id_factura_cabecera
                 WHERE fc.estado <> 'ANULADO' AND fc.id_registro = :id_registro
                 GROUP BY fc.tipo_pago"
            );
            $stmtFact->execute(['id_registro' => $idRegistro]);
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
                 WHERE id_registro = :id_registro
                 GROUP BY tipo_pago"
            );
            $stmtServ->execute(['id_registro' => $idRegistro]);
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
