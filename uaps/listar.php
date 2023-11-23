<style>
  .table.table-compact th,
  .table.table-compact td {
    padding: 10px; 
    font-size: 12px; 
  }
  </style>
   <?php 
session_start();
if(isset($_SESSION['cpf_uaps']) == FALSE){
    header("Location:../index.php");
}
if(isset($_GET["id"])){
  $_SESSION['id'] = $_GET["id"];
}$cpf_logado = $_SESSION['cpf_uaps'];
require_once("head.php");
include "navibar.php";
include "../footer.php";



require_once("../conexao.php");
$nome_paciente = $_SESSION['id'];
$sql = "SELECT * FROM tabela WHERE cod = '$nome_paciente'";
$resultado = $conexao->prepare($sql);
if($resultado->execute()){
    $x=$resultado->fetchAll();
}else{
    echo "erro ao coletar os dados";
}
?>


   <div class = "container mt-1" style="font-size:12px;"> 
    <a href="inicio.php" class="btn btn-danger float-right">VOLTAR</a>
    <div class="">
    <h4 class="mb-4">DADOS COMPLETOS DO PACIENTE</h4>
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
      <div class="row">
        <div class="border col-3 "><?php echo $y["cod"]; ?></div>
        <div class="border col-9"><?php echo $y["nome_paciente"]; ?></div>
      </div>
      <div class="row">
        <div class="col border "><strong>RG</strong></div>
        <div class="col border "><strong>CPF</strong></div>
        <div class="col border "><strong>CNS</strong></div>
        <div class="col border "><strong>DATA NASCIMENTO</strong></div>
      </div>
      <div class="row">
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
</div>      
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
     
            <br>
            <table class="table table-striped table-compact" style="font-size:10px;">
        <thead class="text-center">
            <tr>
			<th scope="col">PROCEDIMENTO</th>
            <th scope="col">STATUS</th>
            <th scope="col">PROFISSIONAL</th>
            <th scope="col">DATA DO ATENDIMENTO</th>
            <th scope="col">LOCAL AGENDAMENTO</th>
            </tr>
        </thead>
        <tbody class="text-center">

                    <?php 
                      foreach ($x2 as $y2) {             
                              if($y2["data_do_agendamento"] != NULL){
                                  $agendamento = date('d/m/Y', strtotime($y2["data_do_agendamento"]));  
                              }else{
                                  $agendamento = NULL;
                              }
                    ?>
                  
  <tr>
                      <td><?php echo $y2["procedimento"]; ?></td> 
                      <td>
                      <?php
                      $id = $y2['id'];
                      $query = "SELECT status FROM agendamento WHERE procedimento = $id";
                      $result = $conexao->prepare($query);
                      $result->execute();

                      $query1 = "SELECT status FROM procedimentos WHERE id = $id";
                      $result1 = $conexao->prepare($query1);
                      $result1->execute();

                      $statusArray = [];

                      if ($result && $result->rowCount() > 0) {
                          $statusRow = $result->fetch(PDO::FETCH_ASSOC);
                          $statusArray[] = $statusRow['status'];
                      } elseif ($result1 && $result1->rowCount() > 0) {
                          $statusRow1 = $result1->fetch(PDO::FETCH_ASSOC);
                          $statusArray[] = $statusRow1['status'];
                      }
                      

                      if (count($statusArray) > 0) {
                          // Os resultados das duas consultas estão em $statusArray
                          foreach ($statusArray as $status) {
                            if ($status === 0) {
                                echo "AGENDADO";
                            } elseif ($status === 1) {
                                echo "COMPARECEU";
                            } elseif ($status === 2) {
                                echo "NÃO COMPARECEU";
                            } elseif ($status === 3) {
                                echo "AGUARDANDO AGENDAMENTO";
                            } elseif ($status === 4) {
                                echo "DEVOLVIDA À UAPS";
                            } elseif ($status === 5) {
                              echo "RETIRADA DO SETOR";
                            } elseif ($status === 6) {
                                echo "ENCAMINHADA À POLICLÍNICA";
                            } elseif ($status === 7) {
                                echo "ENCAMINHADA AO HGLAS";
                            } elseif ($status === 8) {
                                echo "ENCAMINHADA AO CAPS";
                            } elseif ($status === 9) {
                              echo "ENCAMINHADA AO CER";
                           }
                        }
                      } else {
                          echo "AGUARDANDO";
                      }
                      ?>

                      </td>
                    <td><?php echo $y2["profissional"]; ?></td>
            <td><?php echo $agendamento ?></td>
            <td><?php echo $y2["local_do_agendamento"]; ?></td>
            </tr>
            <?php
            }
            ?>
     </tbody>
        </table>
          </div>  
    </div>
</div>
