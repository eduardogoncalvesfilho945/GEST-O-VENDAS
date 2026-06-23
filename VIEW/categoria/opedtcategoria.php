<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/categoria.php";

if (
    !isset($_POST['id']) ||
    !is_numeric($_POST['id']) ||
    !isset($_POST['descricao']) ||
    trim($_POST['descricao']) == ""
) {
    header("location:lstCategoria.php");
    exit;
}

$categoria = new \MODEL\Categoria();

$categoria->setId(
    (int) $_POST['id']
);

$categoria->setDescricao(
    trim($_POST['descricao'])
);

$dalCategoria = new \DAL\Categoria();

$resultado = $dalCategoria->Update($categoria);

if ($resultado) {
    header("location:lstCategoria.php");
    exit;
}

header(
    "location:frmedtcategoria.php?id=" .
    (int) $_POST['id'] .
    "&erro=1"
);

exit;

?>