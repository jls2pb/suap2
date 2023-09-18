<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf'])){
    $cpf_logado = $_SESSION['cpf'];
include "../footer.php";

include "navibar_paciente.php";
require_once("../conexao.php");
$pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
 $cpf_logado = $_SESSION['cpf'];
$nome_paciente = $_SESSION['nome'];

$query_procedimento = "SELECT * FROM procedimentos WHERE nome_paciente = :nome_paciente";
$result_procedimento = $conexao->prepare($query_procedimento);
$result_procedimento->bindParam(':nome_paciente', $nome_paciente, PDO::PARAM_STR);
$result_procedimento->execute();
?>
<br>
<p style="padding-left: 10px;">SEJA BEM VINDO(A) <?php echo $nome_paciente; ?></p>

<table style=""class="table table-striped table-bordered table-sm table-responsive">
        <thead style="background-color: #66a7ff;" class="thead text-white">
            <tr>
            <th scope="col">PROCEDIMENTO</th>
            <th scope="col">DATA DA SOLICITAÇÃO</th>
            <th scope="col">DATA DA ENTRADA</th>
            <th scope="col">DATA DA SAIDA</th>
            <th scope="col">DATA DO AGENDAMENTO</th>
            <th scope="col">LOCAL DO AGENDAMENTO</th>
            <th scope="col">OBSERVAÇÃO</th>
            
            <th scope="col">ESPECIFICAÇÃO</th>
            <th scope="col">AÇÃO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_procedimento) AND ($result_procedimento->rowCount() != 0)) {
                    while ($d = $result_procedimento->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
                        $query_profissionais = "SELECT * FROM agendamento WHERE procedimento = :cod";
                        $result_profissionais = $conexao->prepare($query_profissionais);
                        $result_profissionais->bindParam(':cod', $d['cod'], PDO::PARAM_INT);
                        
                        $result_profissionais->execute();
                        $row = $result_profissionais->fetch(PDO::FETCH_ASSOC);
        
                        // Use $row_profissional['nome'] para obter o nome do profissional
                        $data = $row['data_atendimento'];
                        $local = $row['local_atendimento'];
                        
            ?>
            
            <tr>
            <th scope="row"><?php echo $d["procedimento"]; ?></th>
            <td><?php echo $d["data_da_solicitacao"]; ?></td>
            <td><?php echo $d["data_de_entrada_cadastro"]; ?></td>
            <td><?php echo $d["data_da_saida"]; ?></td>
            <td><?php echo $data; ?></td>
            <td><?php echo $local; ?></td>
            <td><?php echo $d["observacao"]; ?></td>
            
            <td><?php echo $d["especificacao"]; ?></td>
            <td>
                  <a class="btn text-white" style="background-color: #66a7ff;" href = "ver_status.php?id=<?php echo $d["cod"];?>" role="button">VER STATUS</a>
            </td>
                          
            </tr>
            <?php
                    }
            } else {
            echo "<p style='color: #f00;'>Erro: Nenhum paciente encontrado!</p>";
            }  
        }
        else {
          header("location: ../index.php");
        }
            ?>
                </div>
            </div> 
        </tbody>
        </table>

        <script src="mascara.js"></script>
    </div>
</div>
