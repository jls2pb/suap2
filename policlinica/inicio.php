<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf_policlinica'])){
    $cpf_logado = $_SESSION['cpf_policlinica'];
    include "../footer.php";
    include "navibar.php";
    require_once("../conexao.php");

    $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    // Setar a quantidade de registros por página
    $limite_resultado = 6;

    // Calcular o início da visualização
    $inicio = ($limite_resultado * $pagina) - $limite_resultado;
    $query = "SELECT * FROM agendamento WHERE status = 0";
    $result = $conexao->prepare($query);
    $result->execute();
    
    ?>
    <br>
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
                    $row_profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);

                    // Use $row_profissional['nome'] para obter o nome do profissional
                    $nome_profissional = $row_profissional['nome'];
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
                        <td><?php echo $d["procedimento"]; ?></td>
                        <td><?php $status = $d["status"]; 
                            if ($status == 0){
                                echo "Em espera";
                            }
                        ?></td>
                        <td>
                            <a class="btn text-white" style="background-color: #66a7ff;" href="editar_agendamento.php?id=<?php echo $d["id_agendamento"];?>">COMPARECEU</a>
                            <a class="btn text-white btn-danger" href="editar_comparecimento.php?id=<?php echo $d["id_agendamento"];?>">NÃO COMPARECEU</a>
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
                <div class="row">
                    <div class="col">        
                <?php 
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='inicio.php?page=1&cpf=$cpf_logado'>Primeira</a> ";

                for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                    if ($pagina_anterior >= 1) {
                        echo "<a href='inicio.php?page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                    }
                }

                echo "$pagina ";

                for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                    if ($proxima_pagina <= $qnt_pagina) {
                        echo "<a href='inicio.php?page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
                    }
                }
            }
            else {
                echo "<p style='color: #f00;'>Nenhum agendamento encontrado!</p>";
            }  
        }
        else {
            header("location: ../index.php");
        }
        ?>
