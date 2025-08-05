<?php
session_start();
require_once '../conexion/db.php';

if (isset($_POST['ultimo_registro'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT
fc.nro_factura,
fc.timbrado
FROM factura_cabecera fc
ORDER by fc.id_factura_cabecera desc 
limit 1");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['guardar'])) {
    $conexion = new DB();
    $pdo = $conexion->conectar();

    if (!isset($_SESSION['id_apertura'])) {
        if (!isset($_SESSION['id_usuario'])) {
            echo "NO_APERTURA";
            exit;
        }

        $stmt = $pdo->prepare(
            "SELECT id_registro, accion FROM caja_registro WHERE id_usuario = :id_usuario ORDER BY fecha DESC LIMIT 1"
        );
        $stmt->execute(['id_usuario' => $_SESSION['id_usuario']]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registro && $registro['accion'] === 'ABRIR') {
            $_SESSION['id_apertura'] = $registro['id_registro'];
        } else {
            echo "NO_APERTURA";
            exit;
        }
    }

    $json_datos = json_decode($_POST['guardar'], true);
    $json_datos['id_registro'] = $_SESSION['id_apertura'];

    $query = $pdo->prepare("INSERT INTO factura_cabecera" .
            "( nro_factura, fecha, id_cliente, condicion, tipo_pago," .
            " timbrado, estado, id_registro)" .
            " VALUES (:nro_factura, :fecha, :id_cliente," .
            " :condicion, :tipo_pago, :timbrado, :estado, :id_registro)");

    $query->execute($json_datos);
    echo "OK";

}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['anular'])) {
    
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE factura_cabecera SET "
            . "estado  = 'ANULADO' "
            . "WHERE id_factura_cabecera = :id");

    $query->execute([
        "id" => $_POST['anular']
    ]);

   
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['activar'])) {
    
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE factura_cabecera SET "
            . "estado  = 'ACTIVO' "
            . "WHERE id_factura_cabecera = :id");

    $query->execute([
        "id" => $_POST['activar']
    ]);

   
}

if (isset($_POST['leer'])) {
    $conexion = new DB();

    $sql = "SELECT
        fc.id_factura_cabecera,
        fc.fecha,
        fc.nro_factura,
        fc.id_cliente,
        fc.estado,
        CONCAT(c.nombre, ' ', c.apellido) as razon_social,
        fc.condicion,
        fc.tipo_pago,
        SUM(fd.cantidad * fd.precio) as total
        FROM factura_cabecera fc
        JOIN cliente c
        ON c.id_cliente = fc.id_cliente
        JOIN factura_detalle fd
        ON fd.id_factura_cabecera =  fc.id_factura_cabecera";

    $where = [];
    $params = [];

    if (!empty($_POST['desde']) && !empty($_POST['hasta'])) {
        $where[] = "fc.fecha BETWEEN :desde AND :hasta";
        $params['desde'] = $_POST['desde'];
        $params['hasta'] = $_POST['hasta'];
    } else {
        if (!empty($_POST['desde'])) {
            $where[] = "fc.fecha >= :desde";
            $params['desde'] = $_POST['desde'];
        }
        if (!empty($_POST['hasta'])) {
            $where[] = "fc.fecha <= :hasta";
            $params['hasta'] = $_POST['hasta'];
        }
    }

    if (!empty($_POST['nro_factura'])) {
        $where[] = "fc.nro_factura LIKE :nro_factura";
        $params['nro_factura'] = "%" . $_POST['nro_factura'] . "%";
    }

    if (count($where) > 0) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $sql .= " GROUP by fc.id_factura_cabecera order by fc.id_factura_cabecera DESC";

    $query = $conexion->conectar()->prepare($sql);
    $query->execute($params);

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

