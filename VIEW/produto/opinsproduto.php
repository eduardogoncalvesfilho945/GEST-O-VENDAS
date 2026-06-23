<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/produto.php";

if (
    !isset($_POST['descricao']) ||
    !isset($_POST['categoria']) ||
    !isset($_POST['quantidade']) ||
    !isset($_POST['preco']) ||
    !isset($_POST['estoque_minimo'])
) {
    header("location:frminsproduto.php?erro=1");
    exit;
}

$descricao = trim($_POST['descricao']);
$categoria = $_POST['categoria'];
$quantidade = $_POST['quantidade'];
$preco = $_POST['preco'];
$estoqueMinimo = $_POST['estoque_minimo'];

if (
    $descricao == "" ||
    !is_numeric($categoria) ||
    !is_numeric($quantidade) ||
    !is_numeric($preco) ||
    !is_numeric($estoqueMinimo) ||
    $quantidade < 0 ||
    $preco <= 0 ||
    $estoqueMinimo < 0
) {
    header("location:frminsproduto.php?erro=1");
    exit;
}

$produto = new \MODEL\Produto();

$produto->setDescricao($descricao);
$produto->setCategoria((int) $categoria);
$produto->setQuantidade((int) $quantidade);
$produto->setPreco((float) $preco);
$produto->setEstoqueMinimo((int) $estoqueMinimo);

$dalProduto = new \DAL\Produto();

$resultado = $dalProduto->Insert($produto);

if ($resultado) {
    header("location:lstProduto.php");
    exit;
}

header("location:frminsproduto.php?erro=1");
exit;

?>