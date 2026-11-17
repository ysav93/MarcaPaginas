<?php
    session_start();
    include('../BD/conexao.php');

    if (!isset($_SESSION['idUsuario'])) {
        echo '<script>alert(Faça o login primeiro)</script>';
        header("Location: ../Usuário/login.php");
        exit;
    }

    // Busca apenas os livros marcados como 'lendo'
    $sql = "SELECT * FROM livro WHERE statusLivro = 'lendo'";
    $resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Em andamento</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Isometra&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Isometra&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleLendo.css">
    
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
                        <a class="nav-link active" href="../inicio.html">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Comunidades/comunidades.html">Comunidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Grupos/grupos.html">Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Biblioteca/minhaBiblioteca.html">Minha biblioteca</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <nav id="barraPesquisa">
        <div class="container-fluid">
            <form class="d-flex" role="search">
                <input class="form-control" type="search" placeholder="Pesquisar livros..." aria-label="Pesquisar livros">
                <button class="botaoPesquisa" type="submit">Pesquisar</button>
            </form>
        </div>
    </nav>

    <!-- Título e botões -->
    <div id="cabecalhoLidos">
        <h3 id="titulo">Em andamento</h3>

        <div class="grupoBotoes">
            <button type="button" class="botoes" onclick="queroLer()">Quero ler</button>
            <button type="button" class="botoes" onclick="lidos()">Lidos</button>
            <button type="button" class="botoes" onclick="cadastrar()">Cadastrar Livro</button>
            <button type="button" class="botoes" onclick="atualizar()">Atualizar</button>
        </div>
    </div>

    <!-- Lista de livros incompletos -->
    <div id="lendo" class="d-flex flex-wrap gap-4">
        <?php 
            if (mysqli_num_rows($resultado) > 0) {
                while ($livro = mysqli_fetch_assoc($resultado)) {
                    $capa = htmlspecialchars($livro['capa']);
                    $titulo = htmlspecialchars($livro['nome']);
                    $id = $livro['id'];
                    $pageTotal = (int) $livro['numeroDePaginas'];
                    $pageConcluidas = (int) $livro['paginasLidas'];
                
                    if ($pageTotal > 0) {
                        $porcentagemConcluida = round(($pageConcluidas / $pageTotal) * 100);
                    } else {
                        $porcentagemConcluida = 0;
                    }

                    echo "
                        <div class='card-livro text-center'>
                            <img src='$capa' class='imagemLivro' alt='Capa de $titulo'>
                            <p class='mt-2 mb-1'><strong>Título: $titulo</strong></p>
                            <div class='acoes mb-2'>
                                <a href='../Livros/atualizar.php?id=$id' class='btn btn-secondary btn-sm'>Editar</a>
                                <a href='../Livros/excluir.php?id=$id' class='btn btn-danger btn-sm' 
                                    onclick='return confirm('Tem certeza que deseja excluir este livro?');'>Excluir</a>
                            </div>
                            <div class='progress progressoLivro' role='progressbar' aria-label='Progresso de leitura' aria-valuenow='$porcentagemConcluida' aria-valuemin='0' aria-valuemax='100'>
                                <div class='progress-bar' style='width: $porcentagemConcluida%'>$porcentagemConcluida%</div>
                            </div>
                        </div>";
                }
            } else {
                echo '<p>Nenhum livro marcado como lendo foi encontrado.</p>';
            }

            mysqli_close($conexao);
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script>
        function queroLer() {
            window.location.href = "queroLer.php";
        }

        function lidos() {
            window.location.href = "lidos.php";
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
