<?php
include "../conexao.php";

if (isset($_POST['nome_fantasia'])) {
    $local = $_POST['nome_fantasia'];
    $endereco_local = $_POST['endereco_local'];
    $id = $_POST['id']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $cnes = $_POST['cnes'];
    $sql = "UPDATE local_atendimento SET cnes = '$cnes', nome_fantasia = '$local', endereco_local = '$endereco_local' WHERE cnes = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        ?>
        <script>
            alert("LOCAL ATUALIZADO COM SUCESSO!");
            window.location = "tb_local_ag.php";
        </script>
        <?php
    }
} elseif (isset($_POST['procedimento'])) {
    $procedimento = $_POST['procedimento'];
    $id = $_POST['id_procedimento']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $sql = "UPDATE procedimento_medico SET procedimento = '$procedimento' WHERE id_procedimento = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        ?>
        <script>
            alert("PROCEDIMENTO ATUALIZADO COM SUCESSO!");
            window.location = "tb_procedimentos.php";
        </script>
        <?php
    }
} elseif (isset($_POST['nome'])) {
    $acs = $_POST['nome'];
    $id = $_POST['cod']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $sql = "UPDATE acs SET nome = '$acs' WHERE cod = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        ?>
        <script>
            alert("ACS ATUALIZADO COM SUCESSO!");
            window.location = "tb_acs.php";
        </script>
        <?php
    }
} elseif (isset($_POST['nome_uaps'])) {
    $ubs = $_POST['nome_uaps'];
    $id = $_POST['id_uaps']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $sql = "UPDATE uaps SET nome_uaps = '$ubs' WHERE id_uaps = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        ?>
        <script>
            alert("UBS ATUALIZADA COM SUCESSO!");
            window.location = "tb_ubs.php";
        </script>
        <?php
    }
}
?>
