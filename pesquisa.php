<?php
    session_start();
    include('BD/conexao.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Isometra&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Isometra&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff8e7;
            margin: 0;
            padding: 0;
        }

        #titulo {
            font-family: "Isometra", serif;
            color: #751020;
            margin: 0;
        }

        /* Botões */

        .botoes {
            width: 105px;
            height: 50px;
            border: 2px solid #751020;
            border-radius: 30px;
            background-color: #f8ccd7;
            color: #751020;
            font-family: "Isometra", serif;
            cursor: pointer;
            text-decoration: none;
        }

        .botoes:hover {
            background-color: #751020;
            color: white;
        }

        .acoes {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .acoes .botoes {
            width: 65px;
            height: 30px;
            font-size: 11px;
            text-align: center;
            border-radius: 20px;
            padding: 0;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Livro */

        .imagemLivro {
            width: 130px;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }

        @media (max-width: 500px) {
            .botoes {
                width: auto;
                padding: 5px 10px;
                font-size: 12px;
            }

            .imagemLivro {
                width: 100px;
                height: 150px;
            }
        }
    </style>
</head>
<body>

     <div class="container mt-5">
        <a href="inicio.php" class="botoes">Voltar ao início</a>
        <h3 class="mt-3 mb-4">Resultados da Pesquisa</h3>

        <div id="lendo" class="d-flex flex-wrap gap-4">
            <?php
                if (isset($_POST['pesquisar'])) {
                    $usuarioId = (int) $_SESSION['idUsuario'];
                    $nomeDigitado = $_POST['nomeLivro'];

                    $sql = "SELECT nome, capa, id FROM livro WHERE nome LIKE '%$nomeDigitado%'";
                    $resultado = mysqli_query($conexao, $sql);

                    if (mysqli_num_rows($resultado) > 0) {
                        while ($livro = mysqli_fetch_assoc($resultado)) {
                            $capa = $livro['capa'];
                            $titulo = $livro['nome'];
                            $id = $livro['id'];

                            echo "
                                <div class='card-livro text-center'>
                                    <a href='Livros/dadosLivrosGerais.php?id=$id'>
                                        <img src='$capa' class='imagemLivro' alt='Capa de $titulo'>
                                    </a>
                                    <p class='mt-2 mb-1'><strong>$titulo</strong></p>
                                    <div class='acoes mb-2'>
                                        <a href='Livros/atualizar.php?id=$id' class='botoes'>Editar</a>
                                        <a href='Livros/excluir.php?id=$id' class='botoes'
                                            onclick=\"return confirm('Tem certeza que deseja excluir este livro?');\">
                                            Excluir
                                        </a>
                                    </div>
                                </div>";
                        }
                    } else {
                        echo '<p>Nenhum livro encontrado.</p>';
                    }
                }
            ?>
        </div>
    </div>
    
</body>
</html>
