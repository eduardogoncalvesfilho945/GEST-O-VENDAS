<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/vendedor.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstVendedor.php");
    exit;
}

$id = (int) $_GET['id'];

$dalVendedor = new \DAL\Vendedor();

try {
    $dalVendedor->Delete($id);
} catch (\Exception $e) {
    header("location:lstVendedor.php?erro=vinculo");
    exit;
}

header("location:lstVendedor.php");
exit;

?>