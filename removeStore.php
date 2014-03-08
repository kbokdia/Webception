<?php
require("functions.php");
session_start();
if(isset($_SESSION["s_id"]))
{
	if(isset($_GET["store"]) && isset($_GET["id"]))
	{
		$store = "users/".$_GET["store"];
		$id = $_GET["id"];
		
		if(delete_from_user_store($id))
		{	
			rrmdir($store);
			header("Location:index.php");
		}
		else
			echo "Cannot be deleted...";
	}
}
?>