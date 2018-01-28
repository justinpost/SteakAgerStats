<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'controls']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var dashboard = new google.visualization.Dashboard(
          document.getElementById('programmatic_dashboard_div'));

        // We omit "var" so that programmaticSlider is visible to changeRange.
        var programmaticSlider = new google.visualization.ControlWrapper({
          'controlType': 'ChartRangeFilter',
          'containerId': 'programmatic_control_div',
          'options': {
            'filterColumnLabel': 'Time',
            'ui': {'labelStacking': 'vertical'}
          }
        });

        var programmaticChart  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'programmatic_chart_div',
          'options': {
            'width': 900,
            'height': 500,
            'legend': {'position': 'bottom' },
			'curveType': 'function',
            'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0}
          }
        });

        var jsonData = $.ajax({
				url: "chartData.php?data=humidity&id=<?php echo $_GET['id']; ?>",
				dataType: "json",
				async: false
			}).responseText;
			var data = new google.visualization.DataTable(jsonData);
        dashboard.bind(programmaticSlider, programmaticChart);
        dashboard.draw(data);

        changeRangeDay = function() {
			var up = Date.now();
			var down = up - (3600*1000);
			programmaticSlider.setState({'range':{'start': new Date(down),'end':new Date(up)}});
			programmaticSlider.setState({'hAxis':{'viewWindow':{'min':new Date(down),'max':new Date(up)}}});
			programmaticSlider.draw();
        };
		
		changeRangeTDays = function() {
			var up = Date.now();
			var down = up - (259200*1000);
			programmaticSlider.setState({'range':{'start': new Date(down),'end':new Date(up)}});
			programmaticSlider.draw();
        };
		
		//week
		changeRangeWeek = function() {
			var up = Date.now();
			var down = up - (604800*1000);
			programmaticSlider.setState({'range':{'start': new Date(down),'end':new Date(up)}});
			programmaticSlider.draw();
        };

		changeRangeQuarter = function() {
			var up = Date.now();
			var down = up - (7257600*1000);
			programmaticSlider.setState({'range':{'start': new Date(down),'end':new Date(up)}});
			programmaticSlider.draw();
        };
      }

    </script>
  </head>
  <body>
    <div id="programmatic_dashboard_div" style="border: 1px solid #ccc">
      <table class="columns">
	  <tr>
          <td>
            <div id="programmatic_chart_div"></div>
          </td>
		  <td>
			<button onclick="changeRangeDay();">Last Day</button>
			<button onclick="changeRangeTDays();">Last three days</button>
			<button onclick="changeRangeWeek();">Last Week</button>
			<button onclick="changeRangeQuarter();">Last quarter</button>
		  </td>
        </tr>
        <tr>
          <td>
            <div id="programmatic_control_div" style="padding-left: 2em; min-width: 250px"></div>
            <!--<script type="text/javascript">
              function changeRange() {
                programmaticSlider.setState({'lowValue': 2, 'highValue': 5});
                programmaticSlider.draw();
              }

              function changeOptions() {
                programmaticChart.setOption('is3D', true);
                programmaticChart.draw();
              }
            </script>-->
          </td>
		  </tr>
		  
      </table>
    </div>
  </body>
</html>