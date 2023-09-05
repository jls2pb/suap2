<?php 
require_once("../head.php");
session_start();

include "menu_adm.php";
include "navibar_adm.php";

include "../footer.php";
require_once("../conexao.php");
?>
<div class="container">
  <div class="row">
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style=" width: 30%; padding: 7px;"src="../images/paciente.jpeg">
      <?php 
     
        $qdp = "SELECT COUNT(*) AS quantidade FROM tabela";
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
    <img style="width: 30%; padding: 7px;"src="../images/espera.jpeg">
    <p style="margin-top: 15px; color: black;">PACIENTES EM <br> ESPERA:  </p>
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="../images/calendario.jpeg"> 
    <p style="margin-top: 15px; color: black;">PACIENTES <br>AGENDADOS:  </p>                            
    </div>
  </div>


  <div class="row">
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="margin-right: 5px; width: 30%; padding: 7px;"src="../images/p_cadastrado.jpeg">
    <?php 
      $qdp = "SELECT COUNT(*) AS quantidade FROM procedimentos";
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
    <img style="width: 30%; padding: 7px;"src="../images/p_espera.jpeg">
    <?php 
      $qdp = "SELECT COUNT(*) AS quantidade FROM procedimentos WHERE data_do_agendamento IS NULL OR data_do_agendamento = ''";
      
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
    <img style="width: 30%; padding: 7px;"src="../images/p_agendado.jpeg">
    
    <?php 
      $qdp = "SELECT COUNT(*) AS quantidade FROM procedimentos WHERE data_do_agendamento IS NOT NULL AND data_do_agendamento != ''";
      
      $rqdp = $conexao->prepare($qdp);
      $rqdp->execute();
      $xr = $rqdp->fetchAll();
      foreach ($xr as $key => $a) {
        ?>
        <p style="margin-top: 15px; color: black;">PROCEDIMENTOS AGENDADOS: <?= $a["quantidade"] ?> </p>
        <?php
      }

    ?>
    </div>
  </div>