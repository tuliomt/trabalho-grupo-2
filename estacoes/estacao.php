<?php
    session_start();
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
            <a class="navbar-brand" href="<?php echo isset($_SESSION["user"]) ? "home.php?user=" . $_GET["user"] : "../index.php"; ?>">Home</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><?php echo $_GET["user"]; ?> <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                                include_once '../banco/Crud.php';

                                $estacoes = (new Crud("estacoes"))->select("est_usuario = '" . $_GET["user"] . "'", true);
                                
                                foreach($estacoes as $estacao) {
                                    if($_GET["estacao"] == $estacao["nome"])
                                        echo "<script>$('#navbarDropdown').html('" . $estacao["nome"] . "')</script>";
                                    else
                                        echo "<a class='dropdown-item' href='estacao.php?user=emmanureis&estacao=" . $estacao["nome"] . "'>" . $estacao["nome"] . "</a>";
                                }
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
                
            <div class="justify-content-end">
                <?php 
                    if(isset($_SESSION["user"])) {?>
                        <a class="navbar-brand" href="../index.php">Sair</a>
                <?php } 
                    else {
                ?>
                        <a href="" data-toggle="modal" data-target="#buscar" style="text-decoration: none">Buscar outra estação</a>
                <?php }?>
            
            </div>
        </nav>
        
        <div id="chartContainerDE" style="height: 370px; width: 100%;"></div>
        <div id="chartContainerDN" style="height: 370px; width: 100%;"></div>
        <div id="chartContainerDU" style="height: 370px; width: 100%;"></div>
        <div id="chartContainerPDOP" style="height: 370px; width: 100%;"></div>
        <div id="chartContainerDP" style="height: 370px; width: 100%;"></div>

        <script>
            var variaveis = ["DE", "DN", "DU", "PDOP", "DP"];

            window.onload = async function () {
                var dataPoint = [];
               
                for(let index = 0; index < 5; index++) {
                    var chart, name = variaveis[index];
                    
                    if(name != "DP")
                        await $.get(`<?php echo $_GET["user"] . "/" . $_GET["estacao"] . "/"; ?>${name}.csv`, getDataPointsFromCSV);
                    else {
                        let dataLength = dataPoint[0].length;
                        let de = dn = du = pdop = [];

                        chart = new CanvasJS.Chart("chartContainerDP", {
                            animationEnabled: true,
                            theme: "light2",
                            title:{
                                text: "Desvio Padrão por Mês"
                            },
                            legend:{
                                cursor: "pointer",
                                verticalAlign: "center",
                                horizontalAlign: "right",
                                itemclick: toggleDataSeries
                            },
                            data: [{
                                type: "column",
                                name: "DE",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: de
                            },{
                                type: "column",
                                name: "DN",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: dn
                            },{
                                type: "column",
                                name: "DU",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: du
                            },{
                                type: "column",
                                name: "PDOP",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: pdop
                            }]
                        });
                        var teste = 0, max = 1;

                        var updateChart = function (idx) {
                            let tam = de.length;
                            
                            if(tam + 1 == dataLength) {
                                idx = max;
                                teste = 0;
                                de = dn = du = pdop = [];
                            }
                            
                            for (j = teste; j < teste + idx && j < dataLength; j++) {
                                de.push({
                                    label: dataPoint[0][j]["label"],
                                    y: dataPoint[0][j]["y"]
                                });

                                dn.push({
                                    label: dataPoint[1][j]["label"],
                                    y: dataPoint[1][j]["y"]
                                });

                                du.push({
                                    label: dataPoint[2][j]["label"],
                                    y: dataPoint[2][j]["y"]
                                });

                                pdop.push({
                                    label: dataPoint[3][j]["label"],
                                    y: dataPoint[3][j]["y"]
                                });
                            }

                            teste += idx;

                            if (de.length > max) {
                                de.shift();
                                dn.shift();
                                du.shift();
                                pdop.shift();
                            }

                            chart.render();
                        };

                        updateChart(max);
                        setInterval(function(){updateChart(1)}, 3000);
                    }

                    function toggleDataSeries(e){
                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        }
                        else{
                            e.dataSeries.visible = true;
                        }
                        chart.render();
                    }

                    function getDataPointsFromCSV(csv) {
                        var csvLines = points = data = [];

                        csvLines = csv.split(/[\r?\n|\r|\n]+/);

                        for (var i = 0; i < csvLines.length; i++) {
                            if (csvLines[i].length > 0) {
                                points = csvLines[i].split(",");
                                data.push({
                                    label: points[0],
                                    y: parseFloat(points[1])
                                });
                            }
                        }
                        dataPoint.push(data);

                        chart = new CanvasJS.Chart(`chartContainer${name}`, {
                            animationEnabled: true,
                            exportEnabled: true,
                            title:{
                                text: `Variação da ${name} ao longo dos 365 dias`
                            },
                            axisX: {
                                title:"Dia do ano",
                            },
                            axisY: {
                                title: "Nível de variação",
                                includeZero: false
                            },
                            data: [{
                                type: "spline",
                                toolTipContent: "variação: {y} / dia: {x}",
                                dataPoints: dataPoint[index]
                            }]
                        });    
                        
                        chart.render();
                    }
                }
            }
        </script>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
</html>

