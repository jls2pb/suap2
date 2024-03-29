<?php 
include "../conexao.php";
require_once("head.php");
session_start();
date_default_timezone_set('America/Sao_Paulo');
$cpf_logado = $_SESSION['cpf_caps'];
$paciente = $_POST["paciente"];
$sexo = $_POST["sexo"];
$endereco = $_POST["endereco"];
$procedimento = $_POST["procedimento"];
$cpf = $_POST["cpf"];
$cod = $_POST["cod"];
$dia = $_POST["dia"];
$horario = $_POST["horario"];
$endereco_local = $_POST["endereco_local"];
$cod_profissional = $_POST["cod_profissional"];
$local_atendimento = $_POST["l_agendamento"];
$data_geracao = date('d/m/Y H:i:s');

$sqlVerificar = "SELECT * FROM agendamento WHERE cod_profissional = $cod_profissional AND data_atendimento = '$dia' AND hora = '$horario'";
$resultadoVerificar = $conexao->prepare($sqlVerificar);
$resultadoVerificar->execute();

$query_profissionais = "SELECT nome FROM profissionais WHERE id_profissional = $cod_profissional ";
$result_profissionais = $conexao->prepare($query_profissionais);
$result_profissionais->execute();
$profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
$nome_profissional = $profissional['nome'];

if ($resultadoVerificar->rowCount() > 0) {
    echo "<script>alert('Esse horário já está agendado. Por favor, escolha outro horário.'); window.history.back();</script>";
    exit; // Encerra o script em caso de horário duplicado
}


$sql = "INSERT INTO agendamento(cod_usuario, data_atendimento, hora, nome_paciente, sexo, endereco, cpf, endereco_local, cod_profissional,local_atendimento, procedimento, status) VALUES ($cod, '$dia', '$horario', '$paciente', '$sexo', '$endereco', '$cpf', '$endereco_local',$cod_profissional,'$local_atendimento',$procedimento, 0)";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $hoje = date('d/m/Y');
    $sql1 = "UPDATE procedimentos SET data_do_agendamento = '$dia', local_do_agendamento = '$local_atendimento', data_da_saida = '$hoje', profissional = '$nome_profissional' WHERE id = $procedimento";
    $resultado1 = $conexao->prepare($sql1);
    $resultado1->execute();
    $hora = date('H:i');
    $x = "AGENDAMENTO ";
    $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$paciente','$cpf_logado','$hoje','$hora','$cod_profissional')";
    $resultado2 = $conexao->prepare($sql2);
    $resultado2->execute();
   ?><style>
  @media print {
            #print, #voltar {
                display: none;
            }
            /* Estilo para o rodapé */
            .rodape {
               
                border-top: 1px solid black;
            }
        }
</style>  

<button style="width: 100%;" id="print" onclick="printPage()">Imprimir<img style="width: 2%;" src="../images/printer.png"></button>
   <a href="tabela_agendamento.php?id=<?php echo $cod_profissional;?>" ><button  style="width: 100%; background-color:#B22222;color: white;" id="voltar">Voltar</button><a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

   <?php

   echo "<div class='row pt-1' style='color:black;'>";
   echo "<img style='height: 100px; ' class='col-4' src='../images/logo_sm.png'>";
   echo "<div class='col-4 text-center pt-0'>";
   echo "<h5>SECRETARIA MUNICIPAL DE SAÚDE </h5>";
   echo "<h6>SÃO GONÇALO DO AMARANTE</h6>";
   echo "<h7>AVENIDA CORONEL NECO MARTINS, 276</h7><br>";
   echo "<h8>Comprovante de Agendamento</h8>";
   echo "</div>";
   echo "<div class='col-2'></div>";
   echo "<div class='text-right col-2 pt-0 pl-1'><img style='width: 100%;' src='../images/logo_sus.png'><br>";
   echo "SUAP SESA</div>";
   echo "</div>";
   echo "<hr style='background-color: black;'>";
   echo "<div class='flex-row-reverse' style='color:black;'>";
   
   echo "<div class='row'>";
   $sql = "select * from tabela where cod = $cod";
   $resultado = $conexao->prepare($sql);
   $resultado->execute();
   $x = $resultado->fetchAll();
   foreach ($x as $y){
    $telefone = $y['celular'];
    $mae = $y['nome_da_mae'];
    $cns = $y['cns'];
    $data_nascimento = $y['nascimento'];
    $ubs = $y['ubs'];
   }
   echo "<div class='col-5'>";
   echo "<b>Nome: </b>$paciente";
   echo "</div>";
   echo "<div class='col-5'>";
   echo "<b>Telefone: </b>$telefone <br>";
   echo "</div>";
   
   echo "</div>";
   
   echo "<b>Nome da mãe: </b>$mae <br>";
   
   echo "<div class='row'>";
   
   echo "<div class='col-4'>";
   echo "<b>Nº do Cartão Nacional: </b>$cns";
   echo "</div>";
   echo "<div class='col-4'>";
   $nascimento = $data_nascimento;
   echo "<b>Nasc: </b>$nascimento";
   echo "</div>";
   echo "<div class='col-4'>";
   echo "<b>Sexo: </b> $sexo <br>";
   echo "</div>";
   
   echo "</div>";
   
   echo "<b>End. Residencial: </b> $endereco <br>";
   echo "<b>UBS: </b> $ubs <br>";
   echo "<b>Está agendado para: </b>$local_atendimento <br>";
   echo "<b>Endereço: </b>$endereco_local <br>";
   $sql = "select nome from profissionais where id_profissional = $cod_profissional";
   $resultado = $conexao->prepare($sql);
   $resultado->execute();
   $x = $resultado->fetchAll();
   foreach ($x as $y){
    $profissional = $y['nome'];
   }
   echo "<b>Profissional: </b>$profissional <br>";
   $sql = "select procedimento from procedimentos where id = $procedimento";
   $resultado = $conexao->prepare($sql);
   $resultado->execute();
   $x = $resultado->fetchAll();
   foreach ($x as $y){
    $n_procedimento = $y['procedimento'];
   }
   echo "<b>Seu procedimento de: </b> $procedimento - $n_procedimento <br>";
   
   echo "<div class='row'>";
   
   echo "<div class='col-5'>";
   $dia_certo = date('d/m/Y', strtotime($dia));
   echo "<b>Data: </b>$dia_certo";
   echo "</div>";
   echo "<div class='col-5'>";
   echo "<b>Horário da Consulta: </b>$horario<br>";
   echo "</div>";
   
   echo "</div>";
   echo "</div>";
   echo "<div class='row' style='color: black;'>";

   echo "<div class='col-3 p-5'>";
   echo "Atenciosamente, <br> A coordenação";
   echo "</div>";

echo "<div class='col-5'>";
echo "<p>Observações</p>";
echo "<textarea rows='5' cols='50' maxlenght='500'></textarea>";
echo "</div>";

   echo "<div col-4>";
   echo "<p><b>O paciente deverá retornar para:</b></p>";
   echo "<input type='checkbox' id='paciente' name='paciente' value='paciente'>
   <label for='paciente'>Mostrar resultado do exame em _ dias</label><br>";
   echo "<input type='checkbox' id='paciente' name='paciente' value='paciente'>
   <label for='paciente'>Retorno no prazo de 30 dias</label><br>";
   echo "<input type='checkbox' id='paciente' name='paciente' value='paciente'>
   <label for='paciente'>Retorno no prazo de 90 dias, agendar.</label><br>";
   echo "<input type='checkbox' id='paciente' name='paciente' value='paciente'>
   <label for='paciente'>Alta na especialidade</label><br>";
   echo "</div>";
   echo "</div><br>";
   $sql2 = "SELECT id_usuario FROM usuario WHERE cpf =  '$cpf_logado'";
   $stmt = $conexao->prepare($sql2);
   $stmt->execute();
   $result = $stmt->fetch(PDO::FETCH_ASSOC);
   $id_usuario = $result['id_usuario'];

   ?>
   
   <div class="rodape row">
   <div class=" col-7">Usuário responsável: <?php echo $id_usuario; ?></div>
<div class="col-5">Data e Hora de Geração do Boleto: <?=$data_geracao?></div>
 <!-- Adicionei o rodapé aqui -->
</div>
   <script>
   function printPage() {
           window.print();
       }
   </script>
   <?php
}
?>