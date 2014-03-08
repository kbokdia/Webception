<?php
session_start();
$store_id =0;
$store_name="";
$image_name = "";

if(isset($_SESSION['s_id']))
{
	if((isset($_POST['store_id'])) && (isset($_POST['store_name'])))
	{
		include("upload.php");
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
			
			$image_name = upload_image($_FILES,$location);

			if ($_POST['submitted'] == 1)
			{
				$sql = "INSERT INTO `product`(`name`, `product_model_no`, `category_id`, `price`, `product_image`, `product_key_features`, `product_description`,`customizable`, `store_id`, `user_id`) VALUES ('".$_POST['input_product_name']."','".$_POST['input_product_model_no']."',".$category_id.",".$product_price.",'".$image_name."','".$_POST['input_product_key_features']."','".$_POST['input_product_description']."',".$customizable.",".$store_id.",".$_SESSION['s_id'].")";
				
				if($result = mysqli_query($connection,$sql))
				{
					echo "created successfully ".$_POST['input_product_name'];
				}
			}

			if($_POST['submitted'] == 2)
			{
				$delete_file = "";
				$product_id = (int) $_POST['product_id'];
				$sql = "SELECT `product_image` FROM `product` WHERE product_id = ".$product_id;
				
				if($result = mysqli_query($connection,$sql))
				{
					$row = mysqli_fetch_array($result);
					$delete_file = $row["product_image"];
					if($image_name == "")
					{
						$image_name=$delete_file;
					}
					else
					{
						if(file_exists($delete_file)){unlink($delete_file);}
					}
				}

				$sql = "UPDATE `product` SET `name`='".$_POST['input_product_name']."',`product_model_no`='".$_POST['input_product_model_no']."',`category_id`=".$category_id.",`price`=".$product_price.",`product_image`='".$image_name."',`product_key_features`='".$_POST['input_product_key_features']."',`product_description`='".$_POST['input_product_description']."',`customizable`=".$customizable."  WHERE `product_id`=".$product_id.";";

				echo $sql;
				if($result = mysqli_query($connection,$sql))
				{
					echo "updated successfully... ".$category_id." ".$image_name;
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