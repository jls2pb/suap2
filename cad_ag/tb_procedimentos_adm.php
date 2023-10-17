﻿<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf_cad_ag'])){
 $cpf_logado = $_SESSION['cpf_cad_ag'];
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


 $query_usuarios = "SELECT DISTINCT ON (procedimento) * FROM procedimento_medico ORDER BY procedimento ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();


?>
<script>
 function confirmarExclusao(id) {
            var confirmacao = confirm("Tem certeza de que deseja excluir este registro?");
            if (confirmacao) {
                // Se o usuário confirmar, redirecione para o script de exclusão PHP
                window.location = "excluir_tb_procedimentos.php?id=" + id;
            } else {
                // Se o usuário cancelar, não faça nada
            }
        }
        </script>
<table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">PROCEDIMENTO</th>
            
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 

                        extract($d); 
			if($d["procedimento"] != NULL){
        
            ?>
            
            <tr>
            <td><?php echo $d["procedimento"]; ?></td>
            <td>
		<a class="btn text-white btn-primary" href="edita_procedimentos.php?id=<?php echo $d['id_procedimento'];?>" role="button"><b>EDITAR</b></a>
                
            </td>
            <td>
		<a class="btn text-white btn-danger" onclick="confirmarExclusao(<?php echo $d['id_procedimento']; ?>)" role="button"><b>EXCLUIR</b></a>
                
            </td>
            </tr>
            <?php
                    }
		}
            $query_qnt_registros = "SELECT COUNT(procedimento) AS num_result FROM procedimento_medico";
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
            echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tb_procedimentos_adm.php?page=1&cpf=$cpf_logado '>Primeira</a> ";

            for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                if ($pagina_anterior >= 1) {
                    echo "<a href='tb_procedimentos_adm.php?page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                }
            }

            echo "$pagina ";

            for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                if ($proxima_pagina <= $qnt_pagina) {
                    echo "<a href='tb_procedimentos_adm.php?page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
                }
            }

            
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
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