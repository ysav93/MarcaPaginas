<?php
    session_start();
    include('../BD/conexao.php');

    // 1. Verifica se o usuário está logado
    if (!isset($_SESSION['idUsuario'])) {
        echo '<script>alert(Faça o login primeiro)</script>';
        header("Location: ../Usuário/login.php");
        exit;
    }

    if (isset($_GET['id'])) {
        $livroId = (int) $_GET['id'];
        $usuarioId = (int) $_SESSION['idUsuario'];

        // 3. Deleta o livro apenas se ele pertencer ao usuário logado
        $sql = "DELETE FROM livro WHERE id = $livroId";
    
        if (mysqli_query($conexao, $sql)) {
            // Redireciona de volta para a biblioteca após excluir
            header("Location: ../Biblioteca/minhaBiblioteca.php");
            exit;
        } else {
            echo "Erro ao excluir o livro: " . mysqli_error($conexao);
        }
    } else {
        // Se alguém acessar excluir.php sem passar um ID, volta para a biblioteca
        header("Location: ../Biblioteca/minhaBiblioteca.php");
        exit;
    }

    mysqli_close($conexao);
?>