<?php
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';
$sql = "SELECT DISTINCT Sub_Category FROM menu";
$res = $conn->query($sql);
if($res-> num_rows == 0){
	echo "0 results";
}
else{
	echo "<select name='AddSubCategory[]'>";
	while($row = mysqli_fetch_assoc($res)){
		echo "<option value='{$row['Sub_Category']}'>{$row['Sub_Category']}</option>\n";
	}
	echo "</select>";
}
mysqli_close($conn);
?>
