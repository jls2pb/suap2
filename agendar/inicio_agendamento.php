<?php 
require_once("head.php");
session_start();


include "menu_agendamento.php";
include "navibar_agendar.php";
include "../footer.php";
require_once("../conexao.php");
$pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
 $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
 $cpf_logado = $_SESSION['cpf'];

$query_profissional = "SELECT * FROM profissionais ORDER BY nome";
$result_profissional = $conexao->prepare($query_profissional);
$result_profissional->execute();
?>

<table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">NOME PROFISSIONAL</th>
            <th scope="col">ÁREA</th>
            <th scope="col">TEMPO ATENDIMENTO</th>
            <th scope="col">AÇÃO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
              if (($result_profissional) AND ($result_profissional->rowCount() != 0)) {
                    while ($d = $result_profissional->fetch(PDO::FETCH_ASSOC)) { 
                        extract($d); 
            ?>
            
            <tr>
            <th scope="row"><?php echo $d["id_profissional"]; ?></th>
            <td><?php echo $d["nome"]; ?></td>
            <td><?php echo $d["area"]; ?></td>
            <td><?php echo $d["tempo_atendimento"]; ?> Min</td>
            <td>
                <a class="link-underline text-dark" href="cadastrar_agenda.php?id=<?= $d["id_profissional"]; ?>" ><i class="bi bi-calendar-plus"></i></a>  
                <a class="link-underline text-dark" href="cadastrar_agendamento.php?id=<?= $d["id_profissional"]; ?>" ><i class="bi bi-card-list"></i></a> 
                <a class="link-underline text-dark" href="#" ><i class="bi bi-pencil-square"></i></a>  
                <a class="link-underline text-dark" href="#" ><i class="bi bi-trash3"></i></a>  
            </td>                
            </tr>
            <?php
                    }
            } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário Profissional encontrado!</p>";
            }  
                
            ?>
                </div>
            </div> 
        </tbody>
        </table>

        <script src="mascara.js"></script>
    </div>
</div>
