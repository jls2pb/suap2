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


 $query_usuarios = "SELECT DISTINCT ON (nome_fantasia) * FROM local_atendimento ORDER BY nome_fantasia ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();


?>
<script>
 function confirmarExclusao(id) {
            var confirmacao = confirm("Tem certeza de que deseja excluir este registro?");
            if (confirmacao) {
                // Se o usuário confirmar, redirecione para o script de exclusão PHP
                window.location = "excluir_local.php?id=" + id;
            } else {
                // Se o usuário cancelar, não faça nada
            }
        }
        </script>
    <form method = "POST" action = "pesquisar_local.php">    
    <div class="input-group justify-content-end">
        <div class="form-outline">
            <input type="search" id="pesquisa" name="nome" class="form-control" oninput="handleInput(event)" placeholder="BUSCAR LOCAL" />
            <input type="hidden" name="cpf" value="<?php echo $cpf_logado ?>">
        </div>
        <button style="background-color: #66a7ff; color: white;" type="submit" class="btn">
            <i class="bi bi-search"></i>
        </button>
    </div>
    </form>
    <br>
<table class="table table-striped table-compact" style="font-size:12px;">
        <thead>
            <tr>
            <th scope="col">CNES</th>
            <th scope="col">NOME DO LOCAL</th>
            <th scope="col">ENDEREÇO DO LOCAL</th>
            
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
        
            ?>
            
            <tr>
            <th scope="row"><?php echo $d["cnes"];?></th>
            <td><?php echo $d["nome_fantasia"]; ?></td>
            <td><?php echo $d["endereco_local"]; ?></td>
            <td>
                <a class="btn text-white btn-primary" style="font-size:10px;" href="edita_local.php?id=<?php echo $d['cnes'];?>" role="button"><b>EDITAR</b></a>
            </td>

            <td>
                <a class="btn text-white btn-danger" style="font-size:10px;" onclick="confirmarExclusao(<?php $_GET['local_ag'] = $d['cnes']; echo $_GET['local_ag']; ?>)" role="button"><b>EXCLUIR</b></a>
            </td>
            </tr>
            <?php
                    }

            $query_qnt_registros = "SELECT COUNT(cnes) AS num_result FROM local_atendimento";
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
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tb_local_ag_adm.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
            }
    
            if ($pagina > 1) {
                $pagina_anterior = $pagina - 1;
                echo "<a href='tb_local_ag_adm.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                $proxima_pagina = $pagina + 1;
                echo "<a href='tb_local_ag_adm.php?page=$proxima_pagina&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Próximo'><span aria-hidden='true'>&raquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                ?><div class="float-right"><?php
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tb_local_ag_adm.php?page=$qnt_pagina&cpf=$cpf_logado'>Última</a> ";
            ?></div> <?php
            }

            
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
             echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tb_local_ag_adm.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
             $pagina_anterior = $pagina - 1;
             echo "<a href='tb_local_ag_adm.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
        
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
