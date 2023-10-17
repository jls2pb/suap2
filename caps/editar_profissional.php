<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$nome = $_POST["nome"];
$area = $_POST["area"];
$tempo_atendimento = $_POST["tempo_atendimento"];
$cpf = $_POST['cpf'];


$id = $_POST["id"];



$sql = "UPDATE profissionais SET nome = '$nome', area = '$area', tempo_atendimento = '$tempo_atendimento'  WHERE id_profissional = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){ 
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $x = "EDITOU PROFISSIONAL"." ".$id;
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf','$hoje','$hora','$id')";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();?>
    <script>
    alert("ATUALIZADO COM SUCESSO!");
    window.location = "inicio_agendamento.php";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}

?>