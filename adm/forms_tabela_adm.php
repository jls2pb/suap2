<?php 
session_start();
if(isset($_SESSION['cpf'])){
$cpf_logado = $_SESSION['cpf'];
include "head.php";
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";
?>
<h2 class="mb-4">CADASTROS</h2>
<div class="row">
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela_adm.php">
        <strong>LOCAL DE AGENDAMENTO: </strong>
        <input type = "text" class="form-control" name = "local" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff;" class="btn text-white"><b>CADASTRAR</b></button>
        <a class="btn text-white btn-primary" style = "margin-top:7px;" href="tb_local_ag_adm.php" role="button"> VER MAIS </a>
    </form>  
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela_adm.php">    
        <strong>PROCEDIMENTOS:</strong>
        <input type = "text" class="form-control" name = "procedimento" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff;" class="btn text-white"><b>CADASTRAR</b></button>
        <a class="btn text-white btn-primary" style = "margin-top:7px;" href="tb_procedimentos_adm.php" role="button"> VER MAIS </a>
    </form>  
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela_adm.php">    
        <strong>ACS:</strong>
        <input type = "text" class="form-control" name = "acs" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff;" class="btn text-white"><b>CADASTRAR</b></button>
        <a class="btn text-white btn-primary" style = "margin-top:7px;" href="tb_acs_adm.php" role="button"> VER MAIS </a>
    </form>
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela_adm.php">
        <strong>UBS:</strong>
        <input type = "text" class="form-control" name = "ubs" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff;" class="btn text-white"><b>CADASTRAR</b></button>
        <a class="btn text-white btn-primary" style = "margin-top:7px;" href="tb_ubs_adm.php" role="button"> VER MAIS </a>
    </form>
    </div>
  </div>

    </div>
</div>
   
<?php 
}else{
    header("Location:../index.php");
}
?>
