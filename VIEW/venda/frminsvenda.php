<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/vendedor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/vendedor.php";

$dalCliente = new \DAL\Cliente();
$lstCliente = $dalCliente->Select();

$dalVendedor = new \DAL\Vendedor();
$lstVendedor = $dalVendedor->Select();

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

    <title>Nova Venda</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h3 class="center">Nova Venda</h3>

        <?php if (isset($_GET['erro'])) { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Selecione um cliente e um vendedor válidos.
            </div>
        <?php } ?>

        <?php if (empty($lstCliente)) { ?>
            <div class="card-panel orange lighten-4 center">
                Nenhum cliente cadastrado. <a href="../cliente/frminscliente.php">Cadastre um cliente</a> antes de iniciar uma venda.
            </div>
        <?php } elseif (empty($lstVendedor)) { ?>
            <div class="card-panel orange lighten-4 center">
                Nenhum vendedor cadastrado. <a href="../vendedor/frminsvendedor.php">Cadastre um vendedor</a> antes de iniciar uma venda.
            </div>
        <?php } else { ?>
            <form action="opinsvenda.php" method="post">
                <div class="input-field">
                    <select id="cliente" name="cliente" class="browser-default" required>
                        <option value="" disabled selected>Selecione um cliente</option>
                        <?php foreach ($lstCliente as $cliente) { ?>
                            <option value="<?php echo $cliente->getId(); ?>">
                                <?php echo htmlspecialchars($cliente->getNome()); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="input-field">
                    <select id="vendedor" name="vendedor" class="browser-default" required>
                        <option value="" disabled selected>Selecione um vendedor</option>
                        <?php foreach ($lstVendedor as $vendedor) { ?>
                            <option value="<?php echo $vendedor->getId(); ?>">
                                <?php echo htmlspecialchars($vendedor->getNome()); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button class="btn waves-effect waves-light" type="submit">
                    Iniciar venda
                    <i class="material-icons right">point_of_sale</i>
                </button>

                <a class="btn grey" href="lstVenda.php">
                    Voltar
                    <i class="material-icons right">arrow_back</i>
                </a>
            </form>
        <?php } ?>
    </div>
</body>

</html>
