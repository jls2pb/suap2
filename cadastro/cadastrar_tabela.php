<?php 
include "../conexao.php";
if(isset($_POST['local'])){
    $local  = $_POST['local'];
    $sql = "insert into local_atendimento(nome_fantasia) VALUES ('$local');";
    $resultado = $conexao->prepare($sql);
    if($resultado->execute()){
        ?>
        <script>
            alert("NOVO LOCAL REGISTRADO COM SUCESSO!");
            window.location="forms_tabela.php";
        </script> 
        <?php
    }
}else if(isset($_POST['procedimento'])){
    $procedimento  = $_POST['procedimento'];
    $sql = "insert into procedimento_medico(procedimento) VALUES ('$procedimento');";
    $resultado = $conexao->prepare($sql);
    if($resultado->execute()){
        ?>
        <script>
            alert("NOVO PROCEDIMENTO REGISTRADO COM SUCESSO!");
            window.location="forms_tabela.php";
        </script> 
        <?php
    }
}else if(isset($_POST['acs'])){
    $acs  = $_POST['acs'];
    $sql = "insert into acs(nome) VALUES ('$acs');";
    $resultado = $conexao->prepare($sql);
    if($resultado->execute()){
        ?>
        <script>
            alert("NOVO ACS REGISTRADO COM SUCESSO!");
            window.location="forms_tabela.php";
        </script> 
        <?php
    }
}else if(isset($_POST['ubs'])){
    $ubs  = $_POST['ubs'];
    $sql = "insert into uaps(nome_uaps) VALUES ('$ubs');";
    $resultado = $conexao->prepare($sql);
    if($resultado->execute()){
        ?>
        <script>
            alert("NOVA UBS REGISTRADO COM SUCESSO!");
            window.location="forms_tabela.php";
        </script> 
        <?php
    }
}
?>