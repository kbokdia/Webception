<?php
session_start();
$store_id = 0;
$store_name = "";
$row = array();
if(isset($_SESSION["s_id"]))
{
	if(isset($_POST["store_id"])) 
	{
		$store_id = (int) $_POST["store_id"];
//		$store_name = $_POST["store_name"];
		include("header.php");

		include("addslashes_to_POST.php");

		$sql = "UPDATE `basic_store_info` SET `store_title` = '".$_POST['store_title']."' WHERE `store_id` = ".$store_id.";";
		$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
		if($result === false)
		{
			echo "Query Failed ". mysqli_error($connection);
			exit; 	
		}		
	}
	else
	{
		header("Location:index.php");
		exit;		
	}	
}
else
{
	header("Location:index.php");
	exit;
}
?>
