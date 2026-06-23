<?php

/**
 * Script auxiliar para criar o primeiro usuário de acesso ao sistema.
 *
 * COMO USAR:
 * 1. Importe o arquivo DAL/vendas_estoque.sql no seu banco de dados.
 * 2. Acesse este arquivo pelo navegador, ex:
 *    http://localhost/gestaovenda/criar_usuario.php
 * 3. Preencha o formulário com o login e a senha desejados.
 * 4. Depois de criar o usuário, APAGUE este arquivo do servidor
 *    por motivos de segurança (ele permite criar usuários sem login).
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/usuario.php";

$mensagem = "";
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if ($login === '' || $senha === '') {
        $mensagem = "Preencha o login e a senha.";
    } elseif (strlen($senha) < 3) {
        $mensagem = "A senha deve ter pelo menos 3 caracteres.";
    } elseif ($senha !== $confirmarSenha) {
        $mensagem = "As senhas não coincidem.";
    } else {
        try {
            $dalUsuario = new \DAL\Usuario();

            if ($dalUsuario->SelectByLogin($login) !== null) {
                $mensagem = "Já existe um usuário com esse login.";
            } else {
                $usuario = new \MODEL\Usuario();
                $usuario->setLogin($login);
                $usuario->setSenha($senha);

                $dalUsuario->Insert($usuario);

                $sucesso = true;
                $mensagem = "Usuário '" . htmlspecialchars($login) . "' criado com sucesso! "
                    . "Agora apague este arquivo (criar_usuario.php) do servidor.";
            }
        } catch (\Exception $e) {
            $mensagem = "Erro ao criar usuário: " . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário Inicial</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="/gestaovenda/VIEW/css/style.css">
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3 class="center">Criar Usuário Inicial do Sistema</h3>

        <?php if ($mensagem !== "") { ?>
            <div class="card-panel <?php echo $sucesso ? 'green lighten-4 green-text text-darken-4' : 'red lighten-4 red-text text-darken-4'; ?> center">
                <?php echo $mensagem; ?>
            </div>
        <?php } ?>

        <?php if (!$sucesso) { ?>
            <form action="criar_usuario.php" method="post">
                <div class="input-field">
                    <input id="login" name="login" type="text" minlength="3" required>
                    <label for="login">Login:</label>
                </div>

                <div class="input-field">
                    <input id="senha" name="senha" type="password" minlength="3" required>
                    <label for="senha">Senha:</label>
                </div>

                <div class="input-field">
                    <input id="confirmar_senha" name="confirmar_senha" type="password" minlength="3" required>
                    <label for="confirmar_senha">Confirmar senha:</label>
                </div>

                <button class="btn waves-effect waves-light" type="submit">
                    Criar usuário
                    <i class="material-icons right">person_add</i>
                </button>
            </form>
        <?php } else { ?>
            <div class="center">
                <a class="btn" href="/gestaovenda/VIEW/index.php">Ir para o login</a>
            </div>
        <?php } ?>
    </div>
</body>

</html>
