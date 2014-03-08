<?php
session_start();
$store_id =0;
$store_name="";
$image_name = "";

if(isset($_SESSION['s_id']))
{
	if((isset($_POST['store_id'])) && (isset($_POST['store_name'])))
	{
		include("addslashes_to_POST.php");
		$store_id = (int) $_POST["store_id"];
		$store_name = $_POST["store_name"];
		$category_id =(int) $_POST['category_id'];
		$product_price = (int) $_POST['input_product_price'];
		$location = "users/".$store_name."/images/";
		$customizable = 0;

		if(isset($_POST['customize_product']))
			$customizable = 1;

		include("header.php");

		if (isset($_POST['submitted']))
		{
			include("upload.php");
			$image_name = upload_image($_FILES,$location);

			if ($_POST['submitted'] == 1)
			{
				$sql = "INSERT INTO `product`(`name`, `product_model_no`, `category_id`, `price`, `product_image`, `product_key_features`, `product_description`,`customizable`, `store_id`, `user_id`) VALUES ('".$_POST['input_product_name']."','".$_POST['input_product_model_no']."',".$category_id.",".$product_price.",'".$image_name."','".$_POST['input_product_key_features']."','".$_POST['input_product_description']."',".$customizable.",".$store_id.",".$_SESSION['s_id'].")";
				
				if($result = mysqli_query($connection,$sql))
				{
					echo "created successfully ".$_POST['input_product_name'];
				}
			}
		}
		else
		{
			exit;
		}
	}
	else
	{
		exit;		
	}	
}
else
{
	exit;		
}	
?>