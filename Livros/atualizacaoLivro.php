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

    $usuarioId = (int) $_SESSION['idUsuario'];

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $sql = "SELECT * FROM livro WHERE id = $id AND usuario_id = $usuarioId";
        $resultado = $conexao->query($sql);
        $livro = $resultado->fetch_assoc();
    }

    if (isset($_POST['atualizar'])) {
        $usuarioId = (int) $_SESSION['idUsuario'];
        $nome = $_POST['tituloLivro'];
        $autor = $_POST['autor'];
        $editora = $_POST['editora'];
        $numeroPaginas = (int) $_POST['paginas'];
        $paginasLidas = (int) $_POST['paginasLidas'];
        $statusLivro = $_POST['estadoLivro'];
        $estrelas = isset($_POST['avaliacao']) ? (int) $_POST['avaliacao'] : 0;
        $capa = $_POST['urlCapa'];
        $dataHora = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

        $sqlLivro = "UPDATE livro SET
                         nome = '$nome',
                         autor = '$autor',
                         editora = '$editora',
                         capa = '$capa',
                         numeroDePaginas = '$numeroPaginas'
                     WHERE 
                         id = $id AND usuario_id = $usuarioId";

        $sqlAcompanhamento = "UPDATE usuario_acompanha_livro SET
                                  statusLivro = '$statusLivro',
                                  numeroDePaginasConcluidas = '$paginasLidas',
                                  dataHoraAtualizacao = '$dataHora',
                                  avaliacaoEstrelas = '$estrelas'
                              WHERE 
                                  livro_id = $id AND usuario_id = $usuarioId";

        if ($conexao->query($sqlLivro) && $conexao->query($sqlAcompanhamento)) {
            // 5. Volta para a biblioteca após salvar o livro
            header("Location: ../Biblioteca/minhaBiblioteca.php");
            exit;
        } else {
            echo "Erro de atualização: " . $conexao->error;
        }
    }
?>
