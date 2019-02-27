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
					echo "<a href = 'Categories/MenuTypes/{$row['Category']}'><br>{$row['Category']}</a>";
				}
			}
			mysqli_close($conn);
			?>
		</div>
	</div>
</div>