<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_cadastro'];
$id =  $_SESSION['id'];
$sql = "DELETE FROM tabela WHERE cod = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
  $hoje = date('d/m/Y');
  $hora = date('H:i');
  $x = "EXCLUIU"." ".$id;
  $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$n_paciente','$cpf_logado','$hoje','$hora','$id')";
  $resultado2 = $conexao->prepare($sql2);
      if($resultado2->execute()){
          header ("location:index_logado.php");
      }else{
          echo "erro ao registrar Log";
      }
}

?>
<script>
  function confirmarExclusao(id) {
            var confirmacao = confirm("Tem certeza de que deseja excluir este registro?");
            if (confirmacao) {
                // Se o usuário confirmar, redirecione para o script de exclusão PHP
                window.location = "excluir.php?id=" + id;
            } else {
                // Se o usuário cancelar, não faça nada
            }
        }
   </script> 