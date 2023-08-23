<?php 
include "conexao.php";
$sql = "select * from tabela";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x = $resultado->fetchAll();

    foreach ($x as $y) {
        $nova_data = date('d/m/Y', strtotime($y["nascimento"]));
        $cod = $y['cod'];
        if($y["nascimento"] != NULL ){
            $sql2 = "UPDATE tabela SET nascimento = '$nova_data' WHERE cod = $cod ";
            $resultado2 = $conexao->prepare($sql2);
            $resultado2->execute();
            echo "data nova registrada! ".$nova_data;
            echo "<br>";
        }
        
    }
}

?>