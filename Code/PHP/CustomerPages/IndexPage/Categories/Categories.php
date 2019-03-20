<div class="card">
	<div class="card-header" id="headingOne">			
		<button class="btn btn-lg" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"  id="dropDown">
			Categories
		</button>
		<!-- this is the button drops the list categories down. but at the start the categories button is already opened. -->
	</div>
	<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
		<div class="card-body">
			<?php
			require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';
			//connects to the connection file
			$sql = "SELECT DISTINCT Category FROM menu";
			//sql query
			$res = $conn->query($sql);
			//gets the results and stores them as the variable 
			if($res-> num_rows == 0){
				echo "0 results";
			}
			else{
				while($row = mysqli_fetch_assoc($res)){
					//
					echo "<a href = 'Categories/MenuTypes/{$row['Category']}'><br>{$row['Category']}</a>";
				}
			}
			//connection closed
			mysqli_close($conn);
			?>
		</div>
	</div>
</div>