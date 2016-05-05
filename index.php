<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Expense Tracker</title>

		<link rel="stylesheet" href="css/bootstrap.css">

		<script src="js/jquery-2.2.2.js"></script>
		<script src="js/bootstrap.js"></script>
	</head>

	<body>
		<nav class="navbar navbar-default navbar-fixed">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php"><b><u>Home</u></b></a>
					<a class="navbar-brand" href="view.php">View</a>
					<a class="navbar-brand" href="graph.php">Graph</a>
				</div>
			</div>
		</nav>

		<div class="container card">
			<div class="row header">
				<h2>Fill out information below to add expenses to the report</h2>
			</div>

			<br>

			<form class="form-horizontal" action="index.php" method="post">
				<div class="row">
					<div class="input-group">
						<div class="form-group">
							<label for="item-name" class="col-md-5 control-label">Item Name</label>
							<div class="col-md-7">
								<input type="text" name="item-name" required class="form-control" placeholder="Item Name">
							</div>
						</div>
						<div class="form-group">
							<label for="item-cost" class="col-md-5 control-label">Item Cost</label>
							<div class="col-md-7">
								<input type="number" name="item-cost" min="1" step="0.01" max="9999" required class="form-control" placeholder="Item Cost">
							</div>
						</div>
						<div class="form-group">
							<label for="item-date" class="col-md-5 control-label">Purchase Date</label>
							<div class="col-md-7">
								<input type="date" name="item-date" value="<?php echo date('Y-m-d'); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="item-category" class="col-md-5 control-label">Item Category</label>
							<div class="col-md-7">
								<select name="item-category" required class="form-control">
									<option>Personal</option>
									<option>Bills</option>
									<option>Food</option>
									<option>Gas</option>
									<option>Video Games</option>
									<option>Other</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="submit-button">
						<input class="btn btn-primary btn-lg" type="submit" value="Submit" name="submit">
					</div>
				</div>
			</form>

			<?php

				if(isset($_POST['submit']))
				{
					require ('php/dataaccess.php');

					$datalayer = new data();

					$name = $_POST['item-name'];
					$cost = $_POST['item-cost'];
					$date = $_POST['item-date'];
					$category = $_POST['item-category'];

					if(empty($name) || empty($cost) || empty($date) || empty($category))
					{
						echo "<p> Not all data entered </p>\n";
						$status = false;
					}

					else
					{
						$status = $datalayer->add_expense($name, $cost, $date, $category);
					}

					if($status != false)
					{
						//query successful, display
						echo "<p> Record Added! </p>\n";
						echo "<a href=\"view.php\">Woah!  No way?</a>\n";
					}

					else
					{
						echo "<p> Whoops, this should not happen. </p>\n";
					}
				}
			?>
			<br>

		</div>
	</body>
</html>


