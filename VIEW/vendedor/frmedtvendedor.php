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

    <title>Editar Vendedor</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3 class="center">Editar Vendedor</h3>

        <?php if (isset($_GET['erro'])) { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Preencha os dados corretamente.
            </div>
        <?php } ?>

        <form action="opedtvendedor.php" method="post">
            <input type="hidden" name="id"
                value="<?php echo $vendedor->getId(); ?>">

            <div class="input-field">
                <input id="nome" name="nome" type="text"
                    minlength="3" required
                    value="<?php echo htmlspecialchars($vendedor->getNome()); ?>">

                <label for="nome" class="active">Nome:</label>
            </div>

            <div class="input-field">
                <input id="cpf" name="cpf" type="text"
                    minlength="11" maxlength="11"
                    pattern="[0-9]{11}" required
                    value="<?php echo htmlspecialchars($vendedor->getCpf()); ?>">

                <label for="cpf" class="active">CPF, somente numeros:</label>
            </div>

            <div class="input-field">
                <input id="telefone" name="telefone" type="tel"
                    minlength="10" maxlength="15" required
                    value="<?php echo htmlspecialchars($vendedor->getTelefone()); ?>">

                <label for="telefone" class="active">Telefone:</label>
            </div>

            <div class="input-field">
                <input id="email" name="email" type="email" required
                    value="<?php echo htmlspecialchars($vendedor->getEmail()); ?>">

                <label for="email" class="active">E-mail:</label>
            </div>

            <button class="btn waves-effect waves-light" type="submit">
                Salvar
                <i class="material-icons right">save</i>
            </button>

            <a class="btn grey" href="lstVendedor.php">
                Voltar
                <i class="material-icons right">arrow_back</i>
            </a>
        </form>
    </div>
</body>

</html>