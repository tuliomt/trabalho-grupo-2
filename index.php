<?php
    session_start();
    
    unset($_SESSION["user"]);
?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SisPSGraph Beta</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/singlePageTemplate.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
        include_once "estacoes/buscar.php";
    ?>
    <div class="container"> 
        <header> 
            <a href="">
                <h4 class="logo">LOGO</h4>
            </a>

            <nav>
              <ul class="pt-3">
                  <li><a href="" data-toggle="modal" data-target="#buscar" style="text-decoration: none">Buscar estações</a></li>
                  
                  <li> <a href="#ajuda" style="text-decoration: none">AJUDA</a></li>
                  
                  <li>
                      <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer">
                        LOGIN
                      </a>

                      <div class="dropdown-menu">
                            <form class="px-4 py-3">
                                <div class="form-group">
                                    <label for="exampleDropdownFormEmail1">Usuário</label>
                                    <input type="text" class="form-control" name="usuario" placeholder="usuario">
                                </div>

                                <div class="form-group">
                                    <label for="exampleDropdownFormPassword1">Senha</label>
                                    <input type="password" class="form-control" name="senha" placeholder="******">
                                </div>

                                <button type="button" onclick="logar()" class="btn btn-primary">Logar</button>
                            </form>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="cadastro.html">Novo por aqui? Cadastre-se</a>
                    </div>
                  </li>
              </ul>
            </nav>
        </header>
        
        <section class="banner">
            <h2 class="parallax">Sis<span class="light">PSGraph</span></h2>

            <p class="parallax_description">Sistema de Processamento de dados de estações GNSS operadas pelo IBGE</p>
        </section>
        
        <footer>
            <article class="footer_column">
                <h3>Relatórios Personalizados</h3>
                
                <img src="images/placeholder.jpg" alt="" width="400" height="200" class="cards"/>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla </p>
            </article>

            <article class="footer_column">
                <h3>Estações GNSS</h3>
                
                <img src="images/placeholder.jpg" alt="" width="400" height="200" class="cards"/>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla </p>
            </article>
        </footer>
        
        <section class="footer_banner" id="contact">
            <h2 class="hidden">Footer Banner Section </h2>
            
            <p class="hero_header">RODAPÈ</p>
            
            <div class="button">Assine</div>
        </section>
        
        <div class="copyright">&copy;2019 - <strong>Guilherme Vidigal, Marcus Antônio e Tulio Araujo</strong></div>
    </div>

    <script>
      function logar() {
        if(!$("input[name='usuario']").val() || !$("input[name='senha']").val()) {
          alert("Há espaço(s) em branco!");
          return;
        }

        $.post("acao.php?acao=selectUsuario", {usuario: $("input[name='usuario']").val(), senha: $("input[name='senha']").val()}, function(data) {
          if(data) {
            window.location.href = `estacoes/home.php?user=${data}`;
          }
          else {
            alert("Usuário e/ou senha não encontrado!");
          }
        });
      }
    </script>
</body>
</html>
