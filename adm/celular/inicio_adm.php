<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf_adm'])){
  $cpf_logado = $_SESSION['cpf_adm'];
include "menu_adm.php";
include "navibar_adm.php";

include "../../footer.php";
require_once("../../conexao.php");
?>
<div class="container">
  <div class="row">
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style=" width: 30%; padding: 7px;"src="../../images/paciente.jpeg">
      <?php 
     
        $qdp = "SELECT COUNT(*) AS quantidade FROM tabela";
        $rqdp = $conexao->prepare($qdp);
        $rqdp->execute();
        $xr = $rqdp->fetchAll();
        foreach ($xr as $key => $a) {
          ?>
          <p style="margin-top: 15px; color: black;">PACIENTES <br>CADASTRADOS: <?php $cadastrados = $a["quantidade"];
          echo $cadastrados;
          ?> </p>
          <?php 
        }
      ?>
    
    
    </div>
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="../../images/espera.jpeg">
    <?php
    $query = "SELECT COUNT(DISTINCT cod) AS quantidade FROM procedimentos WHERE data_do_agendamento IS NULL OR data_do_agendamento = ''";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        $xr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

    // Contagem de procedimentos agendados e não agendados
   
    foreach ($xr as $key => $a) {
?>  
    <p style="margin-top: 15px; color: black;">PACIENTES EM <br> ESPERA: <?php $espera = $a["quantidade"]; 
    echo $espera;
    ?> </p>
    </div>
    <?php
    }
    ?>

    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="../../images/calendario.jpeg"> 
    


<p style="margin-top: 15px; color: black;">PACIENTES <br>AGENDADOS: <?php $result = $cadastrados-$espera;
echo $result;
?>  </p>
                    
    </div>
  </div>


  <div class="row">
    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="margin-right: 5px; width: 30%; padding: 7px;"src="../../images/p_cadastrado.jpeg">
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
    <img style="width: 30%; padding: 7px;"src="../../images/p_espera.jpeg">
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
    <img style="width: 30%; padding: 7px;"src="../../images/p_agendado.jpeg">
    
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
    }
    else {
      header("location: index.php");
    }
    ?>
    </div>
  </div>
    