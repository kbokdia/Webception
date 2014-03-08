<html>
<head>
</head>
<body>
<?php 
	include("header.php");
	$result = mysqli_query($connection,"SHOW COLUMNS FROM product");
	if (!$result) {
	    echo 'Could not run query: ' . mysql_error();
	    exit;
	}
	if (mysqli_num_rows($result) > 0) {
	    while ($row = mysqli_fetch_assoc($result)) {
	        print_r($row["Field"]);
	    }
	}
	
	$sr = "something new, ";
	
	echo rtrim($sr,", ");
?>
</body>
</html>