<?php 
session_start();
if(isset($_SESSION['cpf_cer']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf_cer'];
require_once("head.php");
include "navibar.php";
include "../footer.php";

require_once("../conexao.php");
$id = $_GET['id'];
$sql = "SELECT * FROM agenda_profissional WHERE id_agenda = $id";
$resultado = $conexao->prepare($sql);


if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>
<script src="../mascara.js"></script>
<h2 class="mb-4">EDITAR AGENDA</h2>
<form method = "POST" action = "editar_agenda.php">  
            <?php 
                foreach ($x as $y) {                    
            ?>
            
            <div class="form-outline mb-4">
            <label class="form-label">DIA DA AGENDA</label>
            <input type="date" name = "dia" class="form-control form-control-lg" value = "<?php echo $y["dia"]; ?>" />
            </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">INICIO DA MANHÃ</label>
                    </div>
                    <div class="col">
                        <label class="form-label">FINAL DA MANHÃ</label>
                    </div>
                    <div class="col">
                        <label class="form-label">INÍCIO DA TARDE</label>
                    </div>
                    <div class="col">
                        <label class="form-label">FINAL DA TARDE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "inicio_manha" class="form-control form-control-lg" value = "<?php echo $y["inicio_manha"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "final_manha" class="form-control form-control-lg" value = "<?php echo $y["final_manha"]; ?>" />
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "inicio_tarde" class="form-control form-control-lg" value = "<?php echo $y["inicio_tarde"]; ?>" />
                        </div>
                    </div>

                    
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "final_tarde" class="form-control form-control-lg" value = "<?php echo $y['final_tarde']; ?>" />
                        </div>
                    </div>
                </div>

                    <div class="col">
                <input type="hidden" name = "cpf_logado" value = "<?php echo $cpf_logado; ?>">     
                <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                <?php
                }
                ?>
                <input type = "hidden" name = "id_profissional" value = "<?php echo $y['id_profissional'] ?>">    
                <button class="btn btn-primary " type="submit">SALVAR</button>
               <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger" style = "color:white" href="tabela_agenda.php?id=<?php echo $y['id_profissional'];?>">VOLTAR</a>
            </div>
            </form>
    </div>
</div>

  