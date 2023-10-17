<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_cer'];

$id =  $_GET["id"];
$query_profissionais = "SELECT nome FROM profissionais WHERE id_profissional = $id ";
$result_profissionais = $conexao->prepare($query_profissionais);
$result_profissionais->execute();
$profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
$nome = $profissional['nome'];
$sql = "DELETE FROM profissionais WHERE id_profissional = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $x = "EXCLUIU PROFISSIONAL"." ".$id;
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora','$id')";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();
?>
    <script>
    alert("EXCLUIDO COM SUCESSO!");
    window.location = "inicio_agendamento.php";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}
?>
