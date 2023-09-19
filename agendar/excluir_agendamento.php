<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf'];

$id =  $_GET["id"];

$sql = "DELETE FROM agendamento WHERE id_agendamento = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
?>
    <script>
    alert("EXCLUIDO COM SUCESSO!");
    window.location = "inicio_agendamento.php";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}
?>
