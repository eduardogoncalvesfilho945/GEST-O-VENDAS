<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/VIEW/menu.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/produto.php";

$dalProduto = new \DAL\Produto();
$lstProdutoEstoqueBaixo = $dalProduto->SelectAbaixoEstoqueMinimo();

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

    <link rel="stylesheet" href="/gestaovenda/VIEW/css/style.css">

    <title>Pagina HOME</title>
</head>

<body class="teal darken-2 white-text">
    <div class="teal darken-2 white-text center">
        <br>

        <h1>Sistema de Gestao de Estoque e Vendas</h1>

        <br>

        <div>
            <i class="material-icons large">inventory_2</i>
        </div>

        <h5>Controle de produtos, categorias, clientes e vendedores</h5>

        <br>
        <br>
    </div>

    <?php if (!empty($lstProdutoEstoqueBaixo)) { ?>
        <div class="container">
            <div class="card-panel orange lighten-4 black-text">
                <h6><i class="material-icons left">warning</i>Produtos com estoque abaixo do mínimo</h6>

                <ul class="collection">
                    <?php foreach ($lstProdutoEstoqueBaixo as $produto) { ?>
                        <li class="collection-item">
                            <?php echo htmlspecialchars($produto->getDescricao()); ?>
                            — estoque atual: <?php echo htmlspecialchars($produto->getQuantidade()); ?>
                            (mínimo: <?php echo htmlspecialchars($produto->getEstoqueMinimo()); ?>)
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>
</body>

</html>