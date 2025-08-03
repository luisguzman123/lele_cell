<?php

require_once '../conexion/db.php';


if(isset($_POST['guardar'])){
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO `equipo`(`descripcion`, `marca`, `modelo`, `estado`) "
            . "VALUES (:descripcion,:marca,:modelo,:estado)");
    
    $query->execute($json_datos);
}

if(isset($_POST['leer'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT * FROM  persona "
            . "order by id_persona DESC "
            . "LIMIT 100");
    
    $query->execute();
    
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo  "0";
    }
}



if(isset($_POST['eliminar'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("DELETE FROM equipo "
            . "WHERE id_equipo = :id");
    
    $query->execute([
        "id" => $_POST['eliminar']
    ]);
}
if (isset($_POST['leer_equipo'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_equipo`, `descripcion`, `marca`, "
            . "`modelo`, `estado` FROM `equipo`");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_equipo_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_equipo`, `descripcion`, `marca`, "
            . "`modelo`, `estado` FROM `equipo` WHERE id_equipo = :id");

      $query->execute([
        "id" => $_POST['leer_equipo_id']
    ]);

    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['actualizar'])) {
    actualizar($_POST['actualizar']);
}

function actualizar($lista)
{
    $json_datos = json_decode($lista, true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("UPDATE `equipo` SET `descripcion`=:descripcion,`marca`=:marca, "
            . "`modelo`=:modelo,`estado`=:estado "
            . "WHERE `id_equipo`=:id_equipo");

    $query->execute($json_datos);
}