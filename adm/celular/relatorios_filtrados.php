<link rel="icon" type="image/png" href="../../images/icon.png" />
<script>
function printPage() {
    window.print();
}
</script>
<style>
@media print {
    #print,
    #voltar,
 {
        display: none;
    }
}
</style>
<button style="width: 100%;" id="print" onclick="printPage()">Imprimir<img style="width: 2%;" src="../../images/printer.png"></button>
<a href="relatorios.php"><button style="width: 100%; background-color:#B22222;color: white;" id="voltar">Voltar</button><a>


<?php
require_once("head.php");
session_start();
if (isset($_SESSION['cpf_adm'])) {
    $cpf_logado = $_SESSION['cpf_adm'];

    require_once("../../conexao.php");
    echo "<div class='row pt-1' style='color:black;'>";
    echo "<img style='height: 100px; ' class='col-4' src='../../images/logo_sm.png'>";
    echo "<div class='col-4 text-center pt-0'>";
    echo "<h5>SECRETARIA MUNICIPAL DE SAÚDE </h5>";
    echo "<h6>SÃO GONÇALO DO AMARANTE</h6>";
    echo "<h7>AVENIDA CORONEL NECO MARTINS, 276</h7><br>";
    echo "</div>";
    echo "<div class='col-2'></div>";
    echo "<div class='text-right col-2 pt-0 pl-1'><img style='width: 100%;' src='../../images/logo_sus.png'><br>";
    echo "SUAP SESA</div>";
    echo "</div>";
    echo "<hr style='background-color: black;'>";
    // Inicializa as variáveis para os resultados
    $procedimentosEntrada = [];
    $agendamentos = [];
    $procedimentosNaoAgendados = [];

    // Verifica se o formulário de "Procedimentos" foi enviado
    if (isset($_POST['procedimento'])) {
        // Verifica se o checkbox "Quantos deram entrada" foi selecionado
            $dataInicio = $_POST['data_inicio'];
            $dataFim = $_POST['data_fim'];

          // Faça a consulta SQL para buscar procedimentos com data de entrada no período especificado
$query = "SELECT id, nome_paciente, procedimento, data_de_entrada_cadastro FROM procedimentos WHERE data_de_entrada_cadastro BETWEEN :dataInicio AND :dataFim";
$stmt = $conexao->prepare($query);
$stmt->bindParam(':dataInicio', $dataInicio, PDO::PARAM_STR);
$stmt->bindParam(':dataFim', $dataFim, PDO::PARAM_STR);
if ($stmt->execute()) {
    $procedimentosEntrada = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $query2 = "SELECT COUNT(*) AS quantidade_entrada FROM procedimentos WHERE  data_de_entrada_cadastro BETWEEN :dataInicio AND :dataFim";
    $stmt2 = $conexao->prepare($query2);
    $stmt2->bindParam(':dataInicio', $dataInicio, PDO::PARAM_STR);
    $stmt2->bindParam(':dataFim', $dataFim, PDO::PARAM_STR);
    if ($stmt2->execute()) {
        $resultado = $stmt2->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Erro na consulta SQL 2: " . $stmt2->errorInfo();
    }
} else {
    echo "Erro na consulta SQL 1: " . $stmt->errorInfo();
}

    
    } 

    
    if (isset($_POST['agendamento'])) {
        $query = "SELECT * FROM procedimentos WHERE data_do_agendamento != '' AND data_do_agendamento IS NOT NULL";
        $stmt = $conexao->prepare($query);
        if ($stmt->execute()) {
            $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Erro na consulta SQL de Agendamentos: " . $stmt->errorInfo();
        }

                
            } 


    if (isset($_POST['agendar'])) {
       
        $periodoInicio = $_POST['periodo_inicio'];
        $periodoFim = $_POST['periodo_fim'];
 if($periodoInicio !== '' && $periodoFim !== '') {
      // Faça a consulta SQL para buscar procedimentos não agendados no período especificado
        $query = "SELECT id, nome_paciente, procedimento FROM procedimentos WHERE id NOT IN (SELECT procedimento FROM agendamento) AND data_de_entrada_cadastro BETWEEN :periodoInicio AND :periodoFim";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':periodoInicio', $periodoInicio, PDO::PARAM_STR);
        $stmt->bindParam(':periodoFim', $periodoFim, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $procedimentosNaoAgendados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Erro na consulta SQL de Procedimentos Não Agendados: " . $stmt->errorInfo();
        }
        }
        else if($periodoInicio !== '' && $periodoFim == '') {
            $data = date('Y-m-d');
            $query = "SELECT id, nome_paciente, procedimento FROM procedimentos WHERE id NOT IN (SELECT procedimento FROM agendamento) AND data_de_entrada_cadastro BETWEEN :periodoInicio AND :data";
            $stmt = $conexao->prepare($query);
            $stmt->bindParam(':periodoInicio', $periodoInicio, PDO::PARAM_STR);
            $stmt->bindParam(':data', $data, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $procedimentosNaoAgendados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "Erro na consulta SQL de Procedimentos Não Agendados: " . $stmt->errorInfo();
            }
        } else if($periodoFim !== '' && $periodoInicio == '') {
            $data = '1970-01-01';
            $query = "SELECT id, nome_paciente, procedimento FROM procedimentos WHERE id NOT IN (SELECT procedimento FROM agendamento) AND data_de_entrada_cadastro BETWEEN  :data AND :periodoFim";
            $stmt = $conexao->prepare($query);
            $stmt->bindParam(':periodoFim', $periodoFim, PDO::PARAM_STR);
            $stmt->bindParam(':data', $data, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $procedimentosNaoAgendados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "Erro na consulta SQL de Procedimentos Não Agendados: " . $stmt->errorInfo();
            }
        }
      else {
        $query = "SELECT id, nome_paciente, procedimento FROM procedimentos WHERE id NOT IN (SELECT procedimento FROM agendamento)";
        $stmt = $conexao->prepare($query);
        if ($stmt->execute()) {
            $procedimentosNaoAgendados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Erro na consulta SQL de Procedimentos Não Agendados: " . $stmt->errorInfo();
        }
      }

            
            } 

            // Contagem de procedimentos agendados e não agendados
            $numProcedimentosAgendados = count($agendamentos);
            $numProcedimentosNaoAgendados = count($procedimentosNaoAgendados);

    // Exibir os resultados em tabelas
    if (!empty($procedimentosEntrada)) {
        echo "<h3>Procedimentos com Entrada no Período</h3>";
        echo "O número de procedimentos com entrada são: " . $resultado['quantidade_entrada'];
        echo "<table class='table table-striped table-bordered table-sm table-responsive'>";
        echo "<tr><th>Cod</th><th>Nome do Paciente</th><th>Procedimento</th><th>Data de Entrada</th></tr>";
        echo '<form method="POST" id="searchForm" class="search-form">
            <div class="input-group container">
                <div class="form-outline">
                    <input autofocus style="width: 105%;" type="search" id="pesquisa" name="nome" class="form-control" placeholder="BUSCAR..." oninput="this.value = this.value.toUpperCase(); searchTable();" style="text-transform: uppercase;">
                    <input type="hidden" name="uaps" value="<?php echo $uapsSelecionada; ?>">
                </div>
            </div>  
        </form>';
        foreach ($procedimentosEntrada as $procedimento) {
            echo "<tr>";
            echo "<td>" . $procedimento['id'] . "</td>";
            echo "<td>" . $procedimento['nome_paciente'] . "</td>";
            echo "<td>" . $procedimento['procedimento'] . "</td>";  
             $dia = date('d/m/Y', strtotime($procedimento['data_de_entrada_cadastro']));
            echo "<td>" .  $dia . "</td>";
         
            echo "</tr>";
        }
        echo "</table>";
    }

    if (!empty($agendamentos)) {
        echo "<h3>Agendamentos</h3>";
        echo "<p>O número de procedimentos agendados são: $numProcedimentosAgendados</p>";
        echo "<table class='table table-striped table-bordered table-sm table-responsive' border='1'>";
        echo "<tr><th>ID</th><th>Nome do Paciente</th><th>Procedimento</th><th>Data de Atendimento</th><th>Local de Atendimento</th><th>Profissional</th></tr>";
        echo '<form method="POST" id="searchForm" class="search-form">
        <div class="input-group container">
            <div class="form-outline">
                <input autofocus style="width: 105%;" type="search" id="pesquisa" name="nome" class="form-control" placeholder="BUSCAR..." oninput="this.value = this.value.toUpperCase(); searchTable();" style="text-transform: uppercase;">
                <input type="hidden" name="uaps" value="<?php echo $uapsSelecionada; ?>">
            </div>
        </div>  
    </form>';
        foreach ($agendamentos as $agendamento) {
            echo "<tr>";
            echo "<td>" . $agendamento['id'] . "</td>";
            echo "<td>" . $agendamento['nome_paciente'] . "</td>";
            echo "<td>" . $agendamento['procedimento'] . "</td>";
            $dia = date('d/m/Y', strtotime($agendamento['data_do_agendamento']));
            echo "<td>" . $dia . "</td>";
            echo "<td>" . $agendamento['local_do_agendamento'] . "</td>";
            echo "<td>" . $agendamento['profissional'] . "</td>";
            echo "</tr>";
        }
        echo "</table> <br>";
    }

    if (!empty($procedimentosNaoAgendados)) {
        echo "<h3>Procedimentos não Agendados</h3>";
        echo "<p>O número de procedimentos não agendados são: $numProcedimentosNaoAgendados</p>";
        echo "<table class='table table-striped table-bordered table-sm table-responsive' border='1'>";
        echo "<tr><th>ID</th><th>Nome do Paciente</th><th>Procedimento</th></tr>";
        foreach ($procedimentosNaoAgendados as $procedimento) {
            echo "<tr>";
            echo "<td>" . $procedimento['id'] . "</td>";
            echo "<td>" . $procedimento['nome_paciente'] . "</td>";
            echo "<td>" . $procedimento['procedimento'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // Execute uma consulta SQL para buscar a agenda do profissional
    if (isset($_POST['profissional_nome'])) {
        $profissional_nome = $_POST["profissional_nome"];
        $agenda_inicio = $_POST["agenda_inicio"];
    
        try {
            // Execute uma consulta SQL para buscar os agendamentos com base nas informações fornecidas
            $sql = "SELECT proc.id, p.nome AS profissional, proc.nome_paciente, proc.procedimento, proc.data_do_agendamento, proc.local_do_agendamento, proc.profissional
            FROM procedimentos AS proc
            INNER JOIN profissionais AS p ON proc.profissional = p.nome
            WHERE p.nome = :profissional_nome
            AND proc.data_do_agendamento = :agenda_inicio";
    
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':profissional_nome', $profissional_nome, PDO::PARAM_STR);
            $stmt->bindParam(':agenda_inicio', $agenda_inicio, PDO::PARAM_STR);
            $stmt->execute();
    
            // Verifique se há resultados
            if ($stmt->rowCount() > 0) {
                echo "<h2>Data marcada com o profissional: $profissional_nome</h2>";
                echo "<table class='table table-striped table-bordered table-lg table-responsive'>";
                echo "<tr><th>ID</th><th>Nome do Profissional</th><th>Nome do Paciente</th><th>Procedimento</th><th>Data do Agendamento</th><th>Local do Agendamento</th></tr>";
                echo '<form method="POST" id="searchForm" class="search-form">
                <div class="input-group container">
                    <div class="form-outline">
                        <input autofocus style="width: 105%;" type="search" id="pesquisa" name="nome" class="form-control" placeholder="BUSCAR..." oninput="this.value = this.value.toUpperCase(); searchTable();" style="text-transform: uppercase;">
                        <input type="hidden" name="uaps" value="<?php echo $uapsSelecionada; ?>">
                    </div>
                </div>  
            </form>';
                // Loop através dos resultados e exiba-os na tabela
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['profissional'] . "</td>";
                    echo "<td>" . $row['nome_paciente'] . "</td>";
                    echo "<td>" . $row['procedimento'] . "</td>";
                    $dia = date('d/m/Y', strtotime($row['data_do_agendamento']));
                    echo "<td>" . $dia . "</td>";
                    echo "<td>" . $row['local_do_agendamento'] . "</td>";
                   
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Nenhum resultado encontrado.";
            }
        } catch (PDOException $e) {
            // Trate erros, se necessário
        }
    }
    
    

    if (isset($_POST['profissional'])) {
        // Execute uma consulta SQL para buscar os profissionais cadastrados
        $sqlProfissionais = "SELECT id_profissional, nome, area, tempo_atendimento FROM profissionais";
        $stmtProfissionais = $conexao->prepare($sqlProfissionais);
        $stmtProfissionais->execute();

        // Verifique se há resultados
        if ($stmtProfissionais->rowCount() > 0) {
            echo "<h3>Profissionais Cadastrados</h3><p>Total de profissionais cadastrados: " . $stmtProfissionais->rowCount() . "</p>";
            echo "<table class='table table-striped table-bordered table-sm' border='1'>";
            echo "<tr><th>ID Profissional</th><th>Nome</th><th>Área</th><th>Tempo de Atendimento</th></tr>";
            echo '<form method="POST" id="searchForm" class="search-form">
            <div class="input-group container">
                <div class="form-outline">
                    <input autofocus style="width: 105%;" type="search" id="pesquisa" name="nome" class="form-control" placeholder="BUSCAR..." oninput="this.value = this.value.toUpperCase(); searchTable();" style="text-transform: uppercase;">
                    <input type="hidden" name="uaps" value="<?php echo $uapsSelecionada; ?>">
                </div>
            </div>  
        </form>';
            // Loop através dos resultados e exiba-os na tabela
            while ($rowProfissional = $stmtProfissionais->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $rowProfissional['id_profissional'] . "</td>";
                echo "<td>" . $rowProfissional['nome'] . "</td>";
                echo "<td>" . $rowProfissional['area'] . "</td>";
                echo "<td>" . $rowProfissional['tempo_atendimento'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nenhum profissional cadastrado encontrado.";
        }
    }

    if (isset($_POST['pacientes_excluidos'])) {
        // Execute uma consulta SQL para buscar os profissionais cadastrados
        $sql1 = "SELECT * FROM tb_log WHERE acao = 'EXCLUIU PACIENTE' ORDER BY nome_paciente ASC";
        $stmt1 = $conexao->prepare($sql1);
        $stmt1->execute();

        // Verifique se há resultados
        if ($stmt1->rowCount() > 0) {
            echo "<h3>Pacientes Excluídos: " . $stmt1->rowCount() . "</h3>" ;
            
            echo "<table class='table table-striped table-bordered'>";
            echo "<tr><th>ID</th><th>Nome do Paciente</th><th>CPF modificador</th><th>Data da Modificação</th><th>Hora da Modificação</th></tr>";
echo '<form method="POST" id="searchForm" class="search-form">
            <div class="input-group container">
                <div class="form-outline">
                    <input autofocus style="width: 105%;" type="search" id="pesquisa" name="nome" class="form-control" placeholder="BUSCAR..." oninput="this.value = this.value.toUpperCase(); searchTable();" style="text-transform: uppercase;">
                    <input type="hidden" name="uaps" value="<?php echo $uapsSelecionada; ?>">
                </div>
            </div>  
        </form>';
            // Loop através dos resultados e exiba-os na tabela
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row1['id_log'] . "</td>";
                echo "<td>" . $row1['nome_paciente'] . "</td>";
                echo "<td>" . $row1['cpf_modificador'] . "</td>";
                echo "<td>" . $row1['data_modificacao'] . "</td>";
                echo "<td>" . $row1['hora'] . "</td>";

                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nenhum resultado encontrado.";
        }
    }
    if (isset($_POST['procedimentos_excluidos'])) {
        // Execute uma consulta SQL para buscar os profissionais cadastrados
        $sql1 = "SELECT * FROM tb_log WHERE acao LIKE 'EXCLUIU PROCEDIMENTO:%'";
        $stmt1 = $conexao->prepare($sql1);
        $stmt1->execute();

        // Verifique se há resultados
        if ($stmt1->rowCount() > 0) {
            echo "<h3>Procedimentos Excluídos: " . $stmt1->rowCount() . "</h3>" ;
           echo '<form method="POST" id="searchForm" class="search-form">
            <div class="input-group container div_pesquisa">
                <div class="form-outline">
                    <input autofocus style="width: 105%;" type="search" id="pesquisa" name="nome" class="form-control" placeholder="BUSCAR..." oninput="this.value = this.value.toUpperCase(); searchTable();" style="text-transform: uppercase;">
                    <input type="hidden" name="uaps" value="<?php echo $uapsSelecionada; ?>">
                </div>
            </div>  
        </form>';
            echo "<table class='table table-striped table-bordered'>";
            echo "<tr><th>ID</th><th>Ação</th><th>Paciente</th><th>CPF modificador</th><th>Data da Modificação</th><th>Hora da Modificação</th></tr>";

            // Loop através dos resultados e exiba-os na tabela
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row1['id_log'] . "</td>";
                echo "<td>" . $row1['acao'] . "</td>";
                echo "<td>" . $row1['nome_paciente'] . "</td>";
                echo "<td>" . $row1['cpf_modificador'] . "</td>";
                echo "<td>" . $row1['data_modificacao'] . "</td>";
                echo "<td>" . $row1['hora'] . "</td>";

                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nenhum resultado encontrado.";
        }
    }
    if (isset($_POST['agendamentos_excluidos'])) {
        // Execute uma consulta SQL para buscar os profissionais cadastrados
        $sql1 = "SELECT * FROM tb_log WHERE acao LIKE 'CANCELAMENTO%'";
        $stmt1 = $conexao->prepare($sql1);
        $stmt1->execute();

        // Verifique se há resultados
        if ($stmt1->rowCount() > 0) {
            echo "<h3>Agendamentos Desmarcados: " . $stmt1->rowCount() . "</h3>" ;
           echo '<form method="POST" id="searchForm" class="search-form">
            <div class="input-group container div_pesquisa">
                <div class="form-outline">
                    <input autofocus style="width: 105%;" type="search" id="pesquisa" name="nome" class="form-control" placeholder="BUSCAR..." oninput="this.value = this.value.toUpperCase(); searchTable();" style="text-transform: uppercase;">
                    <input type="hidden" name="uaps" value="<?php echo $uapsSelecionada; ?>">
                </div>
            </div>  
        </form>';
            echo "<table class='table table-striped table-bordered'>";
            echo "<tr><th>ID</th><th>Ação</th><th>Paciente</th><th>CPF modificador</th><th>Data da Modificação</th><th>Hora da Modificação</th></tr>";

            // Loop através dos resultados e exiba-os na tabela
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row1['id_log'] . "</td>";
                echo "<td>" . $row1['acao'] . "</td>";
                echo "<td>" . $row1['nome_paciente'] . "</td>";
                echo "<td>" . $row1['cpf_modificador'] . "</td>";
                echo "<td>" . $row1['data_modificacao'] . "</td>";
                echo "<td>" . $row1['hora'] . "</td>";

                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nenhum resultado encontrado.";
        }
    }
    if (isset($_POST['nao_comparecidos'])) {
     
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
        }

} else {
    header("location: index.php");
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
