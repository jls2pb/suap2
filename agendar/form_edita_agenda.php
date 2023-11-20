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
$sql = "SELECT * FROM agenda_profissional WHERE id_agenda = $id";
$resultado = $conexao->prepare($sql);


if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>
<script src="../mascara.js"></script>
<h4 class="mb-4">EDITAR AGENDA</h4>
<form method = "POST" action = "editar_agenda.php">  
            <?php 
                foreach ($x as $y) {                    
            ?>
            
            <div class="form-outline mb-4">
            <label class="form-label" style="font-size:12px;">DIA DA AGENDA</label>
            <input type="date" name = "dia" class="form-control form-control-lg" value = "<?php echo $y["dia"]; ?>" style="font-size:12px;"/>
            </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label" style="font-size:12px;">INICIO DA MANHÃ</label>
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-size:12px;">FINAL DA MANHÃ</label>
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-size:12px;">INÍCIO DA TARDE</label>
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-size:12px;">FINAL DA TARDE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "inicio_manha" class="form-control form-control-lg" value = "<?php echo $y["inicio_manha"]; ?>" style="font-size:12px;"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "final_manha" class="form-control form-control-lg" value = "<?php echo $y["final_manha"]; ?>" style="font-size:12px;"/>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "inicio_tarde" class="form-control form-control-lg" value = "<?php echo $y["inicio_tarde"]; ?>" style="font-size:12px;"/>
                        </div>
                    </div>

                    
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "final_tarde" class="form-control form-control-lg" value = "<?php echo $y['final_tarde']; ?>" style="font-size:12px;"/>
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
                <button class="btn btn-primary " type="submit" style="font-size:10px;">SALVAR</button>
               <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger" style = "color:white; font-size:10px;" href="tabela_agenda.php?id=<?php echo $y['id_profissional'];?>">VOLTAR</a>
            </div>
            </form>
    </div>
</div>

  