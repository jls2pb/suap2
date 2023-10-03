<?php 
session_start();
if(isset($_SESSION['cpf_cad_ag']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf_cad_ag'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";

require_once("../conexao.php");
$id = $_GET['id'];
$sql = "SELECT * FROM profissionais WHERE id_profissional = $id";
$resultado = $conexao->prepare($sql);


if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>
<script src="../mascara.js"></script>
<h2 class="mb-4">EDITAR PROFISSIONAL</h2>
<form method = "POST" action = "editar_profissional.php">  
            <?php 
                foreach ($x as $y) {                    
            ?>
            
            <div class="form-outline mb-4">
            <label class="form-label">NOME</label>
            <input type="text" name = "nome" class="form-control form-control-lg" value = "<?php echo $y["nome"]; ?>" />
            </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">ÁREA</label>
                    </div>
                    <div class="col">
                        <label class="form-label">TEMPO DE ATENDIMENTO</label>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "area" class="form-control form-control-lg" value = "<?php echo $y["area"]; ?>" />
                        </div>
                    </div>
                  
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="number" name = "tempo_atendimento" class="form-control form-control-lg" value = "<?php echo $y['tempo_atendimento']; ?>" />
                        </div>
                    </div>
                </div>
           
                    <div class="col">
                     
                <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                <?php
                }
                ?>
                
                <button class="btn btn-primary " type="submit">SALVAR</button>
               <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger" style = "color:white" href="inicio_agendamento.php">VOLTAR</a>
            </div>
            </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Quando o usuário digitar algo no input, convertemos para maiúsculas
        $('input').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>