<?php
    session_start();
    include ('../BD/conexao.php');

    // Impede cadastrar livro se ninguém estiver logado
    if (!isset($_SESSION['idUsuario'])) {
        echo '<script>alert(Faça o login primeiro)</script>';
        header("Location: ../Usuário/login.php");
        exit;
    }

    if (isset($_POST['cadastrar'])) {
        $usuarioId = (int) $_SESSION['idUsuario']; // 3. Pega o ID do usuário logado
        $nome = $_POST['tituloLivro'];
        $autor = $_POST['autor'];
        $editora = $_POST['editora'];
        $numeroPaginas = (int) $_POST['paginas'];
        $capa = $_POST['urlCapa'];

        // 4. Insere na tabela 'livro' incluindo a chave estrangeira 'usuario_id'
        $sql = "INSERT INTO livro (nome, autor, editora, capa, numeroDePaginas, paginasLidas, statusLivro, usuario_id) 
                VALUES ('$nome', '$autor', '$editora', '$capa', $numeroPaginas, 0, 'quero ler', $usuarioId)";

        if ($conexao->query($sql)) {
            // 5. Volta para a biblioteca após salvar o livro
            header("Location: ../Biblioteca/minhaBiblioteca.php");
            exit;
        } else {
            echo "Erro de cadastro: " . $conexao->error;
        }
    }
?>