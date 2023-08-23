<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once("conexao.php");
$n_paciente = $_POST["n_paciente"];
$rg = $_POST["rg"];
$cpf = $_POST["cpf"];
$n_mae = $_POST["n_mae"];
$cns = $_POST["cns"];
$d_nascimento = $_POST["nascimento"];
$acs = $_POST["acs"];
$ubs = $_POST["ubs"];
$celular = $_POST["cel"];
$telefone = $_POST["tel"];
$cpf_logado = $_POST["cpf_logado"];

if($d_nascimento != NULL){
    $nascimento = date('d/m/Y', strtotime($d_nascimento));
}else{
    $nascimento = NULL;
}

if($cpf == NULL){
    $a = "1";
}else{
    $a = $cpf;
}
if($cns == NULL){
    $b = "1";
}else{
    $b = $cns;
}
// Verificar se já existe um cadastro com o mesmo CPF
$sql_verificar = "SELECT cod FROM tabela WHERE cns = '$b'";
$sql_verificar2 = "SELECT cod FROM tabela WHERE cpf = '$a'";
$resultado_verificar = $conexao->query($sql_verificar);
$resultado_verificar2 = $conexao->query($sql_verificar2);
function validateCPF($cpf) {
    // Remove caracteres especiais e espaços em branco
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF possui 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais; caso contrário, não é válido
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Calcula o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    // Calcula o segundo dígito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    // Verifica se os dígitos verificadores calculados são iguais aos dígitos originais
    if ($digito1 == $cpf[9] && $digito2 == $cpf[10]) {
        return true;
    } else {
        return false;
    }
}

if($resultado_verificar->rowCount() > 0 && $resultado_verificar2->rowCount() > 0) {
    ?>
    <script>
        alert("PACIENTE JA POSSUI CADASTRO!");
        window.location="cadastrar_paciente.php";
    </script> 
        <?php
} else {
    if(validateCPF($cpf)){
    // Inserir os dados no banco de dados
    $sql = "INSERT INTO tabela(nome_paciente, rg, cpf, nome_da_mae, cns, nascimento, acs, ubs, celular, telefone) VALUES ('$n_paciente','$rg', '$cpf', '$n_mae' ,'$cns' ,'$nascimento', '$acs', '$ubs', '$celular','$telefone')";
    $resultado = $conexao->prepare($sql);
    if($resultado->execute()){
        $cod = $conexao->lastInsertId();
        $hoje = date('d/m/Y');
        $hora = date('H:i');
        $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('CADASTRADO','$n_paciente','$cpf_logado','$hoje','$hora','$cod')";
        $resultado2 = $conexao->prepare($sql2);

        if($resultado2->execute()){
            header ("location: listar.php?id=".$cod);
        } else {
            echo "Erro ao registrar Log";
        }
    } else {
        echo "Erro ao coletar os dados";
    }
    }else {
        ?>
        <script>
            alert("CPF INVÁLIDO!");
	        window.location="cadastrar_paciente.php";
        </script> 
            <?php
    }
    
    }
   

?>






