<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/venda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/venda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/VIEW/menu.php";

$dalVenda = new \DAL\Venda();
$lstVenda = $dalVenda->Select();

$dalCliente = new \DAL\Cliente();
$mapaClientes = [];
foreach ($dalCliente->Select() as $cliente) {
    $mapaClientes[$cliente->getId()] = $cliente->getNome();
}

$dalVendedor = new \DAL\Vendedor();
$mapaVendedores = [];
foreach ($dalVendedor->Select() as $vendedor) {
    $mapaVendedores[$vendedor->getId()] = $vendedor->getNome();
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
    <link rel="stylesheet" href="/gestaovenda/VIEW/css/style.css">

    <title>Listar Vendas</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h1>Listar Vendas</h1>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'vinculo') { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Não foi possível excluir esta venda.
            </div>
        <?php } ?>

        <table class="striped responsive-table">
            <tr>
                <th>ID</th>
                <th>CLIENTE</th>
                <th>VENDEDOR</th>
                <th>DATA</th>
                <th>VALOR TOTAL</th>

                <th>
                    <a class="btn-floating btn-small green"
                        href="frminsvenda.php">
                        <i class="material-icons">add</i>
                    </a>
                </th>
            </tr>

            <?php foreach ($lstVenda as $venda) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($venda->getId()); ?></td>

                    <td>
                        <?php
                        echo isset($mapaClientes[$venda->getCliente()])
                            ? htmlspecialchars($mapaClientes[$venda->getCliente()])
                            : '(cliente não encontrado)';
                        ?>
                    </td>

                    <td>
                        <?php
                        echo isset($mapaVendedores[$venda->getVendedor()])
                            ? htmlspecialchars($mapaVendedores[$venda->getVendedor()])
                            : '(vendedor não encontrado)';
                        ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($venda->getDataVenda()))); ?>
                    </td>

                    <td>
                        R$ <?php echo number_format($venda->getValorTotal(), 2, ',', '.'); ?>
                    </td>

                    <td>
                        <a class="btn-floating btn-small blue"
                            href="frmdetvenda.php?id=<?php echo $venda->getId(); ?>"
                            title="Ver itens / detalhes">
                            <i class="material-icons">details</i>
                        </a>

                        <a class="btn-floating btn-small red"
                            onclick="remover(<?php echo $venda->getId(); ?>)">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function remover(id) {
            if (confirm('Excluir Venda ' + id + '? Os produtos vendidos voltarão ao estoque.')) {
                location.href = 'opremvenda.php?id=' + id;
            }
        }
    </script>
</body>

</html>
