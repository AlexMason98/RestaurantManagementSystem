<?php
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';	
?>

<div class="row">
	<div class="col-lg-12 scrollit" id="DishesCol">
		<?php
		
		$sql = "SELECT ID, Item, Price FROM menu";
		$res = $conn->query($sql);
			// variables for the refines used in the if statements.
		$Vegetarian = $_POST['Vegetarian'];
		$Vegan = $_POST['Vegan'];
		$GlutenFree = $_POST['GlutenFree'];	
		$Eggs = $_POST['ContainsNoEgg'];	
		$Milk = $_POST['ContainsNoMilk'];	
		$Peanuts = $_POST['ContainsNoPeanuts'];
		$TreeNut = $_POST['ContainsNoTreeNuts'];
		$Celery = $_POST['ContainsNoCelery'];	
		$Fish = $_POST['ContainsNoFish'];	
		$Crustaceans = $_POST['ContainsNoCrustaceans'];	
		$Molluscs = $_POST['ContainsNoMolluscs'];
		$Mustard = $_POST['ContainsNoMustard'];
		$Soya = $_POST['ContainsNoSoya'];	
		$Sulphites = $_POST['ContainsNoSulphites'];	
		$SesameSeeds = $_POST['ContainsNoSesameSeeds'];	
		$Lupin = $_POST['ContainsNoLupin'];	
		if($res-> num_rows == 0){
			echo "0 results";
		}
		else{							
			// The if statments for the refinements
			if($Vegetarian){
				include_once 'Refinements/Vegetarian.php';
			}elseif ($Vegan) {
				include_once 'Refinements/VeganDishes.php';

			}elseif ($GlutenFree) {
				include_once 'Refinements/GlutenFreeDishes.php';

			}elseif ($Eggs) {
				include_once 'Refinements/ContainsNoEgg.php';

			}elseif ($Milk) {
				include_once 'Refinements/ContainsNoMilk.php';

			}elseif ($Peanuts) {
				include_once 'Refinements/ContainsNoPeanuts.php';

			}elseif ($TreeNut) {
				include_once 'Refinements/ContainsNoTreeNuts.php';

			}elseif ($Celery) {
				include_once 'Refinements/ContainsNoCelery.php';

			}elseif ($Fish) {
				include_once 'Refinements/ContainsNoFish.php';

			}elseif ($Crustaceans) {
				include_once 'Refinements/ContainsNoCrustaceans.php';

			}elseif ($Molluscs) {
				include_once 'Refinements/ContainsNoMolluscs.php';

			}elseif ($Mustard) {
				include_once 'Refinements/ContainsNoMustard.php';

			}elseif ($Soya) {
				include_once 'Refinements/ContainsNoSoya.php';

			}elseif ($Sulphites) {
				include_once 'Refinements/ContainsNoSulphites.php';

			}elseif ($SesameSeeds) {
				include_once 'Refinements/ContainsNoSesameSeeds.php';

			}elseif ($Lupin) {
				include_once 'Refinements/ContainsNoLupin.php';
					// 
			}
			else{
				while($row = mysqli_fetch_assoc($res)){
					?>
					<form method="post" action="indexPage?action=add&ID=<?php echo $row['ID']; ?>">
						<div class="col-lg-9 col-md-7 col-sm-6" id="right">
							<div class="row" id="rightInsideRow">
								<div class="DishImagePlaceholder" id="dish">
									<p>One</p>
								</div>
								<div class="DishImagePlaceholder" id="pricing">
									<?php

									echo "<input type='hidden' name='hidden_name' value='{$row['Item']}'>{$row['Item']}";
									echo "<input type='hidden' name='hidden_price' value='{$row['price']}'><br>Price: £{$row['Price']}";
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
		}
		mysqli_close($conn);
		?>
	</div>

</div>
<div class="container-fluid">
	<div class="row" id="buttonRow">
		<div class="col-lg-12" id="OrderButton">
			<a class="btn btn-light btn-lg btn-block" href="../OrderPages/OrderPage">Order</a>
		</div>
	</div>
</div>
