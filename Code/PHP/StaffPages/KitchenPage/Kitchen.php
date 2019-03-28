<!-- Header -->
<?php
include_once '../../Header.php';
?>
<!-- Header -->

<section>
	<div class="container-fluid" id="MainContainerKitchen">
		<div class="row">
			<div class="col-lg-12 col-md-8 col-sm-7" id="KitchenOrderPage">
				<table class="table table-striped table-bordered-less header">
					<thead class="thead-light">
						<tr>
							<th style="width:5%; font-size: 30px; font-weight: bold">Table</th>
							<th style="width:45%; font-size: 30px; font-weight: bold">Order</th>
							<th style="width:15%; font-size: 30px;font-weight: bold">Time</th>
							<th style="width:10%; font-size: 30px; font-weight: bold">Quantity</th>
							<th style="width:25%; font-size: 30px; font-weight: bold">Status</th>
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
						$num_rows = 0;
						while($row = mysqli_fetch_assoc($res)){
							$num_rows++;
							echo "<tr><td><b>{$row['TableNo']}</b></td>";
							echo "<td><b>{$row['Item']}</b></td>";
							echo "<td><b>{$row['Time']}</b></td>";
							echo "<td><b>{$row['Quantity']}</b></td>";
							echo "<div>";
							$cookingButton = "cooking".$num_rows;
							$hrefcookingButton = "#cooking".$num_rows;
							$cookedButton = "cooked".$num_rows;
							$hrefcookingButton = "#cooked".$num_rows;
							?>
							<td>
								<input type="Submit" name="<?php echo $cookingButton;?>" value="Cooking">
								<input type="Submit" name="<?php echo $cookedButton;?>" value="Cooked">
							</td>
							<?php
							echo "<div></tr>";							
						}
						for ($i=1; $i <= $num_rows; $i++) { 
							$CookingBut = "cooking".$i;
							$CookedBut = "cooked".$i;

							if(isset($_POST['CookedBut']) or isset($_POST['CookingBut'])) {

								echo "here";
							// 	$ItemRowData =array();
							// 	$IdRowData = array();
							// 	$TableNoRowData = array();

							// 	$sql = "SELECT TableNo, Item, Time, Quantity, Status FROM Orders ORDER BY Time ASC";
							// 	$res = $conn->query($sql);
							// 	if ($res -> num_rows == 0) {
							// 		echo "0 results";
							// 	}else{
							// 		while ($row = mysqli_fetch_assoc($res)) {
							// 			array_push($IdRowData, $row['ID']);
							// 			array_push($TableNoRowData, $row['TableNo']);
							// 			array_push($ItemRowData, $row['Item']);
							// 		}

							// 		for ($j=0; $j < $i; $j++) { 
							// 			$IdRowData[$j];
							// 			if($_POST[$CookedBut]){
							// 				$UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
							// 			}elseif($_POST[$CookingBut]){
							// 				$UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
							// 			}
							// 		}
							// 		echo $UpdateSql;
							// 	// $res = $conn->query($UpdateSql);
							// 	// if($res === True){
							// 	// 	echo('<meta http-equiv="refresh" content="0">');
							// 	// } else{
							// 	// 	echo "Error updating record! Try again.";
							// 	// }

							// 	}
							}
						}
						mysqli_close($conn);		
					}
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