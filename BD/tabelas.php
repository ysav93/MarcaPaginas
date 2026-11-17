<?php

    include 'conexao.php';

    $sqlUsuario = 'CREATE TABLE IF NOT EXISTS EntrePaginas.usuario (
                    id INT NOT NULL AUTO_INCREMENT,
                    nome VARCHAR(100) NOT NULL,
                    nomeDeUsuario VARCHAR(30) NOT NULL,
                    senha TEXT NOT NULL,
                    email TEXT NOT NULL,
                    PRIMARY KEY (id))
                    ENGINE = InnoDB';
    
    $sqlLivro = 'CREATE TABLE IF NOT EXISTS EntrePaginas.livro (
                 id INT NOT NULL AUTO_INCREMENT,
                 nome TEXT NOT NULL,
                 autor TEXT NOT NULL,
                 editora VARCHAR(100) NOT NULL,
                 capa TEXT NOT NULL,
                 numeroDePaginas INT NOT NULL,
                 statusLivro VARCHAR(10) NOT NULL,
                 avaliacaoEstrelas TINYINT NULL,
                 usuario_id INT NOT NULL,
                 PRIMARY KEY (id, usuario_id),
                 INDEX fk_Livro_Usuario1_idx (usuario_id ASC) VISIBLE,
                 CONSTRAINT fk_Livro_Usuario1
                 FOREIGN KEY (usuario_id)
                 REFERENCES EntrePaginas.usuario (id)
                 ON DELETE NO ACTION
                 ON UPDATE NO ACTION)
                 ENGINE = InnoDB';

    mysqli_query($conexao, $sqlUsuario);
    mysqli_query($conexao, $sqlLivro);

?>