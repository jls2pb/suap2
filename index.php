<?php 
include "head.php";
require_once("conexao.php");


if(isset($_POST["cpf"])){
  $cpf = $_POST['cpf'];
  $senha = $_POST['senha'];
  $query_usuarios = "SELECT * FROM usuario";
  $result_usuarios = $conexao->prepare($query_usuarios);
  $result_usuarios->execute();
  
  foreach ($result_usuarios as $r ) {
    if($r["cpf"] == $cpf && $r["senha"] == $senha && $r["id_tipo"] == 1){
      session_start();
      $_SESSION['cpf_adm'] = $cpf;
      Header("Location:adm/inicio_adm.php");
    }
    else if($r["cpf"] == $cpf && $r["senha"] == $senha && $r["id_tipo"] == 2){
      session_start();
      $_SESSION['cpf_agendar'] = $cpf;
      Header("Location:agendar/inicio_agendamento.php");
    }
    else if($r["cpf"] == $cpf && $r["senha"] == $senha && $r["id_tipo"] == 3){
      session_start();
      $_SESSION['cpf_cadastro'] = $cpf;
      Header("Location:cadastro/inicio.php");
    }
   else if ($r["cpf"] == $cpf && $r["senha"] == $senha && $r["id_tipo"] == 4) {
    session_start();
    $_SESSION['cpf_cad_ag'] = $cpf;
    Header("Location:cad_ag/inicio_cad_ag.php");
}
else if($r["cpf"] == $cpf && $r["senha"] == $senha && $r["id_tipo"] == 5){
  session_start();
  $_SESSION['cpf_policlinica'] = $cpf;
  Header("Location:policlinica/inicio.php");
}
  
  
  }
  ?>
  <link href="css/style.css">
    <script>
      window.alert("ERRO AO EFETUAR LOGIN!");
    </script>
  <?php
}
?>
<body class="image">
<section class="vh-100">

<div class="container py-5 h-100">
  
  <div class="">
  
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                    <div class="row">
                    <div class="col d-flex align-items-center justify-content-center">
                        <img src="images/logo_ti2.png" width = "250px" >
                      </div>
                      <div class="col text-center">
                        <img src="images/iconw2.png" width = "152px">
                      </div>
                      
                    </div>
    
            
              <br>
              <form method = "POST" action = "">
                  <input type="hidden" id="nome" name = "nome" class="form-control form-control-lg" required/>
                  <div class="form-outline mb-4">
                  <label class="form-label" for="cpf" style="color: black;">CPF: </label>    
                  <input type="text" id="cpf" name = "cpf" class="form-control form-control-lg" required/>
                  </div>

                  <div class="form-outline mb-4">
                  <label class="form-label" for="senha" style="color: black;">SENHA: </label> </b>
                  <input type="password" id="senha" name = "senha" class="form-control form-control-lg" required/>
                  </div>

                  <button style="background-color: DarkBlue; color: white;"class="btn  btn-lg btn-block" type="submit">ENTRAR</button>
              
                  <a class="btn btn-primary  btn-lg btn-block" href="form_cad_usuario.php" role="button">CADASTRAR</a>
                
              </form>
        </div>
  </div>
</div>

</section>
</body>
<script src="mascara.js"></script>

<!--
  para iniciar, informe o elemento, a máscara, o caracter de substituição e
  os caracteres a serem ignorados
-->
<script>
  new FormMask(document.querySelector("#cpf"), "___.___.___-__", "_", [".", "-"])
</script>
<style>
        body {
            margin: 0;
            padding: 0;
            background-image: url("images/imagem.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed; /* Isso mantém a imagem fixa na tela */
            height: 100vh;
            display: flex;
            flex-direction: column;
           
        }

       

        /* Seu estilo restante... */

        .responsive {
            width: 70%;
            right: 100px;
        }

        .imgs {
            display: inline-block;
        }

        .tamanho {
            width: 100px;
        }

        p {
            font-size: 20px;
            margin: 0px 15px 15px 20px;
            padding: 0;
        }
    </style>