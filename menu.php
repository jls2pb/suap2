
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
  nav {
	position: relative;
}
nav ul {
	list-style: none;
	margin: 0;
	padding: 0;
}
nav ul li {
  /* Sub Menu */
}
nav ul li a {
	display: block;
	padding: 10px 15px;
	color: #fff;
	text-decoration: none;
	-webkit-transition: 0.2s linear;
	-moz-transition: 0.2s linear;
	-ms-transition: 0.2s linear;
	-o-transition: 0.2s linear;
	transition: 0.2s linear;
}
nav ul li a:hover {
	background: #4169E1;
	color: blue;
}

nav ul ul {
	background: rgba(0, 0, 0, 0.2);
}
nav ul li ul li a {
	
	border-left: 4px solid transparent;
	padding: 10px 20px;
}
nav ul li ul li a:hover {

	border-left: 4px solid #3498db;
}
 </style>

<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" style=" background-color: #66a7ff;" class='animated bounceInDown'>
      <img style="width: 72%;"src="images/logo_clara.png">
      <img style="width: 25%;" src="images/iconw2.png">
      <div class="container">
  <div class="row">
    <div class="col-sm">
    
    </div>
    <div class="col-sm-5">
         <img style=" width: 90%;" src="images/perfil.png">


        

    </div>
    <div class="col-sm">
      
    </div>
  </div>
  <div class="text-center" style="font-size: 80%;">       
<?php
require_once("conexao.php");


  $sql = "SELECT * FROM usuario WHERE cpf = '$cpf_logado'";
  $resultado = $conexao->query($sql);

  if ($resultado) {
    $row = $resultado->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      echo $row['nome'];
    } else {
      echo "Nome não encontrado";
    }
  } else {
    echo "Erro na consulta SQL"; // Pode ser alterado para uma mensagem de erro personalizada
  }


?>
</div>
</div>
    

        <ul class="list-unstyled components mb-5">
          
          <li>
            <a href="inicio.php"><span class="fa fa-home"></span><b> INÍCIO</b></a>
          </li>
          
          <li class="sub-menu-second">
          <a style="cursor: pointer;" class="link-dark rounded"><b>CADASTRO </b><div class="fa fa-caret-down right"></div></a>
           
          <ul>

          <li>
          <a href="cadastrar_paciente.php" class="link-dark rounded"><span class="fa fa-user"></span><b>NOVO PACIENTE</b></a></li>
          </li>
        
          <li><a href="forms_tabela.php" class="link-dark rounded"><span class="bi bi-table"></span><b>TABELAS</b></a></li>
          </li>

          </ul></li>

          <li>
            <a href="index_logado.php"><span class="fa fa-sticky-note"></span><b> LISTAR PACIENTES</b></a>
          </li>

          <li>
            <a href="exibir_resultado.php"><span class="bi bi-bar-chart-line-fill" ></i></span><b> RANKING </b></a>
          </li>

          <li>
            <a href="sair.php"><span class="bi bi-door-open-fill" ></i></span><b> SAIR</b></a>
          </li>
        </ul>

        <div class="footer">
        	<p>
				
					</p>
        </div>
    	</nav>
       
      
      
      <script>
$(document).ready(function () {
    console.log("JavaScript está funcionando!"); // Adicione esta linha para verificar
    $('.sub-menu-second ul').hide();
    $(".sub-menu-second a").click(function () {
        $(this).parent(".sub-menu-second").children("ul").slideToggle("100");
        $(this).find("span.right").toggleClass("fa-caret-up fa-caret-down");
    });
});
</script>
