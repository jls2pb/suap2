<?php 
session_start();
if(isset($_SESSION['cpf_adm']) == FALSE){
    header("Location:index.php");
}$cpf_logado = $_SESSION['cpf_adm'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";

require_once("../conexao.php");
$id = $_SESSION['id'];
$sql = "SELECT * FROM tabela WHERE cod = $id LIMIT 1";
$resultado = $conexao->prepare($sql);
$sql2 = "SELECT * FROM uaps";
$resultado2 = $conexao->prepare($sql2);
$resultado2->execute();
if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>
<h2 class="mb-4">EDITAR PACIENTE</h2>
<form method = "POST" action = "edita_paciente_adm.php">  
            <?php 
                foreach ($x as $y) {

                    $d = $y["nascimento"];
                    $parts = explode("/", $d);  // Dividir a string da data em partes

                    if (count($parts) === 3) {
                        $day = $parts[0];
                        $month = $parts[1];
                        $year = $parts[2];
                        
                        // Criar uma nova string de data formatada
                        $ab = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
                        
                    }        


                    
                    $nome_paricente = $y["nome_paciente"];
                    
            ?>
            
            <div class="form-outline mb-4">
            <label class="form-label">Nome do Paciente</label>
            <input type="text" name = "n_paciente" class="form-control form-control-lg" value = "<?php echo $y["nome_paciente"]; ?>" />
            </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">RG</label>
                    </div>
                    <div class="col">
                        <label class="form-label">CPF</label>
                    </div>
                    <div class="col">
                        <label class="form-label">CNS</label>
                    </div>
                    <div class="col">
                        <label class="form-label">Data de Nascimento</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "rg" class="form-control form-control-lg" value = "<?php echo $y["rg"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "cpf" class="form-control form-control-lg" value = "<?php echo $y["cpf"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "cns" class="form-control form-control-lg" value = "<?php echo $y["cns"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="date" name = "nascimento" class="form-control form-control-lg" value = "<?php echo $ab; ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label">Nome da Mãe</label>
                    <input type="text" name = "n_mae" class="form-control form-control-lg" value = "<?php echo $y["nome_da_mae"]; ?>" />
                </div>
                <div class="row">
                    <div class="col">

                        <label class="form-label">ACS</label>

                    </div>
                    <div class="col">
                        <label class="form-label">UBS</label>
                    </div>
                    <div class="col">
                        <label class="form-label">CELULAR</label>
                    </div>
                    <div class="col">
                        <label class="form-label">TELEFONE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "acs" class="form-control form-control-lg" value = "<?php echo $y["acs"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                         <select class="form-control form-control-lg" name = "ubs" id="ubs">
                         <option value = "<?php echo $y['ubs']; ?>"><?php echo $y["ubs"]; ?></option>
                            <?php 
                            foreach ($resultado2 as $r) {
                             ?>
				<option value = "<?php echo $r['nome_uaps']; ?>"> <?php echo $r["nome_uaps"]; ?></option>
                             <?php
                            }
                            ?>  
                            </select>   
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "celular" class="form-control form-control-lg" value = "<?php echo $y["celular"]; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-4">
                        <input type="text" name = "telefone" class="form-control form-control-lg" value = "<?php echo $y["telefone"]; ?>" />
                        </div>
                    </div>
                </div>
                <input type="hidden" name = "id" value = "<?php echo $y["cod"]; ?>">
                <?php
                }
                ?>
                <input type = "hidden" name = "cpf_logado" value = "<?php echo $cpf_logado ?>">    
                <button class="btn btn-primary " type="submit">SALVAR</button>
                <button class="btn btn-danger "><a class="link-offset-2 link-underline link-underline-opacity-0" style = "color:white" href="listar_adm.php">VOLTAR</a></button>    
            </div>
            </form>
    </div>
</div>



