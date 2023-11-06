<?php
  $host = '167.249.17.2';
  $port = '5433'; // Porta padrão do PostgreSQL
  $database = 'esus';
  $user = 'postgres';
  $password = 'B#OaabI9GknRJg65i*D#jMVxvOpQlS';
 $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password");

if (isset($_GET['cpf'])) {
    $cpf = $_GET['cpf'];

    // Consulta para obter o sexo com base no CPF
    $sql = "SELECT no_sexo FROM tb_cidadao WHERE nu_cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cpf', $cpf, PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        // Retorne o resultado como JSON
        echo json_encode(['sexo' => $resultado['no_sexo']]);
    } else {
        // Retorne um valor padrão (ou vazio) se o sexo não for encontrado
        echo json_encode(['sexo' => '']);
    }
}
?>
