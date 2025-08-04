<?php
require_once '../conexion/db.php';

if (isset($_POST['leer_servicio'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare(
        "SELECT sc.id_servicio, sc.total_general, CONCAT(c.nombre,' ',c.apellido) AS cliente
        FROM servicio_cabecera sc
        JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto
        JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico
        JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera
        JOIN cliente c ON c.id_cliente = rc.id_cliente
        LEFT JOIN servicio_entrega se ON se.id_servicio = sc.id_servicio
        WHERE se.id_servicio IS NULL"
    );
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare(
        "INSERT INTO servicio_entrega (id_servicio, fecha_entrega, id_usuario, monto_servicio)
        VALUES (:id_servicio, :fecha_entrega, :id_usuario, :monto_servicio)"
    );
    $query->execute($json_datos);
}

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare(
        "SELECT se.id_entrega, se.fecha_entrega, se.monto_servicio, u.usuario, sc.id_servicio, CONCAT(c.nombre,' ',c.apellido) AS cliente
        FROM servicio_entrega se
        JOIN usuario u ON u.id_usuario = se.id_usuario
        JOIN servicio_cabecera sc ON se.id_servicio = sc.id_servicio
        JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto
        JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico
        JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera
        JOIN cliente c ON c.id_cliente = rc.id_cliente
        ORDER BY se.id_entrega DESC"
    );
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['anular'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("DELETE FROM servicio_entrega WHERE id_entrega = :id");
    $query->execute(['id' => $_POST['anular']]);
}

if (isset($_POST['pagar'])) {
    $json_datos = json_decode($_POST['pagar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare(
        "INSERT INTO servicio_entrega_pago (id_entrega, tipo_pago, monto)
        VALUES (:id_entrega, :tipo_pago, :monto)"
    );
    $query->execute($json_datos);
}
?>
