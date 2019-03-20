<?php
require '/var/www/html/Alex/PHP/Connections/ConnectionCustomer.php';
session_start()
?>

<div class="row">
	<div class="col-lg-12 scrollit" id="DishesCol">
		<?php

///////////////////////////////////////////////////////////////////
/////////////         Starting SQL Query      ////////////////////

	// the starting sql which joins the menu table, description table, IngredientAndCalories, DietaryRequiement.
	// It checks if the id of the item in all the tables is the same so they dont duplicate the items. 
	//Also it checks if the item/dish is avaiable to be sold, which is linked to the waiter page.
		$sql = "SELECT menu.ID, menu.Item, menu.ImagePath, menu.Price, menu.Availability, Descriptions.Description, IngredientsAndCalories.Ingredients, Allergens.Allergens, IngredientsAndCalories.Calories, DietaryRequirements.Item FROM Descriptions, IngredientsAndCalories, Allergens, DietaryRequirements CROSS JOIN menu WHERE menu.ID = DietaryRequirements.ID AND DietaryRequirements.ID = Descriptions.ID AND Descriptions.ID = IngredientsAndCalories.ID AND IngredientsAndCalories.ID = Allergens.ID AND menu.Availability = 'True' ";
		
//////////////////////////////////////////////////////////////////
/////////////         Multiple Refinements     //////////////////

		$DietReqArray = $_POST['DietReq'];
		//get the data using a post method 
		$DietReq = array();

		if(sizeof($DietReqArray)>0){
			//check if any of the checkboxes are checked. Meaning the size of the array is larger than 0
			foreach ($DietReqArray as $key => $value) {
				array_push($DietReq, $value. " = 'Yes' ");
				// get the value for the post method and then store it in an another array with a string
				//so it can be for the sql query.
			}
			$sql = $sql . " AND ";
			$sql .= join(" AND ", $DietReq);
			//concatintates the sql query by Adding " AND " so it can add another where clause
			// The is joins the whole of the new array $dietRep into one string and joins it to the sql query.
		}		
////////////                                     ////////////////
////////////////////////////////////////////////////////////////	
		
		$res = $conn->query($sql);
		$num_rows = mysqli_num_rows($res);
		if($res-> num_rows == 0){
			echo "0 results";
		}
		else{
			//while loop run until the sql query returns a value. 
			while($row = mysqli_fetch_assoc($res)){

				$image = $row['ImagePath'];
				$id = $row['ID'];
				$item = $row['Item'];
				$price = $row['Price'];
				$description = $row['Description'];
				$ingredients = $row['Ingredients'];
				$allergen = $row['Allergens'];
				$calories = $row['Calories'];
				$Available = $row['Availability'];
				//variable store the data from the database from each column.
				?>
				<form method="post" action="indexPage?action=add&ID=<?php echo $row['ID']; ?>">
					<div class="col-lg-14 col-md-12 col-sm-10" id="center">
						<div class="row" id="centerInsideRow">
							<div class="DishImagePlaceholder border border-light border-right-0 " id="dish">
								<img src="<?php echo $image; ?>" height="298" width="299">
								<!-- the images are displayed -->
							</div>
							<div class="DishImagePlaceholder border border-light border-left-0" id="pricing">
								<p id="itemText">
									<?php
									echo "$item";
									?>
									<!-- this prints it item name -->
								</p>
								<p id="priceText">Price: £
									<?php
									echo "$price";
									?>
									<!-- prints the item prince -->
								</p>

								<?php
								$quantityID = "quantity"."".$id;
								$addToCartID = "addToCart"."".$id;
								$hrefAddToCartID = "#addToCart"."".$id;
								$popup = "popupID"."".$id;
								$hrefPopupID = "#popupID"."".$id;
								?>
								<!-- variable for the vaiable -->
								<div id="<?php echo($quantityID); ?>" class="quantityForm">
									<input type="text" name="<?php echo($quantityID); ?>" value="1" class="form-control" />
								</div>
								<!-- this is for the div which get the quantity of the dishes -->
								<div class="itemBoxes">

									<input type="submit" class="btn btn-success" name="<?php echo($addToCartID); ?>" value="Add to Cart" href="<?php echo($hrefAddToCartID); ?>" />

									<a class="btn btn-success" href="<?php echo($hrefPopupID); ?>">Info</a>
									<!-- This displays the button to display the information about the dish and has the button for add to cart. -->
								</div>
							</div>
							<div id="<?php echo($popup); ?>" class="overlay">
								<div class="popup">
									<h5 id="itemInformation">Item Information</h5>
									<a class="close" href="">&times;</a>
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
								<!-- This is for the the pop up which displays the information about each dish.
								It display the descriptions, Ingredients, Allergen and calories.   -->
							</div>
						</div>
					</div>
					<?php
				}
				for ($id = 1; $id <= $num_rows; $id++) {
					$addToCartID = "addToCart".$id;
					?>
					<div id="<?php echo($addToCartID); ?>" class="addItemToCart">

						<?php
						if (isset($_POST[$addToCartID])) {
							$quantity = $_POST["quantity".$id];

							$sql = "SELECT * FROM TempOrders WHERE ID = '$id'";
							$res = mysqli_query($conn, $sql);

							if (mysqli_num_rows($res) > 0) {
								echo '<script language="javascript">';
								echo 'alert("This item is already in your basket")';
								echo '</script>';

							} else {
								$sql = "INSERT INTO TempOrders (ID, Item, Quantity, Price, Time) SELECT menu.ID, menu.Item, $quantity, menu.Price, now() FROM menu WHERE menu.ID = $id";

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
						<!-- This pop up is for the add to cart, which is displayed to infrom the customer about the addition of the dish to the cart. -->
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
	<!-- leads to the order page which display the dishes which have been add to the cart. -->
</div>
