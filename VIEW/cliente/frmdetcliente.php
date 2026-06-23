<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/cliente.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstCliente.php");
    exit;
}

$dalCliente = new \DAL\Cliente();

$cliente = $dalCliente->SelectById(
    (int) $_GET['id']
);

if ($cliente == null) {
    header("location:lstCliente.php");
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

    <title>Detalhes do Cliente</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3>Detalhes do Cliente</h3>

        <table class="striped responsive-table">
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($cliente->getId()); ?></td>
            </tr>

            <tr>
                <th>NOME</th>
                <td><?php echo htmlspecialchars($cliente->getNome()); ?></td>
            </tr>

            <tr>
                <th>CPF</th>
                <td><?php echo htmlspecialchars($cliente->getCpf()); ?></td>
            </tr>

            <tr>
                <th>TELEFONE</th>
                <td><?php echo htmlspecialchars($cliente->getTelefone()); ?></td>
            </tr>

            <tr>
                <th>EMAIL</th>
                <td><?php echo htmlspecialchars($cliente->getEmail()); ?></td>
            </tr>

            <tr>
                <th>ENDERECO</th>
                <td><?php echo htmlspecialchars($cliente->getEndereco()); ?></td>
            </tr>
        </table>

        <br>

        <a class="btn orange"
            href="frmedtcliente.php?id=<?php echo $cliente->getId(); ?>">

            Editar
            <i class="material-icons right">edit</i>
        </a>

        <a class="btn grey" href="lstCliente.php">
            Voltar
            <i class="material-icons right">arrow_back</i>
        </a>
    </div>
</body>

</html>