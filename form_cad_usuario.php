<?php
include "head.php";
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
              
          <form method = "POST" action = "cadastrar_usuario.php">
                    <div class="form-outline mb-3">
                      
                    <input style="" type="text" id="nome" name = "nome" class="form-control" placeholder="Digite seu nome completo" required/>
                    </div>
                    <div class="form-outline mb-3">
                    
                    <input type="text" id="cpf" name = "cpf" class="form-control" placeholder="Digite seu CPF" required/>
                    </div>

                    <div class="form-outline mb-3">
                   
                    <input type="password" id="senha" name = "senha" class="form-control" placeholder="Digite sua senha" required/>
                    </div>
                    <div class="form-outline mb-3">
                    <select class="form-control " name="funcao" required>
                      <option value="" selected disabled>Selecione sua função</option>
                      <option value="2" id="2">Agendamento</option>
                      <option value="3" id="3">Cadastro</option>
                      <option value="4" id="4">Cadastro-Agendamento</option>
                      <option value="5" id="5">Policlínica</option>
                    </select>
                    </div>
                    <div class="form-outline mb-3">
                   
                   <input type="text" id="codigo" name = "codigo" class="form-control" placeholder="Digite o código" required/>
                   </div>

                    <button style="background-color: DarkBlue; color: white;"class="btn  btn btn-block" type="submit">CADASTRAR</button>
                
                    <a class="btn btn-primary  btn btn-block" href="index.php" role="button">VOLTAR</a>
                </form>
          
        </div>
  </div>
</div>

</section>
</body>

<script src="mascara.js"></script>
<script>
    $(document).ready(function () {
        // Quando o usuário digitar algo no input, convertemos para maiúsculas
        $('#nome').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>
<!--
    para iniciar, informe o elemento, a máscara, o caracter de substituição e
    os caracteres a serem ignorados
-->
<script>
    new FormMask(document.querySelector("#cpf"), "___.___.___-__", "_", [".", "-"])
</script>
<STYLE>
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