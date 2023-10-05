<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_adm'];

$id = $_GET["id"];

$sql1 = "SELECT nome_fantasia FROM local_atendimento WHERE cnes = '$id'";
$result_profissionais = $conexao->prepare($sql1);
$result_profissionais->execute();
$profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
$nome = $profissional['nome_fantasia'];
try {
    $sql = "DELETE FROM local_atendimento WHERE cnes = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $hoje = date('d/m/Y');
            $hora = date('H:i');
            $x = "EXCLUIU LOCAL"." ".$id;
            $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora','$id')";
            $resultado2 = $conexao->prepare($sql2);
            $resultado2->execute();
        header("location: tb_local_ag_adm.php");
    } else {
        echo "Erro ao excluir o registro.";
    }
} catch (PDOException $e) {
    echo "Erro ao executar a consulta: " . $e->getMessage();
}
?>
