
<!-- Header -->
<?php
include_once '../../Header.php';
?>
<!-- Header -->


<section>

	<div class="container-fluid" id="MainContainer">
		<div class="row">
			<div class="col-lg-9 col-md-8 col-sm-7">
				<div class="currentOrderTable">
					<table style="width:100%">
						<colgroup>
							<col style="width:5%">
							<col style="width:45%">
							<col style="width:15%">
							<col style="width:15%">
							<col style="width:20%">
						</colgroup>
						<tr>
							<th>Table</th>
							<th>Items</th>
							<th>Time</th>
							<th>Status</th>
							<th>Change Status</th>
						</tr>
						<?php
						require '../../Connections/ConnectionCustomer.php';

						$sql = "SELECT TableNo, Item, Time,Quantity, Price, Status FROM Orders ORDER BY Time ASC";
						$res = $conn->query($sql);
						if($res-> num_rows == 0){
							echo "0 results";
						}
						else{
							$num_rows = 0;
							while($row = mysqli_fetch_assoc($res)){
								$num_rows++;
								$id = $row['ID'];
								echo "<tr>";
								echo "<td>{$row['TableNo']}</td><td>{$row['Item']}</td><td>{$row['Time']}</td><td>{$row['Status']}</td><td>";

								$StatusId = "status".$num_rows;
								$hrefStatusId = "#status".$num_rows;
								$StatusId = "status".$num_rows."[]";
								$dropdownChange = "dropdownChange".$num_rows;
								?>

								<select name="<?php echo $StatusId ?>">
									<option value="NoStatus">No Status</option>
									<option value="OrderPlaced">Order Placed</option>
									<option value="Cooking">Cooking</option>
									<option value="Cooked">Cooked</option>
									<option value="Delivered">Delivered</option>
									<div class="itemBoxes">
										<?php 
										$submitButtonID = "submitButton".$num_rows;
										$hrefSubmitButtonID = "#submitButton".$num_rows;
										?>
										<input type="submit" class="btn btn-success" name="<?php echo($submitButtonID); ?>" value="Submit" href="<?php echo($hrefSubmitButtonID); ?>" />
									</div>
								</select>


								<?php
								echo "</td>";
								echo "</tr>";
							}

							for ($i = 1; $i <= $num_rows; $i++) {
								$submitButtonID = "submitButton".$i;
								$StatusID = "status".$i;

								?>
								<div id="<?php echo($submitButtonID); ?>" class="addItemToCart">
									<?php
									if (isset($_POST[$submitButtonID]) && $_POST[$StatusID]) {
										$ItemRowData =array();
										$IdRowData = array();
										$StatusRowData = array();
										$TableNoRowData = array();

										$AllStatuses = array();
										array_push($AllStatuses, "NoStatus");
										array_push($AllStatuses, "OrderPlaced");
										array_push($AllStatuses, "Cooking");
										array_push($AllStatuses, "Cooked");
										array_push($AllStatuses, "Delivered");

										$sql = "SELECT TableNo, ID, Item, Status FROM Orders ORDER BY Time ASC";
										$res = $conn->query($sql);
										if ($res -> num_rows == 0) {
											echo "0 results";
										}else{
											while($row = mysqli_fetch_assoc($res)){
												array_push($IdRowData, $row['ID']);
												array_push($TableNoRowData, $row['TableNo']);
												array_push($ItemRowData, $row['Item']);
												array_push($StatusRowData, $row['Status']);
											}
											$GetStatusArray =array();
											foreach ($_POST[$StatusID] as $value) {
												array_push($GetStatusArray, $value);
											}
											$GetStatus = join("", $GetStatusArray);

											foreach ($StatusRowData as $key => $value) {
												if ($GetStatus == $value) {
													echo $value;
													echo("Status not changed. TRY AGIAN!");
													break;
												}else{
													for ($j=0; $j < $i; $j++) { 
														switch($GetStatus){
															case "OrderPlaced":
															$UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
															break;
															case "Cooking":
															$UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
															break;
															case "Cooked":
															$UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
															break;
															case "Delivered":
															$UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
															break;
															case "NoStatus":
															$UpdateSql = "UPDATE  Orders SET Status = '$GetStatus' WHERE Item='$ItemRowData[$j]' AND TableNo='$TableNoRowData[$j]' AND ID ='$IdRowData[$j]'";
															break;
															default:
															echo"didnt work";
														}
													}
													$res = $conn->query($UpdateSql);
													if($res === True){
														echo('<meta http-equiv="refresh" content="0">');
													} else{
														echo "Error updating record! Try again.";
													}
												}
											}
										}
									}
									?>
								</div>
								<?php
							}
						} 
						mysqli_close($conn);
						?>
					</table>
				</div>
			</div>
		</div>
	</div>

</section>

<!-- Footer -->
<?php
include_once '../footer.php';
?>
<!-- Footer -->