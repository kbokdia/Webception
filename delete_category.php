<?php
session_start();
if(isset($_SESSION['s_id']))
{
	if(isset($_POST['id']))
	{
		$id = (int) $_POST['id'];
		$delete_image = $_POST['image'];
		$table_name = $_POST['table_name'];
		$where_variable = $_POST['where_variable'];

		if(file_exists($delete_image)){unlink($delete_image);}

		include("header.php");

		$sql = "DELETE FROM `".$table_name."` WHERE `".$where_variable."` = ".$id.";";
		//echo $sql;
		if($result = mysqli_query($connection,$sql))
		{
			echo "Success";
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