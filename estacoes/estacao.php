<?php
    session_start();

    if(!isset($_GET["user"])) {
        echo "<script>window.location.href = '../index.php'</script>";
    }
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
            <a class="navbar-brand" href="<?php echo isset($_SESSION["user"]) ? "home.php?user=" . $_SESSION["user"] : "../index.php"; ?>">Home</a>
            
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
                                        echo "<script>$('#navbarDropdown').html('" . explode(";ano-", $estacao["nome"])[0] . "/" . explode(";ano-", $estacao["nome"])[1] . "')</script>";
                                    else
                                        echo "<a class='dropdown-item' href='estacao.php?user=". $_GET["user"] . "&estacao=" . $estacao["nome"] . "'>" . explode(";ano-", $estacao["nome"])[0] . "/" . explode(";ano-", $estacao["nome"])[1] . "</a>";
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
        
        <div class="w-100 my-4" id="chartContainerDE" style="height: 370px;"></div>
        <div class="w-100 my-4" id="chartContainerDN" style="height: 370px;"></div>
        <div class="w-100 my-4" id="chartContainerDU" style="height: 370px;"></div>
        <div class="w-100 my-4" id="chartContainerPDOP" style="height: 370px;"></div>
        <div class="w-100 my-4" id="chartContainerDP" style="height: 370px;"></div>
        <div class="w-100 my-4" id="chartContainerM" style="height: 370px;"></div>

        <script>
            var variaveis = ["DE", "DN", "DU", "PDOP", "DP"];

            window.onload = async function () {
                var dataPoint = [];
               
                for(let index = 0; index < 5; index++) {
                    var chart, name = variaveis[index], points = [[[], [], [], []], [[], [], [], []]];
                    
                    await $.get(`<?php echo $_GET["user"] . "/" . $_GET["estacao"] . "/"; ?>${name}.csv`, getDataPointsFromCSV);
                    
                    if(index < 4) {
                        let dataP = [];

                        Object.keys(dataPoint[index]).forEach(function(item) {
                            dataP.push({
                                type: "spline",
                                toolTipContent: "variação: {y} / dia: {x}",
                                dataPoints: dataPoint[index][item]
                            });
                        });
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
                            data: dataP
                        });    
                    
                        chart.render();
                    }
                    else {
                        await $.get(`<?php echo $_GET["user"] . "/" . $_GET["estacao"] . "/"; ?>M.csv`, getDataPointsFromCSV);
                        
                        var  max = 4 / Object.keys(dataPoint[index]).length, teste = 0, x = 0, seg = 10, dataP = [];
                        
                        chartDp =  new CanvasJS.Chart(`chartContainerDP`, {
                            animationEnabled: true,
                            theme: "light2",
                            title:{
                                text: "Desvio Padrão por Dia"
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
                                dataPoints: points[0][0]
                            },{
                                type: "column",
                                name: "DN",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: points[0][1]
                            },{
                                type: "column",
                                name: "DU",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: points[0][2]
                            },{
                                type: "column",
                                name: "PDOP",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: points[0][3]
                            }]
                        });

                        chartM =  new CanvasJS.Chart(`chartContainerM`, {
                            animationEnabled: true,
                            theme: "light2",
                            title:{
                                text: "Média por Dia"
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
                                dataPoints: points[1][0]
                            },{
                                type: "column",
                                name: "DN",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: points[1][1]
                            },{
                                type: "column",
                                name: "DU",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: points[1][2]
                            },{
                                type: "column",
                                name: "PDOP",
                                indexLabel: "{y}",
                                yValueFormatString: "#0.#####",
                                showInLegend: true,
                                dataPoints: points[1][3]
                            }]
                        });
                        
                        var updateCanvas = function (idx) {
                            if(teste + idx > dataPoint[4][Object.keys(dataPoint[4])[0]].length) {
                                idx = max;
                                teste = 0;
                                x = 0;
                                points = [[[], [], [], []], [[], [], [], []]];
                            }
                            
                            for (j = teste; j < teste + idx && j < dataPoint[4][Object.keys(dataPoint[4])[0]].length; j++) {
                                Object.keys(dataPoint[4]).forEach(function(item) {
                                    points[0][0].push({
                                        label: dataPoint[4][item][j][0]["label"],
                                        y: dataPoint[4][item][j][0]["y"],
                                        x: x
                                    });

                                    points[0][1].push({
                                        label: dataPoint[4][item][j][0]["label"],
                                        y: dataPoint[4][item][j][1]["y"],
                                        x: x
                                    });

                                    points[0][2].push({
                                        label: dataPoint[4][item][j][0]["label"],
                                        y: dataPoint[4][item][j][2]["y"],
                                        x: x
                                    });

                                    points[0][3].push({
                                        label: dataPoint[4][item][j][0]["label"],
                                        y: dataPoint[4][item][j][3]["y"],
                                        x: x
                                    });

                                    points[1][0].push({
                                        label: dataPoint[5][item][j][0]["label"],
                                        y: dataPoint[5][item][j][0]["y"],
                                        x: x
                                    });

                                    points[1][1].push({
                                        label: dataPoint[5][item][j][0]["label"],
                                        y: dataPoint[5][item][j][1]["y"],
                                        x: x
                                    });

                                    points[1][2].push({
                                        label: dataPoint[5][item][j][0]["label"],
                                        y: dataPoint[5][item][j][2]["y"],
                                        x: x
                                    });

                                    points[1][3].push({
                                        label: dataPoint[5][item][j][0]["label"],
                                        y: dataPoint[5][item][j][3]["y"],
                                        x: x
                                    });
                                    
                                    x++;
                                });
                            }
                            
                            teste += idx;

                            if (points[0][0].length > max) {
                                points[0][0].shift();
                                points[0][1].shift();
                                points[0][2].shift();
                                points[0][3].shift();
                                points[1][0].shift();
                                points[1][1].shift();
                                points[1][2].shift();
                                points[1][3].shift();
                            }

                            chartM.render();
                            chartDp.render();
                        };            

                        max = parseInt(max);
                        updateCanvas(max);
                        setInterval(function(){updateCanvas(1)}, seg * 1000);
                    }

                    function getDataPointsFromCSV(csv) {
                        var csvLines = point = [], data = {};

                        csvLines = csv.split(/[\r?\n|\r|\n]+/);

                        for (var i = 0; i < csvLines.length; i++) {
                            if (csvLines[i].length > 0) {
                                point = csvLines[i].split(",");
                                let label = point[0].substring(0,(point[0].length - 1)), sol = point[0].substring((point[0].length - 1), point[0].length);
                                
                                if(Object.keys(data).indexOf(sol) < 0) {
                                    data[sol] = [];
                                } 
                                
                                if(index < 4) {
                                    data[sol].push({
                                        label: label,
                                        y: parseFloat(point[1])
                                    });
                                }
                                else {
                                    data[sol].push([{
                                            label: label,
                                            y: parseFloat(point[1])
                                        },
                                        {
                                            label: label,
                                            y: parseFloat(point[2])
                                        },
                                        {
                                            label: label,
                                            y: parseFloat(point[3])
                                        },
                                        {
                                            label: label,
                                            y: parseFloat(point[4])
                                    }]);
                                }
                            }
                        }
                        dataPoint.push(data);
                    }
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
            }
        </script>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
</html>
