<?php 
date_default_timezone_set('America/Sao_Paulo');
session_start();
include "head.php";
include "conexao.php";
include "footer.php";
$hoje = date('d/m/Y');
?>
<script>
        // Função para recarregar a página a cada 5 segundos
        setTimeout(function() {
            location.reload();
        }, 5000); // 5000 milissegundos = 5 segundos
</script>
<div >
    <center>
        <img src="logo_ti.png" width = "250px" >
    </center>
    <br>
<?php 
$qdp = "SELECT COUNT(*) AS quantidade FROM tb_log WHERE acao = 'CADASTRADO'";
$rqdp = $conexao->prepare($qdp);
$rqdp->execute();
$xr = $rqdp->fetchAll();
foreach ($xr as $key => $a) {
  echo "<h5>PACIENTES CADASTRADOS: ".$a["quantidade"]." </h5>";
}

$qdp = "SELECT COUNT(*) AS quantidade FROM tb_log WHERE acao LIKE '%NOVO PROCEDIMENTO%'";
$rqdp = $conexao->prepare($qdp);
$rqdp->execute();
$xr = $rqdp->fetchAll();
foreach ($xr as $key => $a) {
  echo "<h5>PROCEDIMENTOS CADASTRADOS: ".$a["quantidade"]." </h5>";
}

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">COLABORADOR</th>
      <th scope="col">CADASTROS</th>
      <th scope="col">DIÁRIO</th>
      <th scope="col">GERAL</th>
    </tr>
  </thead>
  
  <tbody>
  <?php 
  $sql5 = "SELECT cpf_modificador, COUNT(*) AS quantidade FROM tb_log GROUP BY cpf_modificador ORDER BY quantidade DESC";
  $query5 = $conexao->query($sql5);
  $resultados5 = $query5->fetchAll(PDO::FETCH_ASSOC);
  foreach ($resultados5 as $resultado5) {
    if($resultado5['cpf_modificador'] != NULL){
      $a = $resultado5['cpf_modificador'];
  ?>
    <tr>
      <th scope="row">
        <?php
        $busca = "select nome from usuario where cpf = '$a'";
        $rb = $conexao->prepare($busca);
        $rb->execute();
        $nb = $rb->fetchAll();
        foreach ($nb as $key => $nbb) {
        $nomeM = strtoupper($nbb["nome"]);
          echo $nomeM; 
        }
         
         ?>
      </th>
      <td>PACIENTE <br> PROCEDIMENTOS </td>
      <td>
        <?php
        $sql4 = "SELECT cpf_modificador, COUNT(*) AS quantidade FROM tb_log WHERE acao = 'CADASTRADO' AND data_modificacao = '$hoje' AND cpf_modificador = '$a' GROUP BY cpf_modificador ORDER BY quantidade DESC";
        $query4 = $conexao->query($sql4);
        $resultados4 = $query4->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultados4 as $resultado4) {
          echo $resultado4['quantidade'];
        }
        ?>
        <br>
         <?php 
         $sql3 = "SELECT cpf_modificador, COUNT(*) AS quantidade FROM tb_log WHERE acao LIKE '%NOVO PROCEDIMENTO%' AND data_modificacao = '$hoje' AND cpf_modificador = '$a' GROUP BY cpf_modificador ORDER BY quantidade DESC";
         $query3 = $conexao->query($sql3);
         $resultados3 = $query3->fetchAll(PDO::FETCH_ASSOC);
         foreach ($resultados3 as $resultado3) {
          echo $resultado3['quantidade'];
        }
         ?>
      </td>
      <td>
        <?php 
        $sql2 = "SELECT cpf_modificador, COUNT(*) AS quantidade FROM tb_log WHERE acao = 'CADASTRADO' AND cpf_modificador = '$a' GROUP BY cpf_modificador ORDER BY quantidade DESC";
        $query2 = $conexao->query($sql2);
        $resultados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultados2 as $resultado2) {
        echo $resultado2['quantidade'];
        }
        ?>
        <br>
        <?php 
        $sql = "SELECT cpf_modificador, COUNT(*) AS quantidade FROM tb_log WHERE acao LIKE '%NOVO PROCEDIMENTO%' AND cpf_modificador = '$a' GROUP BY cpf_modificador ORDER BY quantidade DESC";
        $query = $conexao->query($sql);
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultados as $resultado) {
        echo $resultado['quantidade'];
        }
        ?> 
      </td>
    </tr>
    <?php
      }
    }
    ?> 
  </tbody>
</table>
</div>
