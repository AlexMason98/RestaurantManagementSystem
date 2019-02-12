<?php
// session_start();
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';	

// if(isset($_POST["cart"])){
// 	require '/var/www/html/Harshdeep/PHP/CustomerPages/shoppingCart.php';	
// }


?>

<div class="row">
	<div class="col-lg-12 scrollit" id="DishesCol">
		<table class="table table-striped" id="dishTable">
			<?php
			// require '../../../../Connections/ConnectionCustomer.php';
			$sql = "SELECT Item, Price FROM menu";
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
 					//works
				}elseif ($Vegan) {
					include_once 'Refinements/VeganDishes.php';
					//works
				}elseif ($GlutenFree) {
					include_once 'Refinements/GlutenFreeDishes.php';
					//works
				}elseif ($Eggs) {
					include_once 'Refinements/ContainsNoEgg.php';
					//works
				}elseif ($Milk) {
					include_once 'Refinements/ContainsNoMilk.php';
//works
				}elseif ($Peanuts) {
					include_once 'Refinements/ContainsNoPeanuts.php';
//works
				}elseif ($TreeNut) {
					include_once 'Refinements/ContainsNoTreeNuts.php';
//works
				}elseif ($Celery) {
					include_once 'Refinements/ContainsNoCelery.php';
//works
				}elseif ($Fish) {
					include_once 'Refinements/ContainsNoFish.php';
//works
				}elseif ($Crustaceans) {
					include_once 'Refinements/ContainsNoCrustaceans.php';
//works
				}elseif ($Molluscs) {
					include_once 'Refinements/ContainsNoMolluscs.php';
//works
				}elseif ($Mustard) {
					include_once 'Refinements/ContainsNoMustard.php';
//works
				}elseif ($Soya) {
					include_once 'Refinements/ContainsNoSoya.php';
//works
				}elseif ($Sulphites) {
					include_once 'Refinements/ContainsNoSulphites.php';
//works
				}elseif ($SesameSeeds) {
					include_once 'Refinements/ContainsNoSesameSeeds.php';
//works
				}elseif ($Lupin) {
					include_once 'Refinements/ContainsNoLupin.php';
					// 
				}
				else{
					while($row = mysqli_fetch_assoc($res)){
						?>
						<form method="post" act>
							<div class="col-lg-9 col-md-7 col-sm-6" id="right">
								<div class="row" id="rightInsideRow">
									<div class="DishImagePlaceholder" id="dish">
										<p>One</p>
									</div>
									<div class="DishImagePlaceholder" id="pricing">
										<?php
										

										echo "<input type='hidden' name='hidden_name'>{$row['Item']}\n";
										echo "<input type='hidden' name='hidden_Price'>{$row['Price']}";
										?>
										<input type="text" name="quantity" class="form-control" value="1">
										<input class="btn btn-success" name="cart" type="button" Value="Add to cart">
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

		</table>
	</div>
</div>

<div class="container-fluid">
	<div class="row" id="buttonRow">
		<div class="col-lg-12" id="OrderButton">
			<a class="btn btn-light btn-lg btn-block" href="../OrderPages/OrderPage">Order</a>
		</div>
	</div>
</div>


