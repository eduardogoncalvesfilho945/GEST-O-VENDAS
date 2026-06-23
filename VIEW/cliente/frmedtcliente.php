<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/cliente.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstCliente.php");
    exit;
}

$dalCliente = new \DAL\Cliente();
$cliente = $dalCliente->SelectById((int) $_GET['id']);

if ($cliente == null) {
    header("location:lstCliente.php");
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/VIEW/menu.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>Editar Cliente</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3 class="center">Editar Cliente</h3>

        <?php if (isset($_GET['erro'])) { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Preencha os dados corretamente.
            </div>
        <?php } ?>

        <form action="opedtcliente.php" method="post">
            <input type="hidden" name="id"
                value="<?php echo $cliente->getId(); ?>">

            <div class="input-field">
                <input id="nome" name="nome" type="text"
                    minlength="3" required
                    value="<?php echo htmlspecialchars($cliente->getNome()); ?>">

                <label for="nome" class="active">Nome:</label>
            </div>

            <div class="input-field">
                <input id="cpf" name="cpf" type="text"
                    minlength="11" maxlength="11"
                    pattern="[0-9]{11}" required
                    value="<?php echo htmlspecialchars($cliente->getCpf()); ?>">

                <label for="cpf" class="active">CPF, somente numeros:</label>
            </div>

            <div class="input-field">
                <input id="telefone" name="telefone" type="tel"
                    minlength="10" maxlength="15" required
                    value="<?php echo htmlspecialchars($cliente->getTelefone()); ?>">

                <label for="telefone" class="active">Telefone:</label>
            </div>

            <div class="input-field">
                <input id="email" name="email" type="email" required
                    value="<?php echo htmlspecialchars($cliente->getEmail()); ?>">

                <label for="email" class="active">E-mail:</label>
            </div>

            <div class="input-field">
                <input id="endereco" name="endereco" type="text"
                    minlength="5" required
                    value="<?php echo htmlspecialchars($cliente->getEndereco()); ?>">

                <label for="endereco" class="active">Endereco:</label>
            </div>

            <button class="btn waves-effect waves-light" type="submit">
                Salvar
                <i class="material-icons right">save</i>
            </button>

            <a class="btn grey" href="lstCliente.php">
                Voltar
                <i class="material-icons right">arrow_back</i>
            </a>
        </form>
    </div>
</body>

</html>