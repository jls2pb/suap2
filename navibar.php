<div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                <form method = "POST" action = "pesquisa.php">
                        <div class="input-group">
                            <div class="form-outline">
                                <input type="search" name = "nome" class="form-control" oninput="handleInput(event)" placeholder = "BUSCAR PACIENTE"/>
                                <input type = "hidden" name = "cpf" value = "<?php echo $cpf_logado?>">
                            </div>
                            <button type="subimit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                            </button>
                            </div>
                        </form> 
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <script src="mascara.js"></script>