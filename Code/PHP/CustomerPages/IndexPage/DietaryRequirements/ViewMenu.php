<?php
require '/var/www/html/Alex/PHP/Connections/ConnectionCustomer.php';

//require_once "/var/www/html/Main/PHP/CustomerPages/IndexPage/DietaryRequirements/Session.php";

?>

<div class="row">
	<div class="col-lg-12 scrollit" id="DishesCol">
		<?php

///////////////////////////////////////////////////////////////////
/////////////         Starting SQL Query      ////////////////////
		$sql = "SELECT menu.ID, menu.Item, menu.ImagePath, menu.Price, menu.Availability, Descriptions.Description, IngredientsAndCalories.Ingredients, Allergens.Allergens, IngredientsAndCalories.Calories, DietaryRequirements.Item FROM Descriptions, IngredientsAndCalories, Allergens, DietaryRequirements CROSS JOIN menu WHERE menu.ID = DietaryRequirements.ID AND DietaryRequirements.ID = Descriptions.ID AND Descriptions.ID = IngredientsAndCalories.ID AND IngredientsAndCalories.ID = Allergens.ID AND menu.Availability = 'True' ";


//////////////////////////////////////////////////////////////////
/////////////            Category              //////////////////

		$CategoryArray = $_POST['category'];
		$Category = array();
		if(sizeof($CategoryArray)>0){
			foreach ($CategoryArray as $key => $value) {
				array_push($Category, "menu.Category = '".$value."'" );
			}
			$sql = $sql . " AND ";
			$sql .= join("", $Category);
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

		}	

////////////                                     ////////////////
////////////////////////////////////////////////////////////////	
		
		$res = $conn->query($sql);
		$num_rows = mysqli_num_rows($res);
		if($res-> num_rows == 0){
			echo "0 results";
		}
		else{
			echo $res -> num_rows;
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
								$addToCartID = "addToCart"."".$id;
								$hrefAddToCartID = "#addToCart"."".$id;
								$popup = "popupID"."".$id;
								$hrefPopupID = "#popupID"."".$id;
								?>
								<div id="<?php echo($quantityID); ?>" class="quantityForm">
									<input type="text" name="<?php echo($quantityID); ?>" value="1" class="form-control" />
								</div>
								<div class="itemBoxes">
									<input type="submit" class="btn btn-success" name="<?php echo($addToCartID); ?>" value="Add to Cart" href="<?php echo($hrefAddToCartID); ?>" />

									<a class="btn btn-success" href="<?php echo($hrefPopupID); ?>">Info</a>
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

								// This code gets the user's IP public address and uses it to distinguish the user's order between different systems
								if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  // Checks if IP is from shared internet
							      $ip = $_SERVER['HTTP_CLIENT_IP'];
							    
							    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // Checks if IP is passed from a proxy
							      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
							    
							    } else { // Else, get IP address of connecting party 
							      $ip = $_SERVER['REMOTE_ADDR'];

    							}

								$sql = "INSERT INTO TempOrders (IP, ID, Item, Quantity, Price, Time) SELECT '$ip', menu.ID, menu.Item, $quantity, menu.Price, now() FROM menu WHERE menu.ID = $id";

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
