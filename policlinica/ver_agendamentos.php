<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf_policlinica']) == FALSE){
    header("Location:../index.php");
}
 $cpf_logado = $_SESSION['cpf_policlinica'];

include "navibar.php";

include "../footer.php";
require_once("../conexao.php");

$pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

 //Setar a quantidade de registros por página
 $limite_resultado = 20;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;


 $query_usuarios = "SELECT DISTINCT ON (nome_paciente) * FROM agendamento  WHERE local_atendimento = 'POLICLINICA MUNICIPAL DE SAO GONÇALO DO AMARANTE' ORDER BY nome_paciente ASC LIMIT $limite_resultado OFFSET $inicio";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();


?>
<a style="margin: 23px; font-size:10px;" href="inicio.php" class="btn btn-danger text-white float-right" role="button">VOLTAR</a>

<table class="table table-striped table-bordered table-sm table-responsive" style="font-size:12px;">
        <thead>
            <tr>
            <th scope="col">PROFISSIONAL</th>
            <th scope="col">NOME DO PACIENTE</th>
            <th scope="col">DATA</th>
            <th scope="col">HORA</th>
            <th scope="col">ENDEREÇO DO LOCAL</th>
            <th scope="col">LOCAL DO ATENDIMENTO</th>
            <th scope="col">PROCEDIMENTO</th>
            <th scope="col">STATUS</th>
       
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
                        $query_profissionais = "SELECT nome FROM profissionais WHERE id_profissional = :cod_profissional";
                        $result_profissionais = $conexao->prepare($query_profissionais);
                        $result_profissionais->bindParam(':cod_profissional', $d['cod_profissional'], PDO::PARAM_INT);
                        $result_profissionais->execute();
                   
        
                        if ($result_profissionais && $result_profissionais->rowCount() > 0) {
                            $row_profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
        
                            // Use $row_profissional['nome'] para obter o nome do profissional
                            $nome_profissional = $row_profissional['nome'];  }
                            else {
                                // Trate o caso em que a consulta não retornou nenhum resultado
                                $nome_profissional = "Profissional não encontrado";
                            }
        
                            $query = "SELECT procedimento FROM procedimentos WHERE id = :cod";
                            $result = $conexao->prepare($query);
                            $result->bindParam(':cod', $d['procedimento'], PDO::PARAM_INT);
                            $result->execute();
                            if ($result && $result->rowCount() > 0) {
                                $row = $result->fetch(PDO::FETCH_ASSOC);
            
                                // Use $row_profissional['nome'] para obter o nome do profissional
                                $nome_proc = $row['procedimento'];  }
                                else {
                                    // Trate o caso em que a consulta não retornou nenhum resultado
                                    $nome_proc = "Procedimento não encontrado";
                                }
                           
            ?>
            
            <tr>
            <td><?php echo $nome_profissional;?></td>
            <td><?php echo $d["nome_paciente"]; ?></td>
            <td><?php 
            $data = date('d/m/Y', strtotime($d["data_atendimento"]));
            echo $data;
            ?></td>
            <td><?php echo $d["hora"]; ?></td>
            <td><?php echo $d["endereco_local"]; ?></td>
            <td><?php echo $d["local_atendimento"]; ?></td>
            <td><?php echo $nome_proc; ?></td>
            <td><?php $status = $d["status"]; 
                    if ($status==0){
                        echo "Em espera";
                    }
                    else if ($status==1) {
                        echo "Compareceu";
                    }
                    else {
                        echo "Não compareceu";
                    }
                    ?></td>
                      
            
            </tr>
            <?php
                    }

                    $query_qnt_registros = "SELECT COUNT(id_agendamento) AS num_result FROM agendamento";
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
                echo "<a class='btn' style='color: white; background-color: #66a7ff; font-size:12px;' href='ver_agendamentos.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
            }
    
            if ($pagina > 1) {
                $pagina_anterior = $pagina - 1;
                echo "<a href='ver_agendamentos.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:20px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                $proxima_pagina = $pagina + 1;
                echo "<a href='ver_agendamentos.php?page=$proxima_pagina&cpf=$cpf_logado' class='btn'><label style='font-size:20px;' title='Próximo'><span aria-hidden='true'>&raquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                ?><div class="float-right"><?php
                echo "<a class='btn' style='color: white; background-color: #66a7ff; font-size:12px;' href='ver_agendamentos.php?page=$qnt_pagina&cpf=$cpf_logado'>Última</a> ";
            ?></div> <?php
            }

            
        } else {
            echo "<p style='color: #f00; font-size:10px;'>Erro: Nenhum usuário encontrado!</p>";
             echo "<a class='btn' style='color: white; background-color: #66a7ff; font-size:10px;' href='ver_agendamentos.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
             $pagina_anterior = $pagina - 1;
             echo "<a href='ver_agendamentos.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:20px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
        
        }  
                
            ?>
                </div>
            </div> 
        </tbody>
        </table>
        <script src="../mascara.js"></script>
    </div>
</div>
