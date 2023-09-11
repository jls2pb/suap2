<?php
session_start();
if(isset($_SESSION['cpf'])){
    $cpf_logado = $_SESSION['cpf'];
require_once("head.php");
include "menu_adm.php";
include "navibar_adm.php";
include "../footer.php";
include "../conexao.php";
?>
<?php

if (isset($_SESSION['data_geracao'])) {
    // Calcula a diferença em segundos entre a data de geração e a data atual
    $diferenca = time() - strtotime($_SESSION['data_geracao']);

    // Se a diferença for maior ou igual a 24 horas, gera um novo número
    if ($diferenca >= 24 * 60 * 60) {
        // Deleta o registro anterior do banco de dados
        $conexao->query("DELETE FROM codigo");
        
        $numeroAleatorio = rand(10000000, 10000000000);
        // Atualiza a data de geração na variável de sessão
        $_SESSION['data_geracao'] = date('Y-m-d H:i:s');
        
        // Insere o novo número e a data atual no banco de dados
        $sql = "INSERT INTO codigo (numero, data_geracao) VALUES ($numeroAleatorio, NOW())";
        $conexao->query($sql);
    } else {
        // Recupera o número da variável de sessão
        $numeroAleatorio = $_SESSION['numero'];
    }
} else {
    // Se a variável de sessão não existir, gera um número aleatório e cria a data de geração
    $numeroAleatorio = rand(10000000, 10000000000);
    $_SESSION['numero'] = $numeroAleatorio;
    $_SESSION['data_geracao'] = date('Y-m-d H:i:s');
    
    // Deleta qualquer registro existente no banco de dados
    $conexao->query("DELETE FROM codigo");
    
    // Insere o primeiro número e a data atual no banco de dados
    $sql = "INSERT INTO codigo (numero, data_geracao) VALUES ($numeroAleatorio, NOW())";
    $conexao->query($sql);
}

?>
<h1><div class="text-center">
<?php echo "O número gerado é: <br>$numeroAleatorio"; ?>
</div></h1>


<?php
} else{
    header("location: ../index.php");
}
?>