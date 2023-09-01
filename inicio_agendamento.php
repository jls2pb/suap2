<?php 
require_once("head.php");
session_start();

include "menu_agendamento.php";
include "navibar_agendamento.php";

require_once("conexao.php");
$pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
 $cpf_logado = $_SESSION['cpf'];
 //Setar a quantidade de registros por página
 $limite_resultado = 6;

 // Calcular o inicio da visualização
 $inicio = ($limite_resultado * $pagina) - $limite_resultado;


 //$query_usuarios = "SELECT DISTINCT ON (nome_profissional) * FROM profissional ORDER BY nome_profissional ASC LIMIT $limite_resultado OFFSET $inicio ";
// $result_usuarios = $conexao->prepare($query_usuarios);
// $result_usuarios->execute();
?>

        <script src="mascara.js"></script>
    </div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>