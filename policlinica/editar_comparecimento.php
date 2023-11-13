<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$status = $_GET["status"];
$id = $_GET["id"];
$sql = "UPDATE agendamento SET status = '$status' WHERE id_agendamento = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $query = "SELECT * FROM agendamento WHERE id_agendamento = '$id'";
    $result = $conexao->prepare($query);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $proc = $row['procedimento'];

    if ($status==2) { 
    $sql1 = "UPDATE procedimentos SET observacao = 'NÃO COMPARECEU', status = '$status' WHERE id = '$proc'";
$resultado1 = $conexao->prepare($sql1);
$resultado1->execute();
    }

    ?>
    <script>
    alert("ATUALIZADO COM SUCESSO!");
    window.location = "inicio.php";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}

?>
