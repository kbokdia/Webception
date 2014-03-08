<?php
$connection = mysqli_connect("localhost","u475058827_root","kamlesh");
	if(!$connection)
	{
		die(mysqli_error($connection));
	}

$db_select = mysqli_select_db($connection,"u475058827_test");
	if(!$db_select)
	{
		die(mysqli_errno());	
	}

?>