<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$id = $_GET["id"];



$sql = "UPDATE agendamento SET status = 2 WHERE id_agendamento = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){ ?>
    <script>
    alert("ATUALIZADO COM SUCESSO!");
    window.location = "inicio.php";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}

?>