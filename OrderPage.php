<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Order</title>

	<link rel="stylesheet" type="text/css" href="cssStyleSheets/orderStylePage.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</head>
<body id="body">
	<nav class="navbar navbar-expand-lg navbar-light" id="navbar">
		<div class="col-lg-2">
			<img src="images/Logo.png" id="logo" width ="130" height ="90" ;>
		</div>
	</nav>

	<div class="container" id="MainContainer">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 scrollit">
				<table class="table table-striped table-bordered-less header">
					<thead class="thead-light">
						<tr><th>Items</th>
							<th>Time</th>
							<th>Price</th></tr>
						</thead>
						<?php
						header('Content-Type: text/html; charset=utf-8');
						$servername = "localhost";
						$username = "root";
						$password = "teamproject5";
						$dbname = "customer";
								// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
								// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
								// require 'php/Connection.php';
						$sql = "SELECT Item, Time, Price FROM Orders";
						$res = $conn->query($sql);
						if($res-> num_rows == 0){
							echo "0 results";
						}
						else{
							while($row = mysqli_fetch_assoc($res)){
							// echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
								echo "<tr>";
								echo "<td>{$row['Item']}</td><td>{$row['Time']}</td><td>{$row['Price']}</td>";
								echo "</tr>";

							}
						}
						mysqli_close($conn);
						?>
					</table>
				</div>
				<div class="col-lg-8 col-md-7 col-sm-5"></div>
				<div  class="col-lg-4 col-md-5 col-sm-7">
					<table id="TotalPrice">
						<tr><td>Total Price</td></tr>
					</table>
					<table class="table table-striped table-bordered-less header">

						<?php
						// header('Content-Type: text/html; charset=utf-8');
						
						$servername = "localhost";
						$username = "root";
						$password = "teamproject5";
						$dbname = "customer";
								// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
								// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
								// require 'php/Connection.php';
						$sql = "SELECT DISTINCT SUM(Price) AS Total FROM Orders";
						$res = $conn->query($sql);
						if($res-> num_rows == 0){
							echo "0 results";
						}
						else{
							while($row = mysqli_fetch_assoc($res)){
								echo "<tr><td>{$row['Total']}</td></tr>\n";
							}
						}
						mysqli_close($conn);
						?>
					</table>
				</div>
			</div>		
			<div class="row">
				<div class="col-lg-8 col-md-6 col-sm-4"></div>
				<div class="col-lg-4 col-md-6 col-sm-8">
					<button type="button" class="btn btn-success btn-lg" id="Pay" href="#">Pay</button>
					<button type="button" class="btn btn-danger btn-lg" id="Cancel" href="#" >Cancel</button>
				</div>
			</div>
		</div>
	</body>
	</html>
