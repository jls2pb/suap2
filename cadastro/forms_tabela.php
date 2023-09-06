<?php 
session_start();
if(isset($_SESSION['cpf'])){
$cpf_logado = $_SESSION['cpf'];
include "head.php";
include "menu.php";
include "navibar.php";
include "../footer.php";
?>
<h2 class="mb-4">CADASTROS</h2>
<div class="row">
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela.php">
        <strong>LOCAL DE AGENDAMENTO: </strong>
        <input type = "text" class="form-control" name = "local" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff;" class="btn text-white"><b>CADASTRAR</b></button>
    </form>  
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela.php">    
        <strong>PROCEDIMENTOS:</strong>
        <input type = "text" class="form-control" name = "procedimento" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff;" class="btn text-white"><b>CADASTRAR</b></button>
    </form>  
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela.php">    
        <strong>ACS:</strong>
        <input type = "text" class="form-control" name = "acs" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff;" class="btn text-white"><b>CADASTRAR</b></button>
    </form>
    </div>
    <div class="col-sm">
    <form method = "POST" action = "cadastrar_tabela.php">
        <strong>UBS:</strong>
        <input type = "text" class="form-control" name = "ubs" oninput="handleInput(event)">
        <button type="submit" style = "margin-top:7px;background-color: #66a7ff;" class="btn text-white"><b>CADASTRAR</b></button>
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
