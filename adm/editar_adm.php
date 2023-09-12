<?php
include "../conexao.php";

if (isset($_POST['nome_fantasia'])) {
    $local = $_POST['nome_fantasia'];
    $id = $_POST['cnes']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $sql = "UPDATE local_atendimento SET nome_fantasia = '$local' WHERE cnes = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        ?>
        <script>
            alert("LOCAL ATUALIZADO COM SUCESSO!");
            window.location = "tb_local_ag_adm.php";
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
            window.location = "tb_procedimentos_adm.php";
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
            window.location = "tb_acs_adm.php";
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
            window.location = "tb_ubs_adm.php";
        </script>
        <?php
    }
}
?>
