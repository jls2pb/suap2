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
$sql = "SELECT * FROM procedimento_medico WHERE id_procedimento = $id LIMIT 1";
$resultado = $conexao->prepare($sql);

if($resultado->execute()){
    $x = $resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>

<div class="container">
    <h2 class="mb-4">EDITAR PROCEDIMENTO</h2>
    <form method="POST" action="editar.php">  
        <?php foreach ($x as $y) { ?>
            <div class="form-group">
                <label for="procedimento" class="form-label">PROCEDIMENTO</label>
                <input type="text" name="procedimento" class="form-control" id="procedimento" value="<?php echo $y["procedimento"]; ?>" />
            </div>


            <input type="hidden" name="id_procedimento" value="<?php echo $y["id_procedimento"]; ?>">
        <?php } ?>

        <input type="hidden" name="cpf_logado" value="<?php echo $cpf_logado ?>">    

        <div class="form-group">
            <button class="btn btn-primary" type="submit">SALVAR</button>
            <a class="btn btn-danger" href="tb_procedimentos.php">VOLTAR</a>
        </div>
    </form>
</div>
