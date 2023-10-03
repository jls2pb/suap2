<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("../conexao.php");
session_start();
$cpf_logado = $_SESSION['cpf_cad_ag'];

$id = $_GET["id"];

try {
    $sql = "DELETE FROM agendamento WHERE cod_usuario = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
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
