<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$dia = $_POST["dia"];
$inicio_manha = $_POST["inicio_manha"];
$final_manha = $_POST["final_manha"];
$inicio_tarde = $_POST["inicio_tarde"];
$final_tarde = $_POST["final_tarde"];
$id = $_POST["id"];
$cpf = $_POST["cpf_logado"];
$query_profissionais = "SELECT nome FROM profissionais WHERE id_profissional = $id ";
$result_profissionais = $conexao->prepare($query_profissionais);
$result_profissionais->execute();
$profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
$nome_profissional = $profissional['nome'];
$sql = "INSERT INTO agenda_profissional(id_profissional, dia, inicio_manha, final_manha, inicio_tarde, final_tarde) VALUES ('$id','$dia', '$inicio_manha', '$final_manha', '$inicio_tarde', '$final_tarde')";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $cod = $conexao->lastInsertId();
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $x = "NOVA AGENDA PROFISSIONAL: ".$id;
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome_profissional','$cpf','$hoje','$hora','$cod')";
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