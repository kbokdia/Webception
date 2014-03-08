<?php
session_start();
require("functions.php");
$store_id = 0;
$store_name = "";
if(isset($_SESSION["s_id"]))
{
	if(isset($_POST["store_name"]))
	{
		$store_found = false;
		$store_name = $_POST["store_name"];
		$store_name = addslashes($store_name);
		$stores = get_user_store();
		for($i=0;$i<count($stores);$i++)
		{
			if(strcasecmp($stores[$i]["store_name"], $store_name) == 0)
			{
				$store_found = true;
				break;	
			}
			else
				$store_found = false;
		}
		if(!$store_found)
		{
			insert_into_user_store($store_name,$_SESSION["s_id"]);	
			mkdir("users/".$store_name,0755);
			mkdir("users/".$store_name."/images",0755);
			$store_id = get_store_id($store_name);
			if(insert_into_basic_store_info($_SESSION['s_id'],$store_id,"Enter Title","About Us","example@eg.com","9123456789"))
			{
				header("Location:editStore.php?store_id=".$store_id."&store_name=".$store_name);
			}
			else
				echo "Insertion Error in BASIC INFO...";
		}
		else
		{
			header("Location:index.php?store_found=".$store_found);
			exit;
		}
	}
}
else
{
	header("Location:index.php");
	exit;
}
?>
