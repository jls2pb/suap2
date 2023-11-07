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
    $sql = "SELECT tp_logradouro ,ds_logradouro, nu_numero, no_bairro  FROM tb_cidadao WHERE nu_cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cpf', $cpf, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $logradouro = $resultado['tp_logradouro'];

 // Consulta para obter o sexo com base no CPF
 $sql1 = "SELECT no_tipo_logradouro FROM tb_tipo_logradouro WHERE co_tipo_logradouro = :logradouro";
 $stmt1 = $pdo->prepare($sql1);
 $stmt1->bindValue(':logradouro', $logradouro, PDO::PARAM_STR);
 $stmt1->execute();
    $resultado1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($resultado && $resultado1) {
        // Retorne o resultado como JSON
        $result = $resultado1+$resultado;
        echo json_encode($result);
     
    } else {
        // Retorne um valor padrão (ou vazio) se o sexo não for encontrado
        echo json_encode([$result => '']);
    }
}
?>
