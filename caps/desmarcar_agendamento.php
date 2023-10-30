<?php 
session_start();
date_default_timezone_set('America/Sao_Paulo');
include "../conexao.php";
$cpf_logado = $_SESSION['cpf_caps'];
$id = $_GET['id'];
$motivo = $_GET['motivo'];
$hoje = date('d/m/Y');
    $hora = date('H:i');
$sql = "SELECT cod_usuario, nome_paciente, cod_profissional, procedimento FROM agendamento WHERE id_agendamento = $id";
$resultado = $conexao->prepare($sql);
$resultado->execute();
$dados = $resultado->fetchAll();
    foreach ($dados as $k) {
        $proc = $k["procedimento"];
        $nome_paciente = $k["nome_paciente"];
        $id_paciente = $k["cod_usuario"];
        $cod_profissional = $k["cod_profissional"];
        $acao = "CANCELAMENTO AGENDAMENTO ".$id;
    $sql = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente,motivo) VALUES('$acao','$nome_paciente','$cpf_logado','$hoje','$hora',$id_paciente,'$motivo')";
    $resultado = $conexao->prepare($sql);
    if($resultado->execute()){
        $sql = "UPDATE agendamento SET hora = NULL, data_atendimento = NULL, cod_profissional = NULL, status = 3 WHERE id_agendamento = $id";
        $resultado = $conexao->prepare($sql);
        if($resultado->execute()){
            $sql ="UPDATE procedimentos SET data_do_agendamento = '', data_da_saida = '', local_do_agendamento = '', profissional = '' where id = $proc";
            $result = $conexao->prepare($sql);
            if($result->execute()){
                header("Location:tabela_agendamento.php?id=$cod_profissional");
            }
        }
        
    }
    }
   
?>