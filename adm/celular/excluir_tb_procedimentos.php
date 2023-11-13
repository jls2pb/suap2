<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("../../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_adm'];

$procedimento = $_GET['id']; // Aqui você obtém o valor do procedimento que deseja excluir
$sql1 = "SELECT procedimento FROM procedimento_medico WHERE id_procedimento = '$procedimento'";
$result_profissionais = $conexao->prepare($sql1);
$result_profissionais->execute();
$profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
$nome = $profissional['procedimento'];
// Agora você pode usar esse valor em sua consulta SQL para excluir o registro correspondente
$sql = "DELETE FROM procedimento_medico WHERE id_procedimento = :procedimento";
$resultado = $conexao->prepare($sql);
$resultado->bindParam(':procedimento', $procedimento, PDO::PARAM_INT);

if ($resultado->execute()) {
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $x = "EXCLUIU PROCEDIMENTO"." ".$procedimento;
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora','$procedimento')";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();
    header("Location: tb_procedimentos_adm.php");
} else {
    echo "Erro ao excluir procedimento.";
}

?>
