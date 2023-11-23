<?php 
session_start();
if(isset($_SESSION['cpf_cad_ag']) == FALSE){
    header("Location:../index.php");
}

$cpf_logado = $_SESSION['cpf_cad_ag'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";

require_once("../conexao.php");
$id = $_GET['id'];
$sql = "SELECT * FROM uaps WHERE id_uaps = $id LIMIT 1";
$resultado = $conexao->prepare($sql);

if($resultado->execute()){
    $x = $resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>

<div class="container">
    <h4 class="mb-4">EDITAR ACS</h4>
    <form method="POST" action="editar_adm.php">  
        <?php foreach ($x as $y) { ?>
            

            <div class="form-group">
                <label for="nome_uaps" class="form-label" style="font-size:12px;">NOME</label>
                <input required type="text" name="nome_uaps" class="form-control" id="nome_uaps" style="font-size:12px;" value="<?php echo $y["nome_uaps"]; ?>">
            </div>
           
            
            <input type="hidden" name="id_uaps" value="<?php echo $y['id_uaps']; ?>">
        <?php } ?>

        <input type="hidden" name="cpf_logado" value="<?php echo $cpf_logado ?>">    

        <div class="form-group">
            <button class="btn btn-primary" style="font-size:10px;" type="submit">SALVAR</button>
            <a class="btn btn-danger" style="font-size:10px;" href="tb_ubs_adm.php">VOLTAR</a>
        </div>
    </form>
</div>
