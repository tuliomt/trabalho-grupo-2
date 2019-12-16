<?php
    session_start();

    if(!isset($_GET["user"])) {
        echo "<script>window.location.href = '../index.php'</script>";
    }
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
                                  echo "<a class='dropdown-item' href='estacao.php?user=" . $_SESSION["user"] . "&estacao=" . $estacao["nome"] . "'>" . explode(";ano-", $estacao["nome"])[0] . "/" . explode(";ano-", $estacao["nome"])[1] . "</a>";
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
                                  <select class="form-control" name="ano1" id="yearpicker"></select>
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
                              <div class="form-group col-6">
                                  <label>Desvio Padrão .csv</label>
                                  <input type="file" class="form-control" name="dp" accept=".csv">
                              </div>

                              <div class="form-group col-6">
                                  <label>Média .csv</label>
                                  <input type="file" class="form-control" name="m" accept=".csv">
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-6"></div>
                              <div class="form-group col-3">
                                  <label>Ano</label>
                                  <select class="form-control" name="ano2" id="picker"></select>
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
              $('#yearpicker').append(`<option ${i}> ${i} </option>`);
              $('#picker').append(`<option ${i}> ${i} </option>`);
          }

          $("form").submit(function(e) {
              e.preventDefault();    
              $("*").css("cursor", "wait");
              
              let url, enc;
              
              if($("#cPasta").is(':checked')) {
                  url = "uploadDadosZip.php";
                  enc = "application/zip";
                  ano = "ano1";
              }
              else {
                  url = "uploadDadosCsv.php";
                  enc = "multipart/form-data";
                  ano = "ano2";
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

                          window.location.href = "estacao.php?user=" + $("[name='usuario']").val() + "&estacao=" + $("[name='estacao']").val() + ";ano-" + $("[name='"+ano+"']").val();
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
    </body>
</html>