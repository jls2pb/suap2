<?php
    $host = '167.249.17.2';
    $port = '5433'; // Porta padrão do PostgreSQL
    $database = 'esus';
    $user = 'postgres';
    $password = 'B#OaabI9GknRJg65i*D#jMVxvOpQlS';
   $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password");

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    // Verifique se o termo de pesquisa possui pelo menos 3 letras
    if (strlen($term) >= 3) {
        // Consulta para obter os procedimentos que correspondem ao termo de pesquisa
        $sql = "SELECT DISTINCT ON (no_cidadao, nu_cpf, nu_cns) no_cidadao, nu_cpf, nu_cns, dt_nascimento, no_mae, nu_telefone_celular, nu_telefone_contato  FROM tb_cidadao WHERE no_cidadao LIKE :term LIMIT 15";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Retorne os procedimentos encontrados em um array JSON
        $cidadaos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($cidadaos);
    }
}
?>