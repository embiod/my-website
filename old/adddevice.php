<?php
include("connect.php");

$sql = "INSERT INTO device (name, url) VALUES ('".$_POST['name']."','".$_POST['url']."')";
 //echo $sql;
// exit();
if ($conn->query($sql) === TRUE) {
  echo "<span style='color:green;'>New device created successfully";
} else {
	echo "<span style='color:red;'>Failed to add device";
}
//echo "Connected successfully";
