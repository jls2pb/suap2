<?php 
session_start();
if(isset($_SESSION['cpf_adm']) == FALSE){
    header("Location:../index.php");
}

$cpf_logado = $_SESSION['cpf_adm'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
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
    <h2 class="mb-4">EDITAR LOCAL DE AGENDAMENTO</h2>
    <form method="POST" action="editar_adm.php">  
        <?php foreach ($x as $y) { ?>
            <div class="form-group">
                <label for="cnes" class="form-label">CNES</label>
                <input required type="number" name="cnes" class="form-control" id="cnes" value="<?php echo $y["cnes"]; ?>" />
            </div>

            <div class="form-group">
                <label for="nome_fantasia" class="form-label">NOME</label>
                <input required type="text" name="nome_fantasia" class="form-control" id="nome_fantasia" value="<?php echo $y["nome_fantasia"]; ?>">
            </div>
            <div class="form-group">
                <label for="endereco_local" class="form-label">ENDEREÇO</label>
                <input required type="text" name="endereco_local" class="form-control" id="endereco_local" value="<?php echo $y["endereco_local"]; ?>">
            </div>

            <input type="hidden" name="id" value="<?php echo $y["cnes"]; ?>">
        <?php } ?>

        <input type="hidden" name="cpf_logado" value="<?php echo $cpf_logado ?>">    

        <div class="form-group">
            <button class="btn btn-primary" type="submit">SALVAR</button>
            <a class="btn btn-danger" href="tb_local_ag_adm.php">VOLTAR</a>
        </div>
    </form>
</div>
