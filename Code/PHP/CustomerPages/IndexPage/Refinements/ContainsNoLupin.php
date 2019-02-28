<?php  
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';	
$sql = "SELECT menu.ImagePath, menu.Price, DietaryRequirements.Item FROM DietaryRequirements CROSS JOIN menu WHERE ContainsLupin = 'Yes' AND menu.ID = DietaryRequirements.ID ";
$res = $conn->query($sql);
if($res-> num_rows == 0){
	echo "0 results";
}
else{
	echo $res-> num_rows;
	while($row = mysqli_fetch_assoc($res)){
		$image = $row['ImagePath'];
		?>
		<form method="post" action="indexPage?action=add&ID=<?php echo $row['ID']; ?>">
			<div class="col-lg-14 col-md-12 col-sm-10" id="center">
				<div class="row" id="centerInsideRow">
					<div class="DishImagePlaceholder" id="dish">
						<img src="<?php echo $image; ?>" height="300" width="300">
					</div>
					<div class="DishImagePlaceholder" id="pricing">
						<p id="itemText">
							<?php
							echo "{$row['Item']}";
							?>
						</p>
						<p id="priceText">Price: £
							<?php
							echo "{$row['Price']}";
							?>
						</p>
						<div class="quantityForm">
							<input type="text" name="quantity" value="1" class="form-control" />
						</div>
						<div class="itemBoxes">
							<input type="submit" name="add_to_cart" class="btn btn-success" value="Add to Cart" />
							<a class="btn btn-success" href="#popup">Info</a>
						</div>
					</div>
					<div id="popup" class="overlay">
						<h3>Item Information</h3>
						<a class="close" href="#">&times;</a>
						<div class="popupInfo">
							<h3>Description</h3>
						</div>
					</div>
				</div>
			</div>

			
		</form>
		<?php
	}
}
?>
