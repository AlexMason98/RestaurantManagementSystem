<?php 
require '/var/www/html/Harshdeep/PHP/Connections/ConnectionCustomer.php';	 
$sql = "SELECT menu.Price, DietaryRequirements.Item FROM DietaryRequirements CROSS JOIN menu WHERE ContainsEgg = 'Yes' AND menu.ID = DietaryRequirements.ID ";
$res = $conn->query($sql);
if($res-> num_rows == 0){
	echo "0 results";
}
else{
	echo $res-> num_rows;
	while($row = mysqli_fetch_assoc($res)){
		echo "<tr><td>{$row['Item']}</td>\n";
		echo "<td>{$row['Price']}</td></tr>\n";

	}
}
?>