<?php
    session_start();

    $_SESSION["user"] = $_GET["user"];
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Estações</title>
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <script src="../js/jquery-3.2.1.min.js"></script>
      <script src="../js/popper.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
  </head>

  <body>
      <?php
          include_once "buscar.php";
      ?>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <a class="navbar-brand" href="#">Home</a>
          
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                      <a class="nav-link" href="#"><?php echo $_SESSION["user"]; ?> <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Selecionar estação
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <?php
                              include_once '../banco/Crud.php';

                              $estacoes = (new Crud("estacoes"))->select("est_usuario = '" . $_SESSION["user"] . "'", true);
                              
                              foreach($estacoes as $estacao) {
                                  echo "<a class='dropdown-item' href='estacao.php?user=" . $_SESSION["user"] . "&estacao=" . $estacao["nome"] . "'>" . $estacao["nome"] . "</a>";
                              }
                          ?>
                      </div>
                  </li>
              </ul>
          </div>
          
          <div class="justify-content-end">
              <a class="navbar-brand" href="../index.php">Sair</a>
          </div>
      </nav>
      <div class="container mt-3">
          <div class="jumbotron justify-content-around">
              <h1 class="text-center">Central de estações</h1>

              <p class="mt-5 row justify-content-around align-items-center">
                  <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#buscar">Buscar estações</button>

                  <button class="btn btn-primary btn-lg" type="button" data-toggle="collapse" data-target="#form" aria-expanded="false" aria-controls="form">Cadastrar estação</button>
              </p>

              <div class="ml-5 pl-3 collapse" id="form">
                  <form>
                      <input type="text" name="usuario" value="<?php echo $_GET["user"]; ?>" hidden>
                      
                      <div class="form-row">
                          <div class="form-group col-6">
                              <label>Nome da estação</label>
                              <input type="text" class="form-control" name="estacao" placeholder="Digite o nome da estação">
                          </div>

                          <div class="form-group col-5 ml-2">
                              <legend class="col-form-label col-2 pt-0">Uploud</legend>
                              <div class="mt-2 form-check form-check-inline">
                                  <input class="form-check-input" type="radio" id="cPasta" name="arquivos" value="zip" onclick="teste()">
                                  <label class="form-check-label" for="cPasta">
                                      Pasta compactada(.zip)
                                  </label>
                              </div>

                              <div class="mt-2 form-check form-check-inline">
                                  <input class="form-check-input" type="radio" id="cCsv" name="arquivos" value="csv" onclick="teste()">
                                  <label class="form-check-label" for="cCsv">
                                      Arquivos .csv
                                  </label>
                              </div>
                          </div>
                      </div>

                      <div class="form-group collapse" id="pasta">
                          <div class="form-row">
                              <div class="form-group col-6">
                                  <label>Dados .zip</label>
                                  <input type="file" class="form-control" name="tabelas" accept=".zip"> 
                              </div>

                              <div class="form-group col-4">
                                  <label>Ano</label>
                                  <select class="form-control" name="ano" id="yearpicker"></select>
                              </div>
                          </div>

                          <div class="w-75 form-row justify-content-end">
                              <button class="btn btn-success btn-lg">Cadastrar</button>
                          </div>
                      </div>

                      <div class="form-group collapse" id="csv">
                          <div class="form-row">
                              <div class="form-group col-6">
                                  <label>DE(m) .csv</label>
                                  <input type="file" class="form-control" name="de" accept=".csv">
                              </div>

                              <div class="form-group col-6">
                                  <label>DN(m) .csv</label>
                                  <input type="file" class="form-control" name="dn" accept=".csv">
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-6">
                                  <label>DU(m) .csv</label>
                                  <input type="file" class="form-control" name="du" accept=".csv">
                              </div>

                              <div class="form-group col-6">
                                  <label>PDOP .csv</label>
                                  <input type="file" class="form-control" name="pdop" accept=".csv">
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-6"></div>
                              <div class="form-group col-3">
                                  <label>Ano</label>
                                  <select class="form-control" name="ano" id="picker"></select>
                              </div>
                          </div>  
                          
                          <div class="form-row justify-content-end">
                              <button class="btn btn-success btn-lg">Cadastrar</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      
      <script>
          var startYear = 1800;
          for (i = new Date().getFullYear(); i > startYear; i--)
          {
              $('#yearpicker').append($('<option />').val(i).html(i));
              $('#picker').append($('<option />').val(i).html(i));
          }

          $("form").submit(function(e) {
              e.preventDefault();    
              $("*").css("cursor", "wait");
              
              let url, enc;
              
              if($("#cPasta").is(':checked') === "zip") {
                  url = "uploadDadosZip.php";
                  enc = "application/zip";
              }
              else {
                  url = "uploadDadosCsv.php";
                  enc = "multipart/form-data";
              }

              $.ajax({
                  type: "POST",
                  url: url,
                  enctype: enc,
                  data: new FormData(this),
                  processData: false,
                  contentType: false,
                  success: function (data) {
                      $("*").css("cursor", "default");
                      
                      if(data) {
                          alert("Estação " + $("[name='estacao']").val() + " cadastrada!");

                          window.location.href = "estacao.php?user=" + $("[name='usuario']").val() + "&estacao=" + $("[name='estacao']").val();
                      }
                      else {
                          alert("Estação não cadastrada, tente novamente!");
                      }
                  }
              });
          });

          function teste() {
              $("#cCsv").is(':checked') ? $("#pasta").collapse('hide') : $("#pasta").collapse('show');
              $("#cPasta").is(':checked') ? $("#csv").collapse('hide') : $("#csv").collapse('show');
          }
      </script>
      <!-- 
      <section>
        <iframe src="pifl3651/2013/variacao_DE_365_2013.php" width="100%" height="400" frameborder="0"></iframe>
        <iframe src="pifl3651/2013/variacao_DN_365_2013.php" width="100%" height="400" frameborder="0"></iframe>
        <iframe src="pifl3651/2013/variacao_DU_365_2013.php" width="100%" height="400" frameborder="0"></iframe>
        <iframe src="pifl3651/2013/variacao_PDOP_365_2013.php" width="100%" height="400" frameborder="0"></iframe>
        <iframe src="pifl3651/2013/media.php" width="100%" height="400" frameborder="0"></iframe>
        <iframe src="pifl3651/2013/desvio_padrao.php" width="100%" height="400" frameborder="0"></iframe>
      </section>
      
        <div class="container">
      <h1 class="text-center">Informações detalhadas</h1>
          <div class="row">
            <div class="text-center col-md-6 col-12">
              <h3>Planilha DE - DU - DN - PDOP</h3>
              <p>Veja todos os dados da planilha anual, faça o download da planilha</p>
              <a class="btn btn-danger btn-lg" href="pifl3651/2013/pifl3651.xlsx" role="button">Baixar Planilha do ano</a>
            </div>
            <div class="text-center col-md-6 col-12">
              <h3>Manuais e Ajuda</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum, magnam?</p>
              <a class="btn btn-info btn-lg" href="#" role="button">Documentos da estação</a>
            </div>
          </div>
        </div>
        <hr>
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
              <h2>Lorem ipsum</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis accusamus praesentium eveniet ad unde doloremque ex officia eius ab quibusdam.</p>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <h2>Lorem ipsum</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, mollitia natus amet eligendi consequuntur. Veritatis ullam debitis voluptas repellat laboriosam.</p>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <h2> Lorem ipsum</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi, error, itaque non vel architecto ratione obcaecati doloribus delectus illum harum?</p>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <h2>Lorem ipsum</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque, nam voluptate accusantium nulla distinctio odit aliquam voluptatem ab. Earum.</p>
            </div>
          </div>
        </div>
        <hr>
        <div class="container mt-4">
          <div class="row">
            <div class="col-sm-6">
              <div class="card">
                <img class="card-img-top" src="../images/600X300.gif" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">Destaque</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, at.</p>
                  <a href="#" class="btn btn-primary">Botão</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card">
                <img class="card-img-top" src="../images/600X300.gif" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">Destaque 2</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, at.</p>
                  <a href="#" class="btn btn-primary">Botão</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 mb-md-0 mb-2">
              <h2>Contato</h2>
              <address>
                <strong>Alunos:</strong><br>
                Guilherme, Marcus e Tulio<br>
                <strong>Universidade Federal de Uberllândia</strong><br>
          Disciplina PDS - 2019/02
              </address>
              <h4>ícones</h4>
              <div class="row">
                <div class="col-2"><img class="rounded-circle" src="../images/32X32.gif" alt=""></div>
                <div class="col-2"><img class="rounded-circle" src="../images/32X32.gif" alt=""></div>
                <div class="col-2"><img class="rounded-circle" src="../images/32X32.gif" alt=""></div>
                <div class="col-2"><img class="rounded-circle" src="../images/32X32.gif" alt=""></div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <h2>Ultimas estações</h2>
              <ul class="list-unstyled">
                <li class="media">
                  <img class="mr-3" src="../images/35X35.gif" alt="Generic placeholder image">
                  <div class="media-body">
                    <h5 class="mt-0 mb-1">pifl3651</h5>
                    <p class="mb-0">Data de cadastro: 31/10/2019<br>Anos enviados: 2013</p>
                  </div>
                </li>
                <li class="media my-4">
                  <img class="mr-3" src="../images/35X35.gif" alt="Generic placeholder image">
                  <div class="media-body">
                    <h5 class="mt-0 mb-1">Estação 2</h5>
                    <p class="mb-0">Data de cadastro: <br> Anos enviados: 0</p>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col-lg-4 col-12">
              <h2>Sobre o SisGPSGraph</h2>
              <p>O software esta sendo desenvolvido como protótipo.</p>
              <p>Versão beta0311/2019</p>
            </div>
          </div>
        </div>
        <hr>
        <footer class="text-center">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <p>Copyright © MyWebsite. All rights reserved.</p>
              </div>
            </div>
          </div>
        </footer>-->
    </body>
</html>