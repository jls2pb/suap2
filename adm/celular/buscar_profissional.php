<?php
include "../conexao.php";

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    // Verifique se o termo de pesquisa possui pelo menos 3 letras
    if (strlen($term) >= 3) {
        // Consulta para obter os profissionais que correspondem ao termo de pesquisa
        $sql = "SELECT id_profissional, nome, area, tempo_atendimento FROM profissionais WHERE nome LIKE :term";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Retorne os profissionais encontrados em um array associativo
        $profissional = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($profissional);
    }
}
?>
