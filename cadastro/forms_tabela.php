<?php 
session_start();
if(isset($_SESSION['cpf_cadastro'])){
$cpf_logado = $_SESSION['cpf_cadastro'];
include "head.php";
include "menu.php";
include "navibar.php";
include "../footer.php";
?>
<h4 class="mb-4">CADASTROS</h4>
<div class="row">
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela.php">
        <strong>CNES</strong>
        <input type="number" class="form-control" style="font-size:12px;"name = "cnes" oninput="handleInput(event)" required>
        <strong>LOCAL DE AGENDAMENTO: </strong>
        <input type = "text" class="form-control" style="font-size:12px;"name = "local" oninput="handleInput(event)" required>
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff; font-size:10px;" class="btn text-white"><b>CADASTRAR</b></button>
        <a class="btn text-white btn-primary" style = "margin-top:7px; font-size:10px;" href="tb_local_ag.php" role="button"> VER MAIS </a>
    </form>  
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela.php">    
        <strong>PROCEDIMENTOS:</strong>
        <input type = "text" class="form-control" style="font-size:12px;" name = "procedimento" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff; font-size:10px;" class="btn text-white"><b>CADASTRAR</b></button>
        <a class="btn text-white btn-primary" style = "margin-top:7px; font-size:10px;" href="tb_procedimentos.php" role="button"> VER MAIS </a>
    </form>  
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela.php">    
        <strong>ACS:</strong>
        <input required type = "text" class="form-control" style="font-size:12px;" name = "acs" oninput="handleInput(event)">
        <strong>CPF:</strong>
        <input required type = "text" class="form-control" style="font-size:12px;" name = "cpf" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff; font-size:10px;" class="btn text-white"><b>CADASTRAR</b></button>
        <a class="btn text-white btn-primary" style = "margin-top:7px; font-size:10px;" href="tb_acs.php" role="button"> VER MAIS </a>
    </form>
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela.php">
        <strong>UBS:</strong>
        <input type = "text" class="form-control" style="font-size:12px;" name = "ubs" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff; font-size:10px;" class="btn text-white"><b>CADASTRAR</b></button>
        <a class="btn text-white btn-primary" style = "margin-top:7px; font-size:10px;" href="tb_ubs.php" role="button"> VER MAIS </a>
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
