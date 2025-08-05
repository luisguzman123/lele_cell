<?php

require_once '../conexion/db.php';

if (isset($_POST['totales'])) {
    $db = new DB();
    $pdo = $db->conectar();

    $sqlRecep = "SELECT COUNT(*) AS total FROM recepcion_cabecera WHERE DATE(fecha) = CURDATE() AND estado <> 'ANULADO'";
    $queryRecep = $pdo->prepare($sqlRecep);
    $queryRecep->execute();
    $recepciones = $queryRecep->fetch(PDO::FETCH_ASSOC)['total'];

    $sqlVentas = "SELECT COUNT(*) AS total FROM factura_cabecera WHERE DATE(fecha) = CURDATE() AND estado <> 'ANULADO'";
    $queryVentas = $pdo->prepare($sqlVentas);
    $queryVentas->execute();
    $ventas = $queryVentas->fetch(PDO::FETCH_ASSOC)['total'];

    echo json_encode([
        'recepciones' => (int)$recepciones,
        'ventas' => (int)$ventas,
    ]);
}

if (isset($_POST['grafico'])) {
    $db = new DB();
    $pdo = $db->conectar();

    $fechas = [];
    $recepciones = [];
    $ventas = [];

    for ($i = 6; $i >= 0; $i--) {
        $fecha = date('Y-m-d', strtotime("-$i day"));
        $fechas[] = $fecha;

        $stmtRecep = $pdo->prepare("SELECT COUNT(*) AS total FROM recepcion_cabecera WHERE DATE(fecha) = :fecha AND estado <> 'ANULADO'");
        $stmtRecep->execute(['fecha' => $fecha]);
        $recepciones[] = (int)$stmtRecep->fetch(PDO::FETCH_ASSOC)['total'];

        $stmtVentas = $pdo->prepare("SELECT COUNT(*) AS total FROM factura_cabecera WHERE DATE(fecha) = :fecha AND estado <> 'ANULADO'");
        $stmtVentas->execute(['fecha' => $fecha]);
        $ventas[] = (int)$stmtVentas->fetch(PDO::FETCH_ASSOC)['total'];
    }

    echo json_encode([
        'fechas' => $fechas,
        'recepciones' => $recepciones,
        'ventas' => $ventas,
    ]);
}

