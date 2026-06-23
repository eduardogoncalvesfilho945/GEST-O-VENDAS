<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/categoria.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstCategoria.php");
    exit;
}

$id = (int) $_GET['id'];

$dalCategoria = new \DAL\Categoria();

try {
    $dalCategoria->Delete($id);
} catch (\Exception $e) {
    header("location:lstCategoria.php?erro=vinculo");
    exit;
}

header("location:lstCategoria.php");
exit;

?>