<?php
$host = "localhost";
$port = 5432;
$database = "suap";
$user = "postgres";
$password = "1234";
$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password");
if (isset($_GET['cod'])) {
    $cod = $_GET['cod'];

    // Consulta para obter os procedimentos com base no código (cod) e status igual a 1
    $sql = "SELECT p.id, p.procedimento FROM procedimentos p
    LEFT JOIN agendamento a ON p.id = a.procedimento AND a.status != 1
    WHERE p.cod = :cod AND (p.data_do_agendamento IS NULL OR p.data_do_agendamento = '')";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cod', $cod, PDO::PARAM_INT);
    $stmt->execute();
    
    // Retorne os procedimentos encontrados em um array associativo
    $procedimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($procedimentos);
}


?>
