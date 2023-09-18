<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf'])){
  $cpf_logado = $_SESSION['cpf'];
  include "menu_adm.php";
  include "navibar_adm.php";
  include "../footer.php";
  require_once("../conexao.php");
?>
<script src="../mascara.js"></script>

<h3>Buscar procedimentos</h3>
<form action="relatorios_filtrados.php" method="POST">
  <div class="form-outline mb-4">
    <label>
      <input type="checkbox" name="procedimento" value="entrada"> Quantos deram entrada
    </label><br>
    <label for="data_inicio">Data de Entrada: </label>
    <input required type="date" name="data_inicio" id="data_inicio"> <br>
  </div>
  <div class="form-outline mb-4">
    <label for="data_fim">Data de Término: </label>
    <input required type="date" name="data_fim" id="data_fim"> <br>
  </div>
  <button class="btn btn-primary" type="submit">Filtrar</button>
</form>

<h3>Buscar agendamentos</h3>
<form action="relatorios_filtrados.php" method="POST">
  <div class="form-outline mb-4">
    <label>
      <input type="checkbox" name="agendamento" value="agendamento"> Quantidade de agendamentos
    </label><br>
    <hr></hr>
    <label>
      <input type="checkbox" name="agendar" value="agendar"> Quantos faltam agendar
    </label><br>
    <label for="periodo_inicio">Período inicial: </label>
    <input type="date" name="periodo_inicio" id="periodo_inicio" value="<?php echo $periodoInicio; ?>"> <br>
    <label for="periodo_fim">Período final: </label>
    <input type="date" name="periodo_fim" id="periodo_fim" value="<?php echo $periodoFim; ?>"> <br>
  </div>
  <button class="btn btn-primary" type="submit">Filtrar</button>
</form>

<h3>Buscar Agenda Profissional</h3>
<form method="POST" action="relatorios_filtrados.php">
  <div class="form-outline mb-4">
    <label>
      <input type="checkbox" name="agendamento" value="agendamento"> Quantos profissionais são
    </label><br>
    <hr></hr>
    <label class="form-label">NOME DO PROFISSIONAL: </label>
    <input type="text" name="profissional_nome" class="form-control form-control-lg" id="profissional_input" list="profissional_list">
    <datalist id="profissional_list"></datalist>
    <label>
    </label><br>
    <label>Selecione o período da agenda do profissional respectivo</label><br>
    <label for="agenda_inicio">Data de Início: </label>
    <input required type="date" name="agenda_inicio" id="agenda_inicio"> <br>
    <label for="agenda_fim">Data de Término: </label>
    <input required type="date" name="agenda_fim" id="agenda_fim"> <br>
  </div>
  <button class="btn btn-primary" type="submit">Filtrar</button>
</form>

<script>
    $(document).ready(function () {
        // Quando o usuário digitar algo no input, acionamos a função de busca
        $('#profissional_input').on('input', function () {
            var term = $(this).val();
            if (term.length >= 3) {
                // Realizamos a solicitação AJAX para buscar os profissionais
                $.ajax({
                    url: 'buscar_profissional.php',
                    type: 'GET',
                    data: { term: term },
                    dataType: 'json',
                    success: function (data) {
                        // Limpa o datalist antes de preencher com as novas opções
                        $('#profissional_list').empty();

                        // Preenche o datalist com as opções retornadas pela busca
                        data.forEach(function (profissional) {
                            // Profissional é um objeto que contém nome e cod
                            $('#profissional_list').append('<option value="' + profissional.nome_profissional + '" data-cod="' + profissional.id_profissional + '">');
                        });
                    }
                });
            }
        });

        // Quando uma opção é selecionada no datalist
        $('#profissional_input').on('blur', function () {
            // Se o valor selecionado está em cache
            if (this.list.querySelector("option[value='" + this.value + "']")) {
                var id = this.list.querySelector("option[value='" + this.value + "']").getAttribute('data-cod');

                // Atualize o campo de código do profissional
                $('#id_profissional').val(id);
            }
        });
    });
</script>

<?php
} else {
  header("location: ../index.php");
}
?>