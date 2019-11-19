<?php
 
$dataPoints1 = array(
    	array("label"=> "Janeiro", "y"=> 0.10918905179668),
    	array("label"=> "Fevereiro", "y"=> 0.0220805583868133),
    	array("label"=> "Março", "y"=> 0.0101585410151043),
    	array("label"=> "Abril", "y"=> 0.0101585410151043),
    	array("label"=> "Maio", "y"=> 0.0089818431718544),
    	array("label"=> "Junho", "y"=> 0.00225343195050473),
    	array("label"=> "Julho", "y"=> 0.00114495681954667),
    	array("label"=> "Agosto", "y"=> 0.00418579432001742),
    	array("label"=> "Setembro", "y"=> 0.00158101233391773),
    	array("label"=> "Outubro", "y"=> 0.000690277357578109),
    	array("label"=> "Novembro", "y"=> 0.000208299997332907),
    	array("label"=> "Dezembro", "y"=> 0.000803620838214704)

    );
$dataPoints2 = array(
	array("label"=> "2010", "y"=> 64.61),
	array("label"=> "2011", "y"=> 70.55),
	array("label"=> "2012", "y"=> 72.50),
	array("label"=> "2013", "y"=> 81.30),
	array("label"=> "2014", "y"=> 63.60),
	array("label"=> "2015", "y"=> 69.38),
	array("label"=> "2016", "y"=> 98.70)
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
		text: "Average Amount Spent on Real and Artificial X-Mas Trees in U.S."
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Real Trees",
		indexLabel: "{y}",
		yValueFormatString: "$#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Artificial Trees",
		indexLabel: "{y}",
		yValueFormatString: "$#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
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