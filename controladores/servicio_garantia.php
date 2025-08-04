<?php
require_once '../conexion/db.php';

if(isset($_POST['leer'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT sg.id_garantia, sg.id_servicio, sg.fecha_inicio, sg.duracion_dias, sg.estado, CONCAT(c.nombre,' ',c.apellido) as cliente FROM servicio_garantia sg JOIN servicio_cabecera sc ON sc.id_servicio = sg.id_servicio JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente ORDER BY sg.id_garantia DESC");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['leer_servicio'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT sc.id_servicio, CONCAT(c.nombre,' ',c.apellido) as cliente FROM servicio_cabecera sc JOIN presupuesto_servicio_cabecera psc ON psc.id_presupuesto_servicio = sc.id_presupuesto JOIN diagnostico_cabecera dc ON dc.id_diagnostico = psc.id_diagnostico JOIN recepcion_cabecera rc ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera JOIN cliente c ON c.id_cliente = rc.id_cliente LEFT JOIN servicio_garantia sg ON sg.id_servicio = sc.id_servicio WHERE sg.id_garantia IS NULL");
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
    $query = $conexion->conectar()->prepare("INSERT INTO servicio_garantia(id_servicio, fecha_inicio, duracion_dias, estado) VALUES(:id_servicio, :fecha_inicio, :duracion_dias, :estado)");
    $query->execute($json);
}

if(isset($_POST['anular'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE servicio_garantia SET estado='ANULADO' WHERE id_garantia=:id");
    $query->execute(['id'=>$_POST['anular']]);
}

if(isset($_POST['dameUltimoId'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT MAX(id_garantia) AS id FROM servicio_garantia");
    $query->execute();
    $r = $query->fetch(PDO::FETCH_OBJ);
    echo $r ? $r->id : '0';
}
?>
