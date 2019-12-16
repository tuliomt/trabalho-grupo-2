<?php
    include_once "../banco/Crud.php";
    
    $usuario = $_POST["usuario"];
    $estacao = $_POST["estacao"];
    $ano = $_POST["ano2"];

    if((new Crud("estacoes"))->insert("nome, est_usuario", "'$estacao;ano-$ano', '$usuario'")) {
        $uploaddir = dirname(__FILE__) . "/$usuario/$estacao;ano-$ano";     
            
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir);
        }

        if (move_uploaded_file($_FILES['de']['tmp_name'], $uploaddir."/DE.csv") &&
            move_uploaded_file($_FILES['dn']['tmp_name'], $uploaddir."/DN.csv") &&
            move_uploaded_file($_FILES['du']['tmp_name'], $uploaddir."/DU.csv") &&
            move_uploaded_file($_FILES['pdop']['tmp_name'], $uploaddir."/PDOP.csv") &&
            move_uploaded_file($_FILES['dp']['tmp_name'], $uploaddir."/DP.csv") &&
            move_uploaded_file($_FILES['m']['tmp_name'], $uploaddir."/M.csv"))
            echo true;
        else
            echo false;
    }