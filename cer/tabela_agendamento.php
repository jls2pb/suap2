<?php 
require_once("head.php");
session_start();
 $cpf_logado = $_SESSION['cpf_cer'];
include "navibar.php";

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

 $query_usuarios = "SELECT DISTINCT ON (data_atendimento, hora) * FROM agendamento WHERE cod_profissional = $id ORDER BY data_atendimento, hora ASC LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>
<a style="margin: 10px;" href="inicio_agendamento.php" class="btn btn-danger text-white float-right" role="button">VOLTAR</a>

<h2 class="mb-4">TABELA DE AGENDAMENTO</h2>
<a style="" href="cadastrar_agendamento.php?id=<?php echo $id; ?>" class="btn btn-primary text-white float-right" role="button">CADASTRAR AGENDAMENTO</a>
<table class="table table-striped">
        <thead>
            <tr>
           
            <th scope="col">PACIENTE</th>
            <th scope="col">PROFISSIONAL</th>
            <th scope="col">PROCEDIMENTO</th>
            <th scope="col">DATA</th>
            <th scope="col">HORA</th>
            <th scope="col">STATUS</th>
            <th scope="col" class = "text-center">AÇÃO</th>
            
            
            </tr>
        </thead>
        <tbody>
            <?php
        $query_profissionais = "SELECT nome FROM profissionais WHERE id_profissional = $id";
$result_profissionais = $conexao->prepare($query_profissionais);
$result_profissionais->execute();
$row_profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);

if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
    while ($d = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
        extract($d);

        // Use $row_profissional['nome'] para obter o nome do profissional
        $nome_profissional = $row_profissional['nome'];
        $cod = $d["procedimento"];

        // Resto do seu código
?>
            <tr>
         
            <td><?php echo $d["nome_paciente"]; ?></td>
            <td><?php echo $nome_profissional; ?></td>
            <td><?php echo $d["procedimento"]; ?></td>
            <td>
                <?php
                $dia = date('d/m/Y', strtotime($d["data_atendimento"]));
                echo $dia; 
                 ?>
            </td>
            <td><?php echo $d["hora"]; ?></td>
            <td><?php $status = $d["status"]; 
                    if ($status==0){
                        echo "Em espera";
                    }
                    else if ($status==1) {
                        echo "Compareceu";
                    }
                    else {
                        echo "Não Compareceu";
                    }
                    ?></td>
            <td class = "text-center">
                  <a class="btn text-white" style="background-color: #66a7ff;" href = "form_edita_agendamento.php?id=<?php echo $d["id_agendamento"];?>" role="button">EDITAR</a>
                  <a class="btn text-white btn-danger" onclick="confirmarExclusao(<?php echo $d['id_agendamento'] ; ?>)" role="button">DESMARCAR</a>
                  <a class="btn text-white bg-info" href = "boleto.php?id=<?php echo $d["id_agendamento"];?>" role="button">BOLETO</a>
                </td>
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
                    echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tabela_agendamento.php?id=$id&page=1&cpf=$cpf_logado '>Primeira</a>";
        
                    for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                        if ($pagina_anterior >= 1) {
                            echo "<a href='tabela_agendamento.php?id=$id&page=$pagina_anterior&cpf=$cpf_logado'><label>$pagina_anterior</label></a> ";
                        }
                    }
        
                    echo "$pagina ";
        
                    for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                        if ($proxima_pagina <= $qnt_pagina) {
                            echo "<a href='tabela_agendamento.php?id=$id&page=$proxima_pagina&cpf=$cpf_logado'><label>$proxima_pagina</label></a> ";
                        }
                    }

                    
                } else {
            echo "<p style='color: #f00;'>Erro: Nenhum dado encontrado!</p>";
        }  
                
            ?>
        </tbody>
        </table> <script>
  function confirmarExclusao(id) {
            var confirmacao = confirm("Tem certeza de que deseja excluir este registro?");
            if (confirmacao) {
                // Se o usuário confirmar, redirecione para o script de exclusão PHP
                window.location = "excluir_agendamento.php?cod=<?php echo $cod;?>&id1=<?php echo $id; ?>&id=" + id;
            } else {
                // Se o usuário cancelar, não faça nada
            }
        }

   </script>  