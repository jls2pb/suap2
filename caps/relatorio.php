<link rel="icon" type="image/png" href="../images/icon.png" />
<style>
@media print {
    #print,
    #voltar, 
    .search-form {
        display: none;
    }
}
</style>
<button style="width: 100%;" id="print" onclick="printPage()">Imprimir<img style="width: 2%;" src="../images/printer.png"></button>
<a href="inicio.php"><button style="width: 100%; background-color:#B22222;color: white;" id="voltar">Voltar</button><a>
    <?php
require_once("head.php");
session_start();
if (isset($_SESSION['cpf_caps'])) {
    $cpf_logado = $_SESSION['cpf_caps'];

    require_once("../conexao.php");
    echo "<div class='row pt-1' style='color:black;'>";
    echo "<img style='height: 100px; ' class='col-4' src='../images/logo_sm.png'>";
    echo "<div class='col-4 text-center pt-0'>";
    echo "<h5>SECRETARIA MUNICIPAL DE SAÚDE </h5>";
    echo "<h6>SÃO GONÇALO DO AMARANTE</h6>";
    echo "<h7>AVENIDA CORONEL NECO MARTINS, 276</h7><br>";
    echo "</div>";
    echo "<div class='col-2'></div>";
    echo "<div class='text-right col-2 pt-0 pl-1'><img style='width: 100%;' src='../images/logo_sus.png'><br>";
    echo "SUAP SESA</div>";
    echo "</div>";
    echo "<hr style='background-color: black;'>";

        $query = "SELECT id_agendamento, nome_paciente, data_atendimento, hora, endereco_local, local_atendimento, status FROM agendamento WHERE status = 2";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($agendamentos)) {
            echo '<form method="POST" id="searchForm" class="search-form">
            <div class="input-group container">
                <div class="form-outline">
                    <input autofocus style="width: 105%;" type="search" id="pesquisa" name="nome" class="form-control" placeholder="BUSCAR..." oninput="this.value = this.value.toUpperCase(); searchTable();" style="text-transform: uppercase;">
                    <input type="hidden" name="uaps" value="<?php echo $uapsSelecionada; ?>">
                </div>
            </div>  
        </form>';
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
<script>
    function removeAccents(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }

    function searchTable() {
        var searchTerm = removeAccents(document.getElementById("pesquisa").value.toLowerCase());
        var tableRows = document.querySelectorAll("table tr");

        // Comece o loop a partir da segunda linha (índice 1) para ignorar o cabeçalho
        for (var rowIndex = 1; rowIndex < tableRows.length; rowIndex++) {
            var row = tableRows[rowIndex];
            var cells = row.getElementsByTagName("td");
            var rowVisible = false;

            for (var i = 0; i < cells.length; i++) {
                var cell = cells[i];
                var cellText = removeAccents(cell.textContent.toLowerCase());

                if (cellText.includes(searchTerm)) {
                    rowVisible = true;
                    break;
                }
            }

            row.style.display = rowVisible ? "table-row" : "none";
        }
    }

    document.getElementById("pesquisa").addEventListener("input", searchTable);

// Captura o evento "keydown" no campo de pesquisa
document.getElementById("pesquisa").addEventListener("keydown", function(event) {
    // Se a tecla pressionada for "Enter" (código 13), previna a ação padrão
    if (event.keyCode === 13) {
        event.preventDefault();
    }
});
</script>