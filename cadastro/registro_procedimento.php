<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$n_paciente = $_POST["n_paciente"];
$procedimento = $_POST["procedimento"];
$d_solicitacao = $_POST["d_solicitacao"];
$d_entrada = $_POST["d_entrada"];
$d_saida = $_POST["d_saida"];
$d_agendamento = $_POST["d_agendamento"];
$l_agendamento = $_POST["l_agendamento"];
$obs = $_POST["obs"];
$cpf_logado = $_POST["cpf_logado"];
$profissional = $_POST["profissional"];
$n = $_POST["n"];
$especificacao = $_POST["especificacao"];
$sql = "INSERT INTO procedimentos(nome_paciente, procedimento, data_da_solicitacao, data_de_entrada_cadastro, data_da_saida, data_do_agendamento, local_do_agendamento, observacao, profissional,cod,especificacao) VALUES ('$n','$procedimento', '$d_solicitacao', '$d_entrada' ,'$d_saida' ,'$d_agendamento', '$l_agendamento', '$obs', '$profissional','$n_paciente','$especificacao')";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $cod = $conexao->lastInsertId();
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('NOVO PROCEDIMENTO','$n','$cpf_logado','$hoje','$hora','$n_paciente')";
    $resultado2 = $conexao->prepare($sql2);
        if($resultado2->execute()){
            header ("location: listar.php");
        }else{
            echo "erro ao registrar Log";
        }

}else{
    echo "erro ao coletar os dados";
}
?>