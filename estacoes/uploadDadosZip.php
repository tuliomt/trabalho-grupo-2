<?php
$zip = new ZipArchive();

$DE = [];
$DN = [];
$DU = [];
$PDOP = [];
$DP = [];
$M = [];

function standard_deviation($aValues, $bSample = false)
{
    $fMean = array_sum($aValues) / count($aValues);
    $fVariance = 0.0;
    foreach ($aValues as $i)
    {
        $fVariance += pow($i - $fMean, 2);
    }
    $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
    return (float) sqrt($fVariance);
}
 
if($zip->open($_FILES["tabelas"]["tmp_name"])){
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $dia = preg_replace("/[^0-9]/", "", explode("/", $zip->getNameIndex($i))[1]);
        $conteudo = explode("\n", $zip->getFromIndex($i));
        $linhas = [];

        if(count($conteudo) > 1) {
            foreach($conteudo as $key => $linha) {
                $conteudo[$key] = preg_split('/[\s,]+/', $linha);
            
                if($key && count($conteudo[$key]) == count($conteudo[0])) {
                    array_push($linhas, ($conteudo[$key]));
                }
            }
            $iDE = array_keys($conteudo[0], "DE(m)")[0];
            $iDN = array_keys($conteudo[0], "DN(m)")[0];
            $iDU = array_keys($conteudo[0], "DU(m)")[0];
            $iPDOP = array_keys($conteudo[0], "PDOP")[0];
        }

        $ult = array_pop($linhas);
        print_r($linhas);

        array_push($DE, [$dia, $ult[$iDE]]);
        array_push($DN, [$dia, $ult[$iDN]]);
        array_push($DU, [$dia, $ult[$iDU]]);
        array_push($PDOP, [$dia, $ult[$iPDOP]]);
        array_push($DP, [$dia, standard_deviation(array_column($linhas ,$iDE)),
                        standard_deviation(array_column($linhas ,$iDN)),
                        standard_deviation(array_column($linhas ,$iDU)),
                        standard_deviation(array_column($linhas ,$iPDOP))]);
        array_push($M, [$dia, array_sum(array_column($linhas ,$iDE)) / (count($linhas) - 1),
                        array_sum(array_column($linhas ,$iDN)) / (count($linhas) - 1),
                        array_sum(array_column($linhas ,$iDU)) / (count($linhas) - 1),
                        array_sum(array_column($linhas ,$iPDOP)) / (count($linhas) - 1)]);
    }

    $zip->close();

    include_once "../banco/Crud.php";

    $usuario = $_POST["usuario"];
    $ano = $_POST["ano1"];
    $estacao = $_POST["estacao"].";ano-".$ano;
    echo "teste " . $ano;
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

        $dp = fopen("$usuario/$estacao/DP.csv", "w");

        foreach ($DP as $dados) {
            fputcsv($dp, $dados);
        }

        fclose($dp);

        $m = fopen("$usuario/$estacao/M.csv", "w");

        foreach ($M as $dados) {
            fputcsv($m, $dados);
        }

        fclose($m);
    
        echo true;
    }

    echo false;
}
