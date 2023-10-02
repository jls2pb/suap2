
<style>
#myModal {
    margin: 0;
    padding: 0;
   
   
}
</style>    
<?php
include "head.php";
session_start();

// Exibir um modal personalizado com botões Agendamento e Cadastro
echo '<div id="myModal" class="modal">';
echo '  <div class="modal-content">';
echo '    <h2>Escolha uma opção:</h2>';
echo '    <button id="btnAgendamento"><b>Agendamento</b></button>';
echo '    <button id="btnCadastro"><b>Cadastro</b></button>';
echo '  </div>';
echo '</div>';
echo '<script>';
echo 'var modal = document.getElementById("myModal");';
echo 'var btnAgendamento = document.getElementById("btnAgendamento");';
echo 'var btnCadastro = document.getElementById("btnCadastro");';
echo 'btnAgendamento.onclick = function() {';
echo '  window.location.href = "agendar/inicio_agendamento.php";'; // Redirecionar para Agendamento
echo '  modal.style.display = "none";';
echo '};';
echo 'btnCadastro.onclick = function() {';
echo '  window.location.href = "cadastro/inicio.php";'; // Redirecionar para Cadastro
echo '  modal.style.display = "none";';
echo '};';
echo 'modal.style.display = "block";';
echo '</script>';
?>
