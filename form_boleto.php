<?php 
require_once("head.php");
require_once("conexao.php");
session_start();
$id = $_GET["id"];
$cpf_logado = $_SESSION["cpf"];
$sql = "SELECT * FROM procedimentos WHERE id = $id ";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}

include "head.php";
include "menu.php";
include "navibar.php";

foreach ($x as $y) {
    $id_cid = $y["cod"];
    $sql2 = "select * from tabela where cod = '$id_cid'";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();
    $a = $resultado2->fetchAll();
    foreach ( $a as $b) {
        if($y["data_do_agendamento"] != NULL){
            $agendamento = date('d/m/Y', strtotime($y["data_do_agendamento"]));  
        }else{
            $agendamento = NULL;
        }
        ?>
        <div class = "container">
            <center> <h3> AGENDAMENTO </h3> </center>
            <label> <strong> PROCEDIMENTO: </strong> <?php echo $y["procedimento"];?></label><br>
            <label> <strong> PROFISSIONAL: </strong> <?php echo $y["profissional"];?></label><br>
            <label> <strong> PACIENTE: </strong> <?php echo $y["nome_paciente"];?></label><br>
            <label> <strong> DATA DE NASCIMENTO: </strong> <?php echo $b["nascimento"];?></label><br>
            <label> <strong> UNIDADE DE ORIGEM: </strong> <?php echo $b["ubs"];?></label><br>
            <label> <strong> DIA: </strong> </label> <input type = "date" class="form-control-plaintext" name = "dia_marcado"> <br>
            <label> <strong> HORA: </strong> </label> <input type = "time" class="form-control-plaintext" name = "dia_marcado"> <br>
            <label> <strong> LOCAL: </strong> <?php echo $y["local_do_agendamento"];?></label><br>
        </div>    
        <?php
    }
}
?>
