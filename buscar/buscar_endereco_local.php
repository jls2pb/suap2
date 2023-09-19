<?php
// Conexão com o banco de dados
include "../conexao.php";

if (isset($_GET['local'])) {
    $local = $_GET['local'];

    // Consulta para obter o endereço local de atendimento com base no local selecionado
    $sql = "SELECT endereco_local FROM local_atendimento WHERE nome_fantasia = :local";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(':local', $local, PDO::PARAM_STR);
    $stmt->execute();

    // Retorna o endereço local de atendimento em formato JSON
    $enderecoLocal = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($enderecoLocal);
}
?>
