<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/itemvenda.php";

if (
    !isset($_GET['id']) ||
    !isset($_GET['venda']) ||
    !is_numeric($_GET['id']) ||
    !is_numeric($_GET['venda'])
) {
    header("location:lstVenda.php");
    exit;
}

$id = (int) $_GET['id'];
$idVenda = (int) $_GET['venda'];

$dalItemVenda = new \DAL\ItemVenda();

try {
    $dalItemVenda->Delete($id);
} catch (\PDOException $e) {
    header("location:frmdetvenda.php?id=" . $idVenda . "&erro=" . rawurlencode("Erro ao remover o item. Tente novamente."));
    exit;
} catch (\Exception $e) {
    header("location:frmdetvenda.php?id=" . $idVenda . "&erro=" . rawurlencode($e->getMessage()));
    exit;
}

header("location:frmdetvenda.php?id=" . $idVenda);
exit;

?>
