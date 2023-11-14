<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$n_paciente = $_POST["n_paciente"];
$profissional = $_POST["profissional"];
$procedimento = $_POST["procedimento"];
$d_solicitacao = $_POST["d_solicitacao"];
$d_entrada = $_POST["d_entrada"];
$d_saida = $_POST["d_saida"];
$d_agendamento = $_POST["d_agendamento"];
$l_agendamento = $_POST["l_agendamento"];
$obs = $_POST["obs"];
$cpf_logado = $_POST["cpf_logado"];
$id = $_POST["id"];
$status = $_POST["status"];
$cod = $_POST["cod"];
$especificacao = $_POST["especificacao"];
if($status == 0 || $status == 1 || $status == 2 ){
        $sql1 = "UPDATE agendamento SET status = $status WHERE procedimento = $id";
        $resultado1 = $conexao->prepare($sql1);
        $resultado1->execute();
    }
$sql = "UPDATE procedimentos SET nome_paciente = '$n_paciente', procedimento = '$procedimento', data_da_solicitacao = '$d_solicitacao', data_de_entrada_cadastro = '$d_entrada', data_da_saida = '$d_saida', data_do_agendamento = '$d_agendamento', local_do_agendamento = '$l_agendamento', observacao = '$obs', profissional = '$profissional', especificacao = '$especificacao', status = $status WHERE id = '$id'";
$resultado = $conexao->prepare($sql);
    
if($resultado->execute()){
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $nome = "PROCEDIMENTO"." ".$id;
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$nome','$n_paciente','$cpf_logado','$hoje','$hora','$cod')";
    $resultado2 = $conexao->prepare($sql2);
        if($resultado2->execute()){
            header ("location: listar_adm.php?id=".$cod);
        }else{
            echo "erro ao registrar Log";
        }
}else{
    echo "erro ao coletar os dados";
}

?>