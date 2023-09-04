<?php 
require_once("head.php");
session_start();
$id = $_POST["id"];
$cpf_logado = $_SESSION["cpf"];
include "head.php";
include "menu.php";
include "navibar.php";

require_once("conexao.php");

$sql = "SELECT * FROM procedimentos WHERE id = $id";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}



foreach ($x as $y) {
    $id_cid = $y["cod"];
    $sql2 = "select * from tabela where cod = '$id_cid'";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();
    $a = $resultado2->fetchAll();
    foreach ( $a as $b) {
        if($y["data_do_agendamento"] != NULL){
            $agendamento = date('d/m/Y', strtotime($y["data_do_agendamento"]));  
        }else{
            $agendamento = NULL;
        }
        ?>
        <form method="POST" action="agendar.php">
        <div class = "container">
            <center> <h3> AGENDAMENTO </h3> </center>
            <label> <strong> NOME DO PACIENTE: </strong> <?php echo $y["nome_paciente"];?></label><br>
            <input type="hidden" name="nome_paciente" value= "<?= $y["nome_paciente"]; ?>">
            <label> <strong> NOME DA MÃE: </strong> <?php echo $b["nome_da_mae"];?></label><br>
            <input type="hidden" name="nome_da_mae" value= "<?= $b["nome_da_mae"]; ?>">
            <label> <strong> Nº DO CARTÃO NACIONAL: </strong> <?php echo $b["cns"];?></label><br>
            <input type="hidden" name="cns" value= "<?= $b["cns"]; ?>">
            <label> <strong> DATA DE NASCIMENTO: </strong> <?php echo $b["nascimento"];?></label> <br>
            <input type="hidden" name="nascimento" value= "<?= $b["nascimento"]; ?>">
            <label for="sexo"> <strong> SEXO: </strong> </label><br>
            <input type="hidden" name="sexo" value= "<?= $y[""]; ?>">
            <label for="endereco"> <strong> ENDEREÇO RESIDENCIAL: </strong> </label> <br>
            <input type="hidden" name="endereco" value= "<?= $y[""]; ?>">
            <label> <strong> LOCAL DO AGENDAMENTO: </strong> <?php echo $y["local_do_agendamento"];?></label><br>
            <input type="hidden" name="local_do_agendamento" value= "<?= $y["local_do_agendamento"]; ?>">
            <label> <strong> ENDEREÇO: </strong> </label> <br>
            <input type="hidden" name="" value= "<?= $y[""]; ?>">
            <label> <strong> TELEFONE: </strong> </label><br>
            <input type="hidden" name="telefone" value= "<?= $y[""]; ?>">
             <label> <strong> COMPLEMENTO: </strong> </label> <br>
             <input type="hidden" name="complemento" value= "<?= $y[""]; ?>">
            <label> <strong> UNIDADE DE ORIGEM: </strong> <?php echo $b["ubs"];?></label><br>
            <input type="hidden" name="ubs" value= "<?= $b["ubs"]; ?>">
            <label> <strong> PROFISSIONAL: </strong> <?php echo $y["profissional"];?></label><br> 
            <input type="hidden" name="profissional" value= "<?= $y["profissional"]; ?>">
            <label> <strong> PROCEDIMENTO: </strong> <?php echo $y["procedimento"];?></label><br>
            <input type="hidden" name="procedimento" value= "<?= $y["procedimento"]; ?>">
            <label> <strong> ID DO PROCEDIMENTO: </strong> <?php echo $y["id"];?></label><br>
            <input type="hidden" name="id_procedimento" value= "<?= $y["id"]; ?>">
            <label> <strong> LOCAL DO ATENDIMENTO: </strong> </label> 
            <input type="text" name = "l_agendamento" list="local_list" oninput="handleInput(event)" id = "l_agendamento" class="form-control form-control-lg" />
			<datalist id="local_list"></datalist> 
             <br>
            <label> <strong> DATA DO ATENDIMENTO: </strong> </label> <input type = "date" class="form-control-plaintext" name = "dia_marcado"> <br>
            <label> <strong> HORARIO DO ATENDIMENTO: </strong> </label> <input type = "time" class="form-control-plaintext" name = "horario_marcado"> <br>
            <button type="submit" style="background-color: blue; color: white;"class="btn btn-primary">AGENDAR</button>
                <button class="btn btn-danger"  style = "color:white" formaction="listar.php">VOLTAR</button>
    </form>
        </div>    
        <?php
    }
}
?>
<script>
        $(document).ready(function() {
            // Quando o usuário digitar algo no input, acionamos a função de busca
            $('#l_agendamento').on('input', function() {
                var term = $(this).val();
                if (term.length >= 3) {
                    // Realizamos a solicitação AJAX para buscar os procedimentos
                    $.ajax({
                        url: 'buscar_local.php',
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