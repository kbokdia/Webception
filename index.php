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
table
{
	font-size: 16px;
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
$str_login_error="";
$store_alert = "";
$hasStore = false;
$store = "";
if(isset($_GET['error']))
	$str_login_error="<div class='alert alert-danger'>Incorrect username or password</div>";
if(isset($_SESSION["s_username"]))
{
	require("functions.php");
	
	$counter = 0;
	$stores = get_user_store();
	$store="<table class='table table-striped'><thead><th style='text-align:center;'>#</th><th style='text-align:center;'>Stores</th><th></th><th></th></thead><tbody>";
	for($i=0;$i<count($stores);$i++)
	{
		$disable_store_view ="disabled";
		if($stores[$i]["user_id"] == $_SESSION["s_id"])
		{
			$fileName = "users/".$stores[$i]['store_name']."/index.php";
			if(file_exists($fileName)){
				$disable_store_view = "";
			}

			$store .= "<tr><td>".(++$counter)."</td><td>".$stores[$i]["store_name"]."</td><td><a href='users/".$stores[$i]['store_name']."/' class='btn btn-primary btn-xs' ".$disable_store_view.">View</a></td><td><a href='editStore.php?store_id=".$stores[$i]["store_id"]."&store_name=".$stores[$i]["store_name"]."' class='btn btn-success btn-xs'>Edit</a></td><td><a href='removeStore.php?id=".$stores[$i]["store_id"]."&store=".$stores[$i]["store_name"]."' class='btn btn-danger btn-xs'>Delete</a></td></tr>";
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
	<footer class='navbar navbar-default navbar-fixed-bottom'>
		<div class='container'>			
			<ul class='nav navbar-nav navbar-right'>
				<li><a href='http://www.facebook.com/pages/Webception/1412431758999729?ref=hl'><img src='images/facebook.gif' alt='facebook' style='border-radius:30px; height:30px ; width:30px'/></a></li>
				<li><a href='http://www.twitter.com'><img src='images/Twitter.gif' alt='twitter' style='border-radius:30px; height:30px ; width:30px'/></a></li>
			</ul>
		</div>
	</footer>	
	</body>";
	echo $str;
}
else
{
	$str ="<body style='padding-top:80px; padding-bottom:70px;'>

<div class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
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
		  		<li class=''><a href='#'>About Us</a></li>
				<li class=''><a href='contact.php'>Contact Us</a></li>
				<li><a href='#signup' class='btn' data-toggle='modal' data-target='.bs-modal-sm'>Login</a></li>
			</ul>  
   		</div>
   	</div>
</div>
<div class='container'>".$str_login_error ."	
	
	<div class='row'>
		<div class='col-xs-12'>
			<div style='margin: 0 auto;text-align:center;'>		
			<iframe width='100%' height='480px' src='//www.youtube.com/embed/-Gokn8xVi-w?wmode=transparent&rel=0&showinfo=0&autohide=1' frameborder='0'></iframe>
			</div>
		</div>
	</div>
	
</div>	
	<footer class='navbar navbar-default navbar-fixed-bottom'>
		<div class='container'>			
			<ul class='nav navbar-nav navbar-right'>
				<li><a href='http://www.facebook.com/pages/Webception/1412431758999729?ref=hl'><img src='images/facebook.gif' alt='facebook' style='border-radius:30px; height:30px ; width:30px'/></a></li>
				<li><a href='http://www.twitter.com'><img src='images/Twitter.gif' alt='twitter' style='border-radius:30px; height:30px ; width:30px'/></a></li>
			</ul>
		</div>
	</footer>	

</body>";
	echo $str;	
}
?>
<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-sm">
    	<div class="modal-content">        
	      	<div class="modal-body">
	      		<br />
	      		<ul id='myTab' class='nav nav-tabs'>
	              <li class='active'><a href='#signin' data-toggle='tab'>Sign In</a></li>
	              <li><a href='#signup' data-toggle='tab'>Register</a></li>
	              <li><a href='#why' data-toggle='tab'>Why?</a></li>
	            </ul>
	            <div id="myTabContent" class="tab-content" style="padding-top: 20px;">
			        <div class="tab-pane fade in" id="why">
			        <p>We need this information so that you can receive access to the site and its content. Rest assured your information will not be sold, traded, or given to anyone.</p>
			        <p></p><br> Please contact <a mailto:href="webception@gmail.com"></a>Webception@gmail.com</a> for any other inquiries.</p>
			    	</div><!--close why-->
			    	<div class="tab-pane fade active in" id="signin">
			            <form class="form-horizontal" action="checkuser.php" method="post" role="form">
			            <fieldset>
			            <!-- Sign In Form -->
			            
			            <!-- Image -->
			            <div class="contol-group">
			            <center>
			            <img src="images/avatar_2x.png" style="border-radius:100px; height:100px ; width:100px"  />
			            </center>
			            </div>
			            <!-- Text input-->
			            <div class="control-group">
			              <!--<label class="control-label" for="username">Username:</label>-->
			              <div class="controls">
			                <input required id="username" name="username" type="text" class="form-control" placeholder="Username" class="input-medium" required="" style="border-top-left-radius: 5px; margin-top:10px; height:44px;border-top-right-radius: 5px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;">
			              </div>
			            </div>

			            <!-- Password input-->
			            <div class="control-group">
			              <!--<label class="control-label" for="passwordinput">Password:</label>-->
			              <div class="controls">
			                <input required id="password" name="password" class="form-control" type="password" placeholder="Password" class="input-medium" style="border-bottom-left-radius: 5px; margin-top: 0px; height:44px;border-bottom-right-radius: 5px;border-top-left-radius: 0px;border-top-right-radius: 0px;border-top: 1px;">
			              </div>
			            </div>

			            <!-- Multiple Checkboxes (inline) -->
			            <div class="control-group">
			              <label class="control-label" for="rememberme"></label>
			              <div class="controls">
			                <label class="checkbox inline" for="rememberme-0" style="margin-top:-5px">
			                  <input type="checkbox" name="rememberme" id="rememberme-0" value="Remember me" >Remember me
			        </label>
			              </div>
			            </div>

			            <!-- Button -->
			            <div class="control-group">
			              <label class="control-label" for="signin"></label>
			              <div class="controls">
			              <center>
			                <button id="signin" name="signin" class="btn btn-success" style="width:260px">Sign In</button>
			              </center>
			              </div>
			            </div>
			            </fieldset>
			            </form>
			        </div><!--close signin-->
			        <div class="tab-pane fade" id="signup">
			          <form class="form-horizontal" method="post" action="login.php" id="signup_form" role="form">
			            
			            <!-- Sign Up Form -->
			            <!-- Name -->
			            <div class="row">
			              <div class="col-md-11 col-xs-11 col-sm-11">
			                <input id="name" name="clientName" class="form-control" type="text" placeholder="Name" class="input-large" required="required" style="border-radius:0px; height:44px">
			              </div>
			            </div>
			              
			            <!-- Email input-->
			            <div class="row">
			              <div class="col-md-11 col-xs-11 col-sm-11">
			                <input id="Email" name="clientEmail" class="form-control" type="email" placeholder="Email Address" class="input-large" required="required" style="border-radius:0px; height:44px; margin-top:-1px" title="johndoe@example.com">
			              </div>
			            </div> 
			            
			            
			            <!-- Username input-->
			            <div class="row">
			              <div class="col-md-11 col-xs-11 col-sm-11">
			                <input id="signup_username" name="username" class="form-control" type="text" placeholder="Username" class="input-large" required="required" style="border-radius:0px; margin-top:-1px; height:44px;">
			              </div> 
			              <div class="col-xs-1 col-sm-1 col-md-1" id="check_username" style="padding: 5px">
			                
			              </div>
			            </div>
			            
			            <!-- Password input-->
			            <div class="row">
			              <div class="col-md-11 col-xs-11 col-sm-11">
			                <input id="signup_password" name="password" class="form-control" type="password" placeholder="Password        (Min 8 Characters)" class="input-large" required="required" style="border-radius:0px; margin-top:-1px; height:44px" pattern="^.{6,15}$" title="minimum: (6 characters) maximum: (15 characters)">
			              </div>
			               <div class="col-xs-1 col-sm-1 col-md-1" id="check_password" style="padding: 5px">
			                
			              </div>
			            </div>
			            
			            <!-- Re-enter password input-->
			            <div class="row">
			              <div class="col-md-11 col-xs-11 col-sm-11">
			                <input id="reenterpassword" class="form-control" name="reenterpassword" type="password" placeholder="Re-Enter Password" class="input-large" required="required" style="border-radius:0px; margin-top:-1px; height:44px" pattern="^.{6,15}$">
			              </div> 
			               <div class="col-xs-1 col-sm-1 col-md-1" id="check_reenterpassword" style="padding: 5px">
			                
			              </div>     
			            </div>
			             	            
			            <!-- Button -->
			            
			              <center>
			              <input type="submit" id="submit_signup" class="btn btn-success" value="Sign up" style="margin-top:20px; width:260px"/>
			              </center>

			       		 </form>

			        </div><!--close sign-up-->
			    <div><!--close myTabContent-->
	    	</div><!--close modal-body-->
	    	<div class="modal-footer">
		      <center>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </center>
		    </div><!--close footer-->
		</div><!--close modal-content-->
  </div><!--close modal-dialog-->
</div><!--close modal-->
<script type="text/javascript">
  var ok_sign = "<span class='glyphicon glyphicon-ok-circle' style='font-size: 15px; color: green;'></span>";
  var remove_sign ="<span class='glyphicon glyphicon-remove-circle' style='font-size: 15px; color:red;'></span>";
  var is_username_available = false;

  function check_signup_username()
  {
      var username = $("#signup_username").val();
      if (username == "") {return false;};
      for(var i=0; i<username.length;i++)
      {
        if(username[i] == " ")
          return false; 
      }
      return true;
  }

  function check_password_fn(event)
  {
    $("#check_password").empty();
    var temp = $("#signup_password").val();
    if (temp.length > 6 && temp.length < 16)
    {
      $("#check_password").append(ok_sign);
    }
    else
    {
      $("#check_password").append(remove_sign);
    }
  }

  function check_reenterpassword_fn(event)
  {
    $("#check_reenterpassword").empty();
    var password = $("#signup_password").val();
    var temp = $("#reenterpassword").val();

    if (temp == password && !(temp == ""))
    {
      $("#check_reenterpassword").append(ok_sign);
    }
    else
    {
      $("#check_reenterpassword").append(remove_sign);
    }
  }

  function validate_form(event)
  {
  	var password = $("#signup_password").val();
    var temp = $("#reenterpassword").val();

    if(!is_username_available)
    {
        return false;
    }
    else
    {
    	if(temp == password && !(temp == ""))
	    {
	    	return true;	    	
	    }
	    else
	    	return false;
    }
  }

  $("#signup_username").focusout(function(event) {
    /* Act on the event */
    var username = $("#signup_username").val();
    //console.log(check_availability(username));
    $("#check_username").empty();

    if (check_signup_username())
    {
      $.get("checkAvailability.php",
        {
          q:username
        },
        function(data,status)
        {
          //alert("Data: " + data + "\nStatus: " + status);
          temp = data;
          if (data == "Available")
          {
            $("#check_username").empty();
            $("#check_username").append("<span class='glyphicon glyphicon-ok-circle' style='font-size: 15px; color: green;'></span>");
            is_username_available = true;
          }
          else
          {
            $("#check_username").empty();
            $("#check_username").append("<span class='glyphicon glyphicon-remove-circle' style='font-size: 15px; color:red;'></span>");
            is_username_available = false;
          }
        });
    }
    else
    {
      $("#check_username").append("<span class='glyphicon glyphicon-remove-circle' style='font-size: 15px; color:red;'></span>");
    }
  });

  //$("#signup_password").keypress(check_password_fn);
  $("#signup_password").focusout(check_password_fn);

  //$("#reenterpassword").keydown(check_reenterpassword_fn);
  $("#reenterpassword").focusout(check_reenterpassword_fn);

  $("#signup_form").submit(validate_form);
</script>
</html>
