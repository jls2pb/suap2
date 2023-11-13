<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf_adm'])){
 $cpf_logado = $_SESSION['cpf_adm'];
include "menu_adm.php";
include "navibar_adm.php";

include "../footer.php";
require_once("../conexao.php");

$pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

 //Setar a quantidade de registros por página
 $limite_resultado = 6;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;

 $dado = $_POST["nome"];
 $query_usuarios = "SELECT * FROM acs WHERE CAST(cns AS TEXT) LIKE '%$dado%' OR nome LIKE '%$dado%' OR ubs LIKE '%$dado%' OR cpf LIKE '%$dado%' OR vinculo LIKE '%$dado%' ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();


?>
<script>
 function confirmarExclusao(id) {
            var confirmacao = confirm("Tem certeza de que deseja excluir este registro?");
            if (confirmacao) {
                // Se o usuário confirmar, redirecione para o script de exclusão PHP
                window.location = "excluir_acs.php?id=" + id;
            } else {
                // Se o usuário cancelar, não faça nada
            }
        }
        </script>
<form method = "POST" action = "pesquisar_acs.php">    
    <div class="input-group justify-content-end">
        <div class="form-outline">
            <input type="search" id="pesquisa" name="nome" class="form-control" oninput="handleInput(event)" placeholder="BUSCAR ACS" />
            <input type="hidden" name="cpf" value="<?php echo $cpf_logado ?>">
        </div>
        <button style="background-color: #66a7ff; color: white;" type="submit" class="btn">
            <i class="bi bi-search"></i>
        </button>
    </div>
    </form>
<table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">UBS</th>
            <th scope="col">NOME</th>
            <th scope="col">CNS</th>
            <th scope="col">MICROAREA</th>
            <th scope="col">PESSOAS</th>
            <th scope="col">FAMÍLIAS</th>
            <th scope="col" colspan = "2"><center> AÇÃO </center> </th>
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
        		if($d["nome"] != NULL){
            ?>
            
            <tr>
            <th scope="row"><?php echo $d["ubs"];?></th>
            <td><?php echo $d["nome"]; ?></td>
            <td><?php echo $d["cns"]; ?></td>
            <td><?php echo $d["microarea"]; ?></td>
            <td><?php echo $d["pessoas"]; ?></td>
            <td><?php echo $d["familias"]; ?></td>

            <td>
                <a class="btn text-white btn-primary" href="edita_acs.php?id=<?php echo $d['cod'];?>" role="button"><b>EDITAR</b></a>
            </td>
            <td>
                <a class="btn text-white btn-danger" onclick="confirmarExclusao(<?php $_GET['id'] = $d['cod']; echo $_GET['id']; ?>)" role="button"><b>EXCLUIR</b></a>
            </td>
            </tr>
            <?php
                    }
		}
            $query_qnt_registros = "SELECT COUNT(cod) AS num_result FROM acs";
            $result_qnt_registros = $conexao->prepare($query_qnt_registros);
            $result_qnt_registros->execute();
            $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

            //Quantidade de página
            $qnt_pagina = ceil($row_qnt_registros['num_result'] / $limite_resultado);

            // Maximo de link
            $maximo_link = 2;
            ?>
              <div class = "row">
                <div class = "col">        
            <?php 
               if ($pagina > 1) {
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tb_acs_adm.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
            }
    
            if ($pagina > 1) {
                $pagina_anterior = $pagina - 1;
                echo "<a href='tb_acs_adm.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                $proxima_pagina = $pagina + 1;
                echo "<a href='tb_acs_adm.php?page=$proxima_pagina&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Próximo'><span aria-hidden='true'>&raquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                ?><div class="float-right"><?php
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tb_acs_adm.php?page=$qnt_pagina&cpf=$cpf_logado'>Última</a> ";
            ?></div> <?php
            }

            
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
             echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tb_acs_adm.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
             $pagina_anterior = $pagina - 1;
             echo "<a href='tb_acs_adm.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
        
        }  
                
            ?>
                </div>
            </div> 
        </tbody>
        </table>
        <script src="../mascara.js"></script>
    </div>
</div>
<?php 
}else{
    header("Location:../index.php");
}
?>
