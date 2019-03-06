<!DOCTYPE html>
<html>


<body>

<?php
	$servername = "localhost";
	$username = "username";
	$password = "password";

	$conn = new mysqli($servername, $username, $password);

	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 
	echo "Connected successfully";

	$button1 = "Delete from databsename where customertable = '1'";

	if ($conn->query($sql) === TRUE) {
    	echo "Record deleted successfully";
	} else {
    	echo "Error deleting record: " . $conn->error;
}

$conn->close();

?>

</body>


</html>