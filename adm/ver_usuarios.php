<?php 
require_once("head.php");
session_start();
 $cpf_logado = $_SESSION['cpf'];
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

<table class="table table-striped">
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
                <a class="btn text-white" style="background-color: #66a7ff;" href = "form_edita_usuario_adm.php?id=<?php $_GET["id"] = $d["id_usuario"]; echo $_GET["id"];?>" role="button"><b>EDITAR</b></a>
            </td>
            <td>
                <a class="btn text-white btn-danger" href = "excluir_usuario_adm.php?id=<?php $_GET["id"] = $d["id_usuario"]; echo $_GET["id"];?>" role="button"><b>EXCLUIR</b></a>
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
            echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='ver_usuarios.php?page=1&cpf=$cpf_logado '>Primeira</a> ";

            for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                if ($pagina_anterior >= 1) {
                    echo "<a href='ver_usuarios.php?page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                }
            }

            echo "$pagina ";

            for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                if ($proxima_pagina <= $qnt_pagina) {
                    echo "<a href='ver_usuarios.php?page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
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