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

    if (mysqli_num_rows($resultado) > 0) {
        $livro = mysqli_fetch_assoc($resultado);

        $titulo = htmlspecialchars($livro['nome']);
        $autor = htmlspecialchars($livro['autor']);
        $editora = htmlspecialchars($livro['editora']);
        $capa = htmlspecialchars($livro['capa']);
        $numeroPaginas = htmlspecialchars($livro['numeroDePaginas']);
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
    <link rel="stylesheet" href="../Biblioteca/styleDadosLivro.css">
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
                <a href="../inicio.php" class="botoes">Voltar ao inicio</a>
                <a href="../Livros/atualizar.php?id=<?php echo $id; ?>" class="botoes">Atualizar livro</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function queroLer() {
            window.location.href = "Status da Leitura/queroLer.php";
        }

        function lidos() {
            window.location.href = "Status da Leitura/lidos.php";
        }

        function lendo() {
            window.location.href = "Status da Leitura/lendo.php";
        }

        function cadastrar() {
            window.location.href = "Livros/telaCadastro.php";
        }

        function atualizar() {
            window.location.href = "Livros/atualizar.php";
        }
    </script>
</body>

</html>