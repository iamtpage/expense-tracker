<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Expense Grapher</title>

		<link rel="stylesheet" href="css/bootstrap.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javasciprt" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/canvasjs.min.js"></script>

		<script type="text/javascript">
			window.onload = function () {
				var chart = new CanvasJS.Chart("chartContainer",
				{
					title:{
						text: "Spending",
						verticalAlign: 'top',
						horizontalAlign: 'left'
					},
			                animationEnabled: true,
					data: [
					{        
						type: "doughnut",
						startAngle:20,
						toolTipContent: "<strong>{label}: ${y}</strong>",
						indexLabelFontWeight: "bold",
						indexLabel: "{label} #percent%",
						dataPoints: [
						<?php
							require ('php/dataaccess.php');

							$datalayer = new data();

							$status = $datalayer->get_graph_data();

							if($status != false)
							{
								for($n = 0; $n < count($status); $n++)
								{
									echo "{ y: ".htmlspecialchars($status[$n][0]).", label: \"".htmlspecialchars($status[$n][1])."\"}";

									//adding commas
									if($n < count($status) - 1)
									{
										echo ",\n";
									}

									else
									{
										echo "\n";
									}

								}
							}
						?>
						]
					}
					]
				});
				chart.render();
			}
		</script>
	</head>

	<body>
		<nav class="navbar navbar-default navbar-fixed">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Home</a>
					<a class="navbar-brand" href="view.php">View</a>
					<a class="navbar-brand" href="graph.php"><b><u>Graph</u></b></a>
				</div>
			</div>
		</nav>

		<div class="container card">
			<div id="chartContainer" style="height: 300px; width: 100%;"></div>
		</div>
	</body>
</html>


