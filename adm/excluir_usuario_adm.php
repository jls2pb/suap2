<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf'];
$n_paciente = $_GET["nome"];
$id =  $_GET["id"];

$sql = "DELETE FROM usuario WHERE id_usuario = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
          header ("location:ver_usuarios.php");
      }else{
          echo "erro ao registrar Log";
      }


?>
