<?php
   $host = "localhost";
   $port = 5432;
   $database = "suap";
   $user = "postgres";
   $password = "1234";
   
    try {
      $conexao = new PDO("pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password");
      // Use a conexão para executar consultas ou realizar outras operações no banco de dados.
   } catch (PDOException $e) {
      echo "Falha na conexão com o banco de dados: " . $e->getMessage();
   }
?>