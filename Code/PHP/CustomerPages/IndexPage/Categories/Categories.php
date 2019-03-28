<div class="card">
	<div class="card-header" id="headingOne">
		<button class="btn btn-lg" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"  id="dropDown">
			Categories
		</button>
	</div>
	<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
		<div class="card-body">
			<?php
			require '/var/www/html/Main/PHP/Connections/ConnectionCustomer.php';
			$sql = "SELECT DISTINCT Category FROM menu";
			// The sql query which get the data from the database. 
			$res = $conn->query($sql);
			// get the results and store them in to res
			if($res-> num_rows == 0){
				echo "0 results";
			}
			else{
				while($row = mysqli_fetch_assoc($res)){
					// loops until there is data in the table being used
					?>
					<input type="checkbox" name="category[]" value="<?php echo $row['Category'];?>"> <?php echo $row['Category']; ?> <br>
					<?php
					// check boxes which have the nmae of category[] so they are all linked. THe value is taken from the database.
				}
				echo "<br><input type='Submit' value='Submit'>";
				echo "<input type='Submit' value='Revert'>";
				// This creates the button which submit the categories. As well as the button which reverts the categories back to displaying all the dishes.
			}
			mysqli_close($conn);
			?>
		</div>
	</div>
</div>
