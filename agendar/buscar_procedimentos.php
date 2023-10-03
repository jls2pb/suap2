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
    $sql = "SELECT p.cod, p.procedimento FROM procedimentos p
            INNER JOIN agendamento a ON p.cod = a.procedimento
            WHERE a.procedimento = :cod AND a.status != 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cod', $cod, PDO::PARAM_INT);
    $stmt->execute();
    
    // Retorne os procedimentos encontrados em um array associativo
    $procedimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($procedimentos);
}


?>
