<?php 
require_once("head.php");
session_start();
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


 $query_usuarios = "SELECT DISTINCT ON (nome) * FROM usuario ORDER BY nome ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();


?>
<script>
 function confirmarExclusao(id) {
            var confirmacao = confirm("Tem certeza de que deseja excluir este registro?");
            if (confirmacao) {
                // Se o usuário confirmar, redirecione para o script de exclusão PHP
                window.location = "excluir_usuario_adm.php?id= " + id;
            } else {
                // Se o usuário cancelar, não faça nada
            }
        }
        </script>
<table class="table table-striped table-compact" style="font-size:12px;">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">NOME USUÁRIO</th>
            <th scope="col">CPF</th>
            <th scope="col">FUNÇÃO</th>
            <th scope="col">AÇÃO</th>
            <th scope="col">AÇÃO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
        
            ?>
            
            <tr>
            <th scope="row"><?php echo $d["id_usuario"];?></th>
            <td><?php echo $d["nome"]; ?></td>
            <td><?php echo $d["cpf"]; ?></td>
            <td><?php
            
        $nome_tipo = $d["id_tipo"];
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
          } ?>
          
        </td>
            <td>
                <a class="btn text-white" style="background-color: #66a7ff; font-size:10px;" href = "form_edita_usuario_adm.php?id=<?php $_GET["id"] = $d["id_usuario"]; echo $_GET["id"];?>" role="button"><b>EDITAR</b></a>
            </td>
            <td>
                <a class="btn text-white btn-danger text-white" style="font-size:10px;margin:5px; onclick="confirmarExclusao(<?php $_GET['id'] = $d['id_usuario']; echo $_GET['id']; ?>)" role="button"><b>EXCLUIR</b></a>
            </td>
            </tr>
            <?php
                    }

            $query_qnt_registros = "SELECT COUNT(id_usuario) AS num_result FROM usuario";
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
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='ver_usuarios.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
            }
    
            if ($pagina > 1) {
                $pagina_anterior = $pagina - 1;
                echo "<a href='ver_usuarios.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                $proxima_pagina = $pagina + 1;
                echo "<a href='ver_usuarios.php?page=$proxima_pagina&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Próximo'><span aria-hidden='true'>&raquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                ?><div class="float-right"><?php
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='ver_usuarios.php?page=$qnt_pagina&cpf=$cpf_logado'>Última</a> ";
            ?></div> <?php
            }

            
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
             echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='ver_usuarios.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
             $pagina_anterior = $pagina - 1;
             echo "<a href='ver_usuarios.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
        
        }  
                
            ?>
                </div>
            </div> 
        </tbody>
        </table>
        <script src="../mascara.js"></script>
    </div>
</div>