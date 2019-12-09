    <!DOCTYPE HTML>
    <html>
    <head>  
    <script>
    window.onload = function () {
     
    var dataPoints = [];
     
    var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
    	exportEnabled: true,
    	title:{
    		text: "Variação da DN ao longo de 2013, 2014 e 2015"
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
    		dataPoints: dataPoints
    	}]
    });
     
    $.get("dn_3_anos.csv", getDataPointsFromCSV);
     
    //CSV Format
    //Year,Volume
    function getDataPointsFromCSV(csv) {
    	var csvLines = points = [];
    	csvLines = csv.split(/[\r?\n|\r|\n]+/);
    	for (var i = 0; i < csvLines.length; i++) {
    		if (csvLines[i].length > 0) {
    			points = csvLines[i].split(";");
    			dataPoints.push({
    				label: points[0],
    				y: parseFloat(points[1])
    			});
    		}
    	}
    	chart.render();
    }
     
    }
    </script>
    </head>
    <body>		
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
    </html>                              