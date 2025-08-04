<?php
require_once '../conexion/db.php';

if(isset($_POST['leer'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT id_presupuesto_servicio, id_diagnostico, fecha_presupuesto, validez_dias, estado, observaciones FROM presupuesto_servicio_cabecera ORDER BY id_presupuesto_servicio DESC");
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
?>
