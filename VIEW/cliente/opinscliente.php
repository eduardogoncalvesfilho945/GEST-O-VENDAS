<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("location: /gestaovenda/VIEW/index.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/cliente.php";

if (
    !isset($_POST['nome']) ||
    !isset($_POST['cpf']) ||
    !isset($_POST['telefone']) ||
    !isset($_POST['email']) ||
    !isset($_POST['endereco'])
) {
    header("location:frminscliente.php?erro=1");
    exit;
}

$nome = trim($_POST['nome']);
$cpf = trim($_POST['cpf']);
$telefone = trim($_POST['telefone']);
$email = trim($_POST['email']);
$endereco = trim($_POST['endereco']);

if (
    $nome == "" ||
    !preg_match('/^[0-9]{11}$/', $cpf) ||
    $telefone == "" ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $endereco == ""
) {
    header("location:frminscliente.php?erro=1");
    exit;
}

$cliente = new \MODEL\Cliente();

$cliente->setNome($nome);
$cliente->setCpf($cpf);
$cliente->setTelefone($telefone);
$cliente->setEmail($email);
$cliente->setEndereco($endereco);

$dalCliente = new \DAL\Cliente();

$resultado = $dalCliente->Insert($cliente);

if ($resultado) {
    header("location:lstCliente.php");
    exit;
}

header("location:frminscliente.php?erro=1");
exit;

?>