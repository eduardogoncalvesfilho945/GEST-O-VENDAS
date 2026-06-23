<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/VIEW/menu.php";

$dalVendedor = new \DAL\Vendedor();
$lstVendedor = $dalVendedor->Select();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>Listar Vendedores</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h1>Listar Vendedores</h1>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'vinculo') { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Não é possível excluir este vendedor pois existem vendas vinculadas a ele.
            </div>
        <?php } ?>

        <table class="striped responsive-table">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>CPF</th>
                <th>TELEFONE</th>
                <th>EMAIL</th>

                <th>
                    <a class="btn-floating btn-small green"
                        href="frminsvendedor.php">
                        <i class="material-icons">add</i>
                    </a>
                </th>
            </tr>

            <?php foreach ($lstVendedor as $vendedor) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($vendedor->getId()); ?></td>
                    <td><?php echo htmlspecialchars($vendedor->getNome()); ?></td>
                    <td><?php echo htmlspecialchars($vendedor->getCpf()); ?></td>
                    <td><?php echo htmlspecialchars($vendedor->getTelefone()); ?></td>
                    <td><?php echo htmlspecialchars($vendedor->getEmail()); ?></td>

                    <td>
                        <a class="btn-floating btn-small orange"
                            href="frmedtvendedor.php?id=<?php echo $vendedor->getId(); ?>">
                            <i class="material-icons">edit</i>
                        </a>

                        <a class="btn-floating btn-small blue"
                            href="frmdetvendedor.php?id=<?php echo $vendedor->getId(); ?>">
                            <i class="material-icons">details</i>
                        </a>

                        <a class="btn-floating btn-small red"
                            onclick="remover(<?php echo $vendedor->getId(); ?>)">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function remover(id) {
            if (confirm('Excluir Vendedor ' + id + '?')) {
                location.href = 'opremvendedor.php?id=' + id;
            }
        }
    </script>
</body>

</html>