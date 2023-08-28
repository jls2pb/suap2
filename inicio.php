<?php 
session_start();
if(isset($_SESSION['cpf'])){
$cpf_logado = $_SESSION['cpf'];
include "head.php";
include "menu.php";
include "navibar.php";
include "footer.php";

?>
<div class="container">
  <div class="row">
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style=" width: 30%; padding: 7px;"src="paciente.jpeg">
    <p style="margin-top: 15px; color: black;">PACIENTES <br>CADASTRADOS:  </p>
    
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="espera.jpeg">
    <p style="margin-top: 15px; color: black;">PACIENTES EM <br> ESPERA:  </p>
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="calendario.jpeg"> 
    <p style="margin-top: 15px; color: black;">PACIENTES <br>AGENDADOS:  </p>                            
    </div>
  </div>


  <div class="row">
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="margin-right: 5px; width: 30%; padding: 7px;"src="p_cadastrado.jpeg">
    <p style="display: inline; margin-top: 15px; color: black;">PROCEDIMENTOS CADASTRADOS:  </p>
    
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="p_espera.jpeg">
    <p style="margin-top: 15px; color: black;">PROCEDIMENTOS EM <br> ESPERA:  </p>
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="p_agendado.jpeg">
    <p style="margin-top: 15px; color: black;">PROCEDIMENTOS AGENDADOS:  </p>
    </div>
  </div>
</div>
    </div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
<?php 
}else{
    header("Location:index.php");
}
?>
