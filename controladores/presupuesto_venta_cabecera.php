<?php
require_once '../conexion/db.php';

if (isset($_POST['ultimo_registro'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT nro_presupuesto FROM presupuesto_venta_cabecera ORDER BY id_presupuesto_venta DESC LIMIT 1");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO presupuesto_venta_cabecera (nro_presupuesto, fecha_emision, fecha_vencimiento, id_cliente, condicion, estado) VALUES (:nro_presupuesto, :fecha_emision, :fecha_vencimiento, :id_cliente, :condicion, :estado)");
    $query->execute($json_datos);
}

if (isset($_POST['anular'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE presupuesto_venta_cabecera SET estado='ANULADO' WHERE id_presupuesto_venta=:id");
    $query->execute(['id' => $_POST['anular']]);
}

if (isset($_POST['activar'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE presupuesto_venta_cabecera SET estado='ACTIVO' WHERE id_presupuesto_venta=:id");
    $query->execute(['id' => $_POST['activar']]);
}

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $sql = "SELECT pv.id_presupuesto_venta, pv.nro_presupuesto, pv.fecha_emision, pv.fecha_vencimiento, pv.id_cliente, pv.estado, CONCAT(c.nombre, ' ', c.apellido) as razon_social, pv.condicion, SUM(d.cantidad * d.precio) as total FROM presupuesto_venta_cabecera pv JOIN cliente c ON c.id_cliente = pv.id_cliente JOIN presupuesto_venta_detalle d ON d.id_presupuesto_venta = pv.id_presupuesto_venta WHERE 1=1";
    $params = [];
    if (!empty($_POST['nro'])) {
        $sql .= " AND pv.nro_presupuesto LIKE :nro";
        $params['nro'] = "%" . $_POST['nro'] . "%";
    }
    if (!empty($_POST['desde'])) {
        $sql .= " AND pv.fecha_emision >= :desde";
        $params['desde'] = $_POST['desde'];
    }
    if (!empty($_POST['hasta'])) {
        $sql .= " AND pv.fecha_emision <= :hasta";
        $params['hasta'] = $_POST['hasta'];
    }
    $sql .= " GROUP BY pv.id_presupuesto_venta ORDER BY pv.id_presupuesto_venta DESC";
    $query = $conexion->conectar()->prepare($sql);
    $query->execute($params);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
?>
