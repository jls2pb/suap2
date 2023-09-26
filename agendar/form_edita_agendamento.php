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
            
            <div class="form-outline mb-4">
            <label class="form-label">DATA DO ATENDIMENTO</label>
            <input type="date" name = "data_atendimento" class="form-control form-control-lg" value = "<?php echo $y["data_atendimento"]; ?>" />
            </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">HORA</label>
                    </div>
                    <div class="col">
                        <label class="form-label">NOME DO PACIENTE</label>
                    </div>
                    <div class="col">
                        <label class="form-label">SEXO</label>
                    </div>
                    <div class="col">
                        <label class="form-label">ENDEREÇO RESIDENCIAL</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="time" name = "hora" class="form-control form-control-lg" value = "<?php echo $y["hora"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "nome_paciente" class="form-control form-control-lg" value = "<?php echo $y["nome_paciente"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <select required class="form-control form-control-lg" name = "sexo">
            <option selected disabled value = ""> O SEXO ATUAL É: <?php echo $y['sexo'];?> </option>
                <option value = "M"> Masculino </option>
                <option value = "F"> Feminino </option>
            </select>    
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "endereco" class="form-control form-control-lg" value = "<?php echo $y['endereco']; ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label">CPF</label>
                    <input type="text" name = "cpf" class="form-control form-control-lg" value = "<?php echo $y["cpf"]; ?>" />
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
                    <div class="col">
                     
                <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                <?php
                }
                ?>
                <input type = "hidden" name = "cod" value = "<?php echo $y['id_profissional'] ?>">    
                <button class="btn btn-primary " type="submit">SALVAR</button>
               <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger" style = "color:white" href="tabela_agendamento.php?id=<?php echo $y['cod_profissional'];?>">VOLTAR</a>
            </div>
            </form>
    </div>
</div>

  