<?php
$timezone = new DateTimeZone('America/Sao_Paulo');
 require_once("head.php");


 session_start();
 $cpf_logado = $_SESSION['cpf_adm'];
 include "head.php";
 include "menu_adm.php";
 include "navibar_adm.php";
 require_once("../../conexao.php");
 
 $dado = $_POST["nome"];

 $query_usuarios ="SELECT * FROM local_atendimento WHERE nome_paciente LIKE '%$dado%' OR rg LIKE '%$dado%' OR cns LIKE '%$dado%' OR cpf LIKE '%$dado%' OR nascimento LIKE '%$dado%'";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>

<h2 class="mb-4">SUAP - Sistema Unico de Acompanhamento de Procedimentos</h2>

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
            $teste = NULL;
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                               
            
                        <tr>
                        <th scope="row"><?php echo $d["cod"]; ?></th>
                        <td><?php echo $d["nome_paciente"]; ?></td>
                        <td><?php echo $d["rg"]; ?></td>
                        <td><?php echo $d["cpf"]; ?></td>
                        <td><?php echo $d["nascimento"]; ?></td>
                        <td>
                        <a class="btn" style="color: white; background-color: #66a7ff;" href = "listar_adm.php?id=<?php echo $d["cod"];?>" role="button">VER MAIS</a>      
                        </td>
                        </tr>
                    <?php
                        extract($d); 
            
                    }
                } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
        }  
                
            ?>
        </tbody>
        </table>


    </div>
</div>

