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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>Inserir Categoria</title>
</head>

<body class="teal lighten-4">
    <div class="container teal lighten-2 col s12">
        <div class="center teal darken-3 white-text col s12">
            <h3>Inserir Categoria</h3>
        </div>

        <?php if (isset($_GET['erro'])) { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Informe uma descricao valida.
            </div>
        <?php } ?>

        <div class="row grey lighten-2 black-text">
            <form action="opinscategoria.php" method="post" class="row">
                <div class="input-field col s8 offset-s2">
                    <input
                        placeholder="Informar a descricao da categoria"
                        id="descricao"
                        name="descricao"
                        type="text"
                        class="validate"
                        minlength="2"
                        required>

                    <label for="descricao">Descricao:</label>
                </div>

                <div class="row center col s12">
                    <button class="btn waves-effect waves-light" type="submit">
                        Enviar
                        <i class="material-icons right">send</i>
                    </button>

                    <a class="btn waves-effect grey" href="lstCategoria.php">
                        Voltar
                        <i class="material-icons right">arrow_back</i>
                    </a>
                </div>
            </form>
        </div>

        <br>
    </div>
</body>

</html>