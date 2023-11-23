<?php
$timezone = new DateTimeZone('America/Sao_Paulo');
 require_once("head.php");


 session_start();
 if(isset($_SESSION['cpf_uaps']) == FALSE){
    header("Location:../index.php");
}
 $cpf_logado = $_SESSION['cpf_uaps'];
 include "head.php";
 include "navibar.php";
 require_once("../conexao.php");
 include "../footer.php";
 $dado = $_POST["nome"];

 $query_usuarios ="SELECT * FROM tabela WHERE nome_paciente LIKE '%$dado%' OR rg LIKE '%$dado%' OR cns LIKE '%$dado%' OR cpf LIKE '%$dado%' OR nascimento LIKE '%$dado%'";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>
<ul class="nav navbar-nav float-right mt-4 mr-4">
              <li class="nav-item">
              <form method = "POST" action = "pesquisa.php">
                      <div class="input-group">
                        
                          <div class="form-outline">
                              <input type="search" id="pesquisa" name = "nome" class="form-control" oninput="handleInput(event)" placeholder = "BUSCAR PACIENTE"/>
                              <input type = "hidden" name = "cpf" value = "<?php echo $cpf_logado?>">
                          </div>
                          
                          <button style="background-color: #66a7ff; color: white;" type="submit" class="btn">
                          <i class="bi bi-search"></i>
                          </button>
                          </div>
                          
                      </form> 
              </li>
            </ul>
<h4 class="mb-4">SUAP - Sistema Unico de Acompanhamento de Procedimentos</h4>
<a class="btn btn-danger" href="inicio.php">VOLTAR</a><br>
<table class="table table-striped table-compact" style="font-size:12px;">
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
                        <a class="btn" style="color: white; background-color: #66a7ff; font-size:10px; " href = "listar.php?id=<?php echo $d["cod"];?>" role="button">VER MAIS</a>      
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
    <script src="../mascara.js"></script>
</div>

