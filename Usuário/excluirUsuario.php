<?php
    session_start();
    include('../BD/conexao.php');

    // 1. Verifica se o usuário está logado
    if (!isset($_SESSION['idUsuario'])) {
        echo "<script>
                alert('Faça o login primeiro');
                window.location.href = '../Usuário/login.php';
              </script>";
        exit;
    }

    $usuarioId = (int) $_SESSION['idUsuario'];

    $sql = "DELETE FROM usuario WHERE id = $usuarioId";
    
    if (mysqli_query($conexao, $sql)) {
        header("Location: ../index.php");
        exit;
    } else {
        echo "Erro ao excluir a conta: " . mysqli_error($conexao);
    }
    
    mysqli_close($conexao);
?>
