<!-- Header -->
<?php
include_once '../../Header.php';
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionStaff.php';
?>
<!-- Header -->

<section>
	<div class="container" id="MainContainer">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 scrollit">
				<div class="table-responsive">
					<table class="table table-bordered">
						<?php
						// header('Content-Type: text/html; charset=utf-8');
						$sql = "SELECT * FROM Orders";
						$res = $conn->query($sql);
						if($res-> num_rows == 0){
							echo "0 results";
						}
						else{
							while($row = mysqli_fetch_assoc($res)){
								echo "<tr><td>{$row['Items']}</td>\n";
								echo "<td>{$row['Time']}</td>\n";
								echo "<td>{$row['Quantity']}</td>\n";
								echo "<td>£{$row['Price']}</td></tr>\n";
							}
						}

						?>
					</table>
				</div>
			</div>
			<div class="col-lg-8 col-md-7 col-sm-5"></div>
			<div  class="col-lg-4 col-md-5 col-sm-7">
				<table id="TotalPrice">
					<tr><td>Total Price</td></tr>
				</table>
				<table class="table table-striped table-bordered-less header">
					<?php
					// header('Content-Type: text/html; charset=utf-8');
					$sql = "SELECT SUM(Price) AS Total FROM Orders";
					$res = $conn->query($sql);
					if($res-> num_rows == 0){
						echo "0 results";
					}
					else{
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>£{$row['Total']}</td></tr>\n";
						}
					}

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
mysqli_close($conn);
include_once '../../footer.php';
?>
<!-- Footer -->
