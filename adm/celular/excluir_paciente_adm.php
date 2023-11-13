<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_adm'];
$id =  $_SESSION['id'];
$sql_paciente = "SELECT nome_paciente FROM tabela WHERE cod = :id";
$result_nome = $conexao->prepare($sql_paciente);
$result_nome->bindParam(':id', $id, PDO::PARAM_INT);
$result_nome->execute();
$nome_paciente = $result_nome->fetch(PDO:: FETCH_ASSOC);
$nome = $nome_paciente['nome_paciente'];
$sql = "DELETE FROM tabela WHERE cod = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
  $hoje = date('d/m/Y');
  $hora = date('H:i');
  $x = "EXCLUIU PACIENTE";
  $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora','$id')";
  $resultado2 = $conexao->prepare($sql2);
      if($resultado2->execute()){
          header ("location:index_logado_adm.php");
      }else{
          echo "erro ao registrar Log";
      }
}

?>
<script>
function deleteItem(itemId) {
  let userConfirmation = confirm("Você tem certeza de que deseja deletar?");
  
  // Se o usuário confirmou a exclusão
  if(userConfirmation) {
    // Delete o item
    // Código para deletar o item vai aqui
    console.log(`Item ${itemId} deletado.`);
  }
  // Se o usuário cancelou a exclusão
  else {
    // Não faça nada
    console.log('Operação de exclusão cancelada.');
  }
}
   </script> 