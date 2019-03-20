<div class="card">
	<div class="card-header" id="headingOne">
		<button class="btn btn-lg" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"  id="dropDown">
			Categories
		</button>
	</div>
	<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
		<div class="card-body">
			<?php
			require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';
			$sql = "SELECT DISTINCT Category FROM menu";
			$res = $conn->query($sql);
			if($res-> num_rows == 0){
				echo "0 results";
			}
			else{
				while($row = mysqli_fetch_assoc($res)){
					?>

					<input type="checkbox" name="category[]" value="<?php echo $row['Category'];?>" <?php if(sizeof($_POST['category[]'])>0){ foreach ($_POST['category'] as $key => $value) {if($value == $row['Category']){ echo "checked";}}} ?>> <?php echo $row['Category']; ?> <br>
					<?php
				}
				echo "<br><input type='Submit' value='Submit'>";
			}
			mysqli_close($conn);
			?>
		</div>
	</div>
</div>
