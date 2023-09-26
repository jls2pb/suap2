<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_cadastro'];

$procedimento = $_GET['id']; // Aqui você obtém o valor do procedimento que deseja excluir

// Agora você pode usar esse valor em sua consulta SQL para excluir o registro correspondente
$sql = "DELETE FROM procedimento_medico WHERE id_procedimento = :procedimento";
$resultado = $conexao->prepare($sql);
$resultado->bindParam(':procedimento', $procedimento, PDO::PARAM_INT);

if ($resultado->execute()) {
    header("Location: tb_procedimentos.php");
} else {
    echo "Erro ao excluir procedimento.";
}

?>
