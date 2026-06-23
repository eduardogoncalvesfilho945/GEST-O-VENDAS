<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/cliente.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstCliente.php");
    exit;
}

$id = (int) $_GET['id'];

$dalCliente = new \DAL\Cliente();

try {
    $dalCliente->Delete($id);
} catch (\Exception $e) {
    header("location:lstCliente.php?erro=vinculo");
    exit;
}

header("location:lstCliente.php");
exit;

?>