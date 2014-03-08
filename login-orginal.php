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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <a class='navbar-brand' href='index.php'>Webception</a>
  </div>
</nav>
<div class="container">
	<?php echo $str_signup;?>
	<div class="row">	
    	<div class="col-md-6">
        <h3>Login</h3>
        		<br/>
            <form action="checkuser.php" method="POST" role="form"
            style="padding-left:20px; padding-top:20px; padding-bottom:10px; padding-right:40px; 
            width:350px; background:#f1f1f1; border-radius:20px">
            <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                </div>
                <div>
      					<div class="checkbox">
        				<label>
        					  <input type="checkbox"> Remember me
       					 </label>
    		  </div>
   			 </div>
             <?php echo $str_login;?>
                <div class="form-group">
                 <p align="right"> <input type="submit" class="btn btn-success" value="Sign in"></p>
                </div>
                
            </form>
    	</div>
		
	
    	<div class="col-md-4">   
        <h3>Sign Up</h3>
        <br/>
            <form action="login.php" method="post" id="signup_form" role="form"
            style="padding-left:20px; padding-top:20px; padding-bottom:10px; padding-right:40px; 
            width:380px; height:375px; background:#f1f1f1; border-radius:20px">
                <div class="form-group">
                   <label for="name">Name</label>
                    <input type="text" class="form-control" placeholder="Full name" name="clientName" title="Full Name eg:(John Doe)" id="name" required />
                </div>
                <div class="form-group">
                   <label for="username">Username</label>
                    <input type="text" name="username"  class="form-control" placeholder="Username" id="signup_username" title="minimum: (4 characters) maximum: (15 characters)" required />
                    <div id="txtHint"></div>
                    <div id="error_username" class="alert-danger"></div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" placeholder="Password" pattern="^.{6,12}$" name="password" id="signup_password" title="minimum: (6 characters) maximum: (12 characters)" required />
                </div>
                <div class="form-group">
                    <label for="email">Email ID</label>
                    <input type="email" name="clientEmail" class="form-control" placeholder="Email-id" id="email" title="johndoe@example.com" required />
                </div>
                <div class="form-group">
                   <p align="right"> <input type="submit" class="btn btn-success" value="Sign up"></p>
                </div>
                
            </form>
         </div>
        </div>
   </div>
   
   <script>
	$(document).ready(function(e) {
        $("#username").focus();
		
		var check_signup_username  = function(){
			var username = $("#signup_username").val();
			for(var i=0; i<username.length;i++)
			{
				if(username[i] === " ")
					return false;	
			}
			return true;
		};
		
		$("#signup_username").change(function(e) {
			var username = $("#signup_username").val();
            if(!check_signup_username())
				$("#error_username").append("No spaces between characters.");
			else
			{
				$.get("checkAvailability.php",
				{
					q:username
				},
				function(data,status)
				{
					//alert("Data: " + data + "\nStatus: " + status);
					$("#txtHint").append(data);
				});	
			}
        });
		
		$("#signup_username").focus(function(e) {
            $("#txtHint").empty();
			$("#error_username").empty();
			$("#signup_username").removeClass("red-border");
        });
       
	   $("#signup_form").submit(function(event){
		   if(check_signup_username())
		   {
				if($("#txtHint").text() === "Available")
				{
					return true;	
				}
				else
				{
					$("#signup_username").addClass("red-border");
					return false;
				}
		   }
		   else
		   {	   
				$("#signup_username").addClass("red-border");
			}
			event.preventDefault();
		});
	});
   </script>
</body>
</html>
