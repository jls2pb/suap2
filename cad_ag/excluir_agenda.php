<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_cad_ag'];

$id =  $_GET["id"];
$id1 =  $_GET["id1"];
$query_profissionais = "SELECT nome FROM profissionais WHERE id_profissional = $id1 ";
$result_profissionais = $conexao->prepare($query_profissionais);
$result_profissionais->execute();
$profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
$nome = $profissional['nome'];
$sql = "DELETE FROM agenda_profissional WHERE id_agenda = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
$hoje = date('d/m/Y');
  $hora = date('H:i');
  $x = "EXCLUIU AGENDA PROFISSIONAL"." ".$id;
  $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora','$id')";
  $resultado2 = $conexao->prepare($sql2);
      $resultado2->execute();
?>
    <script>
    alert("EXCLUIDO COM SUCESSO!");
    window.location = "tabela_agenda.php?id=<?php echo $id1; ?>";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}
?>
