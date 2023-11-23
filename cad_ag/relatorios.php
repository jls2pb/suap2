<?php 
require_once("head.php");
session_start();
if(isset($_SESSION['cpf_cad_ag'])){
  $cpf_logado = $_SESSION['cpf_cad_ag'];
  include "menu_adm.php";
  include "navibar_adm.php";
  include "../footer.php";
  require_once("../conexao.php");
?>
<script src="../mascara.js"></script>

<h5>Buscar Agendamentos do Dia do Profissional</h5>
<form method="POST" action="relatorios_filtrados.php">
  <div class="form-outline mb-4">

    <hr></hr>
    <label style = "font-size:12px;" class="form-label">NOME DO PROFISSIONAL: </label>
    <input style = "font-size:12px;" type="text" name="profissional_nome" class="form-control form-control-lg" id="profissional_input" list="profissional_list">
    <datalist id="profissional_list"></datalist>
    <label>
    </label><br>
    <label>Selecione a data do agendamento</label><br>
    <label for="agenda_inicio">Data: </label>
    <input  type="date" name="agenda_inicio" id="agenda_inicio" required> <br>
 
  </div>
  <button class="btn btn-primary" style = "color:white; font-size:10px;" type="submit">Filtrar</button>
</form>

<script>
    $(document).ready(function () {
        // Quando o usuário digitar algo no input, convertemos para maiúsculas
        $('#profissional_input').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>

<script>
    $(document).ready(function () {
    // Quando o usuário digitar algo no input, acionamos a função de busca
$('#profissional_input').on('input', function () {
    var term = $(this).val();
    if (term.length >= 3) {
      $('#profissional_list').empty();
        // Realizamos a solicitação AJAX para buscar os profissionais
        $.ajax({
            url: '../buscar/buscar_profissional.php',
            type: 'GET',
            data: { term: term },
            dataType: 'json',
            success: function (data) {
                // Limpa o datalist antes de preencher com as novas opções
                $('#profissional_list').empty();

                // Preenche o datalist com as opções retornadas pela busca
                data.forEach(function (profissional) {
                    // Profissional é um objeto que contém nome e id_profissional
                    $('#profissional_list').append('<option value="' + profissional.nome + '">' + profissional.nome + '</option>');
                });
            }
        });
    }
});


    });
</script>

<?php
} else {
  header("location: ../index.php");
}
?>