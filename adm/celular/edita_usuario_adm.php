<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../../conexao.php");
$cod = $_POST["id"];
$n_usuario = $_POST["n_usuario"];
$cpf = $_POST["cpf"];
$id_tipo = $_POST["funcao"];
$cpf_logado = $_POST["cpf_logado"];

$sql = "UPDATE usuario SET nome = '$n_usuario', cpf = '$cpf', id_tipo = '$id_tipo' WHERE id_usuario = '$cod'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
 header ("location: ver_usuarios.php?id=".$cod);

} else{
    echo "erro ao coletar os dados";
}

?>