<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("head.php");
session_start();
if (isset($_SESSION['cpf_caps']) == FALSE) {
    header("Location:../index.php");
}
$id = $_GET['id'];
$cpf_logado = $_SESSION['cpf_caps'];
?>

<?php
include "head.php";
include "navibar.php";

include "../footer.php";
?> <script src="../mascara.js"></script>
<h2 class="mb-4">CADASTRO DE AGENDAMENTO</h2>
<form method="POST" action="registro_agendamento.php">
<div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">NOME DO PACIENTE: </label>
            <input type="text" name="paciente" class="form-control form-control-lg" oninput="handleInput(event)" id="paciente_input" list="paciente_list">
            <datalist id="paciente_list"></datalist>
        </div>
    </div>
     
    <div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">SEXO: </label>
            <select class="form-control form-control-lg" name = "sexo">
            <option selected disabled value = ""> Selecione o sexo </option>
                <option value = "M"> MASCULINO </option>
                <option value = "F"> FEMININO </option>
            </select>    
        </div>
        </div>

        <div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">ENDEREÇO RESIDENCIAL</label>
            <input type="text" name="endereco" class="form-control form-control-lg" oninput="handleInput(event)" id="endereco_input">
        </div>
        </div>      
    <div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">PROCEDIMENTO: </label>
            <select class="form-control form-control-lg" name="procedimento" id="procedimento">
                <option  value="">Selecione um procedimento</option>
            </select>
        </div>
    </div>
    <input type="hidden" name="cpf" id="cpf">
    <input type="hidden" name="cod" id="cod">

    <div class="col-4">
    <div class="form-outline mb-4">
        <label class="form-label">DIA DO ATENDIMENTO: </label>
        <select class="form-control form-control-lg" name="dia" id="dia" onchange="carregarHorarios()">
        <option selected disabled value = "">Selecione uma data</option>
            <?php
            // Conexão com o banco de dados
            include "../conexao.php";
            $sql = "select * from agenda_profissional where id_profissional = '$id'";
            $resultado = $conexao->prepare($sql);
           if ($resultado->execute()) {
                $x = $resultado->fetchAll();
                $dataAtual = date('Y-m-d'); // Obtém a data atual no formato SQL (AAAA-MM-DD)
                foreach ($x as $dado) {
                    $dataDisponivel = $dado['dia']; // Data disponível no formato SQL (AAAA-MM-DD)
                    
                    // Verifique se a data disponível é posterior à data atual
                    if ($dataDisponivel >= $dataAtual) {
                        $formattedDate = date('d/m/Y', strtotime($dataDisponivel));
                        echo "<option value=\"$dataDisponivel\">$formattedDate</option>";
                    }
                }
            }
            ?>
        </select>
    </div>
</div>
<div class="col-4">
    <div class="form-outline mb-4">
        <label class="form-label">HORARIO DO ATENDIMENTO: </label>
        <select class="form-control form-control-lg" name="horario" id="horario" required>
            <!-- Opções de horário serão carregadas dinamicamente aqui -->
        </select>
    </div>
</div>
<div class="col-4">
    <div class="form-outline mb-4">
    <label class="form-label">LOCAL DO ATENDIMENTO: </label>
        <input type="text" name = "l_agendamento" list="local_list" oninput="handleInput(event)" id = "l_agendamento" class="form-control form-control-lg" />
		<datalist id="local_list"></datalist>
    </div>
</div>
<div class="col-4">
        <div class="form-outline mb-4">
            <label class="form-label">ENDEREÇO LOCAL DE ATENDIMENTO: </label>
            <input type="text" name="endereco_local" class="form-control form-control-lg"  oninput="handleInput(event)" id="enderecolocal_input" list="">
        </div>
</div> 

<input type = "hidden" name = "cod_profissional" value = "<?php echo $id; ?>">
<button class="btn btn-primary" type = "submit">CADASTRAR</button>
<a class="btn btn-danger" role="button" href="tabela_agendamento.php?id=<?php echo $id; ?>">VOLTAR</a>

</form>

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
                        //aaa
                        $('#procedimento').append('<option value="' + procedimento.id + '">' + procedimento.procedimento + '</option>');
                    });
                }
            });
        }
        
    });
</script>

<script>
    // Defina o valor de $id como uma variável JavaScript
    var idProfissional = <?php echo $id; ?>;
</script>

<script>
    function carregarHorarios() {
    var diaSelecionado = document.getElementById("dia").value;
    var horarioSelect = document.getElementById("horario");

    // Limpar a lista de horários
    horarioSelect.innerHTML = "<option value=''>Selecione um horário</option>";

    // Realizar uma solicitação AJAX para obter os horários disponíveis
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "obter_horarios.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Adicione idProfissional como um parâmetro na solicitação POST
    var data = "dia=" + diaSelecionado + "&idProfissional=" + idProfissional;

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var horariosDisponiveis = JSON.parse(xhr.responseText);

            // Preencher a lista de horários com base na resposta do servidor
            for (var i = 0; i < horariosDisponiveis.length; i++) {
                var option = document.createElement('option');
                option.value = horariosDisponiveis[i];
                option.text = horariosDisponiveis[i];
                horarioSelect.appendChild(option);
            }
        }
    };

    xhr.send(data);
}


</script>
<script>
        $(document).ready(function() {
            // Quando o usuário digitar algo no input, acionamos a função de busca
            $('#l_agendamento').on('input', function() {
                var term = $(this).val();
                if (term.length >= 3) {
                    // Realizamos a solicitação AJAX para buscar os procedimentos
                    $.ajax({
                        url: '../buscar/buscar_local.php',
                        type: 'GET',
                        data: {term: term},
                        dataType: 'json',
                        success: function(data) {
                            // Limpa o datalist antes de preencher com as novas opções
                            $('#local_list').empty();

                            // Preenche o datalist com as opções retornadas pela busca
                            data.forEach(function(nome_fantasia) {
                                $('#local_list').append('<option value="' + nome_fantasia + '">');
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        // Quando o usuário digitar algo no input, convertemos para maiúsculas
        $('#enderecolocal_input, #endereco_input').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Quando o usuário escolher um local de atendimento
        $('#l_agendamento').on('change', function () {
            var localSelecionado = $(this).val();
            
            // Realize uma solicitação AJAX para buscar o endereço correspondente
            $.ajax({
                url: '../buscar/buscar_endereco_local.php', // Substitua pelo URL correto para buscar o endereço
                type: 'GET',
                data: { local: localSelecionado },
                dataType: 'json',
                success: function (data) {
                    // Atualize o campo "ENDEREÇO LOCAL DE ATENDIMENTO" com o endereço encontrado
                    if (data && data.endereco_local) {
                        $('#enderecolocal_input').val(data.endereco_local);
                    } else {
                        // Caso não seja encontrado um endereço correspondente, limpe o campo
                        $('#enderecolocal_input').val('');
                    }
                }
            });
        });
    });
</script>
