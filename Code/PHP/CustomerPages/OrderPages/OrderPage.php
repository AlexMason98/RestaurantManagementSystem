<!-- Header -->
<?php
include_once '../../Header.php';
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';

?>
<!-- Header -->

<section>
	<form method="post">
		<div class="container" id="MainContainer">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 scrollit">
					<div class="table-responsive">
						<table class="table table-bordered">
							<?php

							// This code gets the user's IP public address and uses it to distinguish the user's order between different systems
							if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  // Checks if IP is from shared internet
							    $ip = $_SERVER['HTTP_CLIENT_IP'];
							    
							} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // Checks if IP is passed from a proxy
							    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
							    
							} else { // Else, get IP address of connecting party 
							    $ip = $_SERVER['REMOTE_ADDR'];

    						}

							$sql = "SELECT * FROM TempOrders WHERE IP = '$ip'";
							$res = $conn->query($sql);
							if($res-> num_rows == 0){
								echo('<h3 id="noItems">There are no items in your basket</h3>');
							}
							else{
								?>
								<h3 id="yourBasket">Your Basket</h4>

								<thead class="thead-light" id="orderTableHeader">
									<tr>
										<th style="width:10%">Item ID</th>
						    			<th style="width:65%">Item</th>
						    			<th style="width:10%">Quantity</th>
						    			<th style="width:15%">Price (Per Item)</th>
						  			</tr>
								</thead>
								<?php
								while($row = mysqli_fetch_assoc($res)){
									$id = $row['ID'];
									?>
									<tr class="itemsTable">
										<td><?php echo($row['ID']); ?></td>
										<td><?php echo($row['Item']); ?></td>
										<td><?php echo ($row['Quantity']); ?></td>
										<td>£<?php echo($row['Price']); ?></td>
									</tr>
									<?php
								}
								$numberOfRows = mysqli_num_rows($res);
							}

							?>
						</table>
					</div>
				</div>
				<div class="col-lg-8 col-md-7 col-sm-5"></div>
				<div class="col-lg-4 col-md-5 col-sm-7">
					<table id="TotalPrice">
						<tr>
							<td id="totalPriceText">Total Price</td>
						</tr>
					</table>
					<table class="table table-striped table-bordered-less header" id="displayTotalPriceTable">
						<?php
						$sql = "SELECT SUM(Quantity * Price) AS Total FROM TempOrders WHERE IP = '$ip'";
						$res = $conn->query($sql);

						if($res->num_rows > 0) {
							while($row = mysqli_fetch_assoc($res)){
								echo('<tr><td id="orderPagePriceText">');
								echo("£{$row['Total']}");
								echo('</td></tr>');
							}
							
						} else {
							?>
							<tr>
								<td id="orderPagePriceText">£0.00</td>
							</tr>
							<?php
						}

						?>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 col-md-7 col-sm-5"></div>
				<div class="col-lg-4 col-md-5 col-sm-7" id="buttonContainer">
					<div class="greenButtons">
						<a class="btn btn-success btn-lg" id="payBeforeButton" href="#popupPayBefore">Pay Before</a>
						<a class="btn btn-success btn-lg" id="payAfterButton" href="#popupPayAfter">Pay After</a>
					</div>
					<div class="redButtons">
						<a class="btn btn-danger btn-lg" id="cancelOrderButton" href="#popupCancelItems">Cancel Order</a>
						<a class="btn btn-danger btn-lg" id="alertWaiterButton" href="#alertWaiter">Alert Waiter</a>
					</div>
				</div>
			</div>
		</div>

		<div id="popupCancelItems" class="basketOverlay">
			<div class="popup">
				<a class="close" name="closePopup" href="OrderPage.php">&times;</a>
				<div class="popupInfo">

					<?php
						if ($numberOfRows != 0) {

							echo('<h5 id="confirmationTitle">Are you sure you want to cancel your order?</h5>');
							echo('<h6 id="confirmationSubTitle">You will lose all items in your basket</h6>');

							echo('<input type="submit" class="btn btn-success btn-md" name="Yes" id="removeYes" value="Yes" />');
							echo('<input type="submit" class="btn btn-danger btn-md" name="No" id="removeNo" value="No" />');

							if (isset($_POST['Yes'])) {
								$sql = "DELETE FROM TempOrders";
								
								if (mysqli_query($conn, $sql)) {

									// I use this so that the popup closes and the page refreshes so that basket is shown empty
									echo('<script>');
									echo('window.location.href = "OrderPage.php";');
									echo('</script>');
								} else {
									echo('<h5>Error Removing Items From Basket</h5>');
									echo("Error: ".mysqli_error($conn));
								}
							} else if (isset($_POST['No'])) {
								// I use this so that the popup closes and the page refreshes, showing the items still in basket
								echo('<script>');
								echo('window.location.href = "OrderPage.php";');
								echo('</script>');
							}
						} else if ($numberOfRows == 0) {
							echo('<h5 id="cannotCancel">Can not cancel order. There are no items to remove from your basket</h5>');
						}
					?>
				</div>
			</div>
		</div>

		<div id="popupPayBefore" class="payAfterOverlay">
			<div class="popup">
				<a class="close" name="closePopup" href="OrderPage.php">&times;</a>
				<div class="popupInfo">
					<h5 id="enterTableText1">Enter Your Table Number:</h5><br>
					<input type="text" name="payBeforeTableEntry" id="payBeforeTableEntry" />
					<input type="submit" class="btn btn-success btn-sm" name="payBeforeSubmitButton" id="payBeforeSubmitButton" value="Submit" />

					<?php
					if (!empty($_POST['payBeforeTableEntry']) && ($_POST['payBeforeTableEntry'] >= 1) && ($_POST['payBeforeTableEntry'] <= 10) && (isset($_POST['payBeforeSubmitButton']))) {

							$payBeforeTableNumber = ltrim($_POST['payBeforeTableEntry'], '0');

							// Checking to see if there is already an order by the table entered by the user
							$sql = "SELECT Orders.IP, Orders.TableNo FROM Orders, TempOrders WHERE Orders.TableNo = $payBeforeTableNumber";
							$res = mysqli_query($conn, $sql);

							if (mysqli_num_rows($res) > 0) {
								echo('<style> #enterTableText1 { display: none; } </style>');
								echo('<style> #payBeforeTableEntry { display: none; } </style>');
								echo('<style> #payBeforeSubmitButton { display: none; } </style>');
								echo('<h5>Order Already Placed</h5>');
								echo('<h6>We already have an order for your table number, please wait until your current order has been fulfilled</h6>');

							} else if ($numberOfRows != 0) {
								// After checking the table number doesn't already exist, I temporarily set the TableNo in the TempOrders table
								// with the table number the user entered, for all items matching their IP address
								$sql = "UPDATE TempOrders SET TableNo = $payBeforeTableNumber WHERE TempOrders.IP = '$ip'";
								if (mysqli_query($conn, $sql)) {
									// This header redirects to the PaymentSystem's index page once I get the table number.
									echo('<script>');
									echo('window.location.href = "PaymentSystem/index.php";');
									echo('</script>');
								} else {
									echo('<h5>Error Inserting Table Number</h5>');
									echo("Error: ".mysqli_error($conn));
								}
							}

					} else if ((!empty($_POST['payBeforeTableEntry']) || ($_POST['payBeforeTableEntry'] == 0)) && isset($_POST['payBeforeSubmitButton'])) {
						// If the table number is not between 1 and 10, but the table number entry form is not empty (or value inside is equal to 0) and submit has been pressed: 
						echo("<br>");
						echo("Please enter a valid table number");

					} else if (empty($_POST['payBeforeTableEntry']) && isset($_POST['payBeforeSubmitButton'])) {
						// Else, if the submit button has been pressed but the table number entry form is empty:
						echo("<br>");
						echo("Please enter a table number before placing your order");

					}
					?>
				</div>
			</div>
		</div>

		<div id="popupPayAfter" class="payAfterOverlay">
			<div class="popup">
				<a class="close" name="closePopup" href="OrderPage.php">&times;</a>
				<div class="popupInfo">

					<h5 id="enterTableText2">Enter Your Table Number:</h5><br>
					<input type="text" name="payAfterTableEntry" id="payAfterTableEntry" />
					<input type="submit" class="btn btn-success btn-sm" name="payAfterSubmitButton" id="payAfterSubmitButton" value="Submit" />

					<?php
					if (!empty($_POST['payAfterTableEntry']) && ($_POST['payAfterTableEntry'] >= 1) && ($_POST['payAfterTableEntry'] <= 10) && (isset($_POST['payAfterSubmitButton']))) {
						echo('<style> #enterTableText2 { display: none; } </style>');
						echo('<style> #payAfterTableEntry { display: none; } </style>');
						echo('<style> #payAfterSubmitButton { display: none; } </style>');

						$payAfterTableNumber = ltrim($_POST['payAfterTableEntry'], '0');

						$sql = "SELECT Orders.IP, Orders.TableNo FROM Orders, TempOrders WHERE Orders.TableNo = $payAfterTableNumber";
						$res = mysqli_query($conn, $sql);

						if (mysqli_num_rows($res) > 0) {
							echo('<h5>Order Already Placed</h5>');
							echo('<h6>We already have an order for your table number, please wait until your current order has been fulfilled</h6>');

						} else if ($numberOfRows != 0) {

							$sql = "INSERT INTO Orders (IP, TableNo, ID, Item, Quantity, Price, Status, PaymentStatus, Time) SELECT TempOrders.IP, $payAfterTableNumber, TempOrders.ID, TempOrders.Item, TempOrders.Quantity, TempOrders.Price, 'Order Placed', 'Unpaid', now() FROM TempOrders WHERE TempOrders.IP = '$ip'";
							if (mysqli_query($conn, $sql)) {
								$sql = "DELETE FROM TempOrders WHERE IP = '$ip'";
								if (mysqli_query($conn, $sql)) {
									echo('<h5 id="receivedOrder">We have received your order!</h5>');
									echo('<h6 id="paymentLaterText">Call one of our waiters once you have enjoyed your meal to pay</h6>');
								} else {
									echo('<h5>Error Removing Order From Basket. Please request assistance from one of our waiters.</h5>');
									echo('<br>');
									echo(mysqli_error($conn));
								}
							} else {
								echo('<h5>Error Placing Order, Seek Assistance from one of our Waiters</h5>');
								echo('<br>');
								echo("Error: ".mysqli_error($conn));
							}
						} else {
							echo('<h5>Can not place order!</h5>');
							echo('<h6>There are no items in your order</h6>');
						}
					} else if ((!empty($_POST['payAfterTableEntry']) || ($_POST['payAfterTableEntry'] == 0)) && isset($_POST['payAfterSubmitButton'])) {
						// If the table number is not between 1 and 10, but the table number entry form is not empty (or value inside is equal to 0) and submit has been pressed: 
						echo("<br>");
						echo("Please enter a valid table number");

					} else if (empty($_POST['payAfterTableEntry']) && isset($_POST['payAfterSubmitButton'])) {
						// Else, if the submit button has been pressed but the table number entry form is empty:
						echo("<br>");
						echo("Please enter a table number before placing your order");

					}
					?>
				</div>
			</div>
		</div>

	<div id="alertWaiter" class="overlayAssistance">
		<a class="close" href="#">&times;</a>
		<div class="popupInfo">
			<h5>What is your table number?</h5><br>
			<input type="text" name="tableNumberEntry" />
			<input type="submit" name="submitTable" value="Submit" />

			<?php

				if (isset($_POST['submitTable']) && isset($_POST['tableNumberEntry'])) {
					$tableNumber = $_POST['tableNumberEntry'];
					$sql = "INSERT INTO TableAssistance (TableID, Time, WaiterName, Status) VALUES ('$tableNumber', now(), 'Not Assigned', 'Needs Assistance')";

					if (mysqli_query($conn, $sql)) {
						echo('<br>');
						echo('<br>');
						echo('Success!');
						echo('<br>');
						echo('Our waiters have been informed that you require assistance, ');
						echo('please wait until a waiter has become available to assist you.');
					} else {
						echo "Error: ".mysqli_error($conn);
					}
				}
			?>
		</div>
	</div>
</form>

</section>

<!-- Footer -->
<?php
mysqli_close($conn);
include_once '../../footer.php';
?>
<!-- Footer -->
