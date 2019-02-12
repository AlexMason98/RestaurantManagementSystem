 <!-- Header -->
 <?php
 include_once '../../Header.php';
 ?>
 <!-- Header -->

 <section>
 	
 	<form method="post">
 		<div class="container-fluid">
 			<div class="row" id="row1">
 				<div class="col-lg-3 col-md-5 col-sm-6" id="left">

 					<div class="accordion" id="accordionExample">
 						<?php
 						include_once 'Categories.php';
 						?>
 						<?php
 						include_once 'DietaryRequirements.php';
 						?>

 					</div>
 				</div>
 				<div class="col-lg-9 col-md-7 col-sm-6 " id="right">
 					<?php
 					include_once 'ViewMenu.php';
 					?>
 				</div>
 			</div>
 		</div>
 	</form>
 </section>

 <!-- Footer -->
 <?php
 include_once '../footer.php';
 ?>
 <!-- Footer -->

