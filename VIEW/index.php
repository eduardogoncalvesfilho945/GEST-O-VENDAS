<?php

session_start();

if (isset($_SESSION['login'])) {
    header("location: home.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Login - Gestão de Vendas</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet"
        href="/gestaovenda/VIEW/css/style.css">
</head>

<body>
    <div class="had-container">
        <div class="logueo">
            <div class="bg-card-user center">
                <i class="large material-icons">inventory_2</i>

                <h4>Controle de Acesso</h4>

                <h5>Sistema de Gestão de Estoque e Vendas</h5>

                <?php if (isset($_GET['erro'])) { ?>
                    <div class="card-panel red lighten-4 red-text text-darken-4 center">
                        Login ou senha inválidos.
                    </div>
                <?php } ?>

                <form action="login.php" method="POST">
                    <div class="input-field">
                        <i class="material-icons prefix">
                            account_box
                        </i>

                        <input
                            id="login"
                            name="login"
                            type="text"
                            required>

                        <label for="login">Login</label>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix">
                            enhanced_encryption
                        </i>

                        <input
                            id="password"
                            name="pwd"
                            type="password"
                            required>

                        <label for="password">Senha</label>
                    </div>

                    <button class="btn waves-effect waves-light"
                        type="submit">

                        Acessar

                        <i class="material-icons right">
                            login
                        </i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js">
    </script>

    <script src="/gestaovenda/VIEW/js/validacao.js"></script>
</body>

</html>