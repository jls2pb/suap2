<?php 

session_start(); 
$cpf_logado = $_SESSION['cpf_adm'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";



if(isset($_SESSION['cpf_adm']) == FALSE){
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
<form method = "POST" action = "edita_procedimento_adm.php">  
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
                    if($y["data_da_saida"] != NULL){
                        $saida = date('Y-m-d', strtotime($y["data_da_saida"])); 
                    }else{
                        $saida = NULL;
                    }
                    if($y["data_do_agendamento"] != NULL){
                        $agendamento = date('Y-m-d', strtotime($y["data_do_agendamento"]));  
                    }else{
                        $agendamento = NULL;
                    }
            ?>  
            <div class="form-outline mb-4">
            <label class="form-label">Nome do Paciente</label>
            <input type="text" name = "paciente" class="form-control form-control-lg" value = "<?php echo $y['nome_paciente'] ?>"  disabled=""/>
            </div>

            <div class="form-outline mb-4">
            <label class="form-label">Profissional</label>
            <input type="text" name = "profissional" class="form-control form-control-lg" value = "<?php echo $y['profissional'] ?>" />
            </div>
		<div class="row">
                <div class="col-8">     
          	        <div class="form-outline mb-4">
                        <label class="form-label">Procedimento</label>
                        <input type="text" name = "procedimento" class="form-control form-control-lg" id="procedimento_input" list="procedimentos_list" oninput="handleInput(event)" value = "<?php echo $y['procedimento'] ?>">
                    <datalist id="procedimentos_list"></datalist>
		            </div>
                </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <label class="form-label">Especificação</label>    
                        <input type="text" name = "especificacao" oninput="handleInput(event)" class="form-control form-control-lg" value = "<?php echo $y['especificacao'] ?>"/>
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
                        <input type="date" name = "d_solicitacao" class="form-control form-control-lg" value = "<?php echo $solicitacao ?>"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_entrada" class="form-control form-control-lg" value = "<?php echo $entrada ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_saida" class="form-control form-control-lg" value = "<?php echo $saida ?>"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_agendamento" class="form-control form-control-lg" value = "<?php echo $agendamento ?>"/>
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
                            <input type="text" name = "l_agendamento" class="form-control form-control-lg" value = "<?php echo $y['local_do_agendamento'] ?>"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                            <input type="text" name = "obs" class="form-control form-control-lg" value = "<?php echo $y['observacao'] ?>"/>
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
                <button class="btn btn-primary" type="submit">EDITAR</button>
            
                <button class="btn btn-danger"><a class="link-offset-2 link-underline link-underline-opacity-0" style = "color:white" href="listar_adm.php">VOLTAR</a></button>    
                
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