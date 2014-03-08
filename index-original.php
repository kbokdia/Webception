<?php
session_start();	
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Webception</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/avgrund.css">
<style>
html,body 
{
	height: 100%;
}
html 
{
	background-color: #222;
	background-repeat: repeat;
}
</style>
<!--<link href="css/bootstrap-responsive.css" rel="stylesheet" />-->
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.js"></script>
<script type='text/javascript' src='js/avgrund.js'></script>
<script>
	function check()
	{
		if(document.getElementById("store_name").value == "")
		{
			document.getElementsByName("store_name")[0].placeholder = "Enter store name...";
			return false;
		}
		else
		{
			Avgrund.hide();
			return true;
		}
	}
	
	function openDialog() {
		Avgrund.show( "#default-popup" );
	}
	function closeDialog() {
		Avgrund.hide();
	}
</script>
</head>
<?php
$store_alert = "";
$hasStore = false;
$store = "";
if(isset($_SESSION["s_username"]))
{
	require("functions.php");
	$counter = 0;
	$stores = get_user_store();
	$store="<table class='table table-striped'><thead><th style='text-align:center;'>#</th><th style='text-align:center;'>Stores</th><th></th><th></th></thead><tbody>";
	for($i=0;$i<count($stores);$i++)
	{
		if($stores[$i]["user_id"] == $_SESSION["s_id"])
		{
			$store .= "<tr><td>".(++$counter)."</td><td>".$stores[$i]["store_name"]."<td><a href='editStore.php?store_id=".$stores[$i]["store_id"]."&store_name=".$stores[$i]["store_name"]."' class='btn btn-success btn-xs'>Edit</a></td><td><a href='removeStore.php?id=".$stores[$i]["store_id"]."&store=".$stores[$i]["store_name"]."' class='btn btn-danger btn-xs'>Delete</a></td></tr>";
			$hasStore = true;
		} 
	}
	if($hasStore)
		$store .= "</tbody></table>";
	else
		$store = "";
	if(isset($_GET["store_found"]))
	{
		if($_GET["store_found"] == 1)
		{
			$store_alert = "<div class='alert alert-danger'>Store name not available</div>";
		}
	}
	
		$store .="<button tabindex='1' onclick='javascript:openDialog();' class='btn btn-lg btn-primary'>Create Store</button>";	

	$str = "<body style='padding-top:80px;'>
	<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
	<div class='container'>
		<div class='navbar-header'>
			<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
			  <span class='sr-only'>Toggle navigation</span>
			  <span class='icon-bar'></span>
			  <span class='icon-bar'></span>
			  <span class='icon-bar'></span>
			</button>
			<a class='navbar-brand' href='index.php'>			
				<label>
				    <font face='Lucida Sans Unicode' color='#ffffff' size='+2'>[</font>
					<font face='Lucida Sans Unicode' color='#3a5c9b' size='+2'>Web</font>
					<font face='Lucida Sans Unicode' color='#ffffff' size='+2'>]</font>
					<font face='Lucida Sans Unicode' color='#ff6c00' size='+2'>ception</font>
				</label>
			</a>
	  </div>
	  
	  <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
		<ul class='nav navbar-nav navbar-right'>
		  <li class='dropdown'>
			<a href='#' class='dropdown-toggle' data-toggle='dropdown'>".ucwords($_SESSION["s_name"])."<b class='caret'></b></a>
			<ul class='dropdown-menu'>
			  <li><a href='logout.php'>Logout</a></li>
			</ul>
		</ul>
	 
	</div>
	</div>
	</nav>	
	<aside id='default-popup' class='avgrund-popup'>
		<form action='createStore.php' method='post' onSubmit='return check()'>
			<h4>Enter Store name:</h4>
			<input type='text' id='store_name' name='store_name' tabindex='2'/><br/><br/>
			<div id='error'></div>
            <button type='submit' tabindex='3' class='btn btn-primary'>Create</button>
			<button onclick='javascript:closeDialog();' class='btn btn-danger'>Close</button>
        </form>
	</aside>
	<div class='container avgrund-contents'>".$store_alert."<div class='text-center'>".$store."</div>
	</div>	
	</body>";
	echo $str;
}
else
{
	$str ="<body style='padding-top:40px;'>

<div class='navbar-wrapper'>

		<div class='container'>
		<br>
	<div class='navbar navbar-inverse' role='navigation'>
	
	<div class='navbar-inner'>
    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
      <span class='sr-only'>Toggle navigation</span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>
    <a class='navbar-brand' href='index.php'>
	<font face='Brush Script MT' color='#3a8ab5' size='+3'>W</font>
	<font face='Colonna MT' color='#3a8ab5' size='+1'>ebception</font></a>
  </div>
  
  <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
  <ul class='nav navbar-nav navbar-right'>
  		<li class=''><a href='#'>About Us</a></li>
		<li class=''><a href='contact.php'>Contact Us</a></li>
		<li><a href='login.php'>Login</a></li>
	</ul>
   </div>
   </div>
	</div>
	</div>
	<br/>
	<br/>
	<div class='text-center'>
		<iframe id='ytplayer' type='text/html' width='780' height='438.75'
		src='https://www.youtube.com/embed/8QxhiDTdmiQ?rel=0&showinfo=0&autohide=1'
		frameborder='0' allowfullscreen>
	</div>
	<div class='text-right'><br><br><br><br><br><br><br><br><br><br><br>
		<a href='http://www.facebook.com'><img src='images/facebook.gif' alt='facebook' class='img-circle' height='25' width='25' />
		<a href='http://www.twitter.com'><img src='images/Twitter.gif' alt='twitter' class='img-circle' height='25' width='25' />
	</div>
</body>";
	echo $str;	
}
?>

</html>
