<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/VIEW/menu.php";

$dalCliente = new \DAL\Cliente();
$lstCliente = $dalCliente->Select();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>Listar Clientes</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h1>Listar Clientes</h1>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'vinculo') { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Não é possível excluir este cliente pois existem vendas vinculadas a ele.
            </div>
        <?php } ?>

        <table class="striped responsive-table">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>CPF</th>
                <th>TELEFONE</th>
                <th>EMAIL</th>
                <th>ENDERECO</th>

                <th>
                    <a class="btn-floating btn-small green"
                        href="frminscliente.php">
                        <i class="material-icons">add</i>
                    </a>
                </th>
            </tr>

            <?php foreach ($lstCliente as $cliente) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente->getId()); ?></td>
                    <td><?php echo htmlspecialchars($cliente->getNome()); ?></td>
                    <td><?php echo htmlspecialchars($cliente->getCpf()); ?></td>
                    <td><?php echo htmlspecialchars($cliente->getTelefone()); ?></td>
                    <td><?php echo htmlspecialchars($cliente->getEmail()); ?></td>
                    <td><?php echo htmlspecialchars($cliente->getEndereco()); ?></td>

                    <td>
                        <a class="btn-floating btn-small orange"
                            href="frmedtcliente.php?id=<?php echo $cliente->getId(); ?>">
                            <i class="material-icons">edit</i>
                        </a>

                        <a class="btn-floating btn-small blue"
                            href="frmdetcliente.php?id=<?php echo $cliente->getId(); ?>">
                            <i class="material-icons">details</i>
                        </a>

                        <a class="btn-floating btn-small red"
                            onclick="remover(<?php echo $cliente->getId(); ?>)">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function remover(id) {
            if (confirm('Excluir Cliente ' + id + '?')) {
                location.href = 'opremcliente.php?id=' + id;
            }
        }
    </script>
</body>

</html>