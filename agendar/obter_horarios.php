<?php
// Verifique se a solicitação é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o banco de dados
    include "../conexao.php";
    session_start();
    // Obter o dia selecionado pelo usuário da solicitação POST
    $diaSelecionado = $_POST['dia'];
    $id = $_SESSION['id_profissional'];
    // Consulta ao banco de dados para obter os horários disponíveis com base no dia selecionado
    $sql = "SELECT * FROM agenda_profissional WHERE id_profissional = :id_profissional AND dia = :dia";
    $resultado = $conexao->prepare($sql);
    $resultado->bindParam(':id_profissional', $id, PDO::PARAM_INT);
    $resultado->bindParam(':dia', $diaSelecionado, PDO::PARAM_STR);

    // Inicializar um array para armazenar os horários disponíveis
    $horariosDisponiveis = [];

    if ($resultado->execute()) {
        $x = $resultado->fetchAll();
        foreach ($x as $dado) {
            // Horário de início e final da manhã
            $inicioManha = strtotime($dado['inicio_manha']);
            $finalManha = strtotime($dado['final_manha']);

            // Horário de início e final da tarde
            $inicioTarde = strtotime($dado['inicio_tarde']);
            $finalTarde = strtotime($dado['final_tarde']);

            // Tempo de atendimento
            $tempoAtendimento = NULL;
            $sql2 = "SELECT * FROM profissionais where id_profissional = '$id'";
            $resultado2 = $conexao->prepare($sql2);
            if($resultado2->execute){
                $y = $resultado2->fetchAll();
                foreach ($y as $r) {
                    $tempoAtendimento = $r['tempo_atendimento'];
                }
                
            }
           

            // Gerar horários disponíveis e adicioná-los ao array PHP
            for ($horario = $inicioManha; $horario <= $finalManha; $horario += 60 * $tempoAtendimento) {
                $horariosDisponiveis[] = date('H:i', $horario);
            }

            for ($horario = $inicioTarde; $horario <= $finalTarde; $horario += 60 * $tempoAtendimento) {
                $horariosDisponiveis[] = date('H:i', $horario);
            }
        }
    }

    // Defina o cabeçalho Content-Type como JSON
    header('Content-Type: application/json');

    // Retornar os horários disponíveis como um JSON
    echo json_encode($horariosDisponiveis);
} else {
    // Responda com um erro se a solicitação não for um POST
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Solicitação inválida"]);
}
?>