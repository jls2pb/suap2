<?php
date_default_timezone_set('America/Sao_Paulo');
// Verifique se a solicitação é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o banco de dados
    include "../conexao.php";
    session_start();
    
    // Obter o dia selecionado pelo usuário da solicitação POST
    $diaSelecionado = $_POST['dia'];
    $id = $_POST['idProfissional'];
    $teste = "SELECT * FROM profissionais WHERE id_profissional = $id";
    $res = $conexao->prepare($teste);
    $res->execute();
    $vr = $res->fetchAll();
    foreach ($vr as $vr2) {
        $tempoAtendimento = $vr2['tempo_atendimento'];
    }
    
    // Consulta SQL para obter todos os horários disponíveis do profissional para o dia selecionado
    $sql = "SELECT inicio_manha, final_manha, inicio_tarde, final_tarde FROM agenda_profissional WHERE id_profissional = :id_profissional AND dia = :diaSelecionado";
    $resultado = $conexao->prepare($sql);
    $resultado->bindParam(':id_profissional', $id, PDO::PARAM_INT);
    $resultado->bindParam(':diaSelecionado', $diaSelecionado, PDO::PARAM_STR);
    
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
            $sql2 = "SELECT hora FROM agendamento WHERE data_atendimento = '$diaSelecionado' AND cod_profissional = $id";
            $resultado2 = $conexao->prepare($sql2);
            $resultado2->execute();
            $horariosAgendados = $resultado2->fetchAll(PDO::FETCH_COLUMN);

            $horaAtual = strtotime('now');

            for ($horario = $inicioManha; $horario <= $finalManha; $horario += 60 * $tempoAtendimento) {
                $horario_certo = date('H:i', $horario);

                // Consulta SQL para verificar se o horário já está agendado
                $sql3 = "SELECT COUNT(*) AS count FROM agendamento WHERE data_atendimento = :diaSelecionado AND cod_profissional = :id AND hora = :horario";
                $resultado3 = $conexao->prepare($sql3);
                $resultado3->bindParam(':diaSelecionado', $diaSelecionado, PDO::PARAM_STR);
                $resultado3->bindParam(':id', $id, PDO::PARAM_INT);
                $resultado3->bindParam(':horario', $horario_certo, PDO::PARAM_STR);
                $resultado3->execute();
                $row = $resultado3->fetch(PDO::FETCH_ASSOC);

                // Verifique se o horário não está agendado e se é um horário futuro
                if ($row['count'] == 0 && strtotime($horario_certo) > $horaAtual) {
                    $horariosDisponiveis[] = $horario_certo;
                }
            }

            for ($horario = $inicioTarde; $horario <= $finalTarde; $horario += 60 * $tempoAtendimento) {
                $horario_certo = date('H:i', $horario);

                // Consulta SQL para verificar se o horário já está agendado
                $sql4 = "SELECT COUNT(*) AS count FROM agendamento WHERE data_atendimento = :diaSelecionado AND cod_profissional = :id AND hora = :horario";
                $resultado4 = $conexao->prepare($sql4);
                $resultado4->bindParam(':diaSelecionado', $diaSelecionado, PDO::PARAM_STR);
                $resultado4->bindParam(':id', $id, PDO::PARAM_INT);
                $resultado4->bindParam(':horario', $horario_certo, PDO::PARAM_STR);
                $resultado4->execute();
                $row = $resultado4->fetch(PDO::FETCH_ASSOC);

                // Verifique se o horário não está agendado e se é um horário futuro
                if ($row['count'] == 0 && strtotime($horario_certo) > $horaAtual) {
                    $horariosDisponiveis[] = $horario_certo;
                }
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
