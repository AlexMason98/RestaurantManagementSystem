<!-- Header -->
<?php
include_once '../../Header.php';
$results = mysqli_query("SELECT * FROM Orders ;
$user = mysqli_fetch_array($results);
?>
<!-- Header -->

<body>

<section>
		<div class="container" id="MainContainerKitchen">
			<div class="row">
				<div class="col-lg-12 col-md-8 col-sm-7">
					<table class="table table-striped table-bordered-less header">
						<thead class="thead-light">
							<tr>
									<th style="width:10%">TableNo</th>
						    		<th style="width:50%">Order</th>
						    		<th style="width:20%">Time</th>
						    		<th style="width:20%">Status</th>
						  	</tr>
						</thead>
						<?php
           						require '../../Connections/ConnectionCustomer.php';
           						$sql = "SELECT TableNo, Item, Time, Status FROM Orders ORDER BY Time ASC";
           						$res = $conn->query($sql);
          						 if($res-> num_rows == 0){
             							echo "0 results";
           						}
           							else{
            						$num_rows = 0;
            						while($row = mysqli_fetch_assoc($res)){
             						 $num_rows++;
             						 $id = $row['ID'];
            						 // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
              						echo "<tr>";
             						echo "<td>{$row['TableNo']}</td><td>{$row['Item']}</td><td>{$row['Time']}</td><td>{$row['Status']}</td><td>";
              						$StatusId = "status".$num_rows;
              						$hrefStatusId = "#status".$num_rows;
             						$StatusId = "status".$num_rows."[]";
              						$dropdownChange = "dropdownChange".$num_rows;
						}
						}
						mysqli_close($conn);
?>
					</table>
				</div>
			</div>
		</div>

</section>
<?php
include_once '../footer.php';
?>
</body>


</html>
