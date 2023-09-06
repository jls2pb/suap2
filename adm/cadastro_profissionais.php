<?php 
require_once("head.php");
session_start();

include "menu_adm.php";
include "navibar_adm.php";

include "../footer.php";
require_once("../conexao.php");
?>
<h3 class="mb-5 text-center"> CADASTRO DE PROFISSIONAL </h3>
<form method = "POST" action = "registro_profissioal.php">  
<div class="form-outline mb-4">
            <label class="form-label">Nome do Profissional *</label>
            <input type="text" name="n_profissional" class="form-control form-control-lg" id="n_profissional"  required placeholder="Digite o nome do profissional">
</div>
<div class="form-outline mb-4">
            <label class="form-label">Área do Profissional *</label>
            <input type="text" name="n_area" class="form-control form-control-lg" id="n_area"  required placeholder="Digite a área do profissional">
</div>
<div class="form-outline mb-4">
            <label class="form-label">Tempo de Atendimento do Profissional (minutos)*</label>
            <input type="number" name="n_tempo" class="form-control form-control-lg" id="n_tempo"  required placeholder="Digite o tempo de atendimento do profissional">
</div><br>
                <input type = "hidden" name = "cpf_logado" value = "<?php echo $cpf_logado?>">
                <button style="color:white;background-color: #66a7ff;" class="btn " type="submit"><b>CADASTRAR</b></button>
                <button class="btn btn-danger "><a class="link-offset-2 link-underline link-underline-opacity-0" style = "color:white" href="inicio_adm.php">VOLTAR</a></button>    
            

            <?php
            include "../footer.php";
            ?>
            </form>






