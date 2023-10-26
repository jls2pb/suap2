<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf_caps'])){
    $cpf_logado = $_SESSION['cpf_caps'];
    include "../footer.php";
    include "navibar.php";
    require_once("../conexao.php");
    ?>
    <?php
    $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    // Setar a quantidade de registros por página
    $limite_resultado = 6;

    // Calcular o início da visualização
    $hoje = date('d/m/Y');
    $inicio = ($limite_resultado * $pagina) - $limite_resultado;
    $query = "SELECT * FROM agendamento WHERE status = 0 AND data_atendimento = '$hoje' AND local_atendimento = 'CAPS II DE SAO GONCALO DO AMARANTE' ORDER BY nome_paciente ASC LIMIT $limite_resultado OFFSET $inicio";
    $result = $conexao->prepare($query);
    $result->execute();
    
    ?>
    <br>
    <a style="" href="ver_agendamentos.php" class="btn btn-primary text-white float-right" role="button">VER TODOS OS AGENDAMENTOS</a>

    <h2 style="padding-left: 10px;">TABELA DE AGENDAMENTOS EM ESPERA</h2>

    <table style="" class="table table-striped table-bordered table-sm table-responsive">
        <thead style="background-color: #66a7ff;" class="thead text-white">
            <tr>
                <th scope="col">DATA DO ATENDIMENTO</th>
                <th scope="col">HORA</th>
                <th scope="col">NOME DO PACIENTE</th>
                <th scope="col">SEXO</th>
                <th scope="col">ENDEREÇO RESIDENCIAL</th>
                <th scope="col">CPF</th>
                <th scope="col">ENDEREÇO LOCAL</th>
                <th scope="col">NOME DO PROFISSIONAL</th>
                <th scope="col">LOCAL DO ATENDIMENTO</th>
                <th scope="col">PROCEDIMENTO</th>
                <th scope="col">STATUS</th>
                <th scope="col">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (($result) && ($result->rowCount() != 0)) {
                while ($d = $result->fetch(PDO::FETCH_ASSOC)) { 
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
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $procedimento = $row['procedimento'];
            ?>
                    <tr>
                        <td><?php
                            $dia = date('d/m/Y', strtotime($d["data_atendimento"]));
                            echo $dia; 
                        ?></td>
                        <td><?php echo $d["hora"]; ?></td>
                        <td><?php echo $d["nome_paciente"]; ?></td>
                        <td><?php echo $d["sexo"]; ?></td>
                        <td><?php echo $d["endereco"]; ?></td>
                        <td><?php echo $d["cpf"]; ?></td>
                        <td><?php echo $d["endereco_local"]; ?></td>
                        <td><?php echo $nome_profissional; ?></td>
                        <td><?php echo $d["local_atendimento"]; ?></td>
                        <td><?php echo $procedimento; ?></td>
                        <td><?php $status = $d["status"]; 
                            if ($status == 0){
                                echo "Em espera";
                            }
                        ?></td>
                        <td>
                            <a class="btn text-white" style="background-color: #66a7ff;" href="editar_agendamento.php?id=<?php echo $d["id_agendamento"];?>">COMPARECEU</a>
                            <a class="btn text-white btn-danger" onclick="confirmarExclusao(<?php echo $d['id_agendamento'] ; ?>)" >NÃO COMPARECEU</a>
                        </td>
                    </tr>
            <?php
                }

                $query_qnt_registros = "SELECT COUNT(id_agendamento) AS num_result FROM agendamento WHERE status = 0";
                $result_qnt_registros = $conexao->prepare($query_qnt_registros);
                $result_qnt_registros->execute();
                $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

                // Quantidade de página
                $qnt_pagina = ceil($row_qnt_registros['num_result'] / $limite_resultado);

                // Máximo de link
                $maximo_link = 2;
                ?>
           <div class = "row">
                <div class = "col">        
            <?php 
               if ($pagina > 1) {
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='inicio.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
            }
    
            if ($pagina > 1) {
                $pagina_anterior = $pagina - 1;
                echo "<a href='inicio.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                $proxima_pagina = $pagina + 1;
                echo "<a href='inicio.php?page=$proxima_pagina&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Próximo'><span aria-hidden='true'>&raquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                ?><div class="float-right"><?php
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='inicio.php?page=$qnt_pagina&cpf=$cpf_logado'>Última</a> ";
            ?></div> <?php
            }

            
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
             echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='inicio.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
             $pagina_anterior = $pagina - 1;
             echo "<a href='inicio.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
        
        }  
                
            ?>
                </div>
            </div> 
      
        <?php
  }
        
        else {
            header("location: ../index.php");
        }
        ?>
        <script>
  function confirmarExclusao(id) {
            var confirmacao = confirm("CONFIRMAÇÃO DE NÃO COMPARECIMENTO:");
            if (confirmacao) {
                // Se o usuário confirmar, redirecione para o script de exclusão PHP
                window.location = "editar_comparecimento.php?&id=" + id;
            } else {
                // Se o usuário cancelar, não faça nada
            }
        }

   </script>  
