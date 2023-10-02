
<style>
#myModal {
    margin: 0;
    padding: 0;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    background-color: #66a7ff;
}
button {
    width: 50%;
}
.modal-content {
    justify-content: center;
    align-items: center;
}
</style>    
<?php
include "head.php";
session_start();

// Exibir um modal personalizado com botões Agendamento e Cadastro
echo '<div id="myModal" class="  modal d-flex align-items-center justify-content-center vh-100">';
echo '  <div class="modal-content container py-5">';
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
