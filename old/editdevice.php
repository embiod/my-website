<?php
include("connect.php");

$sql = "update device set name='".$_POST['name']."', url='".$_POST['url']."' where id = ".$_POST['id'];
//  echo $sql;
// exit();
if ($conn->query($sql) === TRUE) {
  echo "<span style='color:green;'>Device updated successfully";
} else {
	echo "<span style='color:red;'>Failed to update device";
}
//echo "Connected successfully";
