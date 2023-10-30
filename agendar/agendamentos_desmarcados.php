<?php 
require_once("head.php");
session_start();
 $cpf_logado = $_SESSION['cpf_agendar'];
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

 $query_usuarios = "SELECT * FROM agendamento WHERE cod_profissional = $id LIMIT $limite_resultado OFFSET $inicio ";
 $result_usuarios = $conexao->prepare($query_usuarios);
 $result_usuarios->execute();

?>

<script>
  function confirmarCancelamento(id) {
    var motivo = prompt("Por favor, digite o motivo para desmarcar:");
    if (motivo !== null) {
      // Se o usuário inseriu um motivo (não cancelou o prompt), redirecione para o script de desmarcamento com o motivo
      window.location = "desmarcar_agendamento.php?id1=<?php echo $id; ?>&id=" + id + "&motivo=" + encodeURIComponent(motivo);
    } else {
      // Se o usuário cancelar, não faça nada
    }
  }
</script>

<h2 class="mb-4">PACIENTES DESMARCADOS</h2>

<a style="" href="tabela_agendamento.php?id=<?php echo $id; ?>" class="btn btn-primary text-white float-right" role="button">VOLTAR </a>


<table class="table table-striped">
        <thead>
            <tr>
           
            <th scope="col">PACIENTE</th>
            <th scope="col">PROFISSIONAL</th>
            <th scope="col">PROCEDIMENTO</th>
            <th scope="col">STATUS</th>
          
            
            
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
            <td><?php $status = $d["status"]; 
                    if ($status==0){
                        echo "Agendado";
                    }
                    else if ($status==1) {
                        echo "Compareceu";
                    }else if($status==3){
                        echo "Desmarcado";
                    }else {
                        echo "Não Compareceu";
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
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tabela_agendamento.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
            }
    
            if ($pagina > 1) {
                $pagina_anterior = $pagina - 1;
                echo "<a href='tabela_agendamento.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                $proxima_pagina = $pagina + 1;
                echo "<a href='tabela_agendamento.php?page=$proxima_pagina&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Próximo'><span aria-hidden='true'>&raquo;</span></label></a> ";
            }
    
            if ($pagina < $qnt_pagina) {
                ?><div class="float-right"><?php
                echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tabela_agendamento.php?page=$qnt_pagina&cpf=$cpf_logado'>Última</a> ";
            ?></div> <?php
            }

            
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
             echo "<a class='btn' style='color: white; background-color: #66a7ff;' href='tabela_agendamento.php?page=1&cpf=$cpf_logado'>Primeira</a> ";
             $pagina_anterior = $pagina - 1;
             echo "<a href='tabela_agendamento.php?page=$pagina_anterior&cpf=$cpf_logado' class='btn'><label style='font-size:30px;' title='Anterior'><span aria-hidden='true'>&laquo;</span></label></a> ";
        
        }  
                
            ?>
                </div>
            </div> 
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