<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$nome = $_POST["nome"];
$area = $_POST["area"];
$tempo_atendimento = $_POST["tempo_atendimento"];


$id = $_POST["id"];



$sql = "UPDATE profissionais SET nome = '$nome', area = '$area', tempo_atendimento = '$tempo_atendimento'  WHERE id_profissional = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){ ?>
    <script>
    alert("ATUALIZADO COM SUCESSO!");
    window.location = "inicio_agendamento.php";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}

?>