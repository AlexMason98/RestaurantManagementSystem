<?php
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';
session_start()
?>

<div class="row">
	<div class="col-lg-12 scrollit" id="DishesCol">
		<?php

///////////////////////////////////////////////////////////////////
/////////////         Starting SQL Query      ////////////////////
		$sql = "SELECT menu.ID, menu.Item, menu.ImagePath, menu.Price, DietaryRequirements.Item FROM Descriptions CROSS JOIN menu WHERE menu.ID = DietaryRequirements.ID ";
		
//////////////////////////////////////////////////////////////////
/////////////         Multiple Refinements     //////////////////

		$DietReqArray = $_POST['DietReq'];
		$DietReq = array();


		if(sizeof($DietReqArray)>0){
			foreach ($DietReqArray as $key => $value) {
				array_push($DietReq, $value. " = 'Yes' ");
			}
			$sql = $sql . " AND ";
			$sql .= join(" AND ", $DietReq);
		}		

////////////                                     ////////////////
////////////////////////////////////////////////////////////////	
		
		$res = $conn->query($sql);
		if($res-> num_rows == 0){
			echo "0 results";
		}
		else{

			while($row = mysqli_fetch_assoc($res)){

				$image = $row['ImagePath'];
				$id = $row['ID'];
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
									echo "{$row['Item']}";
									?>
								</p>
								<p id="priceText">Price: £
									<?php
									echo "{$row['Price']}";
									?>
								</p>
								<div class="quantityForm">
									<input type="text" name="quantity" value="1" class="form-control" />
								</div>
								<div class="itemBoxes">
									<input type="submit" name="add_to_cart" class="btn btn-success" value="Add to Cart" />

								</div>
							</div>
						</div>

					</div>


				</form>
				<?php
			}
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
