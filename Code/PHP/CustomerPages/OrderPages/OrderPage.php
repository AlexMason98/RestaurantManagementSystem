<!-- Header -->
<?php
include_once '../../Header.php';
require '/var/www/html/Alex/PHP/Connections/ConnectionCustomer.php';
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
							$sql = "SELECT * FROM TempOrders";
							$res = $conn->query($sql);
							if($res-> num_rows == 0){
								echo('<h3 id="noItems">There are no items in your basket</h3>');
							}
							else{
								while($row = mysqli_fetch_assoc($res)){
									echo "<tr><td>{$row['ID']}</td>\n";
									echo "<td>{$row['Item']}</td>\n";
									echo "<td>{$row['Quantity']}</td>\n";
									echo "<td>£{$row['Price']}</td></tr>\n";
								}
								$numberOfRows = mysqli_num_rows($res);
								$GLOBAL['numberOfRows'];
								echo($numberOfRows);
							}

							?>
						</table>
					</div>
				</div>
				<div class="col-lg-8 col-md-7 col-sm-5"></div>
				<div class="col-lg-4 col-md-5 col-sm-7">
					<table id="TotalPrice">
						<tr><td id="totalPriceText">Total Price</td></tr>
					</table>
					<table class="table table-striped table-bordered-less header">
						<?php
						$sql = "SELECT SUM(Quantity * Price) AS Total FROM TempOrders";
						$res = $conn->query($sql);
						if(is_null($res)) {
							echo('<tr><td id="orderPagePriceText">');
							echo('£0.00');
							echo('</td></tr>');
						} else {
							while($row = mysqli_fetch_assoc($res)){
								echo('<tr><td id="orderPagePriceText">');
								echo("£{$row['Total']}");
								echo('</td></tr>');
							}
						}

						?>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 col-md-6 col-sm-4"></div>
				<div class="col-lg-4 col-md-6 col-sm-8">
					<input type="submit" class="btn btn-success btn-lg" name="Pay" value="Pay" href="#" />
					<a class="btn btn-danger btn-lg" href="#popupCancelItems">Cancel Order</a>
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
								mysqli_query($conn, $sql);
								//echo("<h6>Successfully Cancelled Order</h6>");

								// I use this so that the popup closes and the page refreshes so that basket is shown empty
								header("Refresh:0; url=OrderPage.php", true, 303);
							} else if (isset($_POST['No'])) {
								// I use this so that the popup closes and the page refreshes, showing the items still in basket
								header("Refresh:0; url=OrderPage.php", true, 303);
							}
						} else if ($numberOfRows == 0) {
							echo('<h5 id="cannotCancel">Can not cancel order. There are no items to remove from your basket</h5>');
						} else {
							echo('<h5 id="errorRemoving">ERROR: Could not remove all items from basket</h5>');
						}
					?>
				</div>		
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
