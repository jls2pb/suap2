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
$sql = "SELECT * FROM procedimento_medico WHERE id_procedimento = $id LIMIT 1";
$resultado = $conexao->prepare($sql);

if($resultado->execute()){
    $x = $resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>

<div class="container">
    <h4 class="mb-4">EDITAR PROCEDIMENTO</h4>
    <form method="POST" action="editar_adm.php">  
        <?php foreach ($x as $y) { ?>
            <div class="form-group">
                <label for="procedimento" style="font-size:12px;" class="form-label">PROCEDIMENTO</label>
                <input required type="text" style="font-size:12px;" name="procedimento" class="form-control" id="procedimento" value="<?php echo $y["procedimento"]; ?>" />
            </div>


            <input type="hidden" name="id_procedimento" value="<?php echo $y["id_procedimento"]; ?>">
        <?php } ?>

        <input type="hidden" name="cpf_logado" value="<?php echo $cpf_logado ?>">    

        <div class="form-group">
            <button class="btn btn-primary" style="font-size:10px;" type="submit">SALVAR</button>
            <a class="btn btn-danger" style="font-size:10px;" href="tb_procedimentos_adm.php">VOLTAR</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Quando o usuário digitar algo no input, convertemos para maiúsculas
        $('input').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>