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

    <title>Detalhes da Categoria</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3>Detalhes da Categoria</h3>

        <table class="striped">
            <tr>
                <th>ID</th>

                <td>
                    <?php echo htmlspecialchars($categoria->getId()); ?>
                </td>
            </tr>

            <tr>
                <th>DESCRICAO</th>

                <td>
                    <?php echo htmlspecialchars($categoria->getDescricao()); ?>
                </td>
            </tr>
        </table>

        <br>

        <a class="btn orange"
            href="frmedtcategoria.php?id=<?php echo $categoria->getId(); ?>">

            Editar
            <i class="material-icons right">edit</i>
        </a>

        <a class="btn grey" href="lstCategoria.php">
            Voltar
            <i class="material-icons right">arrow_back</i>
        </a>
    </div>
</body>

</html>