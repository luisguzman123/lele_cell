<?php
require_once '../conexion/db.php';

if(isset($_POST['leer'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT sc.id_servicio, sc.id_presupuesto, sc.fecha_inicio, sc.fecha_fin, sc.estado, sc.observaciones, COALESCE(t.nombre_tecnico,'') as tecnico, CONCAT(c.nombre,' ',c.apellido) as cliente FROM servicio_cabecera sc JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto LEFT JOIN tecnico t ON t.id_tecnico = sc.id_tecnico JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente ORDER BY sc.id_servicio DESC");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['leer_presupuesto'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT psc.id_presupuesto_servicio, psc.fecha_presupuesto, CONCAT(c.nombre,' ',c.apellido) as cliente FROM presupuesto_servicio_cabecera psc JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente WHERE psc.estado='Aprobado' AND DATE_ADD(psc.fecha_presupuesto, INTERVAL psc.validez_dias DAY) >= CURDATE()");
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
    $pdo = $conexion->conectar();
    try{
        $pdo->beginTransaction();
        $query = $pdo->prepare("INSERT INTO servicio_cabecera(id_presupuesto, id_tecnico, fecha_inicio, fecha_fin, estado, observaciones) VALUES(:id_presupuesto, :id_tecnico, :fecha_inicio, :fecha_fin, :estado, :observaciones)");
        $query->execute($json);
        $id = $pdo->lastInsertId();
        $upd = $pdo->prepare("UPDATE presupuesto_servicio_cabecera SET estado='UTILIZADO' WHERE id_presupuesto_servicio=:id");
        $upd->execute(['id'=>$json['id_presupuesto']]);
        $pdo->commit();
        echo $id;
    }catch(PDOException $e){
        $pdo->rollBack();
        http_response_code(500);
        echo $e->getMessage();
    }
}

if(isset($_POST['dameUltimoId'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT MAX(id_servicio) AS id FROM servicio_cabecera");
    $query->execute();
    $r = $query->fetch(PDO::FETCH_OBJ);
    echo $r ? $r->id : '0';
}

if(isset($_POST['guardar_detalle'])){
    $json = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO servicio_detalle(id_servicio, tarea, horas_trabajadas, observaciones) VALUES(:id_servicio, :tarea, :horas_trabajadas, :observaciones)");
    $query->execute($json);
}

if(isset($_POST['leer_detalle'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT tarea, horas_trabajadas, observaciones FROM servicio_detalle WHERE id_servicio=:id");
    $query->execute(['id'=>$_POST['leer_detalle']]);
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['anular'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE servicio_cabecera SET estado='ANULADO' WHERE id_servicio=:id");
    $query->execute(['id'=>$_POST['anular']]);
}
?>
