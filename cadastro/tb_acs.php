<?php 
session_start();
if(isset($_SESSION['cpf']) == FALSE){
    header("Location:../index.php");
}
$cpf_logado = $_SESSION['cpf'];
include "head.php";
include "menu.php";
include "navibar.php";
include "../footer.php";
$pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

 //Setar a quantidade de registros por página
 $limite_resultado = 6;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;


 $query_usuarios = "SELECT DISTINCT ON (nome) * FROM acs ORDER BY nome ASC LIMIT $limite_resultado OFFSET $inicio ";
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
<table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">UBS</th>
            <th scope="col">NOME</th>
            <th scope="col">VÍNCULO</th>
            <th scope="col">CNS</th>
            <th scope="col">CPF</th>
            <th scope="col">MICROAREA</th>
            <th scope="col">PESSOAS</th>
            <th scope="col">FAMÍLIAS</th>
            <th scope="col">TRANSPORTE</th>
            
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
        
            ?>
            
            <tr>
            <th scope="row"><?php echo $d["ubs"];?></th>
            <td><?php echo $d["nome"]; ?></td>
            <td><?php echo $d["vinculo"]; ?></td>
            <td><?php echo $d["cns"]; ?></td>
            <td><?php echo $d["cpf"]; ?></td>
            <td><?php echo $d["microarea"]; ?></td>
            <td><?php echo $d["pessoas"]; ?></td>
            <td><?php echo $d["familias"]; ?></td>
            <td><?php echo $d["transporte"]; ?></td>
            <td>
                <a class="btn text-white btn-primary" href="edita_acs.php?id=<?php echo $d['cod'];?>" role="button"><b>EDITAR</b></a>
            </td>
            <td>
                <a class="btn text-white btn-danger" onclick="confirmarExclusao(<?php $_GET['id'] = $d['cod']; echo $_GET['id']; ?>)" role="button"><b>EXCLUIR</b></a>
            </td>
            </tr>
            <?php
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
            echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tb_acs.php?page=1&cpf=$cpf_logado '>Primeira</a> ";

            for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                if ($pagina_anterior >= 1) {
                    echo "<a href='tb_acs.php?page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                }
            }

            echo "$pagina ";

            for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                if ($proxima_pagina <= $qnt_pagina) {
                    echo "<a href='tb_acs.php?page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
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