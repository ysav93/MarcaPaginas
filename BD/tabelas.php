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
                 avaliacaoEstrelas TINYINT NULL,
                 usuario_id INT NULL,
                 PRIMARY KEY (id),
                 INDEX fk_Livro_Usuario1_idx (usuario_id ASC) VISIBLE,
                 CONSTRAINT fk_Livro_Usuario1
                 FOREIGN KEY (usuario_id)
                 REFERENCES EntrePaginas.usuario (id)
                 ON DELETE SET NULL
                 ON UPDATE NO ACTION)
                 ENGINE = InnoDB';

    $sqlAcompanhamento = 'CREATE TABLE IF NOT EXISTS EntrePaginas.usuario_acompanha_livro (
                          livro_id INT NOT NULL,
                          usuario_id INT NOT NULL,
                          numeroDePaginasConcluidas INT NOT NULL,
                          statusLivro VARCHAR(10) NOT NULL,
                          dataHoraAtualizacao TIMESTAMP NOT NULL,
                          PRIMARY KEY (livro_id, usuario_id),
                          INDEX fk_Livro_has_Usuario_Usuario1_idx (usuario_id ASC) VISIBLE,
                          INDEX fk_Livro_has_Usuario_Livro1_idx (livro_id ASC) VISIBLE,
                          CONSTRAINT fk_Livro_has_Usuario_Livro1
                          FOREIGN KEY (livro_id)
                          REFERENCES EntrePaginas.livro (id)
                          ON DELETE CASCADE
                          ON UPDATE NO ACTION,
                          CONSTRAINT fk_Livro_has_Usuario_Usuario1
                          FOREIGN KEY (usuario_id)
                          REFERENCES EntrePaginas.usuario (id)
                          ON DELETE CASCADE
                          ON UPDATE NO ACTION)
                          ENGINE = InnoDB';

    mysqli_query($conexao, $sqlUsuario);
    mysqli_query($conexao, $sqlLivro);
    mysqli_query($conexao, $sqlAcompanhamento);

?>
