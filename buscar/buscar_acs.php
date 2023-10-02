<?php
   $host = "localhost";
   $port = 5432;
   $database = "suap";
   $user = "postgres";
   $password = "1234";
   $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password");

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    // Verifique se o termo de pesquisa possui pelo menos 3 letras
    if (strlen($term) >= 3) {
        // Consulta para obter os procedimentos que correspondem ao termo de pesquisa
        $sql = "SELECT nome FROM acs WHERE nome LIKE :term";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Retorne os procedimentos encontrados em um array JSON
        $acs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode($acs);
    }
}
?>