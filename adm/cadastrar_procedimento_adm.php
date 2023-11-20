<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf_adm']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf_adm'];
$nome = $_SESSION['id'];

$n = $_GET["n"];
?>
<?php 
include "head.php";
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";
?>
<h4 class="mb-4">CADASTRO DE PROCEDIMENTO</h4>
<form method = "POST" action = "registro_procedimento_adm.php">  
            <div class="form-outline mb-4">
            <label class="form-label"style="font-size:12px;" >Nome do Paciente</label>
            <input type="text" name = "paciente" class="form-control form-control-lg" value = "<?php echo $n ?>"  disabled="" style="font-size:12px;"/>
            </div>

            <div class="form-outline mb-4">
            <label class="form-label" style="font-size:12px;">Profissional</label>
            <input type="text" name = "profissional" class="form-control form-control-lg" oninput="handleInput(event)"style="font-size:12px;"/>
            </div>
            <div class="row">
                <div class="col-8">     
          	        <div class="form-outline mb-4">
                        <label class="form-label" style="font-size:12px;">Procedimento</label>
                        <input type="text" name = "procedimento" class="form-control form-control-lg" style="font-size:12px;" id="procedimento_input" list="procedimentos_list" oninput="handleInput(event)" placeholder="Digite o procedimento..." required> 
                    <datalist id="procedimentos_list"></datalist> 
		            </div>
                </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <label class="form-label" style="font-size:12px;">Especificação</label>    
                        <input type="text" name = "especificacao" oninput="handleInput(event)" class="form-control form-control-lg" style="font-size:12px;"/>
                    </div>
                </div>
            </div>            
                    <br>

                <div class="row">
                    <div class="col">
                        <label class="form-label"style="font-size:12px;" >Data da Solicitação</label>
                    </div>
                    <div class="col">
                        <label class="form-label"style="font-size:12px;">Data de Entrada(Cadastro)</label>
                    </div>
                    <div class="col">
                        <label class="form-label"style="font-size:12px;">Data de Saida </label>
                    </div>
                    <div class="col">
                        <label class="form-label"style="font-size:12px;">Data do Agendamento</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_solicitacao" class="form-control form-control-lg" style="font-size:12px;"required/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_entrada" class="form-control form-control-lg" style="font-size:12px;"required/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_saida" class="form-control form-control-lg" style="font-size:12px;"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_agendamento" class="form-control form-control-lg" style="font-size:12px;"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label"style="font-size:12px;">Local do Agendamento</label>
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-size:12px;">Observações</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                            <input type="text" name = "l_agendamento" list="local_list" oninput="handleInput(event)" id = "l_agendamento" class="form-control form-control-lg" style="font-size:12px;"/>
			                <datalist id="local_list"></datalist>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                            <input type="text" name = "obs" class="form-control form-control-lg" style="font-size:12px;" />
                        </div>
                    </div>

                </div>
                <div class="form-outline mb-4">
                    
                    
                </div>
                <div class="form-outline mb-4">
                    
                    
                </div>
                <input type = "hidden" name = "n" value = "<?php echo $n; ?>" >
                <input type = "hidden" name = "n_paciente" value = "<?php echo $nome; ?>" >
                <input type = "hidden" name = "cpf_logado" value = "<?php echo $cpf_logado; ?>" >
                <button class="btn btn-primary " type="submit"style="font-size:10px;">CADASTRAR</button>
                <button class="btn btn-danger "><a class="link-offset-2 link-underline link-underline-opacity-0" style = "color:white; font-size:10px;" href="listar_adm.php">VOLTAR</a></button>    
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
                        url: '../buscar/buscar_procedimento_medico.php',
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