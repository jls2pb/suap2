<div id="content" class="p-10 p-md-2">

        <nav style="padding: 20px;"class="navbar-expand-lg navbar-light bg-light">
        
          <div class="container-fluid">

            <button style="background-color: #66a7ff;" class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i style="border:none;"class="fa fa-bars"></i>
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
                            
                            <button style="background-color: #66a7ff; color: white;" type="subimit" class="btn">
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