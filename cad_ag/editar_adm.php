<?php
include "../conexao.php";
$cpf_logado = $_POST['cpf_logado'];
if (isset($_POST['nome_fantasia'])) {
    $local = $_POST['nome_fantasia'];
    $endereco_local = $_POST['endereco_local'];
     $id = $_POST['id']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $cnes = $_POST['cnes'];
    $sql = "UPDATE local_atendimento SET cnes = '$cnes', nome_fantasia = '$local', endereco_local = '$endereco_local' WHERE cnes = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        $hoje = date('d/m/Y');
        $hora = date('H:i');
        $x = "EDITOU LOCAL"." ".$id;
        $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$local','$cpf_logado','$hoje','$hora','$id')";
        $resultado2 = $conexao->prepare($sql2);
        $resultado2->execute();
        ?>
        <script>
            alert("LOCAL ATUALIZADO COM SUCESSO!");
            window.location = "tb_local_ag_adm.php";
        </script>
        <?php
    }
} else if (isset($_POST['procedimento'])) {
    $procedimento = $_POST['procedimento'];
    $id = $_POST['id_procedimento']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $sql = "UPDATE procedimento_medico SET procedimento = '$procedimento' WHERE id_procedimento = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        if ($resultado->execute()) {
            $hoje = date('d/m/Y');
            $hora = date('H:i');
            $x = "EDITOU PROCEDIMENTO"." ".$id;
            $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$procedimento','$cpf_logado','$hoje','$hora','$id')";
            $resultado2 = $conexao->prepare($sql2);
            $resultado2->execute();
        ?>
        <script>
            alert("PROCEDIMENTO ATUALIZADO COM SUCESSO!");
            window.location = "tb_procedimentos_adm.php";
        </script>
        <?php
    }}
} else if (isset($_POST['nome'])) {
    $ubs = $_POST['ubs'];
    $acs = $_POST['nome'];
    $id = $_POST['cod']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $vinculo = $_POST['vinculo'];
    $cns = $_POST['cns'];
    $cpf = $_POST['cpf'];
    $microarea = $_POST['microarea'];
    $pessoas = $_POST['pessoas'];
    $familias = $_POST['familias'];
    $transporte = $_POST['transporte'];
    $sql = "UPDATE acs SET ubs = '$ubs', nome = '$acs', vinculo = '$vinculo', cns = '$cns', cpf = '$cpf', microarea = '$microarea', pessoas = '$pessoas', familias = '$familias', transporte = '$transporte' WHERE cod = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        if ($resultado->execute()) {
            $hoje = date('d/m/Y');
            $hora = date('H:i');
            $x = "EDITOU ACS"." ".$id;
            $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$acs','$cpf_logado','$hoje','$hora','$id')";
            $resultado2 = $conexao->prepare($sql2);
            $resultado2->execute();
        ?>
        <script>
            alert("ACS ATUALIZADO COM SUCESSO!");
            window.location = "tb_acs_adm.php";
        </script>
        <?php
    }}
} else if (isset($_POST['nome_uaps'])) {
    $ubs = $_POST['nome_uaps'];
    $id = $_POST['id_uaps']; // Você precisa da chave primária (ID) do registro a ser atualizado
    $sql = "UPDATE uaps SET nome_uaps = '$ubs' WHERE id_uaps = $id";
    $resultado = $conexao->prepare($sql);
    if ($resultado->execute()) {
        if ($resultado->execute()) {
            $hoje = date('d/m/Y');
            $hora = date('H:i');
            $x = "EDITOU UBS"." ".$id;
            $sql2 = "INSERT INTO tb_log(acao,nome_paciente,cpf_modificador,data_modificacao,hora,id_paciente) VALUES ('$x','$ubs','$cpf_logado','$hoje','$hora','$id')";
            $resultado2 = $conexao->prepare($sql2);
            $resultado2->execute();
        ?>
        <script>
            alert("UBS ATUALIZADA COM SUCESSO!");
            window.location = "tb_ubs_adm.php";
        </script>
        <?php
    }
}
}
?>
