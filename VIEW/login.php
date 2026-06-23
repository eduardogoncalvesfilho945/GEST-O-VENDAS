<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/usuario.php";

if (!isset($_POST['login']) || !isset($_POST['pwd'])) {
    header("location: index.php");
    exit;
}

$login = trim($_POST['login']);
$pwd = $_POST['pwd'];

if ($login === "" || $pwd === "") {
    header("location: index.php?erro=1");
    exit;
}

$dalUsuario = new \DAL\Usuario();
$usuario = $dalUsuario->ValidarLogin($login, $pwd);

if ($usuario !== null) {
    // Regenera o ID de sessão ao autenticar, evitando fixação de sessão.
    session_regenerate_id(true);

    $_SESSION['login'] = $usuario->getLogin();
    $_SESSION['usuario_id'] = $usuario->getId();

    header("location: home.php");
    exit;
}

header("location: index.php?erro=1");
exit;

?>