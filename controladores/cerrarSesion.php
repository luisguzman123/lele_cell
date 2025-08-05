<?php

session_start();
require_once 'auditoria.php';
Auditoria::registrar('LOGOUT', 'usuario', $_SESSION['id_usuario'] ?? null, null);
session_unset();
session_destroy();
session_start();

header('location:../login.php');


