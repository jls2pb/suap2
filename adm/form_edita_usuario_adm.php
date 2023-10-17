<?php 
session_start();
if(isset($_SESSION['cpf_adm']) == FALSE){
    header("Location:../index.php");
}$cpf_logado = $_SESSION['cpf_adm'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";

require_once("../conexao.php");
$id = $_GET['id'];
$sql = "SELECT * FROM usuario WHERE id_usuario = $id LIMIT 1";
$resultado = $conexao->prepare($sql);


if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>
<h2 class="mb-4">EDITAR USUÁRIO</h2>
<form method = "POST" action = "edita_usuario_adm.php">  
            <?php 
                foreach ($x as $y) { 
                    $nome_tipo = $y["id_tipo"];
                    $sql2 = "SELECT nome_tipo FROM tipo_usuario WHERE id_tipo ='$nome_tipo' ";
$resultado2 = $conexao->query($sql2);
             
            ?>
            
            <div class="form-outline mb-4">
            <label class="form-label">Nome do Usuário</label>
            <input type="text" name = "n_usuario" class="form-control form-control-lg" value = "<?php echo $y["nome"]; ?>" />
            </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">CPF</label>
                    </div>
                    <div class="col">
                        <label class="form-label">FUNÇÃO</label>
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "cpf" class="form-control form-control-lg" value = "<?php echo $y["cpf"]; ?>" />
                        </div>
                    </div>
                
                    <div class="col">
                        <div class="form-outline mb-4">

                        <select  class="form-control " name="funcao" required>
                    <option value="" selected disabled>A função atual é: <?php 
         $nome_tipo = $y["id_tipo"];
        $sql2 = "SELECT nome_tipo FROM tipo_usuario WHERE id_tipo ='$nome_tipo' ";
        $resultado = $conexao->query($sql2);
        if ($resultado) {
            $row = $resultado->fetch(PDO::FETCH_ASSOC);
            if ($row) {
             echo $row['nome_tipo'];
            } else {
              echo "Nome não encontrado";
            }
          } else {
            echo "Erro na consulta SQL"; // Pode ser alterado para uma mensagem de erro personalizada
          } 
          ?></option>
                      <option value="2" id="2">Agendamento</option>
                      <option value="3" id="3">Cadastro</option>
                      <option value="4" id="4">Cadastro-Agendamento</option>
                      <option value="5" id="5">Policlínica</option>
                      <option value="6" id="6">CAPS</option>
                      <option value="7" id="7">CER</option>
                    </select>
                        
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name = "id" value = "<?php echo $y["id_usuario"]; ?>">
                <?php
                }
                ?>
                <input type = "hidden" name = "cpf_logado" value = "<?php echo $cpf_logado ?>">    
                <button class="btn btn-primary " type="submit">SALVAR</button>
                <button class="btn btn-danger "><a class="link-offset-2 link-underline link-underline-opacity-0" style = "color:white" href="ver_usuarios.php">VOLTAR</a></button>    
            </div>
            </form>
    </div>
</div>



