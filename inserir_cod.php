<?php 
include "conexao.php";
$sql = "select * from usuario";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x = $resultado->fetchAll();
    foreach ($x as $r) {
        if($r['id_tipo'] == NULL){
            $id = $r["id_usuario"];
            $sql2 = "update usuario set id_tipo = 3 where id_usuario = '$id'";
            $resultado2 = $conexao->prepare($sql2);
            $resultado2->execute();
            echo "Codigo inserido"."<br>";
        }
    }
}
?>