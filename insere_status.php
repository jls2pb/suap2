<?php 
include "conexao.php";

$sql = "SELECT * FROM precedimentos WHERE status = NULL";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    while ($x = $resultado->fetch(PDO::FETCH_ASSOC)){
            if($x["data_do_agendamento"] == NULL){
                $x["status"] = 3;
            }else{
                $x["status"] = 0;
            }
    }
}
?>