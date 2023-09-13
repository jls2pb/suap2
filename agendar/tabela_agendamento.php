<?php 
require_once("head.php");
session_start();
 $cpf_logado = $_SESSION['cpf'];
include "menu_agendamento.php";
include "navibar_agendar.php";

include "../footer.php";
require_once("../conexao.php");
?>
<?php
$id = $_GET['id'];
 $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

 //Setar a quantidade de registros por página
 $limite_resultado = 6;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;

 $query_usuarios = "SELECT DISTINCT ON (id_agendamento) * FROM agendamento WHERE cod_profissional = $id ORDER BY id_agendamento ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>

<h2 class="mb-4">TABELA DE AGENDAMENTO</h2>
<a style="" href="cadastrar_agendamento.php?id=<?php echo $id; ?>" class="btn btn-primary text-white float-right" role="button">CADASTRAR AGENDA</a>
<table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">ID DO AGENDAMENTO</th>
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
            
            
            </tr>
        </thead>
        <tbody>
            <?php 
 $query_profissionais = "SELECT nome FROM profissionais WHERE id_profissional = $id ";
                        $result_profissionais = $conexao->prepare($query_profissionais);
                        $nome_profissional = $result_profissionais->execute();
              if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
                    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
                       
            
            
            ?>
            <tr>
            <th scope="row"><?php echo $d["id_agendamento"]; ?></th>
            <td><?php echo $d["data_atendimento"]; ?></td>
            <td><?php echo $d["hora"]; ?></td>
            <td><?php echo $d["nome_paciente"]; ?></td>
            <td><?php echo $d["sexo"]; ?></td>
            <td><?php echo $d["endereco"]; ?></td>
            <td><?php echo $d["cpf"]; ?></td>
            <td><?php echo $d["endereco_local"]; ?></td>
            <td><?php echo $nome_profissional; ?></td>
            <td><?php echo $d["local_atendimento"]; ?></td>
            <td><?php echo $d["procedimento"]; ?></td>
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
                    echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tabela_agendamento.php?page=1&cpf=$cpf_logado '>Primeira</a>";
        
                    for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                        if ($pagina_anterior >= 1) {
                            echo "<a href='tabela_agendamento.php?page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                        }
                    }
        
                    echo "$pagina ";
        
                    for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                        if ($proxima_pagina <= $qnt_pagina) {
                            echo "<a href='tabela_agendamento.php?page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
                        }
                    }

                    
                } else {
            echo "<p style='color: #f00;'>Erro: Nenhum dado encontrado!</p>";
        }  
                
            ?>
        </tbody>
        </table>