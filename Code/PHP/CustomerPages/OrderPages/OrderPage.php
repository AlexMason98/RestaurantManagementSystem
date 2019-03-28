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

    						// Select all from TempOrders table where the IP in the table equals the user's IP to display their order
							$sql = "SELECT * FROM TempOrders WHERE IP = '$ip'";
							$res = $conn->query($sql);
							if($res-> num_rows == 0){
								/* If there are no results, print "There are no items in your basket" */
								echo('<h3 id="noItems">There are no items in your basket</h3>');
							}
							else{
								?>
								<!-- Else, print "Your Basket", generate a table, and print all the items in their order to the user -->
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
									/* While there is a new row, insert the data into each column in the row */
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
								// Store the number of rows from the query to use for later on
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
						/* Produce the sum by multiplying the Quantity and the Price of each item and store as variable Total */
						$sql = "SELECT SUM(Quantity * Price) AS Total FROM TempOrders WHERE IP = '$ip'";
						$res = $conn->query($sql);

						if($res->num_rows > 0) {
							while($row = mysqli_fetch_assoc($res)){
								/* Display the total if there are items in the TempOrders database */
								echo('<tr><td id="orderPagePriceText">');
								echo("£{$row['Total']}");
								echo('</td></tr>');
							}
							
						} else {
							?>
							<!-- If there aren't any items in the database to show, display the price as £0.00 -->
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
						<!-- Display the Pay Before and Pay After buttons on the webpage -->
						<a class="btn btn-success btn-lg" id="payBeforeButton" href="#popupPayBefore">Pay Before</a>
						<a class="btn btn-success btn-lg" id="payAfterButton" href="#popupPayAfter">Pay After</a>
					</div>
					<div class="redButtons">
						<!-- Display the Cancel Order and Alert Waiter buttons on the webpage -->
						<a class="btn btn-danger btn-lg" id="cancelOrderButton" href="#popupCancelItems">Cancel Order</a>
						<a class="btn btn-danger btn-lg" id="alertWaiterButton" href="#alertWaiter">Alert Waiter</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Generate the Cancel Items popup -->
		<div id="popupCancelItems" class="basketOverlay">
			<div class="popup">
				<a class="close" name="closePopup" href="OrderPage.php">&times;</a> <!-- Generate the OrderPage.php -->
				<div class="popupInfo">

					<?php
						if ($numberOfRows > 0) {
							// If the number of items/rows is above 0, display "Are you sure you want to cancel your order"
							echo('<h5 id="confirmationTitle">Are you sure you want to cancel your order?</h5>');
							echo('<h6 id="confirmationSubTitle">You will lose all items in your basket</h6>');

							echo('<input type="submit" class="btn btn-success btn-md" name="Yes" id="removeYes" value="Yes" />');
							echo('<input type="submit" class="btn btn-danger btn-md" name="No" id="removeNo" value="No" />');

							if (isset($_POST['Yes'])) {
								// If user clicks 'Yes', delete their order from the TempOrders table
								$sql = "DELETE FROM TempOrders";
								
								if (mysqli_query($conn, $sql)) {

									// I use this so that the popup closes and the page refreshes so that basket is shown empty
									echo('<script>');
									echo('window.location.href = "OrderPage.php";');
									echo('</script>');
								} else {
									// If the query failed, print "Error Removing Items From Basket" and display the error msg from the connection
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
							// If the number of items/rows is 0, display "Can not cancel order" because there are no items to remove in the basket
							echo('<h5 id="cannotCancel">Can not cancel order. There are no items to remove from your basket</h5>');
						}
					?>
				</div>
			</div>
		</div>

		<!-- Generate the Pay Before popup  -->
		<div id="popupPayBefore" class="payAfterOverlay">
			<div class="popup">
				<a class="close" name="closePopup" href="OrderPage.php">&times;</a> <!-- If the popup has been closed, refresh the page just incase there has been any changes that need updating  -->
				<div class="popupInfo">
					<h5 id="enterTableText1">Enter Your Table Number:</h5><br>
					<input type="text" name="payBeforeTableEntry" id="payBeforeTableEntry" />
					<input type="submit" class="btn btn-success btn-sm" name="payBeforeSubmitButton" id="payBeforeSubmitButton" value="Submit" />

					<?php
					/* If the table number is in range of 1 to 10, and the submit button has been pressed, do this: */
					if (!empty($_POST['payBeforeTableEntry']) && ($_POST['payBeforeTableEntry'] >= 1) && ($_POST['payBeforeTableEntry'] <= 10) && (isset($_POST['payBeforeSubmitButton']))) {

							$payBeforeTableNumber = ltrim($_POST['payBeforeTableEntry'], '0');

							// Checking to see if there is already an order by the table entered by the user
							$sql = "SELECT Orders.IP, Orders.TableNo FROM Orders, TempOrders WHERE Orders.TableNo = $payBeforeTableNumber";
							$res = mysqli_query($conn, $sql);

							if (mysqli_num_rows($res) > 0) {
								/* If there is already an order in the table, based on the Table Number already in the Order's table against the table number they entered, do this: */
								echo('<style> #enterTableText1 { display: none; } </style>');
								echo('<style> #payBeforeTableEntry { display: none; } </style>');
								echo('<style> #payBeforeSubmitButton { display: none; } </style>');
								/* Hide the text, entry form and submit button, then display "Order already placed" to the user */
								echo('<h5>Order Already Placed</h5>');
								echo('<h6>We already have an order for your table number, please wait until your current order has been fulfilled</h6>');

							} else if ($numberOfRows <= 0) {
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
									/* If the SQL query failed, print "Error inserting table number" and display the SQL error from the connection */
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

		<!-- Generate the Pay After popup -->
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
							/* If the order has already been placed, by checking if the Table Number in the Orders table matches the 
							table number entered by the user */
							echo('<h5>Order Already Placed</h5>');
							echo('<h6>We already have an order for your table number, please wait until your current order has been fulfilled</h6>');

						} else if ($numberOfRows <= 0) {
							// If the Table Number entered is not in the orders table, insert the Pay After order into Orders table
							$sql = "INSERT INTO Orders (IP, TableNo, ID, Item, Quantity, Price, Status, PaymentStatus, Time) SELECT TempOrders.IP, $payAfterTableNumber, TempOrders.ID, TempOrders.Item, TempOrders.Quantity, TempOrders.Price, 'Order Placed', 'Unpaid', now() FROM TempOrders WHERE TempOrders.IP = '$ip'";
							if (mysqli_query($conn, $sql)) {
								// If query successful, delete old/temporary order from TempOrders table where IP in TempOrders matches user's IP
								$sql = "DELETE FROM TempOrders WHERE IP = '$ip'";
								if (mysqli_query($conn, $sql)) {
									/* If delete query successful, display "We have received your order!" in the popup,
									with a msg prompting the user to call a waiter to pay after enjoying their meal */
									echo('<h5 id="receivedOrder">We have received your order!</h5>');
									echo('<h6 id="paymentLaterText">Call one of our waiters once you have enjoyed your meal to pay</h6>');
								} else {
									echo('<h5>Error Removing Order From Basket. Please request assistance from one of our waiters.</h5>');
									echo('<br>');
									echo(mysqli_error($conn));
									/* If this fails, print the SQL error from the connection and display "Error removing order from basket" */
								}
							} else {
								echo('<h5>Error Placing Order, Seek Assistance from one of our Waiters</h5>');
								echo('<br>');
								echo("Error: ".mysqli_error($conn));
								/* If this fails, print the SQL error from the connection and display "Error Placing Order" */
							}
						} else {
							echo('<h5>Can not place order!</h5>');
							echo('<h6>There are no items in your order</h6>');
							/* Robust code checking if there are no items to place the order */
						}
					} else if ((!empty($_POST['payAfterTableEntry']) || ($_POST['payAfterTableEntry'] == 0)) && isset($_POST['payAfterSubmitButton'])) {
						// If the table number is not between 1 and 10, but the table number entry form is not empty (or value inside is equal to 0) and submit has been pressed: 
						echo("<br>");
						echo("Please enter a valid table number (Tables 1 - 10)");
						/* If table number entry form is not empty but the number entered is invalid, print "Please enter a valid table number" */

					} else if (empty($_POST['payAfterTableEntry']) && isset($_POST['payAfterSubmitButton'])) {
						// Else, if the submit button has been pressed but the table number entry form is empty:
						echo("<br>");
						echo("Please enter a table number before placing your order (Tables 1 - 10)");
						/* If the submit is pressed with no entry, print "Please enter a table number before placing your order" */
					}
					?>
				</div>
			</div>
		</div>

	<!-- Div to generate the alert waiter popup -->
	<div id="alertWaiter" class="overlayAssistance">
		<a class="close" href="#">&times;</a>
		<div class="popupInfo">
			<h5>What is your table number?</h5><br>
			<input type="text" name="tableNumberEntry" />
			<input type="submit" name="submitTable" value="Submit" />

			<?php

				if (isset($_POST['submitTable']) && isset($_POST['tableNumberEntry'])) {
					/* In the alert waiter overlay's submit button and table entry form is set, do this: */
					$tableNumber = $_POST['tableNumberEntry'];
					$sql = "INSERT INTO TableAssistance (TableID, Time, WaiterName, Status) VALUES ('$tableNumber', now(), 'Not Assigned', 'Needs Assistance')";

					/* Insert into TableAssistance the table number, with 'Not Assigned' as the waiter assigned and 'Needs Assistance' as the status */
					if (mysqli_query($conn, $sql)) {
						/* If the query was successful, print "Our waiter have been informed that you require assistance" */
						echo('<br>');
						echo('<br>');
						echo('Success!');
						echo('<br>');
						echo('Our waiters have been informed that you require assistance, ');
						echo('please wait until a waiter has become available to assist you.');
					} else {
						echo "Error: ".mysqli_error($conn);
						/* If the SQL query failed, print the error message from the connection into the popup */
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
