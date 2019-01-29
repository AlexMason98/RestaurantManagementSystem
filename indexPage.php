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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



</head>
<body id="body">
	<nav class="navbar navbar-expand-lg navbar-light">
		<div class="col-lg-2 col-md-2 col-sm-2">
			<img src="images/Logo.png" id="logo" width ="130" height ="90" ;>
		</div>
	</nav>
	<form method="post">
		<div class="container-fluid">
			<div class="row" id="row1">
				<div class="col-lg-2 col-md-3 col-sm-6 scrollit sticky-top" id="left">
					<table class="table table-striped table-bordered-less header">
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
						mysqli_close($conn);
						?>
					</table>
				</div>
				<div class="col-lg-1 col-md-2 col-sm-3" id="categoryCol">
					<form>
						<label class="container"></br>Vegan
							<input type="checkbox" name="Category1" checked="checked">
							<span class="checkmark"></span>
						</label>

						<label class="container"></br>Veg
							<input type="checkbox" name="Category2">
							<span class="checkmark"></span>
						</label>
						<input type="submit" value="Submit" class="btn btn-light">
					</form>
				</div>
				<div class="col-lg-9 col-md-7 col-sm-3" id="right">
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
					</div>
					<div class="row" id="pricingRow">
						<div class="DishImagePlaceholder" id="pricing">
							
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div>
					</div>
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
					</div>
					<div class="row" id="pricingRow">
						<div class="DishImagePlaceholder" id="pricing">
							
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">
							
						</div>
					</div>
					<div class="container-fluid">
						<div class="row" id="buttonRow">
							<div class="col-lg-12" id="OrderButton">
								<a class="btn btn-light btn-lg btn-block" href="OrderPage.php">Order</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>



<!-- 
	<script type="text/javascript">
		function showData() {
			$.ajax({
				type: "POST",
				url: "php/productPricing.php",
				data:{
					Item;
					},
				success:function(data){
				}
			})

		}
	</script> -->