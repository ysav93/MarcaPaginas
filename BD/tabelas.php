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

    $sqlcomunidades = 'CREATE TABLE IF NOT EXISTS EntrePaginas.comunidades(
                     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                     nome TEXT NOT NULL,
                     descricao TEXT NOT NULL,
                     conviteGeral INT NOT NULL,
                     imagem BLOB NOT NULL,
                     Usuario_IDUsuario INT NOT NULL
                     FOREIGN KEY (Usuario_IdUsuario)
                     REFERENCES EntrePaginas.usuario(id)
                     ON DELETE NO ACTION
                     ON UPDATE NO ACTION)
                     ENGINE=InnoDB';

    $sqlUsuarioEntraComunidade = 'CREATE TABLE IF NOT EXISTS EntrePaginas.Usuario_Entra_Comunidade (
     comunidade_idComunidade INT NOT NULL,
                        Usuario_IdUsuario INT NOT NULL,
                                  PRIMARY KEY (comunidade_idComunidade, Usuario_IdUsuario),
                                  FOREIGN KEY (comunidade_idComunidade)
                                  REFERENCES EntrePaginas.comunidades (id),
                                  FOREIGN KEY (Usuario_IdUsuario)
                                  REFERENCES EntrePaginas.usuario (id))
                                  ENGINE = InnoDB';


    
    $sqlGrupo = 'CREATE TABLE IF NOT EXISTS EntrePaginas.grupo (
                 id INT NOT NULL AUTO_INCREMENT,
                 descricao TEXT NOT NULL,
                 nome TEXT NOT NULL,
                 imagemRepresentativa BLOB,
                 codigoDeAcesso INT NOT NULL,
                 Usuario_IdUsuario INT NOT NULL,
                 PRIMARY KEY (id),
                 FOREIGN KEY (Usuario_IdUsuario)
                 REFERENCES EntrePaginas.usuario (id)
                 ON DELETE NO ACTION
                 ON UPDATE NO ACTION)
                 ENGINE = InnoDB';


    $sqlUsuarioEntraGrupo = 'CREATE TABLE IF NOT EXISTS EntrePaginas.Usuario_Entra_Grupo (
                             Usuario_IdUsuario INT NOT NULL,
                             Grupo_idGrupo INT NOT NULL,
                             PRIMARY KEY (Usuario_IdUsuario, Grupo_idGrupo),
                             FOREIGN KEY (Usuario_IdUsuario)
                             REFERENCES EntrePaginas.usuario (id),
                             FOREIGN KEY (Grupo_idGrupo)
                             REFERENCES EntrePaginas.grupo (id))
                             ENGINE = InnoDB';


   
    mysqli_query($conexao, $sqlUsuario);
    mysqli_query($conexao, $sqlLivro);
    mysqli_query($conexao, $sqlcomunidades);
    mysqli_query($conexao, $sqlUsuarioEntraComunidade);
    mysqli_query($conexao, $sqlGrupo);
    mysqli_query($conexao, $sqlUsuarioEntraGrupo);
