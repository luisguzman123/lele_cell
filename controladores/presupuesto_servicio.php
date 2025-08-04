<?php
require_once '../conexion/db.php';

if(isset($_POST['leer'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT psc.id_presupuesto_servicio, psc.id_diagnostico, psc.fecha_presupuesto, 
psc.validez_dias, psc.estado, psc.observaciones, CONCAT(c.nombre, ' ', c.apellido) as cliente FROM presupuesto_servicio_cabecera psc
JOIN diagnostico_cabecera dc
ON dc.id_diagnostico = psc.id_diagnostico
JOIN recepcion_cabecera rc
ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera
JOIN cliente c
ON c.id_cliente = rc.id_cliente
ORDER BY psc.id_presupuesto_servicio DESC");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['guardar'])){
    $json = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO presupuesto_servicio_cabecera(id_diagnostico, fecha_presupuesto, validez_dias, estado, observaciones) VALUES(:id_diagnostico, :fecha_presupuesto, :validez_dias, :estado, :observaciones)");
    $query->execute($json);
    $upd = $conexion->conectar()->prepare("UPDATE diagnostico_cabecera SET estado_diagnostico='UTILIZADO' WHERE id_diagnostico=:id");
    $upd->execute(['id'=>$json['id_diagnostico']]);
}

if(isset($_POST['dameUltimoId'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT MAX(id_presupuesto_servicio) AS id FROM presupuesto_servicio_cabecera");
    $query->execute();
    $r = $query->fetch(PDO::FETCH_OBJ);
    echo $r ? $r->id : '0';
}

if(isset($_POST['guardar_detalle'])){
    $json = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO presupuesto_servicio_detalle(id_presupuesto_servicio, concepto, cantidad, precio_unitario) VALUES(:id_presupuesto_servicio, :concepto, :cantidad, :precio_unitario)");
    $query->execute($json);
}

if(isset($_POST['leer_detalle'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT id_detalle_presu, concepto, cantidad, precio_unitario, subtotal FROM presupuesto_servicio_detalle WHERE id_presupuesto_servicio=:id");
    $query->execute(['id'=>$_POST['leer_detalle']]);
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['anular'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE presupuesto_servicio_cabecera SET estado='ANULADO' WHERE id_presupuesto_servicio=:id");
    $query->execute(['id'=>$_POST['anular']]);
}

if(isset($_POST['cambiar_estado'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE presupuesto_servicio_cabecera SET estado=:estado WHERE id_presupuesto_servicio=:id");
    $query->execute(['estado'=>$_POST['estado'], 'id'=>$_POST['cambiar_estado']]);
}


if(isset($_POST['utilizado'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE presupuesto_servicio_cabecera SET estado='UTILIZADO' WHERE id_presupuesto_servicio=:id");
    $query->execute(['id'=>$_POST['utilizado']]);
}
?>
