<?php
 session_start();
if(isset($_SESSION['cpf_adm']) == FALSE){
    header("Location:../index.php");
}$cpf_logado = $_SESSION['cpf_adm'];
require_once("../conexao.php");
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";


 $dado = $_SESSION['id'];
 $query_usuarios ="SELECT * FROM tb_log WHERE id_paciente = '$dado'";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>

<h4 class="mb-4">AÇÕES REALIZADAS</h4>
<p><a class="link-offset-2 link-underline link-underline-opacity-0" href="listar_adm.php">VOLTAR</a></p>
<table class="table table-striped table-compact" style="font-size:12px;">
        <thead>
            <tr>
            <th scope="col">COD</th>
            <th scope="col">AÇÃO</th>
            <th scope="col">PACIENTE</th>
            <th scope="col"> CPF MODIFICADOR </th>
            <th scope="col">DATA MODIFICAÇÃO</th>
            <th scope="col">HORA MODIFICAÇÃO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
            ?>
            
            <tr>
            <th scope="row"><?php echo $d["id_log"]; ?></th>
            <td><?php echo $d["acao"]; ?></td>
            <td><?php echo $d["nome_paciente"]; ?></td>
            <td><?php echo $d["cpf_modificador"]; ?></td>
            <td><?php echo $d["data_modificacao"]; ?></td>
            <td><?php echo $d["hora"]; ?></td>
            </tr>
            <?php
                    }
                } else {
            echo "<p style='color: #f00;'>Erro: Nenhum dado encontrado!</p>";
        }  
                
            ?>
        </tbody>
        </table>
    </div>
</div>





