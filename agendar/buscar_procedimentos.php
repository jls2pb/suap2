<?php
$host = "localhost";
$port = 5432;
$database = "suap";
$user = "postgres";
$password = "1234";
$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password");

if (isset($_GET['cod'])) {
    $cod = $_GET['cod'];

    // Consulta para obter os procedimentos com base no código (cod)
    $sql = "SELECT procedimento FROM procedimentos WHERE cod = :cod";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cod', $cod, PDO::PARAM_INT);
    $stmt->execute();
    
    // Retorne os procedimentos encontrados em um array associativo
    $procedimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($procedimentos);
}
?>
