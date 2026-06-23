<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /gestaovenda/VIEW/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="/gestaovenda/VIEW/css/style.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="/gestaovenda/VIEW/js/init.js"></script>
    <script src="/gestaovenda/VIEW/js/validacao.js"></script>

    <title>Menu do Sistema de Gestao de Estoque e Vendas</title>
</head>

<body>
    <a href="#" data-target="slide-out" class="sidenav-trigger">
        <i class="material-icons">menu</i>
    </a>

    <nav>
        <div class="nav-wrapper teal darken-2">
            <a href="/gestaovenda/VIEW/home.php" class="brand-logo right">
                <i class="material-icons">inventory_2</i>
            </a>

            <ul class="left hide-on-med-and-down">
                <li><a href="/gestaovenda/VIEW/home.php">HOME</a></li>
                <li><a href="/gestaovenda/VIEW/categoria/lstCategoria.php">CATEGORIAS</a></li>
                <li><a href="/gestaovenda/VIEW/cliente/lstCliente.php">CLIENTES</a></li>
                <li><a href="/gestaovenda/VIEW/vendedor/lstVendedor.php">VENDEDORES</a></li>
                <li><a href="/gestaovenda/VIEW/produto/lstProduto.php">PRODUTOS</a></li>
                <li><a href="/gestaovenda/VIEW/venda/lstVenda.php">VENDAS</a></li>
                <li><a href="/gestaovenda/VIEW/logout.php">SAIR</a></li>
                <li>
                    <span>
                        Usuario: <?php echo htmlspecialchars($_SESSION['login']); ?>
                    </span>
                </li>
            </ul>

            <ul id="slide-out" class="sidenav teal darken-3">
                <li>
                    <div class="user-view teal darken-2">
                        <i class="material-icons medium white-text">account_circle</i>
                        <span class="white-text name">
                            <?php echo htmlspecialchars($_SESSION['login']); ?>
                        </span>
                    </div>
                </li>

                <li><a href="/gestaovenda/VIEW/home.php" class="white-text">Home</a></li>
                <li><a href="/gestaovenda/VIEW/categoria/lstCategoria.php"
                        class="white-text">Categorias</a></li>
                <li><a href="/gestaovenda/VIEW/cliente/lstCliente.php"
                        class="white-text">Clientes</a></li>
                <li><a href="/gestaovenda/VIEW/vendedor/lstVendedor.php"
                        class="white-text">Vendedores</a></li>
                <li><a href="/gestaovenda/VIEW/produto/lstProduto.php"
                        class="white-text">Produtos</a></li>
                <li><a href="/gestaovenda/VIEW/venda/lstVenda.php"
                        class="white-text">Vendas</a></li>
                <li><a href="/gestaovenda/VIEW/logout.php" class="white-text">Sair</a></li>
            </ul>
        </div>
    </nav>
</body>

</html>
