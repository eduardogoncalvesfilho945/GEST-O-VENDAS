<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/categoria.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstCategoria.php");
    exit;
}

$dalCategoria = new \DAL\Categoria();

$categoria = $dalCategoria->SelectById(
    (int) $_GET['id']
);

if ($categoria == null) {
    header("location:lstCategoria.php");
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

    <title>Editar Categoria</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3 class="center">Editar Categoria</h3>

        <?php if (isset($_GET['erro'])) { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Informe uma descricao valida.
            </div>
        <?php } ?>

        <form action="opedtcategoria.php" method="post">
            <input
                type="hidden"
                name="id"
                value="<?php echo $categoria->getId(); ?>">

            <div class="input-field">
                <input
                    id="descricao"
                    name="descricao"
                    type="text"
                    minlength="2"
                    required
                    value="<?php echo htmlspecialchars($categoria->getDescricao()); ?>">

                <label for="descricao" class="active">Descricao:</label>
            </div>

            <button class="btn waves-effect waves-light" type="submit">
                Salvar
                <i class="material-icons right">save</i>
            </button>

            <a class="btn grey" href="lstCategoria.php">
                Voltar
                <i class="material-icons right">arrow_back</i>
            </a>
        </form>
    </div>
</body>

</html>