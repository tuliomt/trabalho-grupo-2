<div class="modal" id="buscar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pesquisar</h5>
                
                <div class="pl-3 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                    </div>

                    <input type="text" class="form-control" id="validationCustomUsername" placeholder="Usuário" aria-describedby="inputGroupPrepend" required>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <?php
                                $path = isset($_GET["user"]) ? ".." : ".";

                                include_once "$path/banco/Crud.php";

                                $usuarios = (new Crud("usuarios"))->select("1", true);

                                foreach($usuarios as $usuario) {
                                    $estacoes = (new Crud("estacoes"))->select("est_usuario = '" . $usuario["usuario"] . "'", true);
                            ?>
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#<?php echo $usuario["usuario"]; ?>" aria-expanded="true" aria-controls="<?php echo $usuario["usuario"]; ?>">
                                        <?php echo $usuario["usuario"]; ?>
                                    </button>
                                    <div id="<?php echo $usuario["usuario"]; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card">
                            <?php
                                    if(!count($estacoes))
                                        echo "<p class='text-center'>Este usuário ainda não possui estações</p>";
                                    else
                                    foreach($estacoes as $estacao) {
                            ?>
                                        <a class="m-2 text-center" href="<?php echo $path == ".." ? "" : "estacoes/" ?>estacao.php?user=<?php echo $estacao["est_usuario"]; ?>&estacao=<?php echo $estacao["nome"]; ?>">
                                            <?php echo explode(";ano-", $estacao["nome"])[0] . "/" . explode(";ano-", $estacao["nome"])[1]; ?>
                                        </a>
                            <?php }echo "</div></div>";}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>