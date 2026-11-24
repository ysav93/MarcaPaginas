<?php
    session_start();
    include('../BD/conexao.php');

    if (!isset($_SESSION['idUsuario'])) {
        echo "<script>
                alert('Faça o login primeiro');
                window.location.href = '../Usuário/login.php';
              </script>";
        exit;
    } else {
        $usuarioId = $_SESSION['idUsuario'];
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM livro WHERE id = $id";
    $resultado = mysqli_query($conexao, $sql);

    $sqlMeusDados = "SELECT numeroDePaginasConcluidas, statusLivro FROM usuario_acompanha_livro WHERE livro_id = $id";
    $resultadoAcompanhamento = mysqli_query($conexao, $sqlMeusDados);

    if (mysqli_num_rows($resultado) > 0) {
        $livro = mysqli_fetch_assoc($resultado);
        $acompanhamento = mysqli_fetch_assoc($resultadoAcompanhamento);

        $titulo = htmlspecialchars($livro['nome']);
        $autor = htmlspecialchars($livro['autor']);
        $editora = htmlspecialchars($livro['editora']);
        $capa = htmlspecialchars($livro['capa']);
        $numeroPaginas = htmlspecialchars($livro['numeroDePaginas']);
        $paginasLidas = htmlspecialchars($acompanhamento['numeroDePaginasConcluidas']);
        $statusLivro = htmlspecialchars($acompanhamento['statusLivro']);
        $estrelas = (int) $livro['avaliacaoEstrelas'];
        $id = $livro['id'];

    } else {
        echo "Livro não encontrado.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="styleDadosLivro.css">
</head>
<body>

    <div id="dados">
        <div id="capaLivro">
            <img src="<?php echo $capa; ?>" alt="Capa de <?php echo $titulo; ?>">
        </div>

        <div id="informacoes">
            <h2><?php echo $titulo; ?></h2>
            <p><strong>Autor: </strong> <?php echo $autor; ?></p>
            <p><strong>Editora: </strong> <?php echo $editora; ?></p>
            <p><strong>Número de páginas: </strong> <?php echo $numeroPaginas; ?></p>
            <p><strong>Número de páginas concluídas: </strong> <?php echo $paginasLidas; ?></p>
            <p><strong>Status: </strong> <?php echo $statusLivro; ?></p>
            <div id="avaliacao">
                <p><strong>Avaliação:</strong></p>
                <div class="estrelas">
                    <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $estrelas) {
                                echo '<span class="estrela selecionada">&#9733;</span>';
                            } else {
                                echo '<span class="estrela">&#9733;</span>';
                            }
                        }
                    ?>
                </div>
            </div>

            <div id="acoes">
                <a href="minhaBiblioteca.php" class="botoes">Voltar</a>
                <a href="../Livros/atualizar.php?id=<?php echo $id; ?>" class="botoes">Atualizar livro</a>
            </div>
        </div>
    </div>

</body>

</html>
