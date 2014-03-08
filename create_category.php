<?php
session_start();
$store_id =0;
$store_name="";
$image_name = "";

include("function_random_string.php");

if(isset($_SESSION['s_id']))
{
	if((isset($_POST['store_id'])) && (isset($_POST['store_name'])))
	{
		include("addslashes_to_POST.php");
		$store_id = (int) $_POST["store_id"];
		$store_name = $_POST["store_name"];
		$category_name = $_POST['category_name'];
		include("header.php");
		if (isset($_POST['submitted'])) 
		{
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 2000000)
			&& in_array($extension, $allowedExts))
			{
				if($_FILES["file"]["error"] > 0)
				{
					echo "Error... ". $_FILES["file"]["error"]."<br />";
				}
				else
				{
					$image_name = "users/".$store_name."/images/".random_string(10).$_FILES["file"]["name"];
					move_uploaded_file($_FILES["file"]["tmp_name"], $image_name);
				}
			}
			if($_POST['submitted'] == 1)
			{
				$sql="INSERT INTO `category`(`store_id`, `category_name`, `category_image`) VALUES (".$store_id.",'".$category_name."','".$image_name."');";
				if($result = mysqli_query($connection,$sql))
				{
					echo "created successfully ".$category_name;
				}
			}
			if($_POST['submitted'] == 2)
			{
				$delete_file = "";
				$category_id = (int) $_POST['category_id'];
				$sql = "SELECT `category_image` FROM `category` WHERE id = ".$category_id;
				
				if($result = mysqli_query($connection,$sql))
				{
					$row = mysqli_fetch_array($result);
					$delete_file = $row["category_image"];
					if($image_name == "")
					{
						$image_name=$delete_file;
					}
					else
					{
						if(file_exists($delete_file)){unlink($delete_file);}
					}
				}
				$sql = "UPDATE `category` SET `category_name`='".$category_name."',`category_image`='".$image_name."' WHERE `id`=".$category_id.";";
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