<?php 
session_start();
if(isset($_SESSION['cpf']) == FALSE){
    header("Location:index.php");
}
if(isset($_GET["id"])){
  $_SESSION['id'] = $_GET["id"];
}
require_once("head.php");
include "menu.php";
include "navibar.php";
include "footer.php";

$cpf_logado = $_SESSION['cpf'];

require_once("conexao.php");
$nome_paciente = $_SESSION['id'];
$sql = "SELECT * FROM tabela WHERE cod = '$nome_paciente'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>
<script>
function deleteItem(itemId) {
  let userConfirmation = confirm("Você tem certeza de que deseja deletar?");
  // Se o usuário confirmou a exclusão
  if(userConfirmation) {
    // Delete o item
    // Código para deletar o item vai aqui
    console.log(`Item ${itemId} deletado.`);
  }
  // Se o usuário cancelou a exclusão
  else {
    // Não faça nada
    console.log('Operação de exclusão cancelada.');
  }
}
   </script> 
<h2 class="mb-4">DADOS COMPLETOS DO PACIENTE</h2>
<div class = "container">
  <?php 
    foreach ($x as $y) {
      if($y["nascimento"] != NULL){
        $nascimento = date('d/m/Y', strtotime($y["nascimento"]));
    }else{
        $nascimento = NULL;
    }
  ?>
    <h1 class = "text-center"></h1>
      <div class="row">
        <div class="col-3 border "><strong>COD</strong></div>
        <div class="col-9 border "><strong>NOME PACIENTE</strong></div>
      </div>
      <div class="row border ">
        <div class="border col-3 "><?php echo $y["cod"]; ?></div>
        <div class="border col-9"><?php echo $y["nome_paciente"]; ?></div>
      </div>
      <div class="row">
        <div class="col border "><strong>RG</strong></div>
        <div class="col border "><strong>CPF</strong></div>
        <div class="col border "><strong>CNS</strong></div>
        <div class="col border "><strong>DATA NASCIMENTO</strong></div>
      </div>
      <div class="row border">
        <div class="col border "><?php echo $y["rg"]; ?></div>
        <div class="col border "><?php echo $y["cpf"]; ?></div>
        <div class="col border "><?php echo $y["cns"]; ?> </div>
        <div class="col border "><?php echo $y["nascimento"]; ?></div>
      </div>
      <div class="row">
        <div class="col border "><strong>NOME DA MAE</strong></div>
      </div>
      <div class="row">
        <div class="col border "><?php echo $y["nome_da_mae"]; ?></div>
      </div>
      <div class="row ">
        <div class="col border "> <strong>ACS</strong></div>
        <div class="col border "> <strong>UBS</strong></div>
        <div class="col border "> <strong>CELULAR</strong></div>
        <div class="col border "> <strong>TELEFONE</strong></div>
      </div>
      <div class="row">
        <div class="col border "><?php echo $y["acs"]; ?> </div>
        <div class="col border ">  <?php echo $y["ubs"]; ?> </strong></div>
        <div class="col border "> <?php echo $y["celular"]; ?> </strong></div>
        <div class="col border "> <?php echo $y["telefone"]; ?> </div>
    <?php
        $id_usuario = $y["cod"];
    }
    $sql2 = "SELECT * FROM procedimentos WHERE cod = '$nome_paciente' ORDER BY id DESC";
      $resultado2 = $conexao->prepare($sql2);
   
      if($resultado2->execute()){
          $x2=$resultado2->fetchAll();
      }else{
          echo "erro ao coletar os dados";
      }
    ?> 
      </div>
      <br>
      <div class="row text-center">
        <div class="col">
          <a class="btn text-white" style = "background-color: DarkBlue" href="form_edita.php" role="button">EDITAR PACIENTE</a>
          <a class="btn btn-primary text-white" href="cadastrar_procedimento.php?n=<?php echo $y["nome_paciente"]; ?>" role="button">NOVO PROCEDIMENTO</a>
          <a class="btn btn-info text-white" href="listar_log.php" role="button">ATIVIDADES</a>
          <a class="btn btn-danger text-white" href="excluir_paciente.php" role="button">EXCLUIR CADASTRO</a>
        </div>
      </div> 
            <br>
            <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">COD</th>
            <th scope="col">NOME</th>
            <th scope="col">PROCEDIMENTO</th>
		<th scope="col">ESPECIFICAÇÃO</th>
            <th scope="col">SOLICITAÇÃO </th>
            <th scope="col">ENTRADA(CAD)</th>
            <th scope="col">SAIDA</th>
            <th scope="col">AGENDAMENTO</th>
            <th scope="col">LOCAL AG</th>
            <th scope="col">AÇÃO</th>
            </tr>
        </thead>
        <tbody>
          <?php 
            foreach ($x2 as $y2) {
                    if($y2["data_da_solicitacao"] != NULL){
                        $solicitacao = date('d/m/Y', strtotime($y2["data_da_solicitacao"]));
                    }else{
                        $solicitacao = NULL;
                    }
                    if($y2["data_de_entrada_cadastro"] != NULL){
                        $entrada = date('d/m/Y', strtotime($y2["data_de_entrada_cadastro"]));
                    }else{
                        $entrada = NULL;
                    }
                    if($y2["data_da_saida"] != NULL){
                        $saida = date('d/m/Y', strtotime($y2["data_da_saida"])); 
                    }else{
                        $saida = NULL;
                    }
                    if($y2["data_do_agendamento"] != NULL){
                        $agendamento = date('d/m/Y', strtotime($y2["data_do_agendamento"]));  
                    }else{
                        $agendamento = NULL;
                    }
          ?>
            <tr>
            <th scope="row"><?php echo $y2["id"]; ?></th>
            <td><?php echo $y2["nome_paciente"]; ?></td>
            <td><?php echo $y2["procedimento"]; ?></td>
		<td><?php echo $y2["especificacao"]; ?></td>
            <td><?php echo $solicitacao ?></td>
            <td><?php echo $entrada ?></td>
            <td><?php echo $saida ?></td>
            <td><?php echo $agendamento ?></td>
            <td><?php echo $y2["local_do_agendamento"]; ?></td>
            <td><a class="btn text-white" style = "background-color: DarkBlue" href="form_edita_procedimento.php?id=<?php echo $y2['id'] ?>" role="button"> VER MAIS </a></td>
            <td><a onclick="deleteItem(itemId)" class="btn btn-danger text-white" href="excluir_procedimento.php?id=<?php echo $y2['id'] ?>&nome=<?php echo $y2["nome_paciente"]; ?>" role="button" onclick="deleteItem(itemId)"> EXCLUIR </a></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        </table>
          </div>  
    </div>
</div>
    