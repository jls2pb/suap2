<?php 
session_start();
if(isset($_SESSION['cpf'])){
$cpf_logado = $_SESSION['cpf'];
include "head.php";
include "menu.php";
include "navibar.php";
include "footer.php";
include "conexao.php";

?>
<div class="container">
  <div class="row">
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style=" width: 30%; padding: 7px;"src="images/paciente.jpeg">
      <?php 
        $qdp = "SELECT COUNT(*) AS quantidade FROM tb_log WHERE acao = 'CADASTRADO'";
        $rqdp = $conexao->prepare($qdp);
        $rqdp->execute();
        $xr = $rqdp->fetchAll();
        foreach ($xr as $key => $a) {
          ?>
          <p style="margin-top: 15px; color: black;">PACIENTES <br>CADASTRADOS: <?= $a["quantidade"]; ?> </p>
          <?php 
        }
      ?>
    
    
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="images/espera.jpeg">
    <p style="margin-top: 15px; color: black;">PACIENTES EM <br> ESPERA:  </p>
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="images/calendario.jpeg"> 
    <p style="margin-top: 15px; color: black;">PACIENTES <br>AGENDADOS:  </p>                            
    </div>
  </div>


  <div class="row">
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="margin-right: 5px; width: 30%; padding: 7px;"src="images/p_cadastrado.jpeg">
    <?php 
      $qdp = "SELECT COUNT(*) AS quantidade FROM tb_log WHERE acao LIKE '%NOVO PROCEDIMENTO%'";
      $rqdp = $conexao->prepare($qdp);
      $rqdp->execute();
      $xr = $rqdp->fetchAll();
      foreach ($xr as $key => $a) {
        ?>
        <p style="display: inline; margin-top: 15px; color: black;">PROCEDIMENTOS CADASTRADOS: <?= $a["quantidade"]; ?>  </p>
        <?php
      }
    ?>
    
    
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="images/p_espera.jpeg">
    <?php 
      $qdp = "SELECT COUNT(*) AS quantidade FROM procedimentos WHERE data_de_entrada_cadastro IS NOT NULL";
      $rqdp = $conexao->prepare($qdp);
      $rqdp->execute();
      $xr = $rqdp->fetchAll();
      foreach ($xr as $key => $a) {
        ?>
        <p style="margin-top: 15px; color: black;">PROCEDIMENTOS EM <br> ESPERA: <?= $a["quantidade"] ?> </p>
        <?php
      }

    ?>
    

      

    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="images/p_agendado.jpeg">
    <p style="margin-top: 15px; color: black;">PROCEDIMENTOS AGENDADOS:  </p>
    </div>
  </div>
  <?php 

?>
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
