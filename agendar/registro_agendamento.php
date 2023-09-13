<?php 
include "../conexao.php";
require_once("head.php");

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
$sql = "INSERT INTO agendamento(cod_usuario, data_atendimento, hora, nome_paciente, sexo, endereco, cpf, endereco_local, cod_profissional,local_atendimento, procedimento) VALUES ($cod, '$dia', '$horario', '$paciente', '$sexo', '$endereco', '$cpf', '$endereco_local',$cod_profissional,'$local_atendimento',$procedimento)";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
   ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<style>
  @media print {
            #print, #voltar {
                display: none;
            }
        }
</style>  
   <?php

   echo "<div class='row pt-1' style='color:black;'>";
   echo "<img style='height: 100px; ' class='col-4' src='../images/logo_ti3.png'>";
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
   echo "<b>Nasc: </b>$data_nascimento";
   echo "</div>";
   echo "<div class='col-4'>";
   echo "<b>Sexo: </b> $sexo <br>";
   echo "</div>";
   
   echo "</div>";
   
   echo "<b>End. Residencial: </b> $endereco <br>";
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
   $sql = "select procedimento from procedimentos where cod = $procedimento";
   $resultado = $conexao->prepare($sql);
   $resultado->execute();
   $x = $resultado->fetchAll();
   foreach ($x as $y){
    $n_procedimento = $y['procedimento'];
   }
   echo "<b>Seu procedimento de: </b> $procedimento - $n_procedimento <br>";
   
   echo "<div class='row'>";
   
   echo "<div class='col-5'>";
   echo "<b>Data: </b>$dia";
   echo "</div>";
   echo "<div class='col-5'>";
   echo "<b>Horário da Consulta: </b>$horario<br>";
   echo "</div>";
   
   echo "</div>";
   echo "</div>";
   echo "<p style='color: black;' class='text-center'>$n_procedimento</p>";
   echo "<div class='row' style='color: black;'>";
   echo "<div class='col-8 p-5'>";
   echo "Atenciosamente, <br> A coordenação";
   echo "</div>";
   
   echo "<div col-2>";
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
   echo "</div>";
   
   ?>
   <button style="width: 100%;" id="print" onclick="printPage()">Imprimir<img style="width: 2%;" src="../images/printer.png"></button>
   <a href="cadastrar_agendamento.php?id=<?php echo $cod_profissional;?>" ><button  style="width: 100%; background-color:#B22222;color: white;" id="voltar">Voltar</button><a>
   <script>
   function printPage() {
           window.print();
       }
   </script>
   <?php
}
?>