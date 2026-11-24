<?php
 session_start();
    include ('../BD/conexao.php');

    $sql="SELECT comunidades.*,
    usuario.nome AS criador,
    
    (SELECT COUNT(*)
    FROM usuario_entra_comunidade
    WHERE comunidade_idComunidade=comunidades.id
    ) AS participantes,
    
     (SELECT COUNT(*)
         FROM Usuario_Entra_Comunidade
         WHERE comunidade_idComunidade = comunidades.id
         AND Usuario_IdUsuario = ?) AS participa

        FROM comunidades

        INNER JOIN usuario
        ON comunidades.Usuario_IdUsuario = usuario.id";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();

$resultado = $stmt->get_result();

?>
