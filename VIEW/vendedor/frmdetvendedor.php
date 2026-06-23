<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/vendedor.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:lstVendedor.php");
    exit;
}

$dalVendedor = new \DAL\Vendedor();

$vendedor = $dalVendedor->SelectById(
    (int) $_GET['id']
);

if ($vendedor == null) {
    header("location:lstVendedor.php");
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

    <title>Detalhes do Vendedor</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3>Detalhes do Vendedor</h3>

        <table class="striped responsive-table">
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($vendedor->getId()); ?></td>
            </tr>

            <tr>
                <th>NOME</th>
                <td><?php echo htmlspecialchars($vendedor->getNome()); ?></td>
            </tr>

            <tr>
                <th>CPF</th>
                <td><?php echo htmlspecialchars($vendedor->getCpf()); ?></td>
            </tr>

            <tr>
                <th>TELEFONE</th>
                <td><?php echo htmlspecialchars($vendedor->getTelefone()); ?></td>
            </tr>

            <tr>
                <th>EMAIL</th>
                <td><?php echo htmlspecialchars($vendedor->getEmail()); ?></td>
            </tr>
        </table>

        <br>

        <a class="btn orange"
            href="frmedtvendedor.php?id=<?php echo $vendedor->getId(); ?>">

            Editar
            <i class="material-icons right">edit</i>
        </a>

        <a class="btn grey" href="lstVendedor.php">
            Voltar
            <i class="material-icons right">arrow_back</i>
        </a>
    </div>
</body>

</html>