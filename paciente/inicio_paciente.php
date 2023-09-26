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


$query_procedimento = "SELECT * FROM agendamento WHERE cpf = :cpf_logado";
$result_procedimento = $conexao->prepare($query_procedimento);
$result_procedimento->bindParam(':cpf_logado', $cpf_logado, PDO::PARAM_STR);
$result_procedimento->execute();
?>
<br>
<p style="padding-left: 10px;">SEJA BEM VINDO(A) <?php echo $nome_paciente; ?></p>

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
        </tr>
    </thead>
    <tbody>
        <?php
        if (($result_procedimento) AND ($result_procedimento->rowCount() != 0)) {
            while ($d = $result_procedimento->fetch(PDO::FETCH_ASSOC)) {
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
        } else {
            echo "<p style='color: #f00;'>Nenhum agendamento encontrado!</p>";
            }  
        }
        else {
          header("location: ../index.php");
        }
        ?>
    </tbody>
</table>
<script src="../mascara.js"></script>
</div>
</div>


