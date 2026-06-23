<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/venda.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstVenda.php");
    exit;
}

$id = (int) $_GET['id'];

$dalVenda = new \DAL\Venda();

try {
    $dalVenda->Delete($id);
} catch (\Exception $e) {
    header("location:lstVenda.php?erro=vinculo");
    exit;
}

header("location:lstVenda.php");
exit;

?>
