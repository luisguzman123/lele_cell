<?php

require_once '../conexion/db.php';

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT e.`id_entrada`, e.`fecha_entrada`, e.`id_proveedor`, 
e.`documento_referencia`, e.`observaciones`, e.`usuario_registro`, e.`estado`
FROM `entrada_productos_cabecera` e");
    

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
    $query = $conexion->conectar()->prepare("INSERT INTO entrada_productos_cabecera
        (fecha_entrada, id_proveedor, documento_referencia, observaciones, usuario_registro, estado)
        VALUES (:fecha_entrada, :proveedor, :documento_referencia, :observaciones, :usuario_registro , :estado)");

    $query->execute($json_datos);    
}

if (isset($_POST['guardar_detalle'])) {
    $json_datos = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $conn = $conexion->conectar();

    $query = $conn->prepare("INSERT INTO entrada_salida_detalle
        (id_entrada, id_producto, cantidad)
        VALUES (:id_entrada, :id_producto, :cantidad)");

    if ($query->execute($json_datos)) {
        echo "ok";
    } else {
        $error = $query->errorInfo();
        echo "error: " . $error[2];
    }
    exit;
}


if (isset($_POST['dameUltimoId'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT MAX(id_entrada) AS ultimo_id FROM entrada_productos_cabecera");

    $query->execute();

    if ($query->rowCount()) {
        $resultado = $query->fetch(PDO::FETCH_OBJ);
        echo $resultado->ultimo_id;
    } else {
        echo "0";
    }
}

if(isset($_POST['anular'])){
     
    //crea un objeto con las funciones para con la bd
    $base_datos = new DB();
   //sentencia para leer datos
    $query = $base_datos->conectar()->prepare("UPDATE `entrada_productos_cabecera` "
            . "SET estado='ANULADO' WHERE `id_entrada`= :id_entrada");

    $query->execute([
        "id_entrada" => $_POST['anular']
    ]);
}

