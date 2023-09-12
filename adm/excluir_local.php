<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf'];

$id = $_GET["id"];

try {
    $sql = "DELETE FROM local_atendimento WHERE cnes = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("location: tb_local_ag_adm.php");
    } else {
        echo "Erro ao excluir o registro.";
    }
} catch (PDOException $e) {
    echo "Erro ao executar a consulta: " . $e->getMessage();
}
?>
