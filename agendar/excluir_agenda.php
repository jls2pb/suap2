<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf'];

$id =  $_GET["id"];
$id1 =  $_GET["id1"];
$sql = "DELETE FROM agenda_profissional WHERE id_agenda = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
?>
    <script>
    alert("EXCLUIDO COM SUCESSO!");
    window.location = "tabela_agenda.php?id=<?php echo $id1; ?>";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}
?>
