<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/produto.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstProduto.php");
    exit;
}

$id = (int) $_GET['id'];

$dalProduto = new \DAL\Produto();

try {
    $dalProduto->Delete($id);
} catch (\Exception $e) {
    header("location:lstProduto.php?erro=vinculo");
    exit;
}

header("location:lstProduto.php");
exit;

?>