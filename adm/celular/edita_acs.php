<?php 
session_start();
if(isset($_SESSION['cpf_adm']) == FALSE){
    header("Location:index.php");
}

$cpf_logado = $_SESSION['cpf_adm'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../../footer.php";

require_once("../../conexao.php");
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
    <h2 class="mb-4">EDITAR ACS</h2>
    <form method="POST" action="editar_adm.php">  
        <?php foreach ($x as $y) { ?>
            <div class="form-group">
                <label for="ubs" class="form-label">UBS</label>
                <input required type="text" name="ubs" class="form-control" id="ubs" value="<?php echo $y["ubs"]; ?>" />
            </div>

            <div class="form-group">
                <label for="nome" class="form-label">NOME</label>
                <input required type="text" name="nome" class="form-control" id="nome" value="<?php echo $y["nome"]; ?>">
            </div>
            <div class="form-group">
                <label for="vinculo" class="form-label">VÍNCULO</label>
                <input required type="text" name="vinculo" class="form-control" id="vinculo" value="<?php echo $y["vinculo"]; ?>" />
            </div>
            <div class="form-group">
                <label for="cns" class="form-label">CNS</label>
                <input required type="number" name="cns" class="form-control" id="cns" value="<?php echo $y["cns"]; ?>" />
            </div>
            <div class="form-group">
                <label for="cpf" class="form-label">CPF</label>
                <input required type="number" name="cpf" class="form-control" id="cpf" value="<?php echo $y["cpf"]; ?>" />
            </div>
            <div class="form-group">
                <label for="microarea" class="form-label">MICROÁREA</label>
                <input required type="number" name="microarea" class="form-control" id="microarea" value="<?php echo $y["microarea"]; ?>" />
            </div>

            <div class="form-group">
                <label for="pessoas" class="form-label">PESSOAS</label>
                <input required type="number" name="pessoas" class="form-control" id="pessoas" value="<?php echo $y["pessoas"]; ?>" />
            </div>
            <div class="form-group">
                <label for="familias" class="form-label">FAMÍLIAS</label>
                <input required type="number" name="familias" class="form-control" id="familias" value="<?php echo $y["familias"]; ?>" />
            </div>
            <div class="form-group">
                <label for="transporte" class="form-label">TRANSPORTE</label>
                <input type="text" name="transporte" class="form-control" id="transporte" value="<?php echo $y["transporte"]; ?>" />
            </div>
           
            
            <input type="hidden" name="cod" value="<?php echo $y["cod"]; ?>">
        <?php } ?>

        <input type="hidden" name="cpf_logado" value="<?php echo $cpf_logado ?>">    

        <div class="form-group">
            <button class="btn btn-primary" type="submit">SALVAR</button>
            <a class="btn btn-danger" href="tb_acs_adm.php">VOLTAR</a>
        </div>
    </form>
</div>
