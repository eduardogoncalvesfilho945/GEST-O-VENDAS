<?php

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

    <title>Inserir Vendedor</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3 class="center">Inserir Vendedor</h3>

        <?php if (isset($_GET['erro'])) { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Preencha os dados corretamente.
            </div>
        <?php } ?>

        <form action="opinsvendedor.php" method="post">
            <div class="input-field">
                <input id="nome" name="nome" type="text"
                    minlength="3" required>

                <label for="nome">Nome:</label>
            </div>

            <div class="input-field">
                <input id="cpf" name="cpf" type="text"
                    minlength="11"
                    maxlength="11"
                    pattern="[0-9]{11}"
                    required>

                <label for="cpf">CPF, somente numeros:</label>
            </div>

            <div class="input-field">
                <input id="telefone" name="telefone" type="tel"
                    minlength="10"
                    maxlength="15"
                    required>

                <label for="telefone">Telefone:</label>
            </div>

            <div class="input-field">
                <input id="email" name="email" type="email" required>

                <label for="email">E-mail:</label>
            </div>

            <button class="btn waves-effect waves-light" type="submit">
                Enviar
                <i class="material-icons right">send</i>
            </button>

            <a class="btn grey" href="lstVendedor.php">
                Voltar
                <i class="material-icons right">arrow_back</i>
            </a>
        </form>
    </div>
</body>

</html>