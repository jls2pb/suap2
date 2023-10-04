<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$n_profissional = $_POST["n_profissional"];
$area = $_POST["area"];
$tempo = $_POST["tempo"];
$cpf_logado = $_POST["session"];
$sql = "INSERT INTO profissionais(nome, area, tempo_atendimento) VALUES ('$n_profissional','$area', '$tempo')";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $cod = $conexao->lastInsertId();
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $x = "NOVO PROFISSIONAL";
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$n_profissional','$cpf_logado','$hoje','$hora','$cod')";
    $resultado2 = $conexao->prepare($sql2);
        if($resultado2->execute()){
            header ("location: inicio_agendamento.php");
        }else{
            echo "erro ao registrar Log";
        }

}else{
    echo "erro ao coletar os dados";
}
?>