<?php 
include "conexao.php";
$sql = "select * from usuario";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    foreach ($resultado as $r) {
        if($r['id_tipo'] == NULL){
            $id = $r["id_usuario"];
            $sql2 = "update usuario set id_tipo = 2 where id_usuario = '$id'";
            $resultado2 = $conexao->prepare($sql2);
            $resultado2->execute();
        }
    }
}
?>