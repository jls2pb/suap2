<?php 
require_once("head.php");
session_start();

include "menu_agendamento.php";
include "navibar_agendamento.php";

require_once("conexao.php");
$pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
 $cpf_logado = $_SESSION['cpf_agendar'];
 //Setar a quantidade de registros por página
 $limite_resultado = 6;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;


 $query_usuarios = "SELECT DISTINCT ON (nome_profissional) * FROM profissional ORDER BY nome_profissional ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();
?>
<table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">COD</th>
            <th scope="col">NOME PROFISSIONAL</th>
            <th scope="col">CARGO</th>
            <th scope="col">DATA</th>
            <th scope="col">HORÁRIO</th>
           
            </tr>
        </thead>
        <tbody>
            
            <tr>
            <th scope="row"><?php echo $d["cod"]; ?></th>
            <td><?php echo $d["nome_profissional"]; ?></td>
            <td><?php echo $d["cargo"]; ?></td>
            <td><?php echo $d["data"]; ?></td>
            <td><?php echo $d["horario"] ?></td>
            <td>
                <a class="btn text-white" style="background-color: #66a7ff;" href = "listar.php?id=<?php echo $d["cod"];?>" role="button">VER MAIS</a>
            </td>
            </tr>
            <?php
                    
            $query_qnt_registros = "SELECT COUNT(cod) AS num_result FROM profissional";
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
            echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='index_logado.php?page=1&cpf=$cpf_logado '>Primeira</a> ";

            for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                if ($pagina_anterior >= 1) {
                    echo "<a href='lista_profissional.php?page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                }
            }

            echo "$pagina ";

            for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                if ($proxima_pagina <= $qnt_pagina) {
                    echo "<a href='lista_profissional.php?page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
                }
            }

            
        
                
            ?>
                </div>
            </div> 
        </tbody>
        </table>
        <script src="mascara.js"></script>
    </div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>