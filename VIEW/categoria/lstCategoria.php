<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/DAL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/MODEL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/gestaovenda/VIEW/menu.php";

$dalCategoria = new \DAL\Categoria();
$lstCategoria = $dalCategoria->Select();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>Listar Categorias</title>
</head>

<body class="teal lighten-4">
    <div class="container">
        <h1>Listar Categorias</h1>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'vinculo') { ?>
            <div class="card-panel red lighten-4 red-text text-darken-4 center">
                Não é possível excluir esta categoria pois existem produtos vinculados a ela.
            </div>
        <?php } ?>

        <table class="striped responsive-table">
            <tr>
                <th>ID</th>
                <th>DESCRICAO</th>
                <th>
                    <a class="btn-floating btn-small waves-effect waves-light green"
                        href="frminscategoria.php">
                        <i class="material-icons">add</i>
                    </a>
                </th>
            </tr>

            <?php foreach ($lstCategoria as $categoria) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($categoria->getId()); ?></td>

                    <td><?php echo htmlspecialchars($categoria->getDescricao()); ?></td>

                    <td>
                        <a class="btn-floating btn-small waves-effect orange"
                            href="frmedtcategoria.php?id=<?php echo $categoria->getId(); ?>">
                            <i class="material-icons">edit</i>
                        </a>

                        <a class="btn-floating btn-small waves-effect blue"
                            href="frmdetcategoria.php?id=<?php echo $categoria->getId(); ?>">
                            <i class="material-icons">details</i>
                        </a>

                        <a class="btn-floating btn-small waves-effect red"
                            onclick="remover(<?php echo $categoria->getId(); ?>)">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function remover(id) {
            if (confirm('Excluir Categoria ' + id + '?')) {
                location.href = 'opremcategoria.php?id=' + id;
            }
        }
    </script>
</body>

</html>