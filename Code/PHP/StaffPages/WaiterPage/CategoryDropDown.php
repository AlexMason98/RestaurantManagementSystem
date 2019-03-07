<?php
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';
$sql = "SELECT DISTINCT Category FROM menu GROUP BY Category";
$res = $conn->query($sql);
if($res-> num_rows == 0){
	echo "0 results";
}
else{
	echo "<select name='AddCategory[]'>";
	while($row = mysqli_fetch_assoc($res)){
		echo "<option value='{$row['Category']}'>{$row['Category']}</option>\n";
	}
	echo "</select>";
}
mysqli_close($conn);
?>
