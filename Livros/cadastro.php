<?php
    session_start();
    include ('../BD/conexao.php');

    // Impede cadastrar livro se ninguém estiver logado
    if (!isset($_SESSION['idUsuario'])) {
        echo "<script>
                alert('Faça o login primeiro');
                window.location.href = '../Usuário/login.php';
              </script>";
        exit;
    }

    if (isset($_POST['cadastrar'])) {
        $usuarioId = (int) $_SESSION['idUsuario']; // 3. Pega o ID do usuário logado
        $nome = $_POST['tituloLivro'];
        $autor = $_POST['autor'];
        $editora = $_POST['editora'];
        $numeroPaginas = (int) $_POST['paginas'];
        $capa = $_POST['urlCapa'];
        $dataHora = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

        // 4. Insere na tabela 'livro' incluindo a chave estrangeira 'usuario_id'
        $sqlLivro = "INSERT INTO livro (nome, autor, editora, capa, numeroDePaginas, usuario_id) 
                VALUES ('$nome', '$autor', '$editora', '$capa', $numeroPaginas, $usuarioId)";

        if ($conexao->query($sqlLivro)) {
            // 2. Pega o ID do livro que acabou de ser cadastrado
            $livroId = $conexao->insert_id;

            // 3. Insere na tabela 'usuario_acompanha_livro' usando o $livroId
            $sqlAtualizacao = "INSERT INTO usuario_acompanha_livro (livro_id, usuario_id, numeroDePaginasConcluidas, statusLivro, dataHoraAtualizacao) 
                               VALUES ('$livroId', '$usuarioId', 0, 'Indefinido', '$dataHora')";

            if ($conexao->query($sqlAtualizacao)) {
                header("Location: ../Biblioteca/minhaBiblioteca.php");
                exit;
            }
        } else {
            echo "Erro de cadastro: " . $conexao->error;
        }

    }
?>