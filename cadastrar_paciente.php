 <?php 
session_start();
if(isset($_SESSION['cpf']) == FALSE){
    header("Location:index.php");
}
include "menu.php";
include "navibar.php";
include "footer.php";


$cpf_logado = $_SESSION['cpf'];
require_once("head.php");
require_once("conexao.php");
$sql = "SELECT * FROM uaps ORDER BY nome_uaps ASC";
$resultado = $conexao->prepare($sql);
$resultado->execute();
?>
<h3 class="mb-5 text-center"> CADASTRO DE PACIENTE </h3>
<form method = "POST" action = "registro_paciente.php">  
<div class="form-outline mb-4">
            <label class="form-label">Nome do Paciente *</label>
            <input type="text" name="n_paciente" class="form-control form-control-lg" id="n_paciente" list="paciente_list" oninput="handleInput(event)" placeholder="Digite o nome do paciente...">
            <ul id="resultado"></ul>  
            </div>

                <div class="row">
                    <div class="col">
                        <label class="form-label">RG</label>
                    </div>
                    <div class="col">
                        <label class="form-label">CPF </label>
                    </div>
                    <div class="col">
                        <label class="form-label">CNS </label>
                    </div>
                    <div class="col">
                        <label class="form-label">Data de Nascimento *</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "rg" class="form-control form-control-lg" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" id = "cpf" name = "cpf" class="form-control form-control-lg" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" id = "cns" name = "cns" class="form-control form-control-lg" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "nascimento" id = nascimento  class="form-control form-control-lg" required/>
                        </div>
                    </div>
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label">Nome da Mãe *</label>
                    <input type="text" name = "n_mae" id = "n_mae"  class="form-control form-control-lg" oninput="handleInput(event)" required/>
                </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">ACS</label>
                    </div>
                    <div class="col">
                        <label class="form-label">UBS</label>
                    </div>
                    <div class="col">
                        <label class="form-label">CELULAR</label>
                    </div>
                    <div class="col">
                        <label class="form-label">TELEFONE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "acs" class="form-control form-control-lg" id="acs_input" list="acs_list" oninput="handleInput(event)">
                        <datalist id="acs_list"></datalist>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                            <select class="form-control form-control-lg" name = "ubs" id="ubs">
			    	<option value = ""> SELECIONE A UNIDADE </option>
                            <?php 
                            foreach ($resultado as $r) {
                             ?>
                                <option value = "<?php echo $r['nome_uaps']; ?>"> <?php echo $r["nome_uaps"]; ?></option>
                             <?php
                            }
                            ?>  
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" id = "cel" name = "cel" class="form-control form-control-lg" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" id = "tel" name = "tel" class="form-control form-control-lg" />
                        </div>
                    </div>
                </div>
                <input type = "hidden" name = "cpf_logado" value = "<?php echo $cpf_logado?>">
                <button class="btn btn-primary " type="submit">CADASTRAR</button>
                <button class="btn btn-danger "><a class="link-offset-2 link-underline link-underline-opacity-0" style = "color:white" href="inicio.php">VOLTAR</a></button>    
            </div>
            </form>






    </div>
</div>
<script src="mascara.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    new FormMask(document.querySelector("#cpf"), "___.___.___-__", "_", [".", "-"])
    new FormMask(document.querySelector("#cel"), "(__)_____-____", "_", ["(", ")", "-"])
    new FormMask(document.querySelector("#tel"), "(__)_____-____", "_", ["(", ")", "-"])
</script>
<script>
        $(document).ready(function() {
            $('#n_paciente').on('input', function() {
                var term = $(this).val();
                if (term.length >= 3) {
                    $.ajax({
                        url: 'buscar_cidadao.php',
                        type: 'GET',
                        data: {term: term},
                        dataType: 'json',
                        success: function(data) {
                            $('#paciente_list').empty();
                            $('#resultado').empty();  // Limpar resultados anteriores

                            data.forEach(function(cidadao) {
                                $('#resultado').append('<li data-no_cidadao="' + cidadao.no_cidadao + '" data-nu_cpf="' + cidadao.nu_cpf + '" data-nu_cns="' + cidadao.nu_cns + '" data-dt_nascimento="' + cidadao.dt_nascimento +'" data-no_mae="' + cidadao.no_mae +'" data-nu_telefone_celular="' + cidadao.nu_telefone_celular +'" data-nu_telefone_contato="' + cidadao.nu_telefone_contato +'">' + cidadao.no_cidadao + " CPF :  "+cidadao.nu_cpf +" CNS : " +cidadao.nu_cns + '</li>');
                            });
                        }
                    });
                }
            });

            // Manipulador de clique para os itens de resultado
            $('#resultado').on('click', 'li', function() {
                var nome = $(this).data('no_cidadao');
                var cpf = $(this).data('nu_cpf');
                var cns = $(this).data('nu_cns');
                var nascimento = $(this).data('dt_nascimento');
                var no_mae = $(this).data('no_mae');
                var nu_telefone_celular = $(this).data('nu_telefone_celular');
                var nu_telefone_contato = $(this).data('nu_telefone_contato');
                $('#n_paciente').val(nome);
                $('#cpf').val(cpf);
                $('#cns').val(cns);
                $('#nascimento').val(nascimento);
                $('#n_mae').val(no_mae);
                $('#cel').val(nu_telefone_celular);
                $('#tel').val(nu_telefone_contato);
            });
        });
    </script>    
<script>
        $(document).ready(function() {
            // Quando o usuário digitar algo no input, acionamos a função de busca
            $('#acs_input').on('input', function() {
                var term = $(this).val();
                if (term.length >= 3) {
                    // Realizamos a solicitação AJAX para buscar os procedimentos
                    $.ajax({
                        url: 'buscar_acs.php',
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