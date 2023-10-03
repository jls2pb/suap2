<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$data = $_POST["data_atendimento"];
$hora = $_POST["horario"];
$nome = $_POST["nome_paciente"];

$sexo = $_POST["sexo"];
$endereco = $_POST["endereco"];
$cpf = $_POST["cpf"];
$endereco_local = $_POST["endereco_local"];

$local_atendimento = $_POST["local_atendimento"];
$status = $_POST["status"];

$id = $_POST["id"];
$cod = $_POST["cod"];


$sql = "UPDATE agendamento SET data_atendimento = '$data', hora = '$hora', nome_paciente = '$nome', sexo = '$sexo', endereco = '$endereco', cpf = '$cpf', status = '$status', endereco_local = '$endereco_local', local_atendimento = '$local_atendimento'  WHERE id_agendamento = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){ ?>
    <script>
    alert("ATUALIZADO COM SUCESSO!");
    window.location = "tabela_agendamento.php?id=<?php echo $cod; ?>";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}

?>