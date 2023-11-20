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
$sql = "SELECT * FROM acs WHERE cod = $id LIMIT 1";
$resultado = $conexao->prepare($sql);

if($resultado->execute()){
    $x = $resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>

<div class="container">
    <h4 class="mb-4">EDITAR ACS</h4>
    <form method="POST" action="editar.php">  
        <?php foreach ($x as $y) { ?>
            <div class="form-group">
                <label for="ubs" class="form-label" style="font-size:12px;">UBS</label>
                <input required type="text" name="ubs" class="form-control" id="ubs" value="<?php echo $y["ubs"]; ?>" style="font-size:12px;"/>
            </div>

            <div class="form-group">
                <label for="nome" class="form-label" style="font-size:12px;">NOME</label>
                <input required type="text" name="nome" class="form-control" id="nome" value="<?php echo $y["nome"]; ?>" style="font-size:12px;">
            </div>
            <div class="form-group">
                <label for="vinculo" class="form-label" style="font-size:12px;">VÍNCULO</label>
                <input required type="text" name="vinculo" class="form-control" id="vinculo" value="<?php echo $y["vinculo"]; ?>" style="font-size:12px;"/>
            </div>
            <div class="form-group">
                <label for="cns" class="form-label" style="font-size:12px;">CNS</label>
                <input required type="number" name="cns" class="form-control" id="cns" value="<?php echo $y["cns"]; ?>" style="font-size:12px;"/>
            </div>
            <div class="form-group">
                <label for="cpf" class="form-label" style="font-size:12px;">CPF</label>
                <input required type="number" name="cpf" class="form-control" id="cpf" value="<?php echo $y["cpf"]; ?>" style="font-size:12px;"/>
            </div>
            <div class="form-group">
                <label for="microarea" class="form-label" style="font-size:12px;">MICROÁREA</label>
                <input required type="number" name="microarea" class="form-control" id="microarea" value="<?php echo $y["microarea"]; ?>" style="font-size:12px;"/>
            </div>

            <div class="form-group">
                <label for="pessoas" class="form-label" style="font-size:12px;">PESSOAS</label>
                <input required type="number" name="pessoas" class="form-control" id="pessoas" value="<?php echo $y["pessoas"]; ?>" style="font-size:12px;"/>
            </div>
            <div class="form-group">
                <label for="familias" class="form-label" style="font-size:12px;">FAMÍLIAS</label>
                <input required type="number" name="familias" class="form-control" id="familias" value="<?php echo $y["familias"]; ?>" style="font-size:12px;"/>
            </div>
            <div class="form-group">
                <label for="transporte" class="form-label" style="font-size:12px;">TRANSPORTE</label>
                <input type="text" name="transporte" class="form-control" id="transporte" value="<?php echo $y["transporte"]; ?>" style="font-size:12px;"/>
            </div>
           
            
            <input type="hidden" name="cod" value="<?php echo $y["cod"]; ?>">
        <?php } ?>

        <input type="hidden" name="cpf_logado" value="<?php echo $cpf_logado ?>">    

        <div class="form-group">
            <button class="btn btn-primary" type="submit" style="font-size:10px;">SALVAR</button>
            <a class="btn btn-danger" href="tb_acs.php" style="font-size:10px;">VOLTAR</a>
        </div>
    </form>
</div>
