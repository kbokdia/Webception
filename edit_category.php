<?php
session_start();
$category_id =0;
$row = array();
if(isset($_SESSION['s_id']))
{
	if(isset($_POST['category_id']))
	{
		$category_id = (int) $_POST['category_id'];
		include("header.php");
		$sql = "UPDATE category SET category_name = '".$_POST['category_name']."'WHERE id =".$category_id.";";
		if($result = mysqli_query($connection,$sql))
		{
			echo "Success";
			//header("Location:editStore.php?store_id=".$store_id."&store_name=".$store_name); 
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
