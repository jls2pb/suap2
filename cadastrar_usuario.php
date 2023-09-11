<?php
include "head.php";
require_once("conexao.php");
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $funcao = $_POST['funcao'];
    $sql = "SELECT * FROM usuario";
    $resultado = $conexao->prepare($sql);
    $cont = 0;
    if($resultado->execute()){
      $x = $resultado->fetchAll();
      foreach ($x as $y) {
        if($y["cpf"] === $cpf){
        $cont++;
        }
      }
    }
    if($cont == 0){
        $query_usuarios = "INSERT INTO usuario(cpf,nome,senha,id_tipo) VALUES ('$cpf','$nome','$senha', '$funcao')";
        $result_usuarios = $conexao->prepare($query_usuarios);
    
        if($result_usuarios->execute()){
            ?>
        <script>
            window.alert("CADASTRO REALIZADOR COM SUCESSO, REALIZE O LOGIN!");
        </script> 
            <?php
            echo "cadastrou";
            Header("Location:index.php");
        }else{
            ?>
        <script>
            window.alert("ERRO AO CADASTRAR!");
        </script> 
            <?php
        }

    }else{
        ?>
        <script>
            alert("CPF JA CADASTRADO!");
	        window.location="form_cad_usuario.php";
        </script> 
            <?php
    }
    
?>