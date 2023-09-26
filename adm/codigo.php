<?php
session_start();
if (isset($_SESSION['cpf_adm'])) {
    $cpf_logado = $_SESSION['cpf_adm'];
    require_once("head.php");
    include "menu_adm.php";
    include "navibar_adm.php";
    include "../footer.php";
    include "../conexao.php";
?>

<?php
// Função para gerar um número aleatório de 8 a 10 dígitos
function gerarNumeroAleatorio() {
    return rand(10000000, 10000000000);
}

if (isset($_SESSION['data_geracao'])) {
    $diferenca = time() - strtotime($_SESSION['data_geracao']);

    if ($diferenca >= 24 * 60 * 60) {
        $conexao->query("DELETE FROM codigo");
        $numeroAleatorio = gerarNumeroAleatorio();
        $_SESSION['data_geracao'] = date('Y-m-d H:i:s');

        // Usar prepared statement para evitar SQL Injection
        $stmt = $conexao->prepare("INSERT INTO codigo (numero, data_geracao) VALUES (?, NOW())");
        $stmt->bindParam(1, $numeroAleatorio, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $numeroAleatorio = $_SESSION['numero'];
    }
} else {
    $numeroAleatorio = gerarNumeroAleatorio();
    $_SESSION['numero'] = $numeroAleatorio;
    $_SESSION['data_geracao'] = date('Y-m-d H:i:s');

    $conexao->query("DELETE FROM codigo");

    // Usar prepared statement para evitar SQL Injection
    $stmt = $conexao->prepare("INSERT INTO codigo (numero, data_geracao) VALUES (?, NOW())");
    $stmt->bindParam(1, $numeroAleatorio, PDO::PARAM_INT);
    $stmt->execute();
}
?>

<h1><div class="text-center">
    <?php echo "O número gerado é: <br>$numeroAleatorio"; ?>
</div></h1>

<?php
} else {
    header("location: ../index.php");
}
?>
