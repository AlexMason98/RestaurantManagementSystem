<?php
require '/var/www/html/Main/PHP/Connections/ConnectionCustomer.php';	
?>

<div class="row">
	<div class="col-lg-12 scrollit" id="DishesCol">
		<?php

///////////////////////////////////////////////////////////////////
/////////////         Starting SQL Query      ////////////////////
		$sql = "SELECT menu.ID, menu.Item, menu.ImagePath, menu.Price, menu.Availability, Descriptions.Description, IngredientsAndCalories.Ingredients, Allergens.Allergens, IngredientsAndCalories.Calories, DietaryRequirements.Item FROM Descriptions, IngredientsAndCalories, Allergens, DietaryRequirements CROSS JOIN menu WHERE menu.ID = DietaryRequirements.ID AND DietaryRequirements.ID = Descriptions.ID AND Descriptions.ID = IngredientsAndCalories.ID AND IngredientsAndCalories.ID = Allergens.ID AND menu.Availability = 'True' ";

		// The sql query which get information from Descriptions, IngredientsAndCalories, Allergens, DietaryRequirements and menu, 
		// it compares the ID to check if the items are the same to stop duplicates. Also this query only displays the dishes with a Availiabity of True. 

//////////////////////////////////////////////////////////////////
/////////////            Category              //////////////////

		$CategoryArray = $_POST['category'];
		$Category = array();
		if(sizeof($CategoryArray)==1){
			foreach ($CategoryArray as $key => $value) {
				array_push($Category, "menu.Category = '".$value."'" );
			}
			$sql = $sql . " AND ";
			$sql .= join("", $Category);
			// this get the checkboxes checkboxes from the Categories page using a post method. This then pushes to array which is then used to to concatinate with the sql query. 
		}elseif(sizeof($CategoryArray)>1){
			?>
			<h3>You can not select more than 1 category at a time.</h3>
			<?php
			$sql = "SELECT menu.ID, menu.Item, menu.ImagePath, menu.Price, menu.Availability, Descriptions.Description, IngredientsAndCalories.Ingredients, Allergens.Allergens, IngredientsAndCalories.Calories, DietaryRequirements.Item FROM Descriptions, IngredientsAndCalories, Allergens, DietaryRequirements CROSS JOIN menu WHERE menu.ID = DietaryRequirements.ID AND DietaryRequirements.ID = Descriptions.ID AND Descriptions.ID = IngredientsAndCalories.ID AND IngredientsAndCalories.ID = Allergens.ID AND menu.Availability = 'True' ";
		}else {
			$sql = "SELECT menu.ID, menu.Item, menu.ImagePath, menu.Price, menu.Availability, Descriptions.Description, IngredientsAndCalories.Ingredients, Allergens.Allergens, IngredientsAndCalories.Calories, DietaryRequirements.Item FROM Descriptions, IngredientsAndCalories, Allergens, DietaryRequirements CROSS JOIN menu WHERE menu.ID = DietaryRequirements.ID AND DietaryRequirements.ID = Descriptions.ID AND Descriptions.ID = IngredientsAndCalories.ID AND IngredientsAndCalories.ID = Allergens.ID AND menu.Availability = 'True' ";
		}

		if($_POST['Revert']){
			header("Location: indexPage.php", true, 303);
			// this is used to reload the page, restoring the sql and display all the dishes, when the revert button in the categories pages.
		}

//////////////////////////////////////////////////////////////////
/////////////         Multiple Refinements     //////////////////

		$DietReqArray = $_POST['DietReq'];
		$DietReq = array();

		if(sizeof($DietReqArray)>0){
			foreach ($DietReqArray as $key => $value) {
				array_push($DietReq, $value. " = 'No' ");
			}
			$sql = $sql . " AND ";
			$sql .= join(" AND ", $DietReq);
			// This checks which chekes is checked and then pushes to the arrray called $DietReq which is used to join and concatinate the original sql query.
			// which then displays fliters.
		}	

////////////                                     ////////////////
////////////////////////////////////////////////////////////////	
		$res = $conn->query($sql);
		$num_rows = mysqli_num_rows($res);
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
				$Available = $row['Availability'];
				// this stores the info from the database 
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
									<!-- Displays the Item of the dish -->
								</p>
								<p id="priceText">Price: £
									<?php
									echo "$price";
									?>
									<!-- display the price of the item -->
								</p>

								<?php
								$quantityID = "quantity"."".$id;
								$addToCartID = "addToCart"."".$id;
								$hrefAddToCartID = "#addToCart"."".$id;
								$popup = "popupID"."".$id;
								$hrefPopupID = "#popupID"."".$id;
								// This is going to be used to differentiate and generates a button for each dish id.
								?>
								<div id="<?php echo($quantityID); ?>" class="quantityForm">
									<input type="text" name="<?php echo($quantityID); ?>" id="quantityBox" value="1" class="form-control" />
								</div>
								<div class="itemBoxes">
									<input type="submit" class="btn btn-success" name="<?php echo($addToCartID); ?>" value="Add to Cart" href="<?php echo($hrefAddToCartID); ?>" id="addToCartSubmit" />

									<a class="btn btn-success" href="<?php echo($hrefPopupID); ?>" id="infoButton">Info</a>
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
								<!-- this is the pop up code which displays the Description, ingredient, Allergens and calroies. This pop is also different for each dish becuase of the use of dish id.-->
							</div>
						</div>
					</div>
					<?php
				}
				for ($id = 1; $id <= $num_rows; $id++) {
					// For as many available items/rows, concatenate addToCart with $id which increments by 1 each time
					$addToCartID = "addToCart".$id;
					?>
					<!-- Creates a div for each addToCart button, based on the number of available items -->
					<div id="<?php echo($addToCartID); ?>" class="addItemToCart">
						<?php
						// Handler for each addToCart button. If button is pressed, do this:
						if (isset($_POST[$addToCartID])) {
							// Get quantity from corresponding quantity form (both submit button and quantity form have the same number/ID on the end)
							$quantity = $_POST["quantity".$id];
							// Select all from TempOrders where the ID is based on the id of the item they selected
							$sql = "SELECT * FROM TempOrders WHERE ID = '$id'";
							$res = mysqli_query($conn, $sql);

							if (mysqli_num_rows($res) > 0) {
								// If rows is above 0, this means the item already exists in the basket
								echo '<script language="javascript">';
								// Create Javascript alert saying "This item is already in your basket"
								echo 'alert("This item is already in your basket")';
								echo '</script>';

							} else {
								// Else, get the user's IP address and perform SQL query below

								// This code gets the user's IP public address and uses it to distinguish the user's order between different systems
								if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  // Checks if IP is from shared internet
							      $ip = $_SERVER['HTTP_CLIENT_IP'];
							    
							    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // Checks if IP is passed from a proxy
							      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
							    
							    } else { // Else, get IP address of connecting party 
							      $ip = $_SERVER['REMOTE_ADDR'];

    							}

    							// Insert item's details into the TempOrders table with the user's IP, which acts as the user's basket
								$sql = "INSERT INTO TempOrders (IP, ID, Item, Quantity, Price, Time) SELECT '$ip', menu.ID, menu.Item, $quantity, menu.Price, now() FROM menu WHERE menu.ID = $id";

								if (mysqli_query($conn, $sql)) {
									// If query was successful, print "Successfully Added to Basket" with a Javascript alert
									echo '<script language="javascript">';
									echo 'alert("Successfully Added to Basket")';
									echo '</script>';
								} else {
									echo "Error: ".mysqli_error($conn);
									// Else, print "Error" with the SQL error produced from the connection
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
		<div class="OrderButton">
			<!-- This creates the Order Button and links to the OrderPage -->
			<a class="btn btn-success btn-lg" id="OrderButton" href="../OrderPages/OrderPage">Order</a>
		</div>
	</div>
</div>
