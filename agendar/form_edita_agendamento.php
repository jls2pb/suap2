<?php 
session_start();
if(isset($_SESSION['cpf_agendar']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf_agendar'];
require_once("head.php");
include "menu_agendamento.php";
include "navibar_agendar.php";
include "../footer.php";

require_once("../conexao.php");
$id = $_GET['id'];
$sql = "SELECT * FROM agendamento WHERE id_agendamento = $id";
$resultado = $conexao->prepare($sql);


if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>
<script src="../mascara.js"></script>
<h2 class="mb-4">EDITAR AGENDAMENTO</h2>
<form method = "POST" action = "editar_agendamento.php">  
            <?php 
                foreach ($x as $y) {                    
            ?>
                <div class="row">
                    <div class="col">
                        <label class="form-label">PROFISSIONAL</label>
                        <select name="profissional" id="profissional" class="form-control form-control-lg">
            <?php
            $a = $y['cod_profissional'];
            $sql = "SELECT id_profissional, nome FROM profissionais";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $profissionais = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($profissionais as $profissional) {
                $selected = ($profissional['id_profissional'] == $a) ? 'selected' : '';
                echo "<option value=\"{$profissional['id_profissional']}\" $selected>{$profissional['nome']}</option>";
            }
            ?>
        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">DATA DE ATENDIMENTO</label>
                        <select class="form-control form-control-lg" name="dia" id="dia" onchange="carregarHorarios()">
        <option value = "<?php echo $y['data_atendimento']; ?>"> <?php echo $y['data_atendimento']; ?></option>
            <?php
            // Conexão com o banco de dados
            include "../conexao.php";
            $sql = "select * from agenda_profissional where id_profissional = '$a'";
            $resultado = $conexao->prepare($sql);
            if ($resultado->execute()) {
                $x = $resultado->fetchAll();
                foreach ($x as $dado) {
                    ?>
                    <option value="<?php echo $dado['dia']; ?>">
                    <?php 
                    $dia = date('d/m/Y', strtotime($dado['dia']));
                    echo $dia
                    
                    ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
                    <div class="col">
                        <label class="form-label">HORA</label>
                        <select class="form-control form-control-lg" name="horario" id="horario" required>
                            <!-- Opções de horário serão carregadas dinamicamente aqui -->
                        </select>
                    </div>
                </div>
                        <br>
                <div class="row">
                    <div class="col">
                        <label class="form-label">NOME DO PACIENTE</label>
                    </div>
                    <div class="col">
                        <label class="form-label">SEXO</label>
                    </div>
                    <div class="col">
                        <label class="form-label">CPF</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "nome_paciente" class="form-control form-control-lg" value = "<?php echo $y["nome_paciente"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <select required class="form-control form-control-lg" name = "sexo">
            <option selected disabled value = ""><?php echo $y['sexo'];?> </option>
                <option value = "M"> MASCULINO </option>
                <option value = "F"> FEMININO </option>
            </select>    
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "cpf" class="form-control form-control-lg" value = "<?php echo $y["cpf"]; ?>" />    
                        
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                <div class="form-outline mb-4">
                    <label class="form-label">ENDEREÇO RESIDENCIAL</label>
                    <input type="text" name = "endereco" class="form-control form-control-lg" value = "<?php echo $y['endereco']; ?>" />
=======
<div class="row">
                <div class="form-outline mb-4 col">
                    <label class="form-label">CPF</label>
                    <input type="text" name = "cpf" class="form-control form-control-lg" value = "<?php echo $y["cpf"]; ?>" />
>>>>>>> 1cb822481fa8da6ee537dea620c39a3850ed99b9
                </div>
                <div class="col">
                        <label class="form-label">STATUS</label>
                        <div class="form-outline mb-4">
                        <select required class="form-control form-control-lg" name = "status">
            <option selected disabled value = ""> O STATUS ATUAL É: <?php $status = $y["status"]; 
                    if ($status==0){
                        echo "Em espera";
                    }
                    else if ($status==1) {
                        echo "Compareceu";
                    }
                    else {
                        echo "Não Compareceu";
                    }
                    ?></option>
                <option value = "0"> Em espera </option>
                <option value = "1"> Compareceu </option>
                <option value = "2"> Não Compareceu </option>
            </select>    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">

                        <label class="form-label">ENDEREÇO DO ATENDIMENTO</label>

                    </div>
                    <div class="col">
                        <label class="form-label">LOCAL DO ATENDIMENTO</label>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "endereco_local" class="form-control form-control-lg" value = "<?php echo $y["endereco_local"]; ?>" />
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "local_atendimento" class="form-control form-control-lg" value = "<?php echo $y["local_atendimento"]; ?>" />
                        </div>
                    </div>
                </div>   
                    <input type = "hidden" name = "cod" value = "<?php echo $y['cod_profissional']; ?>">     
                <?php
                }
                ?>
                     
                <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                
                <button class="btn btn-primary " type="submit">SALVAR</button>
               <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger" style = "color:white" href="tabela_agendamento.php?id=<?php echo $y['cod_profissional'];?>">VOLTAR</a>
            
            </form>
    </div>
</div>

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


</script>1