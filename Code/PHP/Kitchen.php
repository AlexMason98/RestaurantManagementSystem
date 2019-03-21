<!-- Header -->
<?php
include_once '../../Header.php';
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
									<th style="width:10%">Table</th>
						    		<th style="width:50%">Order</th>
						    		<th style="width:20%">Time</th>
						    		<th style="width:20%">Status</th>
						  	</tr>
						</thead>
						<?php
							include_once '../../Connections/ConnectionStaff.php';
							$sql = "SELECT Time, Items FROM Orders";
							$res = $conn->query($sql);
							if($res-> num_rows == 0){
								echo "0 results";
							}
							else{
								while($row = mysqli_fetch_assoc($res)){
									echo "<tr><td>{$row['Items']}</td>\n";
									echo "<td>{$row['Time']}</td></tr>\n";
									echo "<td>{$row['Status']}</td></tr>\n";
								}
							}
							mysqli_close($conn);
							?>
					</table>
				</div>
			</div>
		</div>

</section>
</body>



</body>
</html>
