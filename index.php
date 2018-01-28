  <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
		google.charts.load('current', {'packages':['corechart', 'controls']});
		google.charts.setOnLoadCallback(drawChart);
		// Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(drawDashboard);
	  
	  function drawChart() {
      var jsonData = $.ajax({
          url: "chartData.php?data=humidity&id=<?php echo $_GET['id']; ?>",
          dataType: "json",
          async: false
          }).responseText;
          
		// Create our data table out of JSON data loaded from server.
		var data = new google.visualization.DataTable(jsonData);

        var options = {
			title: 'Steakager Humidity',
			curveType: 'function',
			legend: { position: 'bottom' },
			hAxis: {
				title: 'Date',
				format: 'd-M-yyyy',
				baselineColor: '#fff',
				viewWindow: {
					max: new Date(Date.now())
				},
				gridlines: {
					count: 5
				},
				minorGridlines:{
					count: 2
				}
			},
			trendlines: {
				0:{
					type: 'linear',
					color: 'green'
				}
			}
        };

        var chart = new google.visualization.LineChart(document.getElementById('humidity'));
		var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div'));
		

        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
	  
	  function drawChart() {
      var jsonData = $.ajax({
          url: "chartData.php?data=temperature&id=<?php echo $_GET['id']; ?>",
          dataType: "json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

        var options = {
			title: 'Steakager Temperature',
			curveType: 'function',
			legend: {
				position: 'bottom'
			},
			trendlines: {
				0:{
					type: 'linear',
					color: 'green'
				}
			}
        };

        var chart = new google.visualization.LineChart(document.getElementById('temprature'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var jsonData = $.ajax({
          url: "chartData.php?id=<?php echo $_GET['id']; ?>",
          dataType: "json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }
    </script>
	<script>
		$.ajax({
		  url: "getMetrics.php?id=<?php echo $_GET['id']; ?>",
		  beforeSend: function( xhr ) {
			xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
		  }
		})
		  .done(function( data ) {
			if ( console && console.log ) {
			  console.log( data );
			  var obj = JSON.parse(data);
			  //Math.round(num * 100) / 100
			  $( "#temp_avg_hour" ).html(Math.round(obj['temperature']['hour']* 100) / 100);
			  $( "#temp_avg_day" ).html(Math.round(obj['temperature']['day']* 100) / 100);
			  $( "#temp_avg_all" ).html(Math.round(obj['temperature']['total']* 100) / 100);
			  
			  $( "#hum_avg_hour" ).html(Math.round(obj['humidity']['hour']* 100) / 100);
			  $( "#hum_avg_day" ).html(Math.round(obj['humidity']['day']* 100) / 100);
			  $( "#hum_avg_all" ).html(Math.round(obj['humidity']['total']* 100) / 100);
			}
		  });
		/*
		var jsonData = $.ajax({
          url: "getMetrics.php?id=<?php echo $_GET['id']; ?>",
          dataType: "json",
          async: false
          }).responseText;
		document.getElementById('temp_avg_day').
		*/
	</script>
  </head>
  <body>
	<div style="width: 100%">
		<div style="width:250px; float:left">
			<strong>Temperature</strong><br />
			Hour average: <span id="temp_avg_hour"></span> &deg;C<br />
			Day Average: <span id="temp_avg_day"></span> &deg;C<br />
			Lifetime average: <span id="temp_avg_all"></span> &deg;C<br />
		</div>
		<div style="width:250px; float:left">
			<strong>Humidity</strong><br />
			Hour average: <span id="hum_avg_hour"></span>%<br />
			Day Average: <span id="hum_avg_day"></span>%<br />
			Lifetime average: <span id="hum_avg_all"></span>%<br />
		</div>
		<div style="clear:left"></div>
	</div>
    <div id="humidity" style="height: 500px"></div>
	<div id="dashboard_div"></div>
	<div id="temprature" style="height: 500px"></div>
	<div id="table_div" style="width: 500px"></div>
  </body>
</html>