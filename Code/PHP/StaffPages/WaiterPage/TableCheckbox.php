<div class="card">
	<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
		<div class="col-lg-12">
			<div class="row">
				<div class="card-body">
					<h1>Table Plan</h1>
					<p>Click to claim a table</p>
					<p>Enter Table number</p>
					<input type="number" name="TableNumber" placeholder="Table Number">
					<?php
					require '/var/www/html/Main/PHP/Connections/ConnectionStaff.php';
			//connects to the connection file
					$sql = "SELECT * FROM Logins";
			//sql query
					$res = $conn->query($sql);
			//gets the results and stores them as the variable 
					if($res-> num_rows == 0){
						echo "0 results";
					}
					else{
						while($row = mysqli_fetch_assoc($res)){
							?>
							<option>
								<input type="checkbox" name="WaiterAssignment[]" value="<?php echo $row['Fullname']; ?>"><?php echo $row['Fullname']; ?><br>
								<!-- This is the checkbox for which names of the Waiter. So the can be assigned to a table. -->
							</option>
							<?php
						}
						echo "<option>";
						echo "<input type='checkbox' name='WaiterAssignment[]' value='Not Assigned'; >Not Assigned<br>";
						echo "</option>";
						echo "<br><input type='Submit'  value='Submit'>";

					}
					?>
				</div>
				<div class="card-body">
					<table>
						<tr>
							<th>Table</th>
							<th>Time</th>
							<th>Waiter Name</th>
							<th>Status</th>
							<th>Change Status</th>
							<!-- The heading for the table -->
						</tr>
						<?php
						$sql = "SELECT * FROM TableAssistance";
						$res = $conn->query($sql);
						if($res-> num_rows == 0){
							echo "0 results";
						}else{
							while ($row = mysqli_fetch_assoc($res)) {
								echo "<tr><td>{$row['TableID']}</td>";
								echo "<td>{$row['Time']}</td>";
								echo "<td>{$row['WaiterName']}</td>";
								echo "<td>{$row['Status']}</td></tr>";
							}
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php


if(!empty($_POST['TableNumber']) && !empty($_POST['WaiterAssignment'])){
	$TableNumberArray = $_POST['TableNumber'];
//get the data using a post method 
	$TableArray = $_POST['WaiterAssignment'];
	$WaiterName = array();
	$Name ="";

	if(sizeof($TableArray)>0){
		foreach ($TableArray as $key => $value) {
			array_push($WaiterName, $value);
		}
		$Name = join("",$WaiterName);
		// this get the name using a post and then store that in a variable as a string which is then used in the sql query.
	}

	$UpdateSql = "UPDATE TableAssistance SET WaiterName = '$Name' WHERE TableID = $TableNumberArray";
	// update the table
	$res = $conn->query($UpdateSql);
	if($res === True){
		echo "<br>Table Assignment has changed.";
	}else{
		echo "Error updating record! Try again.";
	}
}

//connection closed
mysqli_close($conn);

?>

