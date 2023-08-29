<?php 
require_once("head.php");
session_start();
$paciente = $_POST["nome_paciente"];
$mae = $_POST["nome_da_mae"];
$cns = $_POST["cns"];
$data_nascimento = $_POST["nascimento"];
$sexo = $_POST["sexo"];
$endereco_residencial = $_POST["endereco"];
$local = $_POST["local_do_agendamento"];
$endereco = $_POST[""];
$telefone = $_POST[""];
$complemento = $_POST[""];
$ubs = $_POST["ubs"];
$profissional = $_POST["profissional"];
$procedimento = $_POST["procedimento"];
$data = $_POST["dia_marcado"];
$horario = $_POST["horario_marcado"];
include "head.php";
include "menu.php";
include "navibar.php";

require_once("conexao.php");
echo "<div>";
echo "Nome: $paciente - Telefone: $telefone <br>";
echo "Nome da mãe: $mae <br>";
echo "Nº do Cartão Nacional: " . "  " .$cns. " - " . "Nasc: " ."  ". $data_nascimento ." - ". "Sexo:  $sexo <br>";
echo "End. Residencial:  $endereco_residencial <br>";
echo "Está agendado para: $local <br>";
echo "Endereço: $endereco <br>";
echo "Profissional: $profissional <br>";
echo "Seu procedimento de: $procedimento <br>";
echo "Data: $data". " - " ."Horário da Consulta: $horario" ;
echo "</div>";
?>