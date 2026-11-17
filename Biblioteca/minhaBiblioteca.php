<?php
    session_start();
    include('../BD/conexao.php');

    $usuarioId = (int) $_SESSION['usuario_id'];
    $sql = "SELECT * FROM livro WHERE usuario_id = $usuarioId";
    $resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha biblioteca</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Isometra&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Isometra&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleMinhaBiblioteca.css">
    
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top" id="contorno">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" id="nome">MarcaPaginas</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="../inicio.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Comunidades/comunidades.html">Comunidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Grupos/grupos.html">Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="minhaBiblioteca.php">Minha biblioteca</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <nav id="barraPesquisa">
        <div class="container-fluid">
            <form class="d-flex" role="search">
                <input class="form-control" type="search" placeholder="Pesquisar livros..." aria-label="Pesquisar livros">

                <button class="botaoPesquisa" type="submit">
                Pesquisar
            </button>
            </form>
        </div>
    </nav>

    <div id="cabecalhoLendo">
        <h3 id="titulo">Meus livros</h3>

        <div class="grupoBotoes">
            <button type="button" class="botoes" onclick="queroLer()">Quero ler</button>
            <button type="button" class="botoes" onclick="lidos()">Lido</button>
            <button type="button" class="botoes" onclick="lendo()">Lendo</button>
            <button type="button" class="botoes" onclick="cadastrar()">Cadastrar Livro</button>
                <button type="button" class="botoes" onclick="atualizar()">Atualizar</button>
        </div>
    </div>

    <div id="livros" class="d-flex flex-wrap gap-4">
        <?php
            if (mysqli_num_rows($resultado) > 0) {
                while ($livro = mysqli_fetch_assoc($resultado)) {
                    $capa = htmlspecialchars($livro['capa']);
                    $titulo = htmlspecialchars($livro['nome']);
                    $id = $livro['id'];

                    echo '
                    <div class="card-livro text-center">
                        <img src="' . $capa . '" class="imagemLivro" alt="Capa de ' . $titulo . '">
                        <h5 class="mt-2">' . $titulo . '</h5>
                        <div class="acoes">
                            <a href="editar.php?id=' . $id . '" class="btn btn-secondary btn-sm">Editar</a>
                            <a href="excluir.php?id=' . $id . '" class="btn btn-danger btn-sm">Excluir</a>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>Nenhum livro encontrado.</p>';
            }

            mysqli_close($conexao);
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function queroLer() {
            window.location.href = "../Status da Leitura/queroLer.php";
        }

        function lidos() {
            window.location.href = "../Status da Leitura/lidos.php";
        }

        function lendo() {
            window.location.href = "../Status da Leitura/lendo.php";
        }

        function cadastrar() {
            window.location.href = "../Livros/telaCadastro.php";
        }

        function atualizar() {
            window.location.href = "../Livros/atualizar.php";
        }
    </script>

</body>

</html>