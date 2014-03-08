<?php
require_once("header.php");
$q = $_GET['q'];
$sql = "SELECT username FROM  `user` ;";
$result = mysqli_query($connection,$sql);
$found = TRUE;
if(mysqli_num_rows($result) < 1)
	$found=false;
while($row = mysqli_fetch_array($result))
{
	if($row['username'] == $q)
	{
		$found = TRUE;
		break;	
	}
	else
		$found = FALSE;
}

if($found)
	echo "Unavailable";
else
	echo "Available";
	
mysqli_close($connection);
?>