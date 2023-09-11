<?php
require_once("head.php");
include "menu_agendamento.php";
include "navibar_agendar.php";
$id = $_GET['id'];
?>  
<!DOCTYPE html>
<head>
    <title>Agendamento de Consulta</title>
</head>

    <h1>Agendamento de Consulta</h1>
    <form method="post" action="agendar.php">
    <div class="col-8">     
        <div class="form-outline mb-4">
        <label class="form-label">Paciente</label>
        <input type="text" name = "acs" class="form-control form-control-lg" id="acs_input" list="acs_list" oninput="handleInput(event)">
                        <datalist id="acs_list"></datalist>
		</div>
    </div>

        <label for="dia">Dia:</label>
        <input type="date" name="dia" required><br><br>

        <label for="horario">Horário:</label>
        <select name="horario" required>
            <?php
            // Conexão com o banco de dados
            include "../conexao.php";
            $sql = "select * from agenda_profissional where id_profissional = '$id'";
            $resultado = $conexao->prepare($sql);
            if($resultado->execute()){
                $x=$resultado->fetchAll();
            }
            foreach ($x as $dado) {
                // Horário de início e final da manhã
                $inicioManha = strtotime($dado['inicio_manha']);
                $finalManha = strtotime($dado['final_manha']);

                // Horário de início e final da tarde
                $inicioTarde = strtotime($dado['inicio_tarde']);
                $finalTarde = strtotime($dado['final_tarde']);    
            }
            $sql = "select * from profissionais where id_profissional = '$id'";
            $resultado = $conexao->prepare($sql);
            if($resultado->execute()){
                $x=$resultado->fetchAll();
            }
            foreach ($x as $dado) {
                $tempoAtendimento = $dado['tempo_atendimento'];
            }
            // ID do médico e tempo de atendimento
            $idMedico = 1;// minutos

            

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




<?php 
session_start();
if(isset($_SESSION['cpf']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf'];
require_once("head.php");
include "menu.php";
include "navibar.php";

?>

<script>
        $(document).ready(function() {
            // Quando o usuário digitar algo no input, acionamos a função de busca
            $('#acs_input').on('input', function() {
                var term = $(this).val();
                if (term.length >= 3) {
                    // Realizamos a solicitação AJAX para buscar os procedimentos
                    $.ajax({
                        url: '../buscar/buscar_acs.php',
                        type: 'GET',
                        data: {term: term},
                        dataType: 'json',
                        success: function(data) {
                            // Limpa o datalist antes de preencher com as novas opções
                            $('#acs_list').empty();

                            // Preenche o datalist com as opções retornadas pela busca
                            data.forEach(function(acs) {
                                $('#acs_list').append('<option value="' + acs + '">');
                            });
                        }
                    });
                }
            });
        });
    </script>