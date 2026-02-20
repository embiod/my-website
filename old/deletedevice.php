<?php
include("connect.php");

$sql = "delete from device where id = ".$_POST['id'];
//  echo $sql;
// exit();
if ($conn->query($sql) === TRUE) {
  echo "<span style='color:green;'>Device deleted successfully";
} else {
	echo "<span style='color:red;'>Failed to delete device";
}
//echo "Connected successfully";
