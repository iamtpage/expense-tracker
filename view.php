<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Expense Viewer</title>

		<link rel="stylesheet" href="css/bootstrap.css">

		<script src="js/jquery-2.2.2.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/sorttable.js"></script>
	</head>

	<body>
		<nav class="navbar navbar-default navbar-fixed">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Home</a>
					<a class="navbar-brand" href="view.php"><b><u>View</u></b></a>
					<a class="navbar-brand" href="graph.php">Graph</a>
				</div>
			</div>
		</nav>

		<div class="container card">
			<div class="row header">
				<h2>Expense Viewer</h2>
			</div>

			<br>
			<form action="submit.php" method="post">
				<div class="row content">
					<div class="col-md-5">
						<!-- PHP STUFF GOES HERE -->
					</div>
				</div>
			</form>

			<div class="row">
				<hr>
					<center>
						<table class='table sortable' id='results'>
							<tr>
								<th>Name</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Category</th>
							</tr>
							<?php
								require ('php/dataaccess.php');

								$datalayer = new data();

								$status = $datalayer->list_expenses();

								if($status != false)
								{
									for( $n=0; $n < count($status); $n++)
									{
										echo "	<tr>\n";
										echo "		<td>".htmlspecialchars($status[$n][0])."</td>\n";
										echo "		<td>$".htmlspecialchars($status[$n][1])."</td>\n";
										echo "		<td>".htmlspecialchars($status[$n][2])."</td>\n";
										echo "		<td>".htmlspecialchars($status[$n][3])."</td>\n";
										echo "	</tr>\n";
									}
								}

								else
								{
									echo "<p> Error! </p>";
								}
							?>
						</table>

						<br>
						<br>

						<table class='table' id='cost'>
							<tr>
								<th>Total Spent</th>
								<?php

									$status = $datalayer->get_total();

									if($status != false)
									{
										echo "<th>$".$status."</th>";
									}

									else
									{
										echo "<p>Error, sum calculation failed</p>";
									}
								?>
							</tr>
						</table>
					</center>
			</div>
		</div>
	</body>
</html>


