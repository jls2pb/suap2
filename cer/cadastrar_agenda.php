<?php 
date_default_timezone_set('America/Sao_Paulo');
session_start();
if(isset($_SESSION['cpf_cer']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf_cer'];
require_once("head.php");
include "navibar.php";

$id = $_GET['id'];

require_once("../conexao.php");
$sql = "SELECT * FROM uaps ORDER BY nome_uaps ASC";
$resultado = $conexao->prepare($sql);
$resultado->execute();
?>
<h3 class="mb-5 text-center"> CADASTRO AGENDA PROFISSIONAL </h3>
<form method = "POST" action = "registro_agenda.php">  
    <div class="form-outline mb-4">
        <label class="form-label">DIA *</label>
        <input type="date" name="dia" class="form-control form-control-lg" id="dia" required min="<?= date('Y-m-d'); ?>">
    </div>
    <div class="form-outline mb-4">
        <label class="form-label">Hora Inicio Manha </label>
        <input type="time" name="inicio_manha" class="form-control form-control-lg" id="inicio_manha">
    </div>
    <div class="form-outline mb-4">
        <label class="form-label">Hora Final Manha </label>
        <input type="time" name="final_manha" class="form-control form-control-lg" id="final_manha">
    </div>
    <div class="form-outline mb-4">
        <label class="form-label">Hora Inicio Tarde </label>
        <input type="time" name="inicio_tarde" class="form-control form-control-lg" id="inicio_tarde">
    </div>
    <div class="form-outline mb-4">
        <label class="form-label">Hora Final Tarde </label>
        <input type="time" name="final_tarde" class="form-control form-control-lg" id="final_tarde">
    </div>
    <input type = "hidden" name = "id" value = "<?= $id; ?>">
    <button style="color:white;background-color: #66a7ff;" class="btn " type="submit"><b>CADASTRAR</b></button>
    <a class="link-offset-2 link-underline link-underline-opacity-0 btn btn-danger" style = "color:white" href="tabela_agenda.php?id=<?php echo $id; ?>" role="button">VOLTAR</a>
            <?php
            include "../footer.php";
            ?>
            </form>






    </div>
</div>

