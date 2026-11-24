<?php 
session_start();
    include ('../BD/conexao.php');

if(!isset($_SESSION['idUsuario'])){
    header("Location:../usuarios/login.php");
exit;
}
$idUsuario = $_SESSION['idUsuario'];
$idComunidade = intval($_POST['id'] ?? 0);


$sql = "DELETE FROM Usuario_Entra_Comunidade
        WHERE comunidade_idComunidade = ?
        AND Usuario_IdUsuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $idComunidade, $idUsuario);
$stmt->execute();


header("Location: listar.php");
exit;


?>
