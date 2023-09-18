<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf'])){
  $cpf_logado = $_SESSION['cpf'];
  include "menu_adm.php";
  include "navibar_adm.php";
  include "../footer.php";
  require_once("../conexao.php");


  
 
?>

<h3>Buscar procedimentos</h3>
<form action="relatorios_filtrados.php" method="POST">
  <div class="form-outline mb-4">
    <label>
      <input type="checkbox" name="procedimento" value="entrada"> Quantos deram entrada
    </label><br>
    <label for="data_inicio">Data de Entrada: </label>
    <input required type="date" name="data_inicio" id="data_inicio"> <br>
  </div>
  <div class="form-outline mb-4">
    <label for="data_fim">Data de Término: </label>
    <input required type="date" name="data_fim" id="data_fim"> <br>
  </div>
  <button class="btn btn-primary" type="submit">Filtrar</button>
</form>

<h3>Buscar agendamentos</h3>
<form action="relatorios_filtrados.php" method="POST">
  <div class="form-outline mb-4">
    <label>
      <input type="checkbox" name="agendamento" value="agendamento"> Quantidade de agendamentos
    </label><br>
    <hr></hr>
    <label>
      <input type="checkbox" name="agendar" value="agendar"> Quantos faltam agendar
    </label><br>
    <label for="periodo_inicio">Período inicial: </label>
    <input type="date" name="periodo_inicio" id="periodo_inicio" value="<?php echo $periodoInicio; ?>"> <br>
    <label for="periodo_fim">Período final: </label>
    <input type="date" name="periodo_fim" id="periodo_fim" value="<?php echo $periodoFim; ?>"> <br>
  </div>
  <button class="btn btn-primary" type="submit">Filtrar</button>
</form>

<?php
} else {
  header("location: ../index.php");
}
?>
