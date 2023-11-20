<?php 
session_start();
if(isset($_SESSION['cpf_cadastro']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf_cadastro'];
include "head.php";
include "menu.php";
include "navibar.php";
include "../footer.php";
require_once("../conexao.php");
$id = $_GET['id'];
$sql = "SELECT * FROM local_atendimento WHERE cnes = $id LIMIT 1";
$resultado = $conexao->prepare($sql);

if($resultado->execute()){
    $x = $resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>

<div class="container">
    <h4 class="mb-4">EDITAR LOCAL DE AGENDAMENTO</h4>
    <form method="POST" action="editar.php">  
        <?php foreach ($x as $y) { ?>
            <div class="form-group">
                <label for="cnes" class="form-label" style="font-size:12px;">CNES</label>
                <input required type="number" name="cnes" class="form-control" id="cnes" value="<?php echo $y["cnes"]; ?>" style="font-size:12px;"/>
            </div>

            <div class="form-group">
                <label for="nome_fantasia" class="form-label" style="font-size:12px;">NOME</label>
                <input required type="text" name="nome_fantasia" class="form-control" id="nome_fantasia" value="<?php echo $y["nome_fantasia"]; ?>" style="font-size:12px;">
            </div>

            
            <div class="form-group">
                <label for="endereco_local" class="form-label" style="font-size:12px;">ENDEREÇO</label>
                <input required type="text" name="endereco_local" class="form-control" id="endereco_local" value="<?php echo $y["endereco_local"]; ?>" style="font-size:12px;">
            </div>

            <input type="hidden" name="id" value="<?php echo $y["cnes"]; ?>">
        <?php } ?>

        <input type="hidden" name="cpf_logado" value="<?php echo $cpf_logado ?>">    

        <div class="form-group">
            <button class="btn btn-primary" type="submit" style="font-size:10px;">SALVAR</button>
            <a class="btn btn-danger" href="tb_local_ag.php" style="font-size:10px;">VOLTAR</a>
        </div>
    </form>
</div>

