﻿<?php
session_start();
if (!isset($_SESSION['cpf_agendar'])) {
    header("Location:../index.php");
    exit();
}
$cpf_logado = $_SESSION['cpf_agendar'];

require_once("head.php");
include "menu_agendamento.php";
include "navibar_agendar.php";
include "../footer.php";

require_once("../conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM agendamento WHERE id_agendamento = :id";
$resultado = $conexao->prepare($sql);
$resultado->bindParam(':id', $id, PDO::PARAM_INT);

if ($resultado->execute()) {
    $agendamento = $resultado->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Erro ao coletar os dados";
    exit();
}
?>

<script src="../mascara.js"></script>
<h4 class="mb-4">EDITAR AGENDAMENTO</h4>
<form method="POST" action="editar_agendamento.php">
    <div class="row">
        <div class="col">
            <label class="form-label" style="font-size:12px;">PROFISSIONAL</label>
            <select name="profissional" id="profissional" class="form-control form-control-lg" onchange="carregarDatas()" style="font-size:12px;">
                <?php
                $selectedProfissional = $agendamento['cod_profissional'];
                $sql = "SELECT id_profissional, nome FROM profissionais";
                $stmt = $conexao->prepare($sql);
                $stmt->execute();
                $profissionais = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($profissionais as $profissional) {
                    $selected = ($profissional['id_profissional'] == $selectedProfissional) ? 'selected' : '';
                    echo "<option value=\"{$profissional['id_profissional']}\" $selected>{$profissional['nome']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col">
            <label class="form-label" style="font-size:12px;">DATA DE ATENDIMENTO</label>
            <select class="form-control form-control-lg" name="data_atendimento" id="dia" onchange="carregarHorarios()"style="font-size:12px;">
                <option value="<?php echo $agendamento['data_atendimento']; ?>">
                <?php
                $d = date('d/m/Y', strtotime($agendamento['data_atendimento']));
                 echo $d; 

                 ?>
                 </option>
                 <option disabled value="" style="font-size:12px;">Datas disponíveis:</option>
                 <?php

                 $sql9 = "select * from agenda_profissional where id_profissional = '$selectedProfissional'";
                 $resultado9 = $conexao->prepare($sql9);
                if ($resultado9->execute()) {
                     $x = $resultado9->fetchAll();
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
        <div class="col">
            <label class="form-label">HORA</label>
            <select class="form-control form-control-lg" name="horario" id="horario" style="font-size:12px;" required>
                <option value = "<?= $agendamento['hora'] ?>"> <?= $agendamento['hora'] ?> </option>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <label class="form-label" style="font-size:12px;">NOME DO PACIENTE</label>
            <div class="form-outline mb-4">
                <input type="text" name="nome_paciente" class="form-control form-control-lg"
                    value="<?php echo $agendamento["nome_paciente"]; ?>" style="font-size:12px;"/>
            </div>
        </div>
        <div class="col">
            <label class="form-label" style="font-size:12px;">SEXO</label>
            <div class="form-outline mb-4">
                <select required class="form-control form-control-lg" style="font-size:12px;" name="sexo">
                <option value="MASCULINO" <?php if ($agendamento['sexo'] === 'MASCULINO') echo 'selected'; ?>>MASCULINO</option>
                    <option value="FEMININO" <?php if ($agendamento['sexo'] === 'FEMININO') echo 'selected'; ?>>FEMININO</option>
                </select>
            </div>
        </div>
       
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" style="font-size:12px;">ENDEREÇO RESIDENCIAL</label>
        <input type="text" name="endereco" class="form-control form-control-lg"
            value="<?php echo $agendamento['endereco']; ?>" style="font-size:12px;"/>
    </div>

    <div class="row">
        <div class="form-outline mb-4 col">
            <label class="form-label" style="font-size:12px;">CPF</label>
            <input type="text" name="cpf" class="form-control form-control-lg"
                value="<?php echo $agendamento["cpf"]; ?>" style="font-size:12px;"/>
        </div>
        <div class="col">
            <label class="form-label" style="font-size:12px;">STATUS</label>
            <div class="form-outline mb-4">
                <select required class="form-control form-control-lg" style="font-size:12px;" name="status">
                    <option value="0" <?php if ($agendamento['status'] === 0) echo 'selected'; ?>>Agendado</option>
                    <option value="1" <?php if ($agendamento['status'] === 1) echo 'selected'; ?>>Compareceu</option>
                    <option value="2" <?php if ($agendamento['status'] === 2) echo 'selected'; ?>>Não Compareceu</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label class="form-label" style="font-size:12px;">ENDEREÇO DO ATENDIMENTO</label>
            <div class="form-outline mb-4">
                <input type="text" name="endereco_local" class="form-control form-control-lg"
                    value="<?php echo $agendamento["endereco_local"]; ?>" style="font-size:12px;"/>
            </div>
        </div>
        <div class="col">
            <label class="form-label" style="font-size:12px;">LOCAL DO ATENDIMENTO</label>
            <div class="form-outline mb-4">
                <input type="text" name="local_atendimento" class="form-control form-control-lg"
                    value="<?php echo $agendamento["local_atendimento"]; ?>" style="font-size:12px;"/>
            </div>
        </div>
    </div>
    <input type="hidden" name = "cpf_logado" value = "<?php echo $cpf_logado; ?>">     
    <input type="hidden" name="cod" value="<?php echo $agendamento['cod_profissional']; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <button class="btn btn-primary " type="submit" style="font-size:10px;">SALVAR</button>
    <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger" style="color:white; font-size:10px;" href="tabela_agendamento.php?id=<?php echo $agendamento['cod_profissional']; ?>">VOLTAR</a>
</form>

<script>
    function carregarDatas() {
            var profissionalSelecionado = document.getElementById("profissional").value;
            var dataSelect = document.getElementById("dia");

            // Limpar a lista de datas
            dataSelect.innerHTML = "<option value=''>Selecione uma data</option>";

            // Realizar uma solicitação AJAX para obter as datas disponíveis
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "obter_datas_profissional.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Adicionar o profissional selecionado como um parâmetro na solicitação POST
            var data = "profissional=" + profissionalSelecionado;

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var datasDisponiveis = JSON.parse(xhr.responseText);

                    // Preencher a lista de datas com base na resposta do servidor
                    for (var i = 0; i < datasDisponiveis.length; i++) {
                        var option = document.createElement('option');
                        option.value = datasDisponiveis[i];
                        option.text = datasDisponiveis[i];
                        dataSelect.appendChild(option);
                    }
                }
            };

            xhr.send(data);
        }
    function carregarHorarios() {
        var diaSelecionado = document.getElementById("dia").value;
        var horarioSelect = document.getElementById("horario");

        // Limpar a lista de horários
        horarioSelect.innerHTML = "<option value=''>Selecione um horário</option>";

        var idProfissional = document.getElementById("profissional").value;

        
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