<?php
require_once("header.php");
$str_signup = "";
$str_login = "";
if(isset($_GET["error"]))
{
	$str_login = "<div class='alert alert-danger'>Incorrect username or password</div>";	
}
if(isset($_POST["clientName"]))
{
	 if(isset($_POST["username"]))
	 {
		 if(isset($_POST["password"]))
		 {
		 	if(isset($_POST["clientEmail"]))
			{
				$name = $_POST["clientName"];
				$username = $_POST["username"];
				$password = $_POST["password"];
				$email = $_POST["clientEmail"];
				$sql = "INSERT INTO `user`(`name`, `username`, `password`, `email_id`)";
				$sql .= "VALUES ('".$name;
				$sql .= "','".$username."','".sha1($password)."','".$email."');";
				
				if($result = mysqli_query($connection,$sql))
				{
					$str_signup = "<div class='alert alert-success'>Signed Up... Successfully...</div>";
          include("checkuser.php");
				}
				else
				{
					$str_signup =  "<div class='alert alert-danger'>Something went Wrong..</div>";
					die();		
				}
			}
		 }
	 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Webception</title>
<link href="css/bootstrap.css" rel="stylesheet">
<style>
body
{
	padding-top:70px;	
}
.red-border
{
	border:2px solid red;	
}

</style>
<link href="css/bootstrap-responsive.css" rel="stylesheet" />
<script src="js/jquery-1.10.2.js">
</script>
<script src="js/bootstrap.js">
</script>
</head>

<body>
<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
	<div class='navbar-header'>
    <!--<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
      <span class='sr-only'>Toggle navigation</span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>-->
    <a class='navbar-brand' href='index.php' style="margin-left:100px">
    <font face='Lucida Sans Unicode' color='#ffffff' size='+2'>[</font>
	<font face='Lucida Sans Unicode' color='#3a5c9b' size='+2'>Web</font>
	<font face='Lucida Sans Unicode' color='#ffffff' size='+2'>]</font>
	<font face='Lucida Sans Unicode' color='#ff6c00' size='+2'>ception</font></a>
  </div>
</nav>


<div class="container"> 
 <center>
 <br />
 <br />
 <br />
 <br />
 <br />
 <br />
 <br />
 <br />
 <br />
  <button class="btn btn-primary btn-lg" href="#signup" data-toggle="modal" data-target=".bs-modal-sm">Sign In/Register</button>
  </center>
</div>


<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <br>
        <div class="bs-example bs-example-tabs">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#signin" data-toggle="tab">Sign In</a></li>
              <li class=""><a href="#signup" data-toggle="tab">Register</a></li>
              <li class=""><a href="#why" data-toggle="tab">Why?</a></li>
            </ul>
        </div>
      <div class="modal-body">
        <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in" id="why">
        <p>We need this information so that you can receive access to the site and its content. Rest assured your information will not be sold, traded, or given to anyone.</p>
        <p></p><br> Please contact <a mailto:href="webception@gmail.com"></a>Webception@gmail.com</a> for any other inquiries.</p>
        </div>
        
  
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
        </div>
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
              <div class="col-xs-1 col-sm-1 col-md-1" id="check_username" style="padding: 10px">
                
              </div>
            </div>
            
            <!-- Password input-->
            <div class="row">
              <div class="col-md-11 col-xs-11 col-sm-11">
                <input id="signup_password" name="password" class="form-control" type="password" placeholder="Password        (Min 8 Characters)" class="input-large" required="required" style="border-radius:0px; margin-top:-1px; height:44px" pattern="^.{6,15}$" title="minimum: (6 characters) maximum: (15 characters)">
              </div>
               <div class="col-xs-1 col-sm-1 col-md-1" id="check_password" style="padding: 10px">
                
              </div>
            </div>
            
            <!-- Re-enter password input-->
            <div class="row">
              <div class="col-md-11 col-xs-11 col-sm-11">
                <input id="reenterpassword" class="form-control" name="reenterpassword" type="password" placeholder="Re-Enter Password" class="input-large" required="required" style="border-radius:0px; margin-top:-1px; height:44px" pattern="^.{6,15}$">
              </div> 
               <div class="col-xs-1 col-sm-1 col-md-1" id="check_reenterpassword" style="padding: 10px">
                
              </div>     
            </div>
             
            
            <!-- Button -->
            
              <center>
              <input type="submit" id="submit_signup" class="btn btn-success" value="Sign up" style="margin-top:20px; width:260px"/>
              </center>
            

          </form>

        </div>
      </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </center>
      </div>
    </div>
  </div>
</div>
   
<script>
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
    if(!is_username_available)
    {
        event.preventDefault();
    }
    else
      return;
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
</body>
</html>
