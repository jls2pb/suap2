<?php
include "../conexao.php";
require_once("head.php");
session_start();
date_default_timezone_set('America/Sao_Paulo');
$cpf_logado = $_SESSION['cpf_agendar'];
$id = $_GET['id'];
$sql = "SELECT * FROM agendamento WHERE id_agendamento = $id";
$resultado = $conexao->prepare($sql);
$resultado->execute();
$a = $resultado->fetchAll();
foreach ($a as $k) {
    $cod = $k['cod_usuario'];
    $cod_profissional = $k['cod_profissional'];
    $dia = $k['data_atendimento'];
    $procedimento = $k['procedimento'];
    $horario = $k['hora'];
    $paciente = $k['nome_paciente'];
    $sexo = $k['sexo'];
    $endereco_local = $k["endereco_local"];
    $endereco = $k["endereco"];
    $local_atendimento = $k["local_atendimento"];
    $data_geracao = date('d/m/Y H:i:s');
}
?>

<style>
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
   $dia_certo = date('d/m/Y', strtotime($dia));
   echo "<b>Data: </b>$dia_certo";
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