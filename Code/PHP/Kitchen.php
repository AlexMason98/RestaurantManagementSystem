<!-- Header -->
<?php
include_once 'Header.php';
?>
<!-- Header -->


<section>

		<div class="container" id="MainContainer">
			<div class="row">
				<div class="col-lg-9 col-md-8 col-sm-7">
					<table class="table table-striped table-bordered-less header">
						<thead class="thead-light">
							<tr><th>Items</th>
								<th>Time</th></tr>
						</thead>
						<?php
							// header('Content-Type: text/html; charset=utf-8');
							include_once 'ConnectionStaff.php';
							$sql = "SELECT Time, Items FROM Orders";
							$res = $conn->query($sql);
							if($res-> num_rows == 0){
								echo "0 results";
							}
							else{
								while($row = mysqli_fetch_assoc($res)){
									echo "<tr><td>{$row['Items']}</td>\n";
									echo "<td>{$row['Time']}</td></tr>\n";
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
</html>
