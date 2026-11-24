<?php
    session_start();
    include ('../BD/conexao.php');

    if (isset($_POST['cadastrar'])) {
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nome, nomeDeUsuario, email, senha) 
                VALUES ('$nome', '$usuario', '$email', '$senha')";

        if ($conexao->query($sql)) {
            $_SESSION['idUsuario'] = $conexao->insert_id;
            $_SESSION['nomeUsuario'] = $nome;

            header("Location: ../inicio.php"); 
            exit;
        } else {
            echo "Erro de cadastro: " . $conexao->error;
        }
    }
?>