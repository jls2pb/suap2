<?php
include "../conexao.php";
if (isset($_GET['cod'])) {
    $cod = $_GET['cod'];

    // Consulta para obter os procedimentos com base no código (cod) e status igual a 1
    $sql = "SELECT p.id, p.procedimento FROM procedimentos p
    LEFT JOIN agendamento a ON p.id = a.procedimento AND a.status != 1
    WHERE p.cod = :cod AND (p.data_do_agendamento IS NULL OR p.data_do_agendamento = '')";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(':cod', $cod, PDO::PARAM_INT);
    $stmt->execute();
    
    // Retorne os procedimentos encontrados em um array associativo
    $procedimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($procedimentos);
}


?>
