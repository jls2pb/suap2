<?php
require_once("head.php");
session_start();
if (isset($_SESSION['cpf_policlinica'])) {
    $cpf_logado = $_SESSION['cpf_policlinica'];

    require_once("../conexao.php");

        $query = "SELECT id_agendamento, nome_paciente, data_atendimento, hora, endereco_local, local_atendimento, status FROM agendamento WHERE status = 2";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($agendamentos)) {
            echo "<h3>Agendamentos de quem não compareceu</h3>";
            
            echo "<table class='table table-striped table-bordered table-sm table-responsive' border='1'>";
            echo "<tr><th>Nome do Paciente</th><th>Data de Atendimento</th><th>Hora</th><th>Endereço Local</th><th>Local de Atendimento</th><th>Status</th></tr>";
            foreach ($agendamentos as $agendamento) {
                echo "<tr>";
                
                $dia = date('d/m/Y', strtotime($agendamento["data_atendimento"]));
               
        
                echo "<td>" . $agendamento['nome_paciente'] . "</td>";
                echo "<td>" . $dia . "</td>";
                echo "<td>" . $agendamento['hora'] . "</td>";
                echo "<td>" . $agendamento['endereco_local'] . "</td>";
                echo "<td>" . $agendamento['local_atendimento'] . "</td>";
                echo "<td>Não Compareceu</td>";
                echo "</tr>";
            }
            echo "</table> <br>";
        } else {
            echo "Nenhum resultado encontrado.";
        }
?>
<style>
@media print {
    #print,
    #voltar {
        display: none;
    }
}
</style>
<button style="width: 100%;" id="print" onclick="printPage()">Imprimir<img style="width: 2%;" src="../images/printer.png"></button>
<a href="inicio.php"><button style="width: 100%; background-color:#B22222;color: white;" id="voltar">Voltar</button><a>
<script>
function printPage() {
    window.print();
}
</script>
<?php
} else {
    header("location: ../index.php");
}
?>
