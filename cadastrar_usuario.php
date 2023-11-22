<?php
include "head.php";
require_once("conexao.php");

$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$funcao = $_POST['funcao'];
$codigo = $_POST['codigo'];

// Consulta o código na tabela "codigo"
$sql2 = "SELECT * FROM codigo WHERE numero = :codigo";
$resultado2 = $conexao->prepare($sql2);
$resultado2->bindParam(':codigo', $codigo, PDO::PARAM_STR);
$resultado2->execute();

if ($resultado2->rowCount() > 0) {
    // Código válido, insira os dados do usuário na tabela "usuario"
    $query_usuarios = "INSERT INTO usuario(cpf, nome, senha, id_tipo) VALUES (:cpf, :nome, :senha, :funcao)";
    $result_usuarios = $conexao->prepare($query_usuarios);
    $result_usuarios->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $result_usuarios->bindParam(':nome', $nome, PDO::PARAM_STR);
    $result_usuarios->bindParam(':senha', $senha, PDO::PARAM_STR);
    $result_usuarios->bindParam(':funcao', $funcao, PDO::PARAM_INT);

    if ($result_usuarios->execute()) {
        ?>
        <script>
            window.alert("CADASTRO REALIZADO COM SUCESSO, REALIZE O LOGIN!");
            window.location = "index.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            window.alert("ERRO AO CADASTRAR!");
        </script>
        <?php
    }
} else {
    ?>
    <script>
        alert("CÓDIGO INVÁLIDO!");
        window.location = "form_cad_usuario.php";
    </script>
    <?php
}

?>
