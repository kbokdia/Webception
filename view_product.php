
<?php
	
	$root = dirname(dirname(dirname(__FILE__)));
	
	$product_id = $_GET['product_id'];

	echo "<div class = 'row'><div class='col-md-1'></div><div class='col-md-4'>";

	include($root."/header.php");
	
	$sql = "SELECT * FROM product WHERE product_id = " . $product_id;
	if($result = mysqli_query($connection,$sql)){
		while($row = mysqli_fetch_array($result)){
			$image_location = substr(strrchr($row['product_image'], "/"), 1);
			echo "<img src='images/".$image_location."' width='100%' style='height:400px;' /></div><!--close div col-md-4 -->";
			echo "<div class='col-md-1'></div>";
			echo "<div class='col-md-6'>";
			echo "<p><h2>".$row['name']."</h2><small class='text-muted'>Model: ".$row['product_model_no']."</small></p><br/>";
			echo "<p><h3>Rs.".$row['price']."<h3></p>";
			echo "<p><button class='btn btn-success btn-lg'><span class='glyphicon glyphicon-shopping-cart'></span> Add to cart</button></p><br/><br/>";
			echo "<p><h4>Product Description</h4></p><br/><p>".$row['product_description']."</p>";
			echo "</div><!--close div col-md-6--></div><!--close div row -->";
		}
	}
?>