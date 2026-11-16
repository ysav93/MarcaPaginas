<?php
$conexao=new mysqli("localhost","root","","marcaPaginas");

if($conexao -> connect_error){
die("erro na conexão");
}
session_start();

?>