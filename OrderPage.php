
<!-- Header -->
<?php
include_once 'Header.php';
?>
<!-- Header -->

<section>
	<div class="container" id="MainContainer">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 scrollit">
				<table class="table table-striped table-bordered-less header">
					<thead class="thead-light">
						<tr>
							<th>Items</th>
							<th>Time</th>
							<th>Price</th>
						</tr>
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
</section>

<!-- Footer -->
<?php
include_once 'footer.php';
?>
<!-- Footer -->
