<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/VIEW/menu.php";

$dalProduto = new \DAL\Produto();
$lstProduto = $dalProduto->Select();

$dalCategoria = new \DAL\Categoria();
$lstCategoria = $dalCategoria->Select();

$mapaCategorias = [];
foreach ($lstCategoria as $categoria) {
    $mapaCategorias[$categoria->getId()] = $categoria->getDescricao();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>Listar Produtos</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h1>Listar Produtos</h1>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'vinculo') { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Não é possível excluir este produto pois existem vendas vinculadas a ele.
            </div>
        <?php } ?>

        <table class="striped responsive-table">
            <tr>
                <th>ID</th>
                <th>DESCRICAO</th>
                <th>CATEGORIA</th>
                <th>QUANTIDADE</th>
                <th>PRECO</th>
                <th>ESTOQUE MINIMO</th>

                <th>
                    <a class="btn-floating btn-small green"
                        href="frminsproduto.php">
                        <i class="material-icons">add</i>
                    </a>
                </th>
            </tr>

            <?php foreach ($lstProduto as $produto) {
                $estoqueBaixo = $produto->getQuantidade() < $produto->getEstoqueMinimo();
            ?>
                <tr class="<?php echo $estoqueBaixo ? 'red lighten-5' : ''; ?>">
                    <td><?php echo htmlspecialchars($produto->getId()); ?></td>

                    <td><?php echo htmlspecialchars($produto->getDescricao()); ?></td>

                    <td>
                        <?php
                        echo isset($mapaCategorias[$produto->getCategoria()])
                            ? htmlspecialchars($mapaCategorias[$produto->getCategoria()])
                            : '(categoria não encontrada)';
                        ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($produto->getQuantidade()); ?>
                        <?php if ($estoqueBaixo) { ?>
                            <i class="material-icons red-text" title="Estoque abaixo do mínimo">warning</i>
                        <?php } ?>
                    </td>

                    <td>
                        R$ <?php echo number_format(
                            $produto->getPreco(),
                            2,
                            ',',
                            '.'
                        ); ?>
                    </td>

                    <td><?php echo htmlspecialchars($produto->getEstoqueMinimo()); ?></td>

                    <td>
                        <a class="btn-floating btn-small orange"
                            href="frmedtproduto.php?id=<?php echo $produto->getId(); ?>">
                            <i class="material-icons">edit</i>
                        </a>

                        <a class="btn-floating btn-small blue"
                            href="frmdetproduto.php?id=<?php echo $produto->getId(); ?>">
                            <i class="material-icons">details</i>
                        </a>

                        <a class="btn-floating btn-small red"
                            onclick="remover(<?php echo $produto->getId(); ?>)">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function remover(id) {
            if (confirm('Excluir Produto ' + id + '?')) {
                location.href = 'opremproduto.php?id=' + id;
            }
        }
    </script>
</body>

</html>
