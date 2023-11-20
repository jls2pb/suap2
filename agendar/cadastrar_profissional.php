<?php 
session_start();
if(isset($_SESSION['cpf_agendar']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf_agendar'];
require_once("head.php");
include "menu_agendamento.php";
include "navibar_agendar.php";



require_once("../conexao.php");
$sql = "SELECT * FROM uaps ORDER BY nome_uaps ASC";
$resultado = $conexao->prepare($sql);
$resultado->execute();
?>
<h4 class="mb-5 text-center"> CADASTRO DE PROFISSIONAL </h4>
<form method = "POST" action = "registro_profissional.php">  
    <div class="form-outline mb-4">
        <label class="form-label" style="font-size:12px;">Nome do Profissional *</label>
        <input type="text" name="n_profissional" class="form-control form-control-lg" id="n_profissional" oninput="handleInput(event)" style="font-size:12px;">
    </div>
    <div class="form-outline mb-4">
        <label class="form-label" style="font-size:12px;">Área de Atendimento *</label>
        <input type="text" name="area" class="form-control form-control-lg" id="area" oninput="handleInput(event)" style="font-size:12px;">
    </div>
    <div class="form-outline mb-4">
    <label class="form-label" style="font-size:12px;">Tempo de atendimento *</label>
    <input type="hidden" name="session" value="<?php echo $_SESSION['cpf_agendar']; ?>">
    <input type="text" name="tempo" class="form-control form-control-lg" id="tempo" pattern="^(0?[1-9]|[1-5][0-9]|60)$" placeholder = "Tempo de 1 a 60 minutos" title="Digite um número de 1 a 60" style="font-size:12px;">
</div>
    <button style="color:white;background-color: #66a7ff; font-size:10px;" class="btn " type="submit"><b>CADASTRAR</b></button>
                <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger" style = "color:white; font-size:10px;" href="inicio_agendamento.php" role="button">VOLTAR</a> 
            <?php
            include "../footer.php";
            ?>
            </form>






    </div>
</div>