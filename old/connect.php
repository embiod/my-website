<?php 
$servername = "localhost";
$username = "sayoneso_hybrid";
$password = "#emant@1994";
$dbname = "sayoneso_hybrid";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>