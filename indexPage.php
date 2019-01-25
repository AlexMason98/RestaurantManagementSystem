<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Oaxaca</title>

	<link rel="icon" type="image/icon" href="images/Favicon.ico">
	<link rel="stylesheet" type="text/css" href="cssStyleSheets/indexStylePage.css">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</head>
<body id="body">

	<nav class="navbar navbar-expand-lg navbar-light" id="navbar">
		<div class="col-lg-2">
			<img src="images/Logo.jpeg" id="logo" width ="130" height ="90" ;>
		</div>
	</nav>
	<form method ="post">
		<div class="container-fluid">
			<div class="row" id="row1">
				<div class="col-lg-12 col-md-12 col-sm-12 " id="whole">
					<div class="row" id="wholeInsideRow">
						<!-- <div class="col-lg-3 col-md-3 col-sm-3" id="left"> -->
						<!-- <div class="col-lg-2 col-md-2 col-sm-2" id="left"> -->
						<div class="col-lg-2 col-md-4 col-sm-6 scrollit" id="left">
							<table class="table table-striped table-bordered-less">
								<thead class="thead-light">
									<tr><th>Category</th></tr>
								</thead>
								<?php
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
								$sql = "SELECT DISTINCT Category FROM menu";
								$res = $conn->query($sql);

								if($res-> num_rows == 0){
									echo "0 results";
								}
								else{
									while($row = mysqli_fetch_assoc($res)){
										echo "<tr><td>{$row['Category']}</td></tr>\n";
									}
								}
								?>
							</table>
						</div>
						<!-- <div class="col-lg-9 col-md-9 col-sm-9" id="right"> -->
						<div class="col-lg-10" id="right">
							<div class="row" id="rightInsideRow">
								<div class="DishImagePlaceholder" id="dish">
									<p>One</p>
								</div>
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Two</p>
								</div>
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Three</p>
								</div> 
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Four</p>
								</div> 
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Five</p>
								</div>
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Six</p>
								</div>
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Seven</p>
								</div> 
							</div>
							<div class="row" id="rightInsideRow2">
								<div class="DishImagePlaceholder" id="dish">
									<p>One</p>
								</div>
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Two</p>
								</div>
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Three</p>
								</div> 
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Four</p>
								</div> 
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Five</p>
								</div>
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Six</p>
								</div>
								<div class="EmptySpace" id="EmptySpace"></div>
								<div class="DishImagePlaceholder" id="dish">
									<p>Seven</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>  
	</form>
	<div class="row">
		<div class="col-lg-2"></div>
		<div class="col-lg-8" id="OrderButton">
			<a class="btn btn-light btn-lg btn-block" href="OrderPage.php">Order</a>
		</div>
		<div class="col-lg-2"></div>
	</div>
</body>
</html>
