<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("head.php");
session_start();
if (isset($_SESSION['cpf']) == FALSE) {
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf'];
$nome = $_SESSION['id'];
$id = $_GET['id'];
?>

<?php
include "head.php";
include "menu_agendamento.php";
include "navibar_agendar.php";
include "../footer.php";
?>
<h2 class="mb-4">CADASTRO DE AGENDAMENTO</h2>
<form method="POST" action="registro_procedimento.php">
    <div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">NOME DO PACIENTE</label>
            <input type="text" name="paciente" class="form-control form-control-lg" id="paciente_input" list="paciente_list">
            <datalist id="paciente_list"></datalist>
        </div>
    </div>
    <div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">PROCEDIMENTO</label>
            <select class="form-control form-control-lg" name="procedimento" id="procedimento">
                <option  value="">PROCEDIMENTO</option>
            </select>
        </div>
    </div>
    <input type="hidden" name="cpf" id="cpf">
    <input type="hidden" name="cod" id="cod">
    <div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">DIA DO ATENDIMENTO</label>
            <select class="form-control form-control-lg" name="dia" id="dia">
                <?php
                // Conexão com o banco de dados
                include "../conexao.php";
                $sql = "select * from agenda_profissional where id_profissional = '$id'";
                $resultado = $conexao->prepare($sql);
                if ($resultado->execute()) {
                    $x = $resultado->fetchAll();
                }
                foreach ($x as $dado) {
                    ?>
                    <option value="<?php echo $dado['dia']; ?>"><?php echo $dado["dia"]; ?></option>
                <?php }

                ?>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">HORARIO DO ATENDIMENTO</label>
            <select class="form-control form-control-lg" name="horario" required>
                <?php
                // Conexão com o banco de dados
                $sql = "select * from agenda_profissional where id_profissional = '$id'";
                $resultado = $conexao->prepare($sql);
                if ($resultado->execute()) {
                    $x = $resultado->fetchAll();
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
                if ($resultado->execute()) {
                    $x = $resultado->fetchAll();
                }
                foreach ($x as $dado) {
                    $tempoAtendimento = $dado['tempo_atendimento'];
                }

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
                ?>
            </select><br><br>
        </div>
    </div>
</form>

<script src="../mascara.js"></script>
<script>
    $(document).ready(function () {
        // Quando o usuário digitar algo no input, acionamos a função de busca
        $('#paciente_input').on('input', function () {
            var term = $(this).val();
            if (term.length >= 3) {
                // Realizamos a solicitação AJAX para buscar os pacientes
                $.ajax({
                    url: 'buscar_paciente.php',
                    type: 'GET',
                    data: { term: term },
                    dataType: 'json',
                    success: function (data) {
                        // Limpa o datalist antes de preencher com as novas opções
                        $('#paciente_list').empty();

                        // Preenche o datalist com as opções retornadas pela busca
                        data.forEach(function (paciente) {
                            // Paciente é um objeto que contém nome, cpf e cod
                            $('#paciente_list').append('<option value="' + paciente.nome_paciente + '" data-cpf="' + paciente.cpf + '" data-cod="' + paciente.cod + '">');
                        });
                    }
                });
            }
        });

        // Quando uma opção é selecionada no datalist
        $('#paciente_input').on('blur', function () {
            // Se o valor selecionado está em cache
            if (this.list.querySelector("option[value='" + this.value + "']")) {
                var cpf = this.list.querySelector("option[value='" + this.value + "']").getAttribute('data-cpf');
                var cod = this.list.querySelector("option[value='" + this.value + "']").getAttribute('data-cod');

                // Atualize os valores dos campos de entrada com o CPF e o código
                $('#cpf').val(cpf);
                $('#cod').val(cod);

                // Atualize os procedimentos com base no código do paciente
                atualizarProcedimentos(cod);
            }
        });

        // Quando o usuário seleciona um paciente no datalist
        $('#paciente_input').on('change', function () {
            var selectedOption = this.querySelector("option:checked");

            if (selectedOption) {
                var cod = selectedOption.getAttribute('data-cod');

                // Atualize o campo de seleção de procedimentos com base no código (cod)
                atualizarProcedimentos(cod);
            }
        });

        function atualizarProcedimentos(cod) {
            // Realize uma solicitação AJAX para buscar os procedimentos com base no código (cod)
            $.ajax({
                url: 'buscar_procedimentos.php', // Substitua pelo URL correto para buscar procedimentos com base no código de paciente
                type: 'GET',
                data: { cod: cod },
                dataType: 'json',
                success: function (data) {
                    // Limpa o campo de seleção de procedimentos
                    $('#procedimento').empty();

                    // Preenche o campo de seleção de procedimentos com os procedimentos obtidos na consulta
                    data.forEach(function (procedimento) {
                        $('#procedimento').append('<option value="' + procedimento.procedimento + '">' + procedimento.procedimento + '</option>');
                    });
                }
            });
        }
    });
</script>
