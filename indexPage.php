<!-- Header -->
<?php
include_once 'Header.php';
?>
<!-- Header -->

<section>
	<form method="post">
		<div class="container-fluid">
			<div class="row" id="row1">

				<div class="col-lg-3 col-md-5 col-sm-6" id="left">

					<div class="accordion" id="accordionExample">
						<div class="card">
							<div class="card-header" id="headingOne">			
								<button class="btn btn-lg" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"  id="dropDown">
									Categories
								</button>
							</div>
							<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div class="card-body">
									<?php
									require '/var/www/html/Harshdeep/php/Connections/ConnectionCustomer.php';
									
									$sql = "SELECT DISTINCT Category FROM menu";
									$res = $conn->query($sql);
									if($res-> num_rows == 0){
										echo "0 results";
									}
									else{
										while($row = mysqli_fetch_assoc($res)){
											echo "<a href='#'><br>{$row['Category']}</a>\n";
										}
									}
									mysqli_close($conn);
									?>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
									<button class="btn btn-lg" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="dropDown">
										Dietary Requirements
									</button>
								</h2>
							</div>
							<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
								<div class="card-body">
									<a href="#"><br>Vegan</a>
									<a href="#"><br>Vegetarian</a>
									<a href="#"><br>Contains Egg</a>
									<a href="#"><br>Contains Milk</a>
									<a href="#"><br>Contains Peanu</a>
									<a href="#"><br>Contains Tree Nuts</a>
									<a href="#"><br>Contains Celery</a>
									<a href="#"><br>Contains Fish </a>
									<a href="#"><br>Contains Crustaceans </a>
									<a href="#"><br>Contains Molluscs</a>
									<a href="#"><br>Contains Mustard</a>
									<a href="#"><br>Contains Soya</a>
									<a href="#"><br>Contains Sulphites</a>
									<a href="#"><br>Contains Sesame Seeds</a>
									<a href="#"><br>Contains Lupin Link</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-7 col-sm-6" id="right">
					<div class="row" id="rightInsideRow">
						<div class="DishImagePlaceholder" id="dish">
							<p>One</p>
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Two</p>
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Three</p>
						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Four</p>
						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Five</p>
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Six</p>
						</div>
					</div>
					<div class="row" id="pricingRow">
						<div class="DishImagePlaceholder" id="pricing">

						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div>
					</div>
					<div class="row" id="rightInsideRow">
						<div class="DishImagePlaceholder" id="dish">
							<p>One</p>
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Two</p>
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Three</p>
						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Four</p>
						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Five</p>
						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="dish">
							<p>Six</p>
						</div>
					</div>
					<div class="row" id="pricingRow">
						<div class="DishImagePlaceholder" id="pricing">

						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div> 
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div>
						<div class="EmptySpace" id="EmptySpace"></div>
						<div class="DishImagePlaceholder" id="pricing">

						</div>
					</div>
					<div class="container-fluid">
						<div class="row" id="buttonRow">
							<div class="col-lg-12" id="OrderButton">
								<a class="btn btn-light btn-lg btn-block" href="OrderPage">Order</a>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</form>
</section>

<!-- Footer -->
<?php
include_once 'footer.php';
?>
<!-- Footer -->