<?php

?>


<div id="<?php echo($popup); ?>" class="overlay">
	<div class="popup">
		<h5 id="itemInformation">Item Information</h5>
		<a class="close" href="#">&times;</a>
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