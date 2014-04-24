<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Webception</title>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<style></style>
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.js"></script>
</head>
<body>
	<form>
		<div class='form-group'>
			<label>Customer Name:</label>
			<input type="text" name="clientName" class='form-control' title="Full Name" pattern='[a-zA-Z]*\s[a-zA-Z]*' required="required" />
		</div>
		<div class='form-group'>
			<label>Address:</label>
			<textarea name="clientAddress" class='form-control' title="Address" required="required"></textarea>
		</div>
		<div class='form-group'>
			<label>Pincode</label>
			<input type="text" name="clientPincode" title="Area Code(Chennai)" pattern="[0-9]{6}" class='form-control' required="required" />
		</div>
		<div class='form-group'>
			<label>Mobile No. : </label>
			<input type="text" name="clientMobile" title="Mobile No(10 digit)"  pattern="[7-9][0-9]{9}" class='form-control' required="required" />
		</div>
	</form>
</body>
</html>
