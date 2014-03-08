<?php
function upload_image($arr_image,$location)
{
	include("function_random_string.php");
	$image_location = "";
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $arr_image["file"]["name"]);
	$extension = end($temp);
	if ((($arr_image["file"]["type"] == "image/gif")
	|| ($arr_image["file"]["type"] == "image/jpeg")
	|| ($arr_image["file"]["type"] == "image/jpg")
	|| ($arr_image["file"]["type"] == "image/pjpeg")
	|| ($arr_image["file"]["type"] == "image/x-png")
	|| ($arr_image["file"]["type"] == "image/png"))
	&& ($arr_image["file"]["size"] < 512000)
	&& in_array($extension, $allowedExts))
	{
		if ($arr_image["file"]["error"] > 0)
	    {
	 		echo "Return Code: " . $arr_image["file"]["error"] . "<br>";
	    }	  
	    else
	    {
	    	$image_location = $location.random_string(10).$arr_image["file"]["name"];
	    	move_uploaded_file($arr_image["file"]["tmp_name"], $image_location);	    	
	    }
	    
	}
	else
	{
	  echo "Invalid file";
	}

	  return $image_location;
}
?>