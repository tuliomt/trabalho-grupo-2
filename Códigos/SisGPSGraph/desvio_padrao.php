    <?php
     
    $dataPoints1 = array(
    	array("label"=> "Janeiro", "y"=> 0.109189051),
    	array("label"=> "Fevereiro", "y"=> 0.02208055838),
    	array("label"=> "Março", "y"=> 0.01015854101),
    	array("label"=> "Abril", "y"=> 0.01015854101),
    	array("label"=> "Maio", "y"=> 0.00898184317),
    	array("label"=> "Junho", "y"=> 0.002253431950),
    	array("label"=> "Julho", "y"=> 0.001144956819),
    	array("label"=> "Agosto", "y"=> 0.004185794320),
    	array("label"=> "Setembro", "y"=> 0.001581012333),
    	array("label"=> "Outubro", "y"=> 0.0006902773575),
    	array("label"=> "Novembro", "y"=> 0.0002082999973),
    	array("label"=> "Dezembro", "y"=> 0.0008036208382)

    );
    $dataPoints2 = array(
    	array("label"=> "Janeiro", "y"=> 0.176410438493796),
    	array("label"=> "Fevereiro", "y"=> 0.0183245124110313),
    	array("label"=> "Março", "y"=> 0.0146852927183023),
    	array("label"=> "Abril", "y"=> 0.00434028800887683),
    	array("label"=> "Maio", "y"=> 0.00340289097878959),
    	array("label"=> "Junho", "y"=> 0.00194900544437983),
    	array("label"=> "Julho", "y"=> 0.00177322554237794),
    	array("label"=> "Agosto", "y"=> 0.00255896132024334),
    	array("label"=> "Setembro", "y"=> 0.00105653521790174),
    	array("label"=> "Outubro", "y"=> 0.000883176086632785),
    	array("label"=> "Novembro", "y"=> 0.000544966869533269),
    	array("label"=> "Dezembro", "y"=> 0.00163556340075131)
    );
	$dataPoints3 = array(
    	array("label"=> "Janeiro", "y"=> 0.286901500680306),
    	array("label"=> "Fevereiro", "y"=> 0.0737339815706795),
    	array("label"=> "Março", "y"=> 0.0767462992955071),
    	array("label"=> "Abril", "y"=> 0.0140073155489869),
    	array("label"=> "Maio", "y"=> 0.0133184989451484),
    	array("label"=> "Junho", "y"=> 0.00433733661235658),
    	array("label"=> "Julho", "y"=> 0.00456031608886764),
    	array("label"=> "Agosto", "y"=> 0.0109935720505576),
    	array("label"=> "Setembro", "y"=> 0.00230327303346057),
    	array("label"=> "Outubro", "y"=> 0.00243881208182333),
    	array("label"=> "Novembro", "y"=> 0.00261797419561173),
    	array("label"=> "Dezembro", "y"=> 0.00354181796620368)
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