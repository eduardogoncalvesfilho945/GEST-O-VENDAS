<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/categoria.php";

$dalCategoria = new \DAL\Categoria();
$lstCategoria = $dalCategoria->Select();

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

    <title>Inserir Produto</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3 class="center">Inserir Produto</h3>

        <?php if (isset($_GET['erro'])) { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Preencha os dados corretamente.
            </div>
        <?php } ?>

        <form action="opinsproduto.php" method="post">
            <div class="input-field">
                <input id="descricao" name="descricao" type="text"
                    minlength="2" required>

                <label for="descricao">Descricao:</label>
            </div>

            <div class="input-field">
                <select id="categoria" name="categoria"
                    class="browser-default" required>

                    <option value="" disabled selected>
                        Selecione uma categoria
                    </option>

                    <?php foreach ($lstCategoria as $categoria) { ?>
                        <option value="<?php echo $categoria->getId(); ?>">
                            <?php echo htmlspecialchars($categoria->getDescricao()); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="input-field">
                <input id="quantidade" name="quantidade"
                    type="number" min="0" required>

                <label for="quantidade">Quantidade:</label>
            </div>

            <div class="input-field">
                <input id="preco" name="preco"
                    type="number" min="0.01" step="0.01" required>

                <label for="preco">Preco:</label>
            </div>

            <div class="input-field">
                <input id="estoque_minimo" name="estoque_minimo"
                    type="number" min="0" required>

                <label for="estoque_minimo">Estoque minimo:</label>
            </div>

            <button class="btn waves-effect waves-light" type="submit">
                Enviar
                <i class="material-icons right">send</i>
            </button>

            <a class="btn grey" href="lstProduto.php">
                Voltar
                <i class="material-icons right">arrow_back</i>
            </a>
        </form>
    </div>
</body>

</html>