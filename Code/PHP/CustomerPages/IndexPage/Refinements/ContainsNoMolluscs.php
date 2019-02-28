<?php  
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';	
$sql = "SELECT menu.ImagePath, menu.Price, DietaryRequirements.Item FROM DietaryRequirements CROSS JOIN menu WHERE ContainsMolluscs = 'Yes' AND menu.ID = DietaryRequirements.ID ";
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
			<div class="col-lg-9 col-md-7 col-sm-6" id="right">
				<div class="row" id="rightInsideRow">
					<div class="DishImagePlaceholder" id="dish">
						<img src="<?php echo $image; ?>" height="300" width="300">
					</div>
					<div class="DishImagePlaceholder" id="pricing">
						<?php
						echo "<p>{$row['Item']}</p>";
						echo "<p><br>Price: £{$row['Price']}</p>";
						?>
						<input type="text" name="quantity" value="1" class="form-control" />
						<input type="submit" name="add_to_cart" class="btn btn-success" value="Add to Cart" />
					</div>
				</div>
			</div>
		</form>
		<?php
	}
}
?>
