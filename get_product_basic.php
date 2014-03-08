<?php
session_start();
$store_id =0;
$store_name="";
if(isset($_SESSION['s_id']))
{
	if(isset($_GET['store_id']))
	{
		$store_id = (int) $_GET["store_id"];
//		$store_name = $_GET["store_name"];
		include("header.php");
		$sql = "SELECT product_id, name, category_id, product_image FROM `product` WHERE `store_id` =".$store_id;
		$rs = array();
		if($result = mysqli_query($connection,$sql))
		{
			while($row=mysqli_fetch_array($result))
			{
				array_push($rs,$row);
			}
			
			echo json_encode($rs);
		}
		else
			echo "None";
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