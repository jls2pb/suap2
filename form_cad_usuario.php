<?php
include "head.php";
?>


<body class="image">
<section class="vh-100">

<div class="container py-5 h-100">
  
  <div class="">
  
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                    <div class="row">
                      <div class="col text-center">
                        <img src="iconw2.png" width = "152px">
                      </div>
                      <div class="col d-flex align-items-center justify-content-center">
                        <img src="logo_ti2.png" width = "250px" >
                      </div>
                    </div>
    
          <div class = "container" style = "margin-top:20px">   
              
          <form method = "POST" action = "cadastrar_usuario.php">
                    <div class="form-outline mb-4">
                    <b> <label class="form-label" for="cpf" style="color: black;">DIGITE SEU NOME: </label></b>    
                    <input type="text" id="nome" name = "nome" class="form-control form-control-lg" required/>
                    </div>
                    <div class="form-outline mb-4">
                    <b> <label class="form-label" for="cpf" style="color: black;">CPF: </label></b>    
                    <input type="text" id="cpf" name = "cpf" class="form-control form-control-lg" required/>
                    </div>

                    <div class="form-outline mb-4">
                    <b> <label class="form-label" for="cpf" style="color: black;">SENHA: </label></b>
                    <input type="password" id="senha" name = "senha" class="form-control form-control-lg" required/>
                    </div>

                    <button style="background-color: DarkBlue; color: white;"class="btn  btn-lg btn-block" type="submit">CADASTRAR</button>
                
                    <a class="btn btn-primary  btn-lg btn-block" href="index.php" role="button">VOLTAR</a>
                </form>
          </div>
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
  html, body{
    width: 100%;
    max-width: 100vw;
    height: 100%;
    padding: 0;
    margin: 0;
  }
  body {
  background-image: url("imagem.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  margin: 0; 
  padding: 0; 
  display: flex;
  flex-direction: column;
  min-height: 100vh; 
}

.container {
display: block;
justify-content: right;
align-items: right;
left: 200px;
}
form {
  
}
input {
width: 20%;
}
  .responsive {
    width: 70%;
    right: 100px;
  }
  .imgs{
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