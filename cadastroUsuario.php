<?php
include("conexao.php");

if(isset($_POST['cadastrar'])){
    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'],PASSWORD_DEFAULT);

    $sql="INSERT INTO Usuario(nome, nomeDeUsuario,email, senha) 
    VALUES ('$nome', '$usuario', '$email', '$senha')";

    if($conexao->query($sql)){
        header("Location:login.php");
        exit;
    }
    else{
        echo"erro de cadastro";
    }

}
 ?>
