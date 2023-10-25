<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_adm'];
$cod = $_GET['cod'];
$id = $_GET["id"];
$id1 = $_GET["id1"];
$sql1 = "SELECT nome_paciente FROM agendamento WHERE id_agendamento = :id";
$result_profissionais = $conexao->prepare($sql1);
$result_profissionais->bindParam(':id', $id, PDO::PARAM_INT);
$result_profissionais->execute();
$profissional = $result_profissionais->fetch(PDO::FETCH_ASSOC);
$nome = $profissional['nome_paciente'];

// Início de uma transação
try {
    $conexao->beginTransaction();

    $sql = "DELETE FROM agendamento WHERE id_agendamento = :id";
    $resultado = $conexao->prepare($sql);
    $resultado->bindParam(':id', $id, PDO::PARAM_INT);

    if ($resultado->execute()) {
        $sql3 = "UPDATE procedimentos SET data_do_agendamento = '' WHERE id = :cod";
        $resultado3 = $conexao->prepare($sql3);
        $resultado3->bindParam(':cod', $cod, PDO::PARAM_INT);
        $resultado3->execute();

        $hoje = date('d/m/Y');
        $hora = date('H:i');
        $x = "EXCLUIU AGENDAMENTO " . $id;
        $sql2 = "INSERT INTO tb_log(acao, nome_paciente, cpf_modificador, data_modificacao, hora, id_paciente) VALUES (:x, :nome, :cpf_logado, :hoje, :hora, :id)";
        $resultado2 = $conexao->prepare($sql2);
        $resultado2->bindParam(':x', $x);
        $resultado2->bindParam(':nome', $nome);
        $resultado2->bindParam(':cpf_logado', $cpf_logado);
        $resultado2->bindParam(':hoje', $hoje);
        $resultado2->bindParam(':hora', $hora);
        $resultado2->bindParam(':id', $id);

        $resultado2->execute();

        // Confirma a transação
        $conexao->commit();

        echo '<script>alert("EXCLUÍDO COM SUCESSO!");</script>';
        echo '<script>window.location = "tabela_agendamento.php?id=' . $id1 . '";</script>';
    } else {
        echo "Erro ao excluir o agendamento.";
    }
} catch (PDOException $e) {
    // Caso ocorra algum erro na transação, desfaz as alterações
    $conexao->rollBack();
    echo "Erro: " . $e->getMessage();
}
?>
