<!-- Header --> 
<?php

include_once '../../TAHeader.php';
?>
<!-- Header -->
<!DOCTYPE html>
<html>
<style>
	<?php include 'TAStylePage.css'; 
	// Calles the CSS files
	?>

</style>
<head>
	<title>Table Plan</title>
</head>
<body>
	<img src="TablePlan.png" id="TablePlan" width ="521" height ="241" ;>
	<!-- image for the layout of the table -->
	<form method="post">
		<h1>Table Plan</h1>
		<p>Click to claim a table<p>
		<?php
		include 'TableCheckbox.php';
		// call a file in the same folder
		?>
	</form>
</body>
</html>

<!-- Footer -->
<?php
include_once '../../footer.php';
?>
<!-- Footer-->