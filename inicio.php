<?php 
session_start();
if(isset($_SESSION['cpf'])){
$cpf_logado = $_SESSION['cpf'];
include "head.php";
include "menu.php";
include "navibar.php";
include "footer.php";

?>
<h2 class="mb-4">SUAP - Sistema Unico de Acompanhamento de Procedimentos</h2>
    </div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
<?php 
}else{
    header("Location:index.php");
}
?>
