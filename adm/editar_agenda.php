<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
$dia = $_POST["dia"];
$inicio_m = $_POST["inicio_manha"];
$final_m = $_POST["final_manha"];

$inicio_t = $_POST["inicio_tarde"];
$final_t = $_POST["final_tarde"];



$id = $_POST["id"];
$id_profissional = $_POST["id_profissional"];


$sql = "UPDATE agenda_profissional SET dia = '$dia', inicio_manha = '$inicio_m', final_manha = '$final_m', inicio_tarde = '$inicio_t', final_tarde = '$final_t'  WHERE id_agenda = '$id'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){ 
    $hoje = date('d/m/Y');
    $hora = date('H:i');
    $x = "EDITOU AGENDA"." ".$id;
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf','$hoje','$hora','$id')";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();?>
    <script>
    alert("ATUALIZADO COM SUCESSO!");
    window.location = "tabela_agenda.php?id=<?php echo $id_profissional; ?>";
</script> <?php
}else{
    echo "erro ao coletar os dados";
}

?>