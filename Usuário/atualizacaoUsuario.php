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

    $sql = "SELECT * FROM usuario WHERE id = $usuarioId";
    $resultado = $conexao->query($sql);
    $usuario = $resultado->fetch_assoc();

    if (isset($_POST['atualizar'])) {
        $nome = $_POST['tituloLivro'];
        $user = $_POST['usuario'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        
        $sql = $sql = "UPDATE usuario SET
                        nome = '$nome',
                        nomeDeUsuario = '$user',
                        email = '$email',
                        senha = '$senha',
                       WHERE id = $usuarioId";

        if ($conexao->query($sql)) {
            // 5. Volta para a biblioteca após salvar o livro
            header("Location: ../Usuario/dadosUsuario.php");
            exit;
        } else {
            echo "Erro de atualização: " . $conexao->error;
        }
    }
?>
