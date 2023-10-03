<!DOCTYPE html>
<html lang="pt-br">
<?php 
require_once("head.php");
session_start(); 
if(isset($_SESSION['cpf_cadastro'])){
$cpf_logado = $_SESSION['cpf_cadastro'];

include "menu.php";
include "navibar.php";


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
    <?php
    $query = "SELECT COUNT(*) AS quantidade FROM tabela WHERE cpf NOT IN (SELECT cpf FROM agendamento)";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        $xr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

    // Contagem de procedimentos agendados e não agendados
   
    foreach ($xr as $key => $a) {
?>  
    <p style="margin-top: 15px; color: black;">PACIENTES EM <br> ESPERA: <?= $a["quantidade"]; ?> </p>
    </div>
    <?php
    }
    ?>

    <div class="col-sm border rounded d-flex" style="margin: 10px;">
    <img style="width: 30%; padding: 7px;"src="../images/calendario.jpeg"> 
    <?php
$cont = 0;

$sqlTabela = "SELECT cod FROM tabela"; // Substitua 'tabela' pelo nome da sua tabela
$stmtTabela = $conexao->prepare($sqlTabela);
$stmtTabela->execute();
$resultado = $stmtTabela->fetchAll(PDO::FETCH_ASSOC);

foreach ($resultado as $r) {
    $cod = $r['cod'];
    
    $sqlProcedimentos = "SELECT * FROM procedimentos WHERE cod = :cod";
    $stmtProcedimentos = $conexao->prepare($sqlProcedimentos);
    $stmtProcedimentos->bindParam(':cod', $cod, PDO::PARAM_INT);
    $stmtProcedimentos->execute();
    $resultado2 = $stmtProcedimentos->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($resultado2 as $r2) {
        $data_do_agendamento = $r2['data_do_agendamento'];
        if ($data_do_agendamento !== NULL && $data_do_agendamento != '') {
            $cont++;
        }
    }
}

?>

<p style="margin-top: 15px; color: black;">PACIENTES <br>AGENDADOS: <?= $cont; ?>  </p>

    <?php 
        
      ?>                            
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
  <?php 

?>
</div>

    </div>
</div>
    
<?php 
}else{
    header("Location:../index.php");
}
?>
