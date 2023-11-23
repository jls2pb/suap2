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

    $sql1 = "SELECT cod FROM tabela WHERE cpf = :cpf_logado";
    $result_paciente = $conexao->prepare($sql1);
    $result_paciente->bindParam(':cpf_logado', $cpf_logado, PDO::PARAM_STR);
    $result_paciente->execute();
    $paciente = $result_paciente->fetch(PDO::FETCH_ASSOC);
    $cod = $paciente['cod'];

    $query_procedimento = "SELECT * FROM procedimentos WHERE cod = :cod";
    $result_procedimento = $conexao->prepare($query_procedimento);
    $result_procedimento->bindParam(':cod', $cod, PDO::PARAM_INT);
    $result_procedimento->execute();
    ?>

    <br>
    <p style="padding-left: 10px;">SEJA BEM VINDO(A) <?php echo $nome_paciente; ?></p>

    <table class="table table-striped table-bordered table-sm table-responsive">
        <thead style="background-color: #66a7ff; font-size:12px" class="thead text-white">
            <tr>
                <th scope="col">PROCEDIMENTO</th>
				<th scope="col">STATUS</th>
                <th scope="col">PROFISSIONAL</th>
                <th scope="col">DATA DA CONSULTA</th>
                <th scope="col">LOCAL AGENDAMENTO</th>
                
            </tr>
			
        </thead>
        <tbody>
        <?php
        if (($result_procedimento) && ($result_procedimento->rowCount() > 0)) {
            while ($d2 = $result_procedimento->fetch(PDO::FETCH_ASSOC)) {
                if($d2["procedimento"] != NULL){

               
<<<<<<< HEAD

                // Processar os dados do procedimento aqui
                $solicitacao = ($d2["data_da_solicitacao"] != NULL) ? date('d/m/Y', strtotime($d2["data_da_solicitacao"])) : NULL;
                $entrada = ($d2["data_de_entrada_cadastro"] != NULL) ? date('d/m/Y', strtotime($d2["data_de_entrada_cadastro"])) : NULL;
                $saida = ($d2["data_da_saida"] != NULL ) ? date('d/m/Y', strtotime($d2["data_da_saida"])) : NULL;
                $agendamento = ($d2["data_do_agendamento"] != NULL) ? date('d/m/Y', strtotime($d2["data_do_agendamento"])) : NULL;
        ?>
            <tr>
                <td><?php echo $d2["procedimento"]; ?></td> 
                <td><?php echo $d2["profissional"]; ?></td>
                <td><?php echo $solicitacao ?></td>  
               
                <td><?php echo $agendamento ?></td>
                <td><?php echo $d2["local_do_agendamento"]; ?></td>
                <td>
                <?php 
                    $id = $d2["id"];
                    $sql = "SELECT * FROM agendamento WHERE procedimento = :id";
                    $stmt = $conexao->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        echo "Agendado";
                    } else {
                        if($agendamento != NULL){
                            echo "Agendado";
                        }else{
                            echo "Aguardando Agendamento";
=======
               
                $agendamento = ($d2["data_do_agendamento"] != NULL) ? date('d/m/Y', strtotime($d2["data_do_agendamento"])) : NULL;
        ?>
            <tr>
                <td><?php echo $d2["procedimento"]; ?></td>
				<td>
                <?php
                      $id = $d2['id'];
                      $query = "SELECT status FROM agendamento WHERE procedimento = $id";
                      $result = $conexao->prepare($query);
                      $result->execute();

                      $query1 = "SELECT status FROM procedimentos WHERE id = $id";
                      $result1 = $conexao->prepare($query1);
                      $result1->execute();

                      $statusArray = [];

                      if ($result && $result->rowCount() > 0) {
                          $statusRow = $result->fetch(PDO::FETCH_ASSOC);
                          $statusArray[] = $statusRow['status'];
                      } elseif ($result1 && $result1->rowCount() > 0) {
                          $statusRow1 = $result1->fetch(PDO::FETCH_ASSOC);
                          $statusArray[] = $statusRow1['status'];
                      }
                      

                      if (count($statusArray) > 0) {
                          // Os resultados das duas consultas estão em $statusArray
                          foreach ($statusArray as $status) {
                            if ($status === 0) {
                                echo "AGENDADO";
                            } elseif ($status === 1) {
                                echo "COMPARECEU";
                            } elseif ($status === 2) {
                                echo "NÃO COMPARECEU";
                            } elseif ($status === 3) {
                                echo "AGUARDANDO AGENDAMENTO";
                            } elseif ($status === 4) {
                                echo "DEVOLVIDA À UAPS";
                            } elseif ($status === 5) {
                              echo "RETIRADA DO SETOR";
                            } elseif ($status === 6) {
                                echo "ENCAMINHADA À POLICLÍNICA";
                            } elseif ($status === 7) {
                                echo "ENCAMINHADA AO HGLAS";
                            } elseif ($status === 8) {
                                echo "ENCAMINHADA AO CAPS";
                            } elseif ($status === 9) {
                              echo "ENCAMINHADA AO CER";
                           }
>>>>>>> 2d170ae99c2c9e95445a9008d4048fb79816f9a3
                        }
                      } else {
                          echo "AGUARDANDO";
                      }
                      ?>
                </td>	
                <td><?php echo $d2["profissional"]; ?></td>
                <td><?php echo $agendamento ?></td>
                <td><?php echo $d2["local_do_agendamento"]; ?></td>
                
            </tr>
        <?php
            }
        }
        } else {
            echo "<tr><td colspan='10' style='color: #f00; font-size:12px'>Nenhum agendamento encontrado!</td></tr>";
        }  
        
    } else {
        header("location: index.php");
    }
    ?>
        </tbody>
    </table>
    <script src="../mascara.js"></script>
</div>
</div>
