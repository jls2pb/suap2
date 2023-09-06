<?php
require_once("head.php");
include "menu_agendamento.php";
include "navibar_agendar.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agendamento de Consulta</title>
</head>
<body>
    <h1>Agendamento de Consulta</h1>
    <form method="post" action="agendar.php">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br><br>

        <label for="dia">Dia:</label>
        <input type="date" name="dia" required><br><br>

        <label for="horario">Horário:</label>
        <select name="horario" required>
            <?php
            // Conexão com o banco de dados
            include "../conexao.php";

            // ID do médico e tempo de atendimento
            $idMedico = 1;
            $tempoAtendimento = 20; // minutos

            // Horário de início e final da manhã
            $inicioManha = strtotime('08:20:00');
            $finalManha = strtotime('12:00:00');

            // Horário de início e final da tarde
            $inicioTarde = strtotime('13:00:00');
            $finalTarde = strtotime('17:00:00');

            // Consulta ao banco para obter os horários disponíveis
            $dia = $_POST['dia']; // Dia selecionado pelo usuário

            // Loop para gerar os horários disponíveis com base no tempo de atendimento
            for ($horario = $inicioManha; $horario <= $finalManha; $horario += 60 * $tempoAtendimento) {
                $horarioFormatado = date('H:i', $horario);
                echo "<option value='$horarioFormatado'>$horarioFormatado</option>";
            }

            for ($horario = $inicioTarde; $horario <= $finalTarde; $horario += 60 * $tempoAtendimento) {
                $horarioFormatado = date('H:i', $horario);
                echo "<option value='$horarioFormatado'>$horarioFormatado</option>";
            }

            // Feche a conexão com o banco de dados
            pg_close($conn);
            ?>
        </select><br><br>

        <input type="submit" value="Agendar Consulta">
    </form>
</body>
</html>