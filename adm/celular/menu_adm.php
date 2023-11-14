<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* Estilos gerais para a navibar */
        nav {
            position: relative;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            /* Estilos para itens do menu */
            display: inline-block;
            margin-right: 10px; /* Espaçamento entre os itens */
        }
        nav ul li a {
            display: block;
            padding: 10px 15px;
            color: #fff;
            text-decoration: none;
            -webkit-transition: 0.2s linear;
            -moz-transition: 0.2s linear;
            -ms-transition: 0.2s linear;
            -o-transition: 0.2s linear;
            transition: 0.2s linear;
        }
        nav ul li a:hover {
            background: #4169E1;
            color: blue;
        }
        /* Estilos para o submenu */
        nav ul ul {
            background: rgba(0, 0, 0, 0.2);
            display: none;
            position: absolute;
            z-index: 1;
        }
        nav ul li:hover > ul {
            display: inherit;
        }
        nav ul li ul li {
            border-left: 4px solid transparent;
            padding: 10px 20px;
        }
        nav ul li ul li a:hover {
            border-left: 4px solid #3498db;
        }
        /* Estilos específicos para dispositivos móveis */
        @media (max-width: 850px) {
            nav ul li {
                display: block;
                margin-right: 0;
            }
            /* Adicione um <br> após o item "LISTAR PACIENTES" para quebrar a linha */
            li.nav-item:nth-child(5) {
                clear: both;
            }
            nav ul ul {
                display: none;
                position: static;
            }
        }
    </style>
</head>
<body>
    <div class="p-0 m-0">
        <nav style="padding: 20px; background-color: #1E90FF; width: 100%;" class="navbar-expand-lg navbar-light ">
            <div class="container-fluid">
                <img class="img-responsive img-fluid d-block d-lg-none" style="width: 75%;" src="../../images/logo_clara.png">
                <img class="img-responsive img-fluid d-none d-lg-block" style="width: 16%;" src="../../images/logo_clara.png">
                <div id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item ml-auto sub-menu-second">
                            <a style="cursor: pointer;" class="link-dark rounded text-white"><span class="fa fa-bars"></span></a>
                            <ul>
                                <li class="nav-item ml-auto">
                                    <a href="inicio_adm.php" class="link-dark rounded text-white"><span class="fa fa-home"></span><b> INÍCIO</b></a>
                                </li>
                                <li class="nav-item ml-auto sub-menu-second">
                                    <a style="cursor: pointer;" class="link-dark rounded text-white"><span class="bi bi-pencil-square"></span><b>CADASTRO </b><div class="fa fa-caret-down right"></div></a>
                                    <ul>
                                        <li class="nav-item ml-auto">
                                            <a href="cadastrar_paciente_adm.php" class="link-dark rounded text-white"><span class="fa fa-user"></span><b>NOVO PACIENTE</b></a>
                                        </li>
                                        <li class="nav-item ml-auto">
                                            <a href="forms_tabela_adm.php" class="link-dark rounded text-white"><span class="bi bi-table"></span><b>TABELAS</b></a>
                                        </li>
                                        <li class="nav-item ml-auto">
                                            <a href="cadastrar_profissional.php" class="link-dark rounded text-white"><img style="width: 5%;" src="../../images/medico.png"><b>NOVO PROFISSIONAL</b></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item ml-auto">
                                    <a href="inicio_agendamento.php" class="link-dark rounded text-white"><span class="bi bi-card-list"></span><b> AGENDAMENTO</b></a>
                                </li>
                                <li class="nav-item ml-auto sub-menu-second">
                                    <a style="cursor: pointer;" class="link-dark rounded text-white"><span class="bi bi-eye"></span><b>VISUALIZAR </b><div class="fa fa-caret-down right"></div></a>
                                    <ul>
                                        <li class="nav-item ml-auto">
                                            <a href="ver_atividades.php" class="link-dark rounded text-white"><img style="width: 9%;" src="../../images/checklist.png"><b>VER ATIVIDADES</b></a>
                                        </li>
                                        <li class="nav-item ml-auto">
                                            <a href="ver_usuarios.php" class="link-dark rounded text-white"><span class="bi bi-person"></span><b>VER USUÁRIOS</b></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item ml-auto">
                                    <a href="index_logado_adm.php" class="link-dark rounded text-white"><span class="fa fa-sticky-note"></span><b> LISTAR PACIENTES</b></a>
                                </li>
                                <li class="nav-item ml-auto">
                                    <a href="codigo.php" class="link-dark rounded text-white">  <img class="img-responsive img-fluid d-inline d-lg-none"  style="width: 10%;" src="../../images/pin.png">
                                    <img class="img-responsive img-fluid d-none d-lg-inline"  style="width: 3%;" src="../../images/pin.png"><b> GERAR CÓDIGO</b></a>
                                </li>
                                <li class="nav-item ml-auto">
                                    <a href="relatorios.php" class="link-dark rounded text-white"><span class="bi bi-file-earmark-text"></span> <b> RELATÓRIOS</b></a>
                                </li>
                                <li class="nav-item ml-auto">
                                    <a href="exibir_resultado_adm.php" class="link-dark rounded text-white"><span class="bi bi-bar-chart-line-fill" ></span><b> RANKING </b></a>
                                </li>
                                <li class="nav-item ml-auto">
                                    <a href="sair.php" class="link-dark rounded text-white"><span class="bi bi-door-open-fill" ></span><b> SAIR</b></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</body>
</html>
<script src="mascara.js"></script>
<script>
    $(document).ready(function () {
        console.log("JavaScript está funcionando!");
        $('.sub-menu-second ul').hide();
        $(".sub-menu-second a").click(function () {
            $(this).parent(".sub-menu-second").children("ul").slideToggle("100");
            $(this).find("span.right").toggleClass("fa-caret-up fa-caret-down");
        });
    });
</script>
