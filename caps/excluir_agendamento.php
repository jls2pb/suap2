<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_caps'];
$cod = $_GET['cod'];
$id =  $_GET["id"];
$id1 =  $_GET["id1"];
$sql1 = "SELECT nome_paciente FROM agendamento WHERE id_agendamento = '$id'";
$result_profissionais = $conexao->prepare($sql1);
$result_profissionais->execute();
$profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
$nome = $profissional['nome_paciente'];
$sql = "DELETE FROM agendamento WHERE id_agendamento = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $sql3 = "UPDATE procedimentos SET data_do_agendamento = '' WHERE cod = '$cod'";
        $resultado3 = $conexao->prepare($sql3);
        $resultado3->execute();
$hoje = date('d/m/Y');
  $hora = date('H:i');
  $x = "EXCLUIU AGENDAMENTO"." ".$id;
  $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora','$id')";
  $resultado2 = $conexao->prepare($sql2);
      $resultado2->execute();
?>
    <script>
    alert("EXCLUIDO COM SUCESSO!");
    window.location = "tabela_agendamento.php?id=<?php echo $id1; ?>";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}
?>
