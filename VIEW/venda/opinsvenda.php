<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/venda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/venda.php";

if (
    !isset($_POST['cliente']) ||
    !isset($_POST['vendedor']) ||
    !is_numeric($_POST['cliente']) ||
    !is_numeric($_POST['vendedor'])
) {
    header("location:frminsvenda.php?erro=1");
    exit;
}

$venda = new \MODEL\Venda();

$venda->setCliente((int) $_POST['cliente']);
$venda->setVendedor((int) $_POST['vendedor']);
$venda->setDataVenda(date('Y-m-d H:i:s'));

$dalVenda = new \DAL\Venda();

try {
    $idVenda = $dalVenda->Insert($venda);
} catch (\Exception $e) {
    header("location:frminsvenda.php?erro=1");
    exit;
}

if ($idVenda) {
    // Depois de criar a venda, vai direto para a tela de detalhes
    // para que o usuário possa adicionar os itens (produtos vendidos).
    header("location:frmdetvenda.php?id=" . $idVenda);
    exit;
}

header("location:frminsvenda.php?erro=1");
exit;

?>
