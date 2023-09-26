<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" style=" background-color: #66a7ff;">
      <img style="width: 72%;"src="../images/logo_clara.png">
      <img style="width: 25%;" src="../images/iconw2.png">
      <div class="container">
    <div class="row">
    <div class="col-sm">
    
    </div>
    <div class="col-sm-5">
         <img style=" width: 90%;" src="../images/perfil.png">


        

    </div>
    <div class="col-sm">
      
    </div>
  </div>
  
  <div class="text-center" style="font-size: 80%;">       
<?php
require_once("../conexao.php");


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

</li>
          <li >
            <a href="inicio_agendamento.php"><span class="fa fa-home"></span><b> INÍCIO</b></a>
          </li>

          <li>
          <a href="cadastrar_profissional.php" class="link-dark rounded"><img style="width: 14%;" src="../images/medico.png"><b>NOVO PROFISSIONAL</b></a></li>
          </li>
  
          </li>
          
          <li>
            <a href="exibir_resultado_agendar.php"><span class="bi bi-bar-chart-line-fill" ></i></span><b> RANKING </b></a>
          </li>
          <li>
            <a href="../sair.php"><span class="bi bi-door-open-fill" ></i></span><b> SAIR</b></a>
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