<div class="card">
	<div class="card-header" id="headingTwo">
		<h2 class="mb-0">
			<!-- drop down button for the Dietary Requirements -->
			<button class="btn btn-lg" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="dropDown">
				Dietary Requirements
			</button>
		</h2>
	</div>
	<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
		<div class="card-body">
			<!-- printing the checkboxes for each of the refinements. Furthoermore, the it checks if the checkbox is checked and it checks the checkbox checked until it is unchecked. -->
			<input type="checkbox" name="DietReq[]" id="Vegetarian" value="Vegetarian" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'Vegetarian'){ echo "checked";}}} ?> > Vegetarian<br>

			<input type="checkbox" name="DietReq[]" id="Vegan" value="Vegan" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'Vegan'){ echo "checked";}}} ?>  > Vegan<br>

			<input type="checkbox" name="DietReq[]" id="GlutenFree" value="GlutenFree" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'GlutenFree'){ echo "checked";}}} ?> > Gluten Free<br>

			<input type="checkbox" name="DietReq[]" id="ContainsEgg" value="ContainsEgg" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsEgg'){ echo "checked";}}} ?> > Doesn't Contain Egg<br>

			<input type="checkbox" name="DietReq[]" id="ContainsMilk" value="ContainsMilk"<?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsMilk'){ echo "checked";}}} ?> > Doesn't Contain Milk<br>

			<input type="checkbox" name="DietReq[]" id="ContainsPeanuts" value="ContainsPeanuts" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsPeanuts'){ echo "checked";}}} ?> > Doesn't Contain Peanuts<br>

			<input type="checkbox" name="DietReq[]" id="ContainsTreeNuts" value="ContainsTreeNuts" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsTreeNuts'){ echo "checked";}}} ?> > Doesn't Contain Nuts<br>

			<input type="checkbox" name="DietReq[]" id="ContainsCelery" value="ContainsCelery" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsCelery'){ echo "checked";}}} ?> > Doesn't Contain Celery<br>

			<input type="checkbox" name="DietReq[]" id="ContainsFish" value="ContainsFish" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsFish'){ echo "checked";}}} ?> > Doesn't Contain Fish<br>

			<input type="checkbox" name="DietReq[]" id="ContainsCrustaceans" value="ContainsCrustaceans"  <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsCrustaceans'){ echo "checked";}}} ?> > Doesn't Contain Crustaceans<br>

			<input type="checkbox" name="DietReq[]" id="ContainsMolluscs" value="ContainsMolluscs"  <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsMolluscs'){ echo "checked";}}} ?> > Doesn't Contain Molluscs<br>

			<input type="checkbox" name="DietReq[]" id="ContainsMustard" value="ContainsMustard" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsMustard'){ echo "checked";}}} ?> > Doesn't Contain Mustard<br>

			<input type="checkbox" name="DietReq[]" id="ContainsSoya" value="ContainsSoya" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsSoya'){ echo "checked";}}} ?> > Doesn't Contain Soya<br>

			<input type="checkbox" name="DietReq[]" id="ContainsSulphites" value="ContainsSulphites" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsSulphites'){ echo "checked";}}} ?> > Doesn't Contain Sulphites<br>

			<input type="checkbox" name="DietReq[]" id="ContainsSesameSeeds" value="ContainsSesameSeeds" <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsSesameSeeds'){ echo "checked";}}} ?> > Doesn't Contain Sesame Seeds<br>

			<input type="checkbox" name="DietReq[]" id="ContainsLupin" value="ContainsLupin"  <?php if(sizeof($_POST['DietReq'])>0){
			foreach ($_POST['DietReq'] as $key => $value) {if($value == 'ContainsLupin'){ echo "checked";}}} ?> > Doesn't Contain Lupin<br>
			<!-- Submite button which send the information as a post method. -->
			<br><input type="Submit" value="Submit">

		</div>
	</div>
</div>
