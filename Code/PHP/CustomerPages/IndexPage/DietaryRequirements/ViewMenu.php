<?php
require '/var/www/html/Alex/PHP/Connections/ConnectionCustomer.php';
session_start()
?>

<div class="row">
	<div class="col-lg-12 scrollit" id="DishesCol">
		<?php

///////////////////////////////////////////////////////////////////
/////////////         Starting SQL Query      ////////////////////
		$sql = "SELECT menu.ID, menu.Item, menu.ImagePath, menu.Price, Descriptions.Description, IngredientsAndCalories.Ingredients, Allergens.Allergens, IngredientsAndCalories.Calories, DietaryRequirements.Item FROM Descriptions, IngredientsAndCalories, Allergens, DietaryRequirements CROSS JOIN menu WHERE menu.ID = DietaryRequirements.ID AND DietaryRequirements.ID = Descriptions.ID AND Descriptions.ID = IngredientsAndCalories.ID AND IngredientsAndCalories.ID = Allergens.ID";
		
//////////////////////////////////////////////////////////////////
/////////////         Multiple Refinements     //////////////////

		$DietReqArray = $_GET['DietReq'];
		$DietReq = array();


		if(sizeof($DietReqArray)>0){
			foreach ($DietReqArray as $key => $value) {
				array_push($DietReq, $value. " = 'Yes' ");
			}
			$sql = $sql . " AND ";
			$sql .= join(" AND ", $DietReq);
		}		

////////////                                     ////////////////
////////////////////////////////////////////////////////////////	
		
		$res = $conn->query($sql);
		//$num_rows = mysqli_num_rows($res);
		if($res-> num_rows == 0){
			echo "0 results";
		}
		else{
			while($row = mysqli_fetch_assoc($res)){

				$image = $row['ImagePath'];
				$id = $row['ID'];
				$item = $row['Item'];
				$price = $row['Price'];
				$description = $row['Description'];
				$ingredients = $row['Ingredients'];
				$allergen = $row['Allergens'];
				$calories = $row['Calories'];
				?>
				<form method="post" action="indexPage?action=add&ID=<?php echo $row['ID']; ?>">
					<div class="col-lg-14 col-md-12 col-sm-10" id="center">
						<div class="row" id="centerInsideRow">
							<div class="DishImagePlaceholder border border-light border-right-0 " id="dish">
								<img src="<?php echo $image; ?>" height="298" width="299">
							</div>
							<div class="DishImagePlaceholder border border-light border-left-0" id="pricing">
								<p id="itemText">
									<?php
									echo "$item";
									?>
								</p>
								<p id="priceText">Price: £
									<?php
									echo "$price";
									?>
								</p>

								<?php
									$quantityID = "quantity"."".$id;
									$hrefAddToCartID = "#addToCart"."".$id;
									$popup = "popupID"."".$id;
									$hrefPopupID = "#popupID"."".$id;
								?>
								<div id="<?php echo($quantityID); ?>" class="quantityForm">
									<input type="text" name="quantity" value="1" class="form-control" />
								</div>
								<div class="itemBoxes">

									<input type="submit" class="btn btn-success" name="<?php echo($addToCartID); ?>" value="Add to Cart" href="<?php echo($hrefAddToCartID); ?>" />
									<a class="btn btn-success" href="<?php echo($hrefPopupID); ?>">Info</a>
								</div>
							</div>
							<div id="<?php echo($popup); ?>" class="overlay">
								<div class="popup">
									<h5 id="itemInformation">Item Information</h5>
									<a class="close" href="#">&times;</a>
									<div class="popupInfo">
										<h6 id="descriptionText">Description:</h6>
										<p id="itemDescription"><?php echo($description); ?></p>
										<h6 id="ingredientsText">Ingredients:</h6>
										<p id="itemIngredients"><?php echo ($ingredients); ?></p>
										<h6 id="allergenText">Allergen Information:</h6>
										<p id="itemAllergens"><?php echo($allergen); ?></p>
										<h6 id="caloriesText">Calories:</h6>
										<p id="itemCalories"><?php echo($calories); ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php
				}
			?>

				<?php
					for ($id = 1; $id <= 302; $id++) {
						$addToCartID = "addToCart".$id;
				?>
						<div id="<?php echo($addToCartID); ?>" class="addItemToCart">

							<?php
								if (isset($_POST[$addToCartID])) {
									$quantity = $_POST['quantity'];
										
									$sql = "SELECT * FROM TempOrders WHERE ID = '$id'";
									$res = mysqli_query($conn, $sql);

									if (mysqli_num_rows($res) > 0) {
										echo '<script language="javascript">';
										echo 'alert("This item is already in your basket")';
										echo '</script>';

									} else {
										$sql = "INSERT INTO TempOrders (ID, Item, Quantity, Price) SELECT menu.ID, menu.Item, {$quantity}, menu.Price FROM menu WHERE menu.ID = $id";

										if (mysqli_query($conn, $sql)) {
			   								 echo '<script language="javascript">';
											echo 'alert("Successfully Added to Basket")';
											echo '</script>';
										} else {
											echo "Error: ".mysqli_error($conn);
										}
									}
								}
							?>
						</div>
				<?php
					}
				?>

				</form>
	<?php
		}
		mysqli_close($conn);
	?>
	</div>

</div>
<div class="container-fluid">
	<div class="table-responsive">

	</div>
	<div class="row" id="buttonRow">
		<div class="col-lg-12" id="OrderButton">
			<a class="btn btn-light btn-lg btn-block" href="../OrderPages/OrderPage">Order</a>
		</div>
	</div>
</div>
