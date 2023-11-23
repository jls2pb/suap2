<?php 
include "conexao.php";

$sql = "SELECT * FROM procedimentos";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x = $resultado->fetchAll();
    foreach ($x as $y) {
        if($y["data_do_agendamento"] == NULL){
            $id = $y['id'];
            $sql = "UPDATE procedimentos SET status = 3 WHERE id = $id";
            $resultado2 = $conexao->prepare($sql);
            if($resultado2->execute()){
                echo "nao agendado, ";
            }
            
            
        }else{
            $id = $y['id'];
            $sql = "UPDATE procedimentos SET status = 0 WHERE id = $id";
            $resultado2 = $conexao->prepare($sql);
            if($resultado2->execute()){
                echo "agendado, ";
            }
        }
    }
}
?>