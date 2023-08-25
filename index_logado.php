
<?php
session_start();
if(isset($_SESSION['cpf']) == FALSE){
    header("Location:index.php");
}
require_once("head.php");
include "menu.php";
include "navibar.php";
include "footer.php";

$cpf_logado = $_SESSION['cpf'];

require_once("conexao.php");
 $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
 $cpf_logado = $_SESSION['cpf'];
 //Setar a quantidade de registros por página
 $limite_resultado = 6;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;


 $query_usuarios = "SELECT DISTINCT ON (nome_paciente) * FROM tabela ORDER BY nome_paciente ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>

<table class="table table-striped">
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
                <a class="btn text-white" style = "background-color: DarkBlue" href = "listar.php?id=<?php echo $d["cod"];?>" role="button">VER MAIS</a>
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
            echo "<a class='btn btn-primary' href='index_logado.php?page=1&cpf=$cpf_logado '>Primeira</a> ";

            for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                if ($pagina_anterior >= 1) {
                    echo "<a href='index_logado.php?page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                }
            }

            echo "$pagina ";

            for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                if ($proxima_pagina <= $qnt_pagina) {
                    echo "<a href='index_logado.php?page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
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
        <script src="mascara.js"></script>
    </div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>




