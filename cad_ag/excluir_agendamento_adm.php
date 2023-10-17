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
        $sql3 = "UPDATE procedimentos SET data_do_agendamento = '' WHERE cod = '$cod'";
        $resultado3 = $conexao->prepare($sql3);
        $resultado3->execute();
    $hoje = date('d/m/Y');
      $hora = date('H:i');
      $x = "EXCLUIU AGENDAMENTO"." ".$id;
      $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$nome','$cpf_logado','$hoje','$hora','$id')";
      $resultado2 = $conexao->prepare($sql2);
          $resultado2->execute();
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
