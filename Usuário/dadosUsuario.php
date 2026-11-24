<?php
    session_start();
    include('../BD/conexao.php');

    if (!isset($_SESSION['idUsuario'])) {
        echo '<script>alert(Faça o login primeiro)</script>';
        header("Location: ../Usuário/login.php");
        exit;
    } else {
        $usuarioId = $_SESSION['idUsuario'];
    }


    $sql = "SELECT * FROM usuario WHERE id = $usuarioId";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        $nome = htmlspecialchars($usuario['nome']);
        $nomeUsuario = htmlspecialchars($usuario['nomeDeUsuario']);
        $email = htmlspecialchars($usuario['email']);

        // Livros lidos
        $sql = "SELECT COUNT(*) AS total FROM usuario_acompanha_livro WHERE usuario_id = $usuarioId AND statusLivro = 'lido'";
        $resultado = mysqli_query($conexao, $sql);
        $quantidade = mysqli_fetch_assoc($resultado);
        $lidos = $quantidade['total'];

        // Livros que está lendo
        $sql = "SELECT COUNT(*) AS total FROM usuario_acompanha_livro WHERE usuario_id = $usuarioId AND statusLivro = 'lendo'";
        $resultado = mysqli_query($conexao, $sql);
        $quantidade = mysqli_fetch_assoc($resultado);
        $lendo = $quantidade['total'];

        // Livros que quer ler
        $sql = "SELECT COUNT(*) AS total FROM usuario_acompanha_livro WHERE usuario_id = $usuarioId AND statusLivro = 'queroLer'";
        $resultado = mysqli_query($conexao, $sql);
        $quantidade = mysqli_fetch_assoc($resultado);
        $queroLer = $quantidade['total'];

        $total = $queroLer + $lendo + $lidos;
    } else {
        echo "Usuário não encontrado.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha área</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Isometra&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Isometra&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleDadosUsuario.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top" id="contorno">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" id="nome">MarcaPaginas</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../inicio.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Comunidades/comunidades.html">Comunidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Grupos/grupos.html">Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Biblioteca/minhaBiblioteca.php">Minha biblioteca</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="dadosUsuario.php">Meu perfil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="dados">
        <div id="informacoes">
            <h2><?php echo $nomeUsuario; ?></h2>
            <p><strong>Nome: </strong> <?php echo $nome; ?></p>
            <p><strong>E-mail: </strong> <?php echo $email; ?></p>
            <p><strong>Número de livros lidos: </strong> <?php echo $lidos; ?></p>
            <p><strong>Quantidade de livros em espera: </strong> <?php echo $queroLer; ?></p>
            <p><strong>Livros que estou lendo: </strong> <?php echo $lendo; ?></p>
            <p><strong>Todos os meus livros: </strong> <?php echo $total; ?></p>
            
        </div>
        <div id="acoes">
                <a href="minhaBiblioteca.php" class="botoes" 
                    onclick="return confirm('Tem certeza que deseja excluir esta conta?');">
                    Apagar conta
                </a>
                <a href="atualizar.php?id=<?php echo $usuarioId; ?>" class="botoes">Atualizar perfil</a>
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