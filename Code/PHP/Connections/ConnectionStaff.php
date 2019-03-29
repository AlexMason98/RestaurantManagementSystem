<?php

//the information for the database connection 
$servername = "localhost";
$username = "root";
$password = "teamproject5";
$dbname = "staff";
// Create/checking connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	//returns and error message, when the connection is not made.
	die("Connection failed: " . $conn->connect_error);
}

?>
