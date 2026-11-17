<?php
    include 'conexao.php';

    $sql = "CREATE DATABASE EntrePaginas";

    if (mysqli_query($conexao, $sql)) {
    echo "Banco criado com sucesso!";
    } else {
    echo "Erro ao criar BD: " . mysqli_error($conexao);
    }

    mysqli_close($conexao);
?>
