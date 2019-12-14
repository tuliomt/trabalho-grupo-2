<?php
$zip = new ZipArchive();

$DE = [];
$DN = [];
$DU = [];
$PDOP = [];
 
if($zip->open($_FILES["tabelas"]["tmp_name"])){
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $dia = preg_replace("/[^0-9]/", "", explode("/", $zip->getNameIndex($i))[1]);
        $conteudo = explode("\n", $zip->getFromIndex($i));
        
        if(count($conteudo) > 1) {
            $conteudo[0] = preg_split('/[\s,]+/', $conteudo[0]);
            
            $iDE = array_keys($conteudo[0], "DE(m)")[0];
            $iDN = array_keys($conteudo[0], "DN(m)")[0];
            $iDU = array_keys($conteudo[0], "DU(m)")[0];
            $iPDOP = array_keys($conteudo[0], "PDOP")[0];
            $tam = count($conteudo[0]);
                
            do {
                $ult =  preg_split('/[\s,]+/', array_pop($conteudo));
            }while(count($ult) != $tam);
        }

        array_push($DE, [$dia, $ult[$iDE]]);
        array_push($DN, [$dia, $ult[$iDN]]);
        array_push($DU, [$dia, $ult[$iDU]]);
        array_push($PDOP, [$dia, $ult[$iPDOP]]);
    }

    $zip->close();

    include_once "../banco/Crud.php";

    $usuario = $_POST["usuario"];
    $estacao = $_POST["estacao"];

    if((new Crud("estacoes"))->insert("nome, est_usuario", "'$estacao', '$usuario'")) {
        $uploaddir = dirname(__FILE__) . "/$usuario/$estacao";     
            
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir);
        }

        $de = fopen("$usuario/$estacao/DE.csv", "w");

        foreach ($DE as $dados) {
            fputcsv($de, $dados);
        }

        fclose($de);

        $dn = fopen("$usuario/$estacao/DN.csv", "w");

        foreach ($DN as $dados) {
            fputcsv($dn, $dados);
        }

        fclose($dn);

        $du = fopen("$usuario/$estacao/DU.csv", "w");

        foreach ($DU as $dados) {
            fputcsv($du, $dados);
        }

        fclose($du);

        $pdop = fopen("$usuario/$estacao/PDOP.csv", "w");

        foreach ($PDOP as $dados) {
            fputcsv($pdop, $dados);
        }

        fclose($pdop);
    
        echo true;
    }

    echo false;
}
