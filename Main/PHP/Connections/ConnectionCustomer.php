<?php
//this is the information for the database
$servername = "localhost";
$username = "root";
$password = "teamproject5";
$dbname = "customer";
// Create/checking connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	//if the connection does not work it returns an error.
	die("Connection failed: " . $conn->connect_error);
}

?>
