<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_adm'];
$n_paciente = $_GET["nome"];
$id =  $_GET["id"];
 $sql1 = "SELECT procedimento FROM procedimentos WHERE id = :id";
    $result = $conexao->prepare($sql1);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
$result->execute();
$procedimento = $result->fetch(PDO::FETCH_ASSOC);
$procedimento = $procedimento['procedimento'];
$sql = "DELETE FROM procedimentos WHERE id = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $sql8 = "DELETE FROM agendamento WHERE procedimento = :id";
    $resultado8 = $conexao->prepare($sql8);
    $resultado8->bindParam(':id', $id, PDO::PARAM_INT);
$resultado8->execute();

  $hoje = date('d/m/Y');
  $hora = date('H:i');
  $x = "EXCLUIU PROCEDIMENTO:"." ".$procedimento;
  $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$n_paciente','$cpf_logado','$hoje','$hora','$id')";
  $resultado2 = $conexao->prepare($sql2);
      if($resultado2->execute()){
          header ("location:listar_adm.php");
      }else{
          echo "erro ao registrar Log";
      }
}

?>
