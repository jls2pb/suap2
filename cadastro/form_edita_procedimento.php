<?php 
session_start(); 
if(!isset($_SESSION['cpf_cadastro'])){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf_cadastro'];
require_once("head.php");
include "menu.php";
include "navibar.php";
include "../footer.php";

if(isset($_SESSION['cpf_cadastro']) == FALSE){
    header("Location:../index.php");
}



require_once("../conexao.php");
$id = $_GET["id"];
$sql = "SELECT * FROM procedimentos WHERE id = $id ";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>

<h2 class="mb-4">EDIÇÃO DE PROCEDIMENTO</h2>
<form method = "POST" action = "edita_procedimento.php">  
<?php 

foreach ($x as $y) {
    if($y["data_da_solicitacao"] != NULL){
        $solicitacao = date('Y-m-d', strtotime($y["data_da_solicitacao"]));
    }else{
        $solicitacao = NULL;
    }
    if($y["data_de_entrada_cadastro"] != NULL){
        $entrada = date('Y-m-d', strtotime($y["data_de_entrada_cadastro"]));
    }else{
        $entrada = NULL;
    }
    if ($y["data_da_saida"] != NULL) {
        // Verifica se a data está no formato d/m/Y
      
        if (strpos($y["data_da_saida"], '-') !== false) {
            $saida = date('Y-m-d', strtotime($y["data_da_saida"]));
        } else {
              $data = DateTime::createFromFormat('d/m/Y', $y['data_da_saida']);
        $saida = $data->format('Y-m-d');
        }
    } else {
        $saida = NULL;
    }
    if($y["data_do_agendamento"] != NULL){
        $agendamento = date('Y-m-d', strtotime($y["data_do_agendamento"]));  
    }else{
        $agendamento = NULL;
    }
?>   <div class="form-outline mb-4">
<label class="form-label">Nome do Paciente</label>
<input type="text" name = "paciente" style="font-size:12px;" class="form-control form-control-lg" value = "<?php echo $y['nome_paciente'] ?>"  disabled=""/>
</div>

<div class="form-outline mb-4">
<label class="form-label">Profissional</label>
<input type="text" name = "profissional" style="font-size:12px;" class="form-control form-control-lg" value = "<?php echo $y['profissional'] ?>" />
</div>
<div class="row">
<div class="col-6">     
      <div class="form-outline mb-4">
        <label class="form-label">Procedimento</label>
        <input type="text" name = "procedimento" style="font-size:12px;" class="form-control form-control-lg" id="procedimento_input" list="procedimentos_list" oninput="handleInput(event)" value = "<?php echo $y['procedimento'] ?>">
    <datalist id="procedimentos_list"></datalist>
    </div>
</div>
    <div class="col">
        <div class="form-outline mb-4">
        <label class="form-label">Especificação</label>    
        <input type="text" name = "especificacao" style="font-size:12px;" oninput="handleInput(event)" class="form-control form-control-lg" value = "<?php echo $y['especificacao'] ?>"/>
    </div>
</div>
<div class="col">
        <label class="form-label">Status</label>
        <div class="form-outline mb-4">
<select class="form-control form-control-lg" name="status" id="status" style="font-size:12px;">
    <?php
    $query = "SELECT status FROM agendamento WHERE procedimento = $id";
    $result = $conexao->prepare($query);
    $result->execute();  

    $query1 = "SELECT status FROM procedimentos WHERE id = $id";
    $result1 = $conexao->prepare($query1);
    $result1->execute();

    $status = -1; 
    $statusTable = ""; 

    if ($result && $result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $status = $row['status'];
        $statusTable = "agendamento";
    } elseif ($result1 && $result1->rowCount() > 0) {
        $row1 = $result1->fetch(PDO::FETCH_ASSOC);
        $status = $row1['status'];
        $statusTable = "procedimentos";
    }
    ?>

    <?php if ($statusTable === "agendamento") : ?>
        <option value="0" <?php if ($status === 0) {echo 'selected';} ?>>Agendado</option>
        <option value="1" <?php if ($status === 1) {echo 'selected';} ?>>Compareceu</option>
        <option value="2" <?php if ($status === 2) {echo 'selected';} ?>>Não Compareceu</option>
    <?php elseif ($statusTable === "procedimentos") : ?>
        <option value="3" <?php if ($status === 3) {echo 'selected';} ?>>Aguardando agendamento</option>
        <option value="4" <?php if ($status === 4) {echo 'selected';} ?>>Devolvida à UAPS</option>
        <option value="5" <?php if ($status === 5) {echo 'selected';} ?>>Retirada do setor</option>
        <option value="6" <?php if ($status === 6) {echo 'selected';} ?>>Encaminhada à Policlínica Municipal</option>
        <option value="7" <?php if ($status === 7) {echo 'selected';} ?>>Encaminhada ao HGLAS</option>
        <option value="8" <?php if ($status === 8) {echo 'selected';} ?>>Encaminhada ao CAPS</option>
        <option value="9" <?php if ($status === 9) {echo 'selected';} ?>>Encaminhada ao CER</option>
    <?php endif; ?>

</select>

</div>
    </div>
</div>

<div class="row">
    <div class="col">
        <label class="form-label">Data da Solicitação</label>
    </div>
    <div class="col">
        <label class="form-label">Data de Entrada(Cadastro)</label>
    </div>
    <div class="col">
        <label class="form-label">Data de Saida </label>
    </div>
    <div class="col">
        <label class="form-label">Data do Agendamento</label>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-outline mb-4">
        <input type="date" style="font-size:12px;" name = "d_solicitacao" class="form-control form-control-lg" value = "<?php echo $solicitacao ?>"/>
        </div>
    </div>
    <div class="col">
        <div class="form-outline mb-4">
        <input type="date" style="font-size:12px;" name = "d_entrada" class="form-control form-control-lg" value = "<?php echo $entrada ?>" />
        </div>
    </div>
    <div class="col">
        <div class="form-outline mb-4">
        <input type="date" style="font-size:12px;" name = "d_saida" class="form-control form-control-lg" value = "<?php echo $saida ?>"/>
        </div>
    </div>
    <div class="col">
        <div class="form-outline mb-4">
        <input type="date" style="font-size:12px;" name = "d_agendamento" class="form-control form-control-lg" value = "<?php echo $agendamento ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <label class="form-label">Local do Agendamento</label>
    </div>
    <div class="col">
        <label class="form-label">Observações</label>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-outline mb-4">
            <input type="text" style="font-size:12px;" name = "l_agendamento" class="form-control form-control-lg" value = "<?php echo $y['local_do_agendamento'] ?>"/>
        </div>
    </div>
    <div class="col">
        <div class="form-outline mb-4">
            <input type="text" style="font-size:12px;" name = "obs" class="form-control form-control-lg" value = "<?php echo $y['observacao'] ?>"/>
        </div>
    </div>

</div>
<div class="form-outline mb-4">
    
    
</div>
<div class="form-outline mb-4">
<input type = "hidden" name = "cod" value = "<?php echo $y['cod'] ?>" >    
<input type = "hidden" name = "n_paciente" value = "<?php echo $y['nome_paciente'] ?>" >
<input type = "hidden" name = "id" value = "<?php echo $y['id'] ?>" >
<input type = "hidden" name = "cpf_logado" value = "<?php echo $cpf_logado ?>">     
<?php 
}
?>  
    
</div>
<button class="btn btn-primary" style="font-size:10px;" type="submit">SALVAR</button>

<a class="btn btn-danger text-white link-offset-2 link-underline link-underline-opacity-0" style="font-size:10px;color:white" href="listar.php">VOLTAR</a>
            </div>
            </form>
    </div>
</div>
<script src="../mascara.js"></script>
<script>
        $(document).ready(function() {
            // Quando o usuário digitar algo no input, acionamos a função de busca
            $('#procedimento_input').on('input', function() {
                var term = $(this).val();
                if (term.length >= 3) {
                    // Realizamos a solicitação AJAX para buscar os procedimentos
                    $.ajax({
                        url: '../buscar/buscar_procedimentos.php',
                        type: 'GET',
                        data: {term: term},
                        dataType: 'json',
                        success: function(data) {
                            // Limpa o datalist antes de preencher com as novas opções
                            $('#procedimentos_list').empty();

                            // Preenche o datalist com as opções retornadas pela busca
                            data.forEach(function(procedimento) {
                                $('#procedimentos_list').append('<option value="' + procedimento + '">');
                            });
                        }
                    });
                }
            });
        });
    </script>