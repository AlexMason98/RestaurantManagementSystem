
<!-- Header -->
<?php
include_once '../../Header.php';
?>
<!-- Header -->

<section>
	<div class="container" id="MainContainer">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 scrollit">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<th width="40%">Item Name</th>
							<th width="10%">Quantity</th>
							<th width="20%">Price</th>
							<th width="15%">Total</th>
							<th width="5%">Action</th>
						</tr>
						<?php
						if(!empty($_SESSION["shopping_cart"]))
						{
							$total = 0;
							foreach($_SESSION["shopping_cart"] as $keys => $values)
							{
								?>
								<tr>
									<td><?php echo $values["item_name"]; ?></td>
									<td><?php echo $values["item_quantity"]; ?></td>
									<td>$ <?php echo $values["item_price"]; ?></td>
									<td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
									<td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
								</tr>
								<?php
								$total = $total + ($values["item_quantity"] * $values["item_price"]);
							}
							?>
							<tr>
								<td colspan="3" align="right">Total</td>
								<td align="right">$ <?php echo number_format($total, 2); ?></td>
								<td></td>
							</tr>
							<?php
						}
						?>
						
					</table>
				</div>
			</div>
			<div class="col-lg-8 col-md-7 col-sm-5"></div>
			<div  class="col-lg-4 col-md-5 col-sm-7">
				<table id="TotalPrice">
					<tr><td>Total Price</td></tr>
				</table>
				<table class="table table-striped table-bordered-less header">

					<?php

					require '/var/www/html/Harshdeep/PHP/Connections/ConnectionStaff.php';

						// header('Content-Type: text/html; charset=utf-8');
					$sql = "SELECT SUM(Price) AS Total FROM Orders";
					$res = $conn->query($sql);
					if($res-> num_rows == 0){
						echo "0 results";
					}
					else{
						while($row = mysqli_fetch_assoc($res)){
							echo "<tr><td>{$row['Total']}</td></tr>\n";
						}
					}
					mysqli_close($conn);
					?>
				</table>
			</div>
		</div>		
		<div class="row">
			<div class="col-lg-8 col-md-6 col-sm-4"></div>
			<div class="col-lg-4 col-md-6 col-sm-8">
				<button type="button" class="btn btn-success btn-lg" id="Pay" href="#">Pay</button>
				<button type="button" class="btn btn-danger btn-lg" id="Cancel" href="#" >Cancel</button>
			</div>
		</div>
	</div>
</section>

<!-- Footer -->
<?php
include_once '../../footer.php';
?>
<!-- Footer -->
