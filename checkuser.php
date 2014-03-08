<?php
require_once("header.php");
session_start();
$found = false;
if(isset($_POST['username']))
{
	$username = $_POST['username'];
	if(isset($_POST['password']))
	{
		$password = sha1($_POST['password']);
		$sql = "SELECT * FROM  `user` ;";
		$result = mysqli_query($connection,$sql);
		$found = FALSE;
		while($row = mysqli_fetch_array($result))
		{	
			if($row['username'] == $username)
			{
				if($row['password'] == $password)
				{	
					$found = TRUE;
					session_regenerate_id();
					$_SESSION['s_username'] = $username;
					$_SESSION['s_name'] = $row['name'];
					$_SESSION['s_id'] = $row['id'];
					header("Location:index.php");
					break;
				}
				break;	
			}
			else
				$found = FALSE;
		}
		if(!$found)
			header("Location:index.php?error=Incorrect");
	}
}
mysqli_close($connection);
?>