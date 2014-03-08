<?php
require_once("header.php");
function insert_into_user_store($name,$user_id)
{
	global $connection;
	$sql = "INSERT INTO `user_store`(`store_name`, `user_id`) VALUES ('".$name."',".$user_id.");";
	if($result = mysqli_query($connection,$sql))
		return true;
	else
		return false;
}

function insert_into_basic_store_info($user_id,$store_id,$store_title,$description,$email,$mobile)
{
	global $connection;
	$sql= "INSERT INTO `basic_store_info`(`user_id`, `store_id`, `store_title`, `store_desc`, `email`, `mobile`) VALUES (".$user_id.",".$store_id.",'".$store_title."','".$description."','".$email."','".$mobile."');";
	if($result = mysqli_query($connection,$sql))
	{
		if(mysqli_affected_rows($connection)>0)
		{
			return true;	
		}
		else
		{
			return false;	
		}
	}
}


function get_user_store()
{
	global $connection;
	$a = array();
	$sql = "SELECT * FROM user_store;";
	if($result = mysqli_query($connection,$sql))
	{
		while($row = mysqli_fetch_array($result))
		{
				array_push($a,$row);
		}
	}
	return $a;
}

function get_store_id($name)
{
	$store_found = false;;
	$stores = get_user_store();
	for($i=0;$i<count($stores);$i++)
	{
		if($stores[$i]["store_name"] == $name)
		{
			$store_found = true;
			$store_id = $stores[$i]["store_id"];
			break;	
		}
		else
			$store_found = false;
	}
	if($store_found)
		return $store_id;
	else
		return 0;	
}

function rrmdir($dir)
{
  if (is_dir($dir)) 
  {
    $objects = scandir($dir);
    foreach ($objects as $object) 
	{
      if ($object != "." && $object != "..") 
	  {
        if (filetype($dir."/".$object) == "dir") 
           rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }
 
function delete_from_user_store($id)
{
	global $connection;
	$sql = "DELETE FROM `user_store` WHERE store_id = ".$id;
	if($result = mysqli_query($connection,$sql))
	{
		$sql = "DELETE FROM `basic_store_info` WHERE store_id = ".$id;
		if($result = mysqli_query($connection,$sql))
		{
			$sql = "DELETE FROM `category` WHERE store_id = ".$id;
			if($result = mysqli_query($connection,$sql))
			{
				$sql = "DELETE FROM `product` WHERE store_id = ".$id;
				if($result = mysqli_query($connection,$sql))
				{
					return true;
				}
			}
		}
	}
	else
		return false;
}

function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with underscore.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>