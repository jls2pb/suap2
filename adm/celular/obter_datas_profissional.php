<?php
// Inclua o arquivo de conexão com o banco de dados
require_once("../../conexao.php");

// Verifique se a solicitação POST contém o ID do profissional
if (isset($_POST['profissional'])) {
    $idProfissional = $_POST['profissional'];
$dataAtual = date('Y-m-d');
    // Consulta SQL para selecionar as datas disponíveis para o profissional
    $sql = "SELECT DISTINCT dia FROM agenda_profissional WHERE id_profissional = :idProfissional AND dia >= '$dataAtual'";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idProfissional', $idProfissional, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $datasDisponiveis = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Converte as datas para o formato desejado (por exemplo, 'd/m/Y')
        $formattedDatas = array_map(function ($data) {
            return date('d/m/Y', strtotime($data));
        }, $datasDisponiveis);

        // Retorna as datas disponíveis como uma resposta JSON
        header('Content-Type: application/json');
        echo json_encode($formattedDatas);
    } else {
        echo "Erro ao consultar datas disponíveis.";
    }
} else {
    echo "ID do profissional não fornecido na solicitação.";
}
?>
