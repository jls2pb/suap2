<?php
session_start();
if(isset($_SESSION['cpf_adm']) == FALSE){
    header("Location:index.php");
}$cpf_logado = $_SESSION['cpf_adm'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../../footer.php";



require_once("../../conexao.php");
 $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
 $cpf_logado = $_SESSION['cpf_adm'];
 //Setar a quantidade de registros por página
 $limite_resultado = 6;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;


 $query_usuarios = "SELECT DISTINCT ON (nome_paciente) * FROM tabela ORDER BY nome_paciente ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>

<table class="table table-responsive  table-striped">
        <thead>
            <tr>
            <th scope="col">COD</th>
            <th scope="col">NOME PACIENTE</th>
            <th scope="col">RG</th>
            <th scope="col">CPF</th>
            <th scope="col">DATA DE NASCIMENTO</th>
            <th scope="col">AÇÃO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
                        if($d["nascimento"] != NULL){
                            $nascimento = date('d/m/Y', strtotime($d["nascimento"]));
                        }else{
                            $nascimento = NULL;
                        }
            ?>
            
            <tr>
            <th scope="row"><?php echo $d["cod"]; ?></th>
            <td><?php echo $d["nome_paciente"]; ?></td>
            <td><?php echo $d["rg"]; ?></td>
            <td><?php echo $d["cpf"]; ?></td>
            <td><?php echo $d["nascimento"] ?></td>
            <td>
                <a class="btn text-white" style="background-color: #66a7ff;" href = "listar_adm.php?id=<?php echo $d["cod"];?>" role="button">VER MAIS</a>
            </td>
            </tr>
            <?php
                    }

            $query_qnt_registros = "SELECT COUNT(cod) AS num_result FROM tabela";
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
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='index_logado_adm.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
            }
    
            if ($pagina > 1) {
                $pagina_anterior = $pagina - 1;
                echo "<a href='index_logado_adm.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                $proxima_pagina = $pagina + 1;
                echo "<a href='index_logado_adm.php?page=$proxima_pagina&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Próximo'><span aria-hidden='true'>&raquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                ?><div class="float-right"><?php
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='index_logado_adm.php?page=$qnt_pagina&cpf=$cpf_logado'>Última</a> ";
            ?></div> <?php
            }

            
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
             echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='index_logado_adm.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
             $pagina_anterior = $pagina - 1;
             echo "<a href='index_logado_adm.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
        
        }  
                
            ?>
                </div>
            </div> 
        </tbody>
        </table>
        <script src="../../mascara.js"></script>
    </div>
</div>





