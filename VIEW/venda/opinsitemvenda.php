<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/itemvenda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/itemvenda.php";

if (
    !isset($_POST['venda']) ||
    !isset($_POST['produto']) ||
    !isset($_POST['quantidade']) ||
    !is_numeric($_POST['venda']) ||
    !is_numeric($_POST['produto']) ||
    !is_numeric($_POST['quantidade'])
) {
    header("location:lstVenda.php");
    exit;
}

$idVenda = (int) $_POST['venda'];
$idProduto = (int) $_POST['produto'];
$quantidade = (int) $_POST['quantidade'];

if ($quantidade <= 0) {
    header("location:frmdetvenda.php?id=" . $idVenda . "&erro=" . rawurlencode("A quantidade deve ser maior que zero."));
    exit;
}

$itemVenda = new \MODEL\ItemVenda();
$itemVenda->setVenda($idVenda);
$itemVenda->setProduto($idProduto);
$itemVenda->setQuantidade($quantidade);

$dalItemVenda = new \DAL\ItemVenda();

try {
    $dalItemVenda->Insert($itemVenda);
} catch (\PDOException $e) {
    header("location:frmdetvenda.php?id=" . $idVenda . "&erro=" . rawurlencode("Erro ao adicionar o item. Tente novamente."));
    exit;
} catch (\Exception $e) {
    header("location:frmdetvenda.php?id=" . $idVenda . "&erro=" . rawurlencode($e->getMessage()));
    exit;
}

header("location:frmdetvenda.php?id=" . $idVenda);
exit;

?>
