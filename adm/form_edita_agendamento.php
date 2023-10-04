<?php
session_start();
if (!isset($_SESSION['cpf_adm'])) {
    header("Location:../index.php");
    exit();
}
$cpf_logado = $_SESSION['cpf_adm'];

require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
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
<h2 class="mb-4">EDITAR AGENDAMENTO</h2>
<form method="POST" action="editar_agendamento.php">
    <div class="row">
        <div class="col">
            <label class="form-label">PROFISSIONAL</label>
            <select name="profissional" id="profissional" class="form-control form-control-lg" onchange="carregarDatas()">
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
            <label class="form-label">DATA DE ATENDIMENTO</label>
            <select class="form-control form-control-lg" name="data_atendimento" id="dia" onchange="carregarHorarios()">
                <option value="<?php echo $agendamento['data_atendimento']; ?>">
                <?php
                $d = date('d/m/Y', strtotime($agendamento['data_atendimento']));
                 echo $d; 
                 ?>
                 </option>
            </select>
        </div>
        <div class="col">
            <label class="form-label">HORA</label>
            <select class="form-control form-control-lg" name="horario" id="horario" required>
                <option value = "<?= $agendamento['hora'] ?>"> <?= $agendamento['hora'] ?> </option>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <label class="form-label">NOME DO PACIENTE</label>
            <div class="form-outline mb-4">
                <input type="text" name="nome_paciente" class="form-control form-control-lg"
                    value="<?php echo $agendamento["nome_paciente"]; ?>" />
            </div>
        </div>
        <div class="col">
            <label class="form-label">SEXO</label>
            <div class="form-outline mb-4">
                <select required class="form-control form-control-lg" name="sexo">
                    <option selected disabled value=""><?php echo $agendamento['sexo']; ?> </option>
                    <option value="M">MASCULINO</option>
                    <option value="F">FEMININO</option>
                </select>
            </div>
        </div>
       
    </div>

    <div class="form-outline mb-4">
        <label class="form-label">ENDEREÇO RESIDENCIAL</label>
        <input type="text" name="endereco" class="form-control form-control-lg"
            value="<?php echo $agendamento['endereco']; ?>" />
    </div>

    <div class="row">
        <div class="form-outline mb-4 col">
            <label class="form-label">CPF</label>
            <input type="text" name="cpf" class="form-control form-control-lg"
                value="<?php echo $agendamento["cpf"]; ?>" />
        </div>
        <div class="col">
            <label class="form-label">STATUS</label>
            <div class="form-outline mb-4">
                <select required class="form-control form-control-lg" name="status">
                    <option selected disabled value=''>
                        O STATUS ATUAL É:
                        <?php
                        $status = $agendamento["status"];
                        if ($status == 0) {
                            echo "Em espera";
                        } else if ($status == 1) {
                            echo "Compareceu";
                        } else {
                            echo "Não Compareceu";
                        }
                        ?>
                    </option>
                    <option value="0">Em espera</option>
                    <option value="1">Compareceu</option>
                    <option value="2">Não Compareceu</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label class="form-label">ENDEREÇO DO ATENDIMENTO</label>
            <div class="form-outline mb-4">
                <input type="text" name="endereco_local" class="form-control form-control-lg"
                    value="<?php echo $agendamento["endereco_local"]; ?>" />
            </div>
        </div>
        <div class="col">
            <label class="form-label">LOCAL DO ATENDIMENTO</label>
            <div class="form-outline mb-4">
                <input type="text" name="local_atendimento" class="form-control form-control-lg"
                    value="<?php echo $agendamento["local_atendimento"]; ?>" />
            </div>
        </div>
    </div>
    <input type="hidden" name="cod" value="<?php echo $agendamento['cod_profissional']; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="cpf_logado" value="<?php echo $cpf_logado; ?>">
    <button class="btn btn-primary " type="submit">SALVAR</button>
    <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger"
        style="color:white"
        href="tabela_agendamento.php?id=<?php echo $agendamento['cod_profissional']; ?>">VOLTAR</a>
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