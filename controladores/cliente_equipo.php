<?php

require_once '../conexion/db.php';

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT 
        `id_producto`, `nombre`, `stock`, `precio`,
        `estado`, iva FROM `productos` 
            where estado = 'ACTIVO'");
    

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_cliente'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_cliente`, `nombre`, `apellido`, "
            . "`cedula`, `correo`, `telefono`, `estado` FROM `cliente` WHERE estado = 'ACTIVO'");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
if(isset($_POST['eliminar'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("DELETE FROM `cliente_equipo` WHERE "
            . "`id_cliente_equipo`= :id");
    
    $query->execute([
        "id" => $_POST['eliminar']
    ]);
}


if (isset($_POST['leer_cliente_equipo_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_cliente_equipo`, `id_cliente`, "
            . "`id_equipo`, `imei`, `tipo_pass`, `pass`, `estado` "
            . "FROM `cliente_equipo` WHERE `id_cliente_equipo` = :id");

      $query->execute([
        "id" => $_POST['leer_cliente_equipo_id']
    ]);

    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}





if (isset($_POST['leer_equipo_cliente'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT cle.`id_cliente_equipo`, "
            . "CONCAT(c.nombre, ' ', c.apellido) as nombre_cliente, e.descripcion "
            . "as nombre_equipo, cle.`tipo_pass`, cle.estado, e.modelo, e.marca FROM `cliente_equipo` cle "
            . "JOIN cliente c ON cle.`id_cliente` = "
            . "c.id_cliente JOIN equipo e ON cle.`id_equipo` = e.id_equipo");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
if (isset($_POST['leer_equipo'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_equipo`, `descripcion`, `marca`, `modelo`, "
            . "`estado` FROM `equipo` WHERE estado = 'ACTIVO'");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}


//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO `cliente_equipo`(`id_cliente`, "
            . "`id_equipo`, `imei`, `tipo_pass`, `pass`, `estado`) "
            . "VALUES (:id_cliente,:id_equipo,:imei,:tipo_pass,:pass,:estado)");

    $query->execute($json_datos);

   
}


if (isset($_POST['actualizar'])) {
    actualizar($_POST['actualizar']);
}

function actualizar($lista)
{
    $json_datos = json_decode($lista, true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("UPDATE `cliente_equipo` SET `id_cliente`=:id_cliente,"
            . "`id_equipo`=:id_equipo,`imei`=:imei,`tipo_pass`=:tipo_pass,`pass`=:pass,`estado`=:estado "
            . "WHERE  `id_cliente_equipo`=:id_cliente_equipo");

    $query->execute($json_datos);
}
