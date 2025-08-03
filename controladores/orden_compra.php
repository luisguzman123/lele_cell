<?php
require_once '../conexion/db.php';

if(isset($_POST['leer'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT c.id_orden, c.fecha, c.observacion, c.total, c.estado, p.nombre_proveedor FROM orden_compra_cabecera c JOIN proveedor p ON p.id_proveedor=c.id_proveedor ORDER BY c.id_orden DESC");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo "0";
    }
}

if(isset($_POST['leer_activo'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT c.id_orden, c.fecha, c.observacion, c.total, c.estado, c.id_proveedor, p.nombre_proveedor FROM orden_compra_cabecera c JOIN proveedor p ON p.id_proveedor=c.id_proveedor WHERE c.estado='ACTIVO' ORDER BY c.id_orden DESC");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}
if(isset($_POST['leer_aprobado'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT c.id_orden, c.fecha, c.observacion, c.total, c.estado, c.id_proveedor, p.nombre_proveedor FROM orden_compra_cabecera c JOIN proveedor p ON p.id_proveedor=c.id_proveedor WHERE c.estado='APROBADO' ORDER BY c.id_orden DESC");
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
    $query = $conexion->conectar()->prepare("INSERT INTO orden_compra_cabecera(fecha, observacion, id_proveedor, total, id_presupuesto, estado) VALUES(:fecha,:observacion,:proveedor,:total,:presupuesto,:estado)");
    $query->execute($json);
}

if(isset($_POST['dameUltimoId'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT MAX(id_orden) AS id FROM orden_compra_cabecera");
    $query->execute();
    $r = $query->fetch(PDO::FETCH_OBJ);
    echo $r ? $r->id : "0";
}

if(isset($_POST['guardar_detalle'])){
    $json = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO orden_compra_detalle(id_orden, id_producto, cantidad, precio) VALUES(:id_orden,:id_producto,:cantidad,:precio)");
    $query->execute($json);
}

if(isset($_POST['leer_detalle'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT d.id_producto, p.nombre, d.cantidad, d.precio, p.iva FROM orden_compra_detalle d JOIN producto p ON p.id_producto=d.id_producto WHERE d.id_orden=:id");
    $query->execute(['id'=>$_POST['leer_detalle']]);
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['anular'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE orden_compra_cabecera SET estado='ANULADO' WHERE id_orden=:id");
    $query->execute(['id'=>$_POST['anular']]);
}

if(isset($_POST['cambiar_estado'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE orden_compra_cabecera SET estado=:estado WHERE id_orden=:id");
    $query->execute([
        'estado' => $_POST['estado'],
        'id' => $_POST['cambiar_estado']
    ]);
}
if(isset($_POST['cambiar_estado_utilizado'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE orden_compra_cabecera SET estado=UTILIZADO WHERE id_orden=:id");
    $query->execute([
        'id' => $_POST['cambiar_estado_utilizado']
    ]);
}
?>
