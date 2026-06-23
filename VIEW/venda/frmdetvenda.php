<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/venda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/venda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/itemvenda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/itemvenda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/produto.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstVenda.php");
    exit;
}

$idVenda = (int) $_GET['id'];

$dalVenda = new \DAL\Venda();
$venda = $dalVenda->SelectById($idVenda);

if ($venda == null) {
    header("location:lstVenda.php");
    exit;
}

$dalCliente = new \DAL\Cliente();
$cliente = $dalCliente->SelectById($venda->getCliente());

$dalVendedor = new \DAL\Vendedor();
$vendedor = $dalVendedor->SelectById($venda->getVendedor());

$dalItemVenda = new \DAL\ItemVenda();
$lstItens = $dalItemVenda->SelectByVenda($idVenda);

$dalProduto = new \DAL\Produto();
$lstProduto = $dalProduto->Select();

$mapaProdutos = [];
foreach ($lstProduto as $produto) {
    $mapaProdutos[$produto->getId()] = $produto;
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
    <link rel="stylesheet" href="/gestaovenda/VIEW/css/style.css">

    <title>Detalhes da Venda</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3>Venda #<?php echo htmlspecialchars($venda->getId()); ?></h3>

        <table class="striped responsive-table">
            <tr>
                <th>Cliente</th>
                <td><?php echo $cliente != null ? htmlspecialchars($cliente->getNome()) : '(não encontrado)'; ?></td>
            </tr>
            <tr>
                <th>Vendedor</th>
                <td><?php echo $vendedor != null ? htmlspecialchars($vendedor->getNome()) : '(não encontrado)'; ?></td>
            </tr>
            <tr>
                <th>Data</th>
                <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($venda->getDataVenda()))); ?></td>
            </tr>
            <tr>
                <th>Valor Total</th>
                <td><strong>R$ <?php echo number_format($venda->getValorTotal(), 2, ',', '.'); ?></strong></td>
            </tr>
        </table>

        <br>

        <h5>Itens da Venda</h5>

        <?php if (isset($_GET['erro'])) { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                <?php echo htmlspecialchars($_GET['erro']); ?>
            </div>
        <?php } ?>

        <table class="striped responsive-table">
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Subtotal</th>
                <th></th>
            </tr>

            <?php if (empty($lstItens)) { ?>
                <tr>
                    <td colspan="5" class="center">Nenhum item adicionado ainda.</td>
                </tr>
            <?php } ?>

            <?php foreach ($lstItens as $item) { ?>
                <tr>
                    <td>
                        <?php
                        echo isset($mapaProdutos[$item->getProduto()])
                            ? htmlspecialchars($mapaProdutos[$item->getProduto()]->getDescricao())
                            : '(produto não encontrado)';
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($item->getQuantidade()); ?></td>
                    <td>R$ <?php echo number_format($item->getPrecoUnitario(), 2, ',', '.'); ?></td>
                    <td>R$ <?php echo number_format($item->getSubtotal(), 2, ',', '.'); ?></td>
                    <td>
                        <a class="btn-floating btn-small red"
                            onclick="removerItem(<?php echo $item->getId(); ?>)"
                            title="Remover item">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <br>

        <h5>Adicionar Item</h5>

        <?php if (empty($lstProduto)) { ?>
            <div class="card-panel orange lighten-4 center">
                Nenhum produto cadastrado. <a href="../produto/frminsproduto.php">Cadastre um produto</a> antes de adicionar itens.
            </div>
        <?php } else { ?>
            <form action="opinsitemvenda.php" method="post" class="row">
                <input type="hidden" name="venda" value="<?php echo $venda->getId(); ?>">

                <div class="input-field col s12 m6">
                    <select id="produto" name="produto" class="browser-default" required>
                        <option value="" disabled selected>Selecione um produto</option>
                        <?php foreach ($lstProduto as $produto) { ?>
                            <option value="<?php echo $produto->getId(); ?>">
                                <?php echo htmlspecialchars($produto->getDescricao()); ?>
                                (estoque: <?php echo htmlspecialchars($produto->getQuantidade()); ?>,
                                R$ <?php echo number_format($produto->getPreco(), 2, ',', '.'); ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="input-field col s12 m3">
                    <input id="quantidade" name="quantidade" type="number" min="1" required>
                    <label for="quantidade">Quantidade:</label>
                </div>

                <div class="input-field col s12 m3">
                    <button class="btn waves-effect waves-light" type="submit">
                        Adicionar
                        <i class="material-icons right">add_shopping_cart</i>
                    </button>
                </div>
            </form>
        <?php } ?>

        <a class="btn grey" href="lstVenda.php">
            Voltar
            <i class="material-icons right">arrow_back</i>
        </a>
    </div>

    <script>
        function removerItem(id) {
            if (confirm('Remover este item da venda? O produto voltará ao estoque.')) {
                location.href = 'opremitemvenda.php?id=' + id + '&venda=<?php echo $venda->getId(); ?>';
            }
        }
    </script>
</body>

</html>
