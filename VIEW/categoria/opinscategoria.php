<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/categoria.php";

if (!isset($_POST['descricao']) || trim($_POST['descricao']) == "") {
    header("location:frminscategoria.php?erro=1");
    exit;
}

$categoria = new \MODEL\Categoria();

$categoria->setDescricao(
    trim($_POST['descricao'])
);

$dalCategoria = new \DAL\Categoria();

$resultado = $dalCategoria->Insert($categoria);

if ($resultado) {
    header("location:lstCategoria.php");
    exit;
}

header("location:frminscategoria.php?erro=1");
exit;

?>