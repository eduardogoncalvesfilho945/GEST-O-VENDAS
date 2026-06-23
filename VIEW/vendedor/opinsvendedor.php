<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/vendedor.php";

if (
    !isset($_POST['nome']) ||
    !isset($_POST['cpf']) ||
    !isset($_POST['telefone']) ||
    !isset($_POST['email'])
) {
    header("location:frminsvendedor.php?erro=1");
    exit;
}

$nome = trim($_POST['nome']);
$cpf = trim($_POST['cpf']);
$telefone = trim($_POST['telefone']);
$email = trim($_POST['email']);

if (
    $nome == "" ||
    !preg_match('/^[0-9]{11}$/', $cpf) ||
    $telefone == "" ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    header("location:frminsvendedor.php?erro=1");
    exit;
}

$vendedor = new \MODEL\Vendedor();

$vendedor->setNome($nome);
$vendedor->setCpf($cpf);
$vendedor->setTelefone($telefone);
$vendedor->setEmail($email);

$dalVendedor = new \DAL\Vendedor();

$resultado = $dalVendedor->Insert($vendedor);

if ($resultado) {
    header("location:lstVendedor.php");
    exit;
}

header("location:frminsvendedor.php?erro=1");
exit;

?>