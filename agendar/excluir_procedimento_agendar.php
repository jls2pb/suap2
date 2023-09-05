<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf'];
$n_paciente = $_GET["nome"];
$id =  $_GET["id"];

$sql = "DELETE FROM procedimentos WHERE id = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
  $hoje = date('d/m/Y');
  $hora = date('H:i');
  $x = "EXCLUIU"." ".$id;
  $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$n_paciente','$cpf_logado','$hoje','$hora','$id')";
  $resultado2 = $conexao->prepare($sql2);
      if($resultado2->execute()){
          header ("location:listar_agendar.php");
      }else{
          echo "erro ao registrar Log";
      }
}

?>
