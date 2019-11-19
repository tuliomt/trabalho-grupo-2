    <?php
     
    $dataPoints1 = array(
    	array("label"=> "Janeiro", "y"=> -0.0219),
    	array("label"=> "Fevereiro", "y"=> 0.0289464285714286),
    	array("label"=> "Março", "y"=> -0.0344066666666667),
    	array("label"=> "Abril", "y"=> -0.0393666666666667),
    	array("label"=> "Maio", "y"=> -0.0328064516129032),
    	array("label"=> "Junho", "y"=> -0.0155933333333333),
    	array("label"=> "Julho", "y"=> -0.0148064516129032),
    	array("label"=> "Agosto", "y"=> -0.0245903225806452),
    	array("label"=> "Setembro", "y"=> -0.02228),
    	array("label"=> "Outubro", "y"=> -0.0208645161290323),
    	array("label"=> "Novembro", "y"=> -0.0226833333333333),
    	array("label"=> "Dezembro", "y"=> -0.0244)

    );
    $dataPoints2 = array(
    	array("label"=> "Janeiro", "y"=> 0.187309677419355),
    	array("label"=> "Fevereiro", "y"=> 0.291271428571429),
    	array("label"=> "Março", "y"=> 0.258253333333333),
    	array("label"=> "Abril", "y"=> 0.26703),
    	array("label"=> "Maio", "y"=> 0.258096774193548),
    	array("label"=> "Junho", "y"=> 0.253606666666667),
    	array("label"=> "Julho", "y"=> 0.253122580645161),
    	array("label"=> "Agosto", "y"=> 0.252545161290323),
    	array("label"=> "Setembro", "y"=> 0.25012),
    	array("label"=> "Outubro", "y"=> 0.2457),
    	array("label"=> "Novembro", "y"=> 0.243363333333333),
    	array("label"=> "Dezembro", "y"=> 0.239309677419355)
    );
	$dataPoints3 = array(
    	array("label"=> "Janeiro", "y"=> 0.283729032258065),
    	array("label"=> "Fevereiro", "y"=> 0.198832142857143),
    	array("label"=> "Março", "y"=> 0.0751233333333333),
    	array("label"=> "Abril", "y"=> 0.164933333333333),
    	array("label"=> "Maio", "y"=> 0.119487096774194),
    	array("label"=> "Junho", "y"=> 0.133813333333333),
    	array("label"=> "Julho", "y"=> 0.141135483870968),
    	array("label"=> "Agosto", "y"=> 0.130251612903226),
    	array("label"=> "Setembro", "y"=> 0.13416),
    	array("label"=> "Outubro", "y"=> 0.127116129032258),
    	array("label"=> "Novembro", "y"=> 0.117423333333333),
    	array("label"=> "Dezembro", "y"=> 0.106493548387097)
    );
    	
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>  
    <script>
    window.onload = function () {
     
    var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
    	theme: "light2",
    	title:{
    		text: "Média por Mês"
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
    		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "column",
    		name: "DN",
    		indexLabel: "{y}",
    		yValueFormatString: "#0.#####",
    		showInLegend: true,
    		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "column",
    		name: "DU",
    		indexLabel: "{y}",
    		yValueFormatString: "#0.#####",
    		showInLegend: true,
    		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart.render();
     
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
    </head>
    <body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
    </html>                              