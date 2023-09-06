<?php 
require_once("head.php");
require_once("../conexao.php");
$id = $_POST["id"];
$cpf_logado = $_POST["cpf"];
$sql = "SELECT * FROM procedimentos WHERE id = $id";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>
<body style="background-color: #508bfc;">
<section class="vh-100" style="background-color: #508bfc;">

<div class="container py-5 h-100">
  
  <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="container">
      <div class="card shadow-2-strong" style="border-radius: 1rem;">
        <div class="card-body p-5">
          <h3 class="mb-5 text-center"> AGENDAMENTO </h3>
          <form method = "POST" action = "edita_procedimento.php">  
          <?php 
                foreach ($x as $y) {
            ?>
            <div class="form-outline mb-4">
            <label class="form-label">Nome do Paciente</label>
            <input type="text" name = "paciente" class="form-control form-control-lg" value = "<?php echo $y['nome_paciente'] ?>"  disabled=""/>
            </div>

            <div class="form-outline mb-4">
            <label class="form-label">Profissional</label>
            <input type="text" name = "profissional" class="form-control form-control-lg" value = "<?php echo $y['profissional'] ?>" />
            </div>

            <div class="form-outline mb-4">
            <label class="form-label">Procedimento</label>
            <input type="text" name = "procedimento" class="form-control form-control-lg" id="procedimento_input" list="procedimentos_list" oninput="handleInput(event)" value = "<?php echo $y['procedimento'] ?>">

            <datalist id="procedimentos_list"></datalist>

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
                        <input type="date" name = "d_solicitacao" class="form-control form-control-lg" value = "<?php echo $y['data_da_solicitacao'] ?>"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_entrada" class="form-control form-control-lg" value = "<?php echo $y['data_de_entrada_cadastro'] ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_saida" class="form-control form-control-lg" value = "<?php echo $y['data_da_saida'] ?>"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "d_agendamento" class="form-control form-control-lg" value = "<?php echo $y['data_do_agendamento'] ?>"/>
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
                <input type = "hidden" name = "n_paciente" value = "<?php echo $y['nome_paciente'] ?>" >
                <input type = "hidden" name = "id" value = "<?php echo $y['id'] ?>" >
                <input type = "hidden" name = "cpf_logado" value = "<?php echo $cpf_logado ?>">     
                <?php 
            }
            ?> 
                 <a href="#" onclick="window. print();"> <i class="bi bi-printer"></i> </a>  
                </div>
                </div>
            </form>  
        </div>
            <button class="btn btn-danger btn-lg btn-block"><a class="link-offset-2 link-underline link-underline-opacity-0" style = "color:white" href="listar.php?id=<?php echo $y['nome_paciente'] ?>&cpf=<?php echo $cpf_logado ?>">VOLTAR</a></button>    
            
    </div>
  </div>
</div>
<script src="mascara.js"></script>
</section>

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