<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("../../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_adm'];

$id = $_GET["id"];

try {
    $sql = "DELETE FROM agendamento WHERE id_agendamento = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        
        $sql3 = "UPDATE procedimentos SET data_do_agendamento = NULL, local_do_agendamento = NULL WHERE id = '$id'";
        $resultado3 = $conexao->prepare($sql3);
        $resultado3->execute();
        $hoje = date('d/m/Y');
        $hora = date('H:i');
        $x = "EXCLUIU AGENDAMENTO " . $id;
        $nome = "PACIENTE";
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
        ?>
        <script>
        alert("EXCLUIDO COM SUCESSO!");
        window.location = "ver_agendamentos.php?id=<?php echo $id; ?>";
    </script> <?php
    } else {
        echo "Erro ao excluir o registro.";
    }
} catch (PDOException $e) {
    echo "Erro ao executar a consulta: " . $e->getMessage();
}
?>
