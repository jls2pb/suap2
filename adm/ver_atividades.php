<?php 
require_once("head.php");
session_start();
 $cpf_logado = $_SESSION['cpf'];
include "menu_adm.php";
include "navibar_adm.php";

include "../footer.php";
require_once("../conexao.php");
?>
<?php
 $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

 //Setar a quantidade de registros por página
 $limite_resultado = 6;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;

 $query_usuarios = "SELECT DISTINCT ON (data_modificacao) * FROM tb_log ORDER BY data_modificacao ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>

<h2 class="mb-4">AÇÕES REALIZADAS</h2>
<table class="table table-striped">
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

                    $query_qnt_registros = "SELECT COUNT(id_log) AS num_result FROM tb_log";
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
                    echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='ver_atividades.php?page=1&cpf=$cpf_logado '>Primeira</a> ";
        
                    for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                        if ($pagina_anterior >= 1) {
                            echo "<a href='ver_atividades.php?page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                        }
                    }
        
                    echo "$pagina ";
        
                    for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                        if ($proxima_pagina <= $qnt_pagina) {
                            echo "<a href='ver_atividades.php?page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
                        }
                    }

                    
                } else {
            echo "<p style='color: #f00;'>Erro: Nenhum dado encontrado!</p>";
        }  
                
            ?>
        </tbody>
        </table>
        