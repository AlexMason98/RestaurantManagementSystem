<!-- Header -->
<?php
include_once '../../Header.php';
?>
<!-- Header -->


<section>
	<div class="container-fluid" id="MainContainerKitchen">
		<div class="row">
			<div class="col-lg-12 col-md-8 col-sm-7">
				<table class="table table-striped table-bordered-less header">
					<thead class="thead-light">
						<tr>
							<th style="width:5%">Table</th>
							<th style="width:45%">Order</th>
							<th style="width:15%">Time</th>
							<th style="width:5%">Quantity</th>
							<th style="width:25%">Status</th>
						</tr>
					</thead>
					<?php
					include_once '../../Connections/ConnectionCustomer.php';
					$sql = "SELECT TableNo, Item, Time, Quantity, Status FROM Orders ORDER BY Time ASC";
					$res = $conn->query($sql);
					if($res-> num_rows == 0){
						echo "0 results";
					}
					else{
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>{$row['TableNo']}</td>";
							echo "<td>{$row['Item']}</td>";
							echo "<td>{$row['Time']}</td>";
							echo "<td>{$row['Quantity']}</td>";
							echo "<td>{$row['Status']}</td></tr>";
						}
					}
					mysqli_close($conn);
					?>
				</table>
			</div>
		</div>
	</div>

</section>

<!-- Footer -->
<?php
 // this holds the closing body tag and html tag
include_once '../../footer.php';
?>
 <!-- Footer -->