<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$data = $_POST["data_atendimento"];
$horario = $_POST["horario"];
$nome = $_POST["nome_paciente"];
$id_profissional = $_POST["profissional"];
$sexo = $_POST["sexo"];
$endereco = $_POST["endereco"];

$cpf = $_POST["cpf"];
$cpf_logado = $_POST["cpf_logado"];
$endereco_local = $_POST["endereco_local"];

$local_atendimento = $_POST["local_atendimento"];
$status = $_POST["status"];

$id = $_POST["id"];
$cod = $_POST["cod"];


$sql = "UPDATE agendamento SET data_atendimento = '$data', hora = '$horario', nome_paciente = '$nome', sexo = '$sexo', endereco = '$endereco', cpf = '$cpf', status = '$status', endereco_local = '$endereco_local', local_atendimento = '$local_atendimento', cod_profissional = '$id_profissional'   WHERE id_agendamento = $id";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $query_profissionais = "SELECT procedimento FROM agendamento WHERE id_agendamento = $id";
    $result_profissionais = $conexao->prepare($query_profissionais);
    $result_profissionais->execute();
    $row_profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
    $procedimento = $row_profissional['procedimento'];

    $query_profissionai = "SELECT nome FROM profissionais WHERE id_profissional = $id_profissional";
    $result_profissionai = $conexao->prepare($query_profissionai);
    $result_profissionai->execute();
    $row_profissionai = $result_profissionai->fetch(PDO::FETCH_ASSOC);
    $profissional = $row_profissionai['nome'];

    $sql3 = "UPDATE procedimentos SET data_do_agendamento = '$data', profissional = '$profissional' WHERE id = $procedimento";
    $resultado3 = $conexao->prepare($sql3);
    $resultado3->execute();
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $x = "EDITOU AGENDAMENTO"." ".$id;
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora',$id)";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();
    ?>
    <script>
    alert("ATUALIZADO COM SUCESSO!");
    window.location = "tabela_agendamento.php?id=<?php echo $cod; ?>";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}

?>