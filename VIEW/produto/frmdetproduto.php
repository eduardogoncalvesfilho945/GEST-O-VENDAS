<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/categoria.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstProduto.php");
    exit;
}

$dalProduto = new \DAL\Produto();
$produto = $dalProduto->SelectById((int) $_GET['id']);

if ($produto == null) {
    header("location:lstProduto.php");
    exit;
}

$dalCategoria = new \DAL\Categoria();

$categoria = $dalCategoria->SelectById(
    $produto->getCategoria()
);

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

    <title>Detalhes do Produto</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3>Detalhes do Produto</h3>

        <table class="striped responsive-table">
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($produto->getId()); ?></td>
            </tr>

            <tr>
                <th>DESCRICAO</th>
                <td><?php echo htmlspecialchars($produto->getDescricao()); ?></td>
            </tr>

            <tr>
                <th>CATEGORIA</th>

                <td>
                    <?php
                    echo $categoria != null
                        ? htmlspecialchars($categoria->getDescricao())
                        : htmlspecialchars($produto->getCategoria());
                    ?>
                </td>
            </tr>

            <tr>
                <th>QUANTIDADE</th>
                <td><?php echo htmlspecialchars($produto->getQuantidade()); ?></td>
            </tr>

            <tr>
                <th>PRECO</th>

                <td>
                    R$ <?php echo number_format(
                        $produto->getPreco(),
                        2,
                        ',',
                        '.'
                    ); ?>
                </td>
            </tr>

            <tr>
                <th>ESTOQUE MINIMO</th>
                <td><?php echo htmlspecialchars($produto->getEstoqueMinimo()); ?></td>
            </tr>
        </table>

        <br>

        <a class="btn orange"
            href="frmedtproduto.php?id=<?php echo $produto->getId(); ?>">

            Editar
            <i class="material-icons right">edit</i>
        </a>

        <a class="btn grey" href="lstProduto.php">
            Voltar
            <i class="material-icons right">arrow_back</i>
        </a>
    </div>
</body>

</html>