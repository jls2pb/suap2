<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("conexao.php");
$cod = $_POST["id"];
$n_paciente = $_POST["n_paciente"];
$rg = $_POST["rg"];
$cpf = $_POST["cpf"];
$n_mae = $_POST["n_mae"];
$cns = $_POST["cns"];
$d_nascimento = $_POST["nascimento"];
$acs = $_POST["acs"];
$ubs = $_POST["ubs"];
$celular = $_POST["celular"];
$telefone = $_POST["telefone"];
$cpf_logado = $_POST["cpf_logado"];

if($d_nascimento != NULL){
    $nascimento = date('d/m/Y', strtotime($d_nascimento));
}else{
    $nascimento = NULL;
}

$sql = "UPDATE tabela SET nome_paciente = '$n_paciente', rg = '$rg', cpf = '$cpf', nome_da_mae = '$n_mae', cns = '$cns', nascimento = '$nascimento', acs = '$acs', ubs = '$ubs', celular = '$celular', telefone = '$telefone' WHERE cod = '$cod'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('EDITADO','$n_paciente','$cpf_logado','$hoje','$hora','$cod')";
    $resultado2 = $conexao->prepare($sql2);
        if($resultado2->execute()){
            header ("location: listar.php?id=".$cod);
        }else{
            echo "erro ao registrar Log";
        }
}else{
    echo "erro ao coletar os dados";
}

?>