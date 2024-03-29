<?php
include "../conexao.php";

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    // Verifique se o termo de pesquisa possui pelo menos 3 letras
    if (strlen($term) >= 3) {
        // Consulta para obter os pacientes que correspondem ao termo de pesquisa
        $sql = "SELECT DISTINCT ON (nome_paciente, cod) cod, nome_paciente, cpf, nascimento FROM tabela WHERE nome_paciente LIKE :term LIMIT 5";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
        $stmt->execute();
        
        // Retorne os pacientes encontrados em um array associativo
        $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($pacientes);
    }
}
?>
