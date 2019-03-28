<!-- Header -->
<?php

include_once '../../TAHeader.php';
?>
<!-- Header -->
<!DOCTYPE html>
<html>
<style>
	<?php include 'TAStylePage.css'; ?>
</style>
<head>
	<title>Table Plan</title>
</head>

<body>
	<img src="TablePlan.png" id="TablePlan" width ="521" height ="241" ;>
	<form method="post">
		<h1>Table Plan</h1>
		<p>Click to claim a table<p>
		<?php
		include 'TableCheckbox.php';
		?>
	</form>
</body>
</html>

<!-- Footer -->
<?php
include_once '../../footer.php';
?>
<!-- Footer -->