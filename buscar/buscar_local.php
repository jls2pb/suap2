<?php
include "../conexao.php";

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    // Verifique se o termo de pesquisa possui pelo menos 3 letras
    if (strlen($term) >= 3) {
        // Consulta para obter os locais de atendimento que correspondem ao termo de pesquisa
        $sql = "SELECT nome_fantasia FROM local_atendimento WHERE nome_fantasia LIKE :term";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Retorne os locais encontrados em um array associativo
        $locais = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode($locais);
    }
}
?>