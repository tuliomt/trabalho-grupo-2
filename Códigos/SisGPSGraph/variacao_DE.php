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
    		text: "Variação da DE ao longo dos 365 dias"
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
     
    $.get("pifl3651_DE.CSV", getDataPointsFromCSV);
     
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