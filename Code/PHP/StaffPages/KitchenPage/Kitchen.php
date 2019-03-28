
<!-- Header -->
<?php
include_once '../../Header.php';
?>
<!-- Header -->

<section>
	<form method="post">
		<div class="container-fluid" id="MainContainerKitchen">
			<div class="row">
				<div class="col-lg-12 col-md-8 col-sm-7" id="KitchenOrderPage">
					<table class="table table-striped table-bordered-less header">
						<thead class="thead-light">
							<tr>
								<th style="width:5%; font-size: 30px; font-weight: bold">Table</th>
								<th style="width:43%; font-size: 30px; font-weight: bold">Order</th>
								<th style="width:22%; font-size: 30px;font-weight: bold">Time</th>
								<th style="width:8%; font-size: 30px; font-weight: bold">Quantity</th>
								<th style="width:20%; font-size: 30px; font-weight: bold">Status</th>
								<!-- This creates the table and set the styling for the whole tables. -->
							</tr>
						</thead>
						<?php
						include_once '../../Connections/ConnectionCustomer.php';
						$sql = "SELECT TableNo, ID, Item, Time, Quantity, Status FROM Orders WHERE Status!='Cooked' AND Status!='Deliveried' ORDER BY Time ASC";
						// sql query which get the orders, and sorts them according to the Time they were enerted. Also this only display the data which doesnt have a status of Cooked and deliveried
						$res = $conn->query($sql);
						if($res-> num_rows == 0){
							echo "0 results";
						}
						else{
							$num_rows = 0;
							while($row = mysqli_fetch_assoc($res)){
								$num_rows++;
								echo "<tr><td><b>{$row['TableNo']}</b></td>";
								echo "<td><b>{$row['Item']}</b></td>";
								echo "<td><b>{$row['Time']}</b></td>";
								echo "<td align='center'><b>{$row['Quantity']}</b></td>";
								// creates the rows for each column and insert information for the database
								echo "<div>";

								$cookingButton = "cooking".$num_rows;
								$hrefcookingButton = "#cooking".$num_rows;
								$cookedButton = "cooked".$num_rows;
								$hrefcookingButton = "#cooked".$num_rows;
								?>
								<!-- Variable created to differentiate each button for each order. -->
								<td>
									<input type="Submit" name="<?php echo $cookingButton;?>" value="Cooking">
									<input type="Submit" name="<?php echo $cookedButton;?>" value="Cooked">
								</td>
								<!-- creates the button  -->
								<?php
								echo "<div></tr>";							
							}
							for ($i=1; $i <= $num_rows; $i++) { 
								
								$CookingBut = "cooking".$i;
								$CookedBut = "cooked".$i;

								if(isset($_POST[$CookedBut]) or isset($_POST[$CookingBut])) {

									$ItemRowData =array();
									$IdRowData = array();
									$TableNoRowData = array();
									// array to store the data from the database

									$sql = "SELECT TableNo, ID, Item, Time, Quantity, Status FROM Orders WHERE Status!='Cooked' AND Status!='Deliveried' ORDER BY Time ASC";

									$res = $conn->query($sql);
									if ($res -> num_rows == 0) {
										echo "0 results";
									}else{
										while ($row = mysqli_fetch_assoc($res)) {
											array_push($IdRowData, $row['ID']);
											array_push($TableNoRowData, $row['TableNo']);
											array_push($ItemRowData, $row['Item']);
											// while used to store the info from the database to the array . 
										}
										for ($j=0; $j < $i; $j++) { 
											if($_POST[$CookedBut]){
												$UpdateSql = "UPDATE  Orders SET Status = 'Cooked' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
												// updates sql query to change the status of the dishes to cooking
											}elseif($_POST[$CookingBut]){
												$UpdateSql = "UPDATE  Orders SET Status = 'Cooking' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
													// updates sql query to change the status of the dishes to cooked
											}
										}
										$res = $conn->query($UpdateSql);
										if($res === True){
											echo('<meta http-equiv="refresh" content="0">');
											// refreshes the page when the sql query runs correctly/
										} else{
											echo "Error updating record! Try again.";
										}

									}
								}
							}
							mysqli_close($conn);		
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</form>
</section>

<!-- Footer -->
<?php
 // this holds the closing body tag and html tag
include_once '../../footer.php';
?>
 <!-- Footer -->