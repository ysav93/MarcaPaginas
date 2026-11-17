<?php
    $servidor   = "localhost:3306";
    $usuario    = "root";
    $senha      = "root";
    $bd         = "EntrePaginas";

    $conexao = mysqli_connect($servidor, $usuario, $senha, $bd);

    if (!$conexao) {
        die("Conexão falhou: " . mysqli_connect_error());
    }
?>
