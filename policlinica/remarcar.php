<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$data = $_POST["data_atendimento"];
$horario = $_POST["horario"];
$cpf_logado = $_POST["cpf_logado"];
$id = $_POST["id"];
$cod = $_POST["cod"];


$sql = "UPDATE agendamento SET cod_profissional = '$cod' ,data_atendimento = '$data', hora = '$horario', status = 0  WHERE id_agendamento = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $x = "EDITOU AGENDAMENTO"." ".$id;
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora','$id')";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();
    ?>
    <script>
    alert("ATUALIZADO COM SUCESSO!");
    window.location = "ver_agendamentos.php?id=<?php echo $cod; ?>";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}

?>