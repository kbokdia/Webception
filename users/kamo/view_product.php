<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <title>K-BOX</title>
      <link href='../../css/bootstrap.css' rel='stylesheet' type='text/css'>
      <script src='../../js/jquery-1.10.2.js'></script>
      <script src='../../js/bootstrap.js'></script>

      <script type='text/javascript'>

      </script>
    </head>
    <body>
      <!--Container-->
    <div class='container'>

      <!--Title-->
      <div class='center-block page-header'>
        <h2 class='text-center' id='store_title'>K-BOX<label class='pull-right'><button class='btn btn-default'><span class='glyphicon glyphicon-shopping-cart'></span> Cart(0)</button></label></h2>
      </div><!--close title div-->
<?php
	
	$root = dirname(dirname(dirname(__FILE__)));
	
	$product_id = $_GET['product_id'];

	echo "<br />";
	echo "<div class = 'row'><div class='col-md-1'></div><div class='col-md-4'>";

	include($root."/header.php");
	
	$sql = "SELECT * FROM product WHERE product_id = " . $product_id;
	if($result = mysqli_query($connection,$sql)){
		while($row = mysqli_fetch_array($result)){
			$image_location = substr(strrchr($row['product_image'], "/"), 1);

			$display_customize_btn = "";
			if($row['customizable'] == 1){
				$display_customize_btn = "<a href='../../canvas_tuts.php?location=".$row['product_image']."' class='btn btn-success btn-lg' onclick='callCustomizeApp();' >Customize</a>";
			}

			
			echo "<img src='images/".$image_location."' width='100%' style='height:400px;' /></div><!--close div col-md-4 -->";
			echo "<div class='col-md-1'></div>";
			echo "<div class='col-md-6'>";
			echo "<p><h2>".$row['name']."</h2><small class='text-muted'>Model: ".$row['product_model_no']."</small></p><br/>";
			echo "<p><h3>Rs.".$row['price']."<h3></p>";
			echo "<p><button class='btn btn-primary btn-lg'><span class='glyphicon glyphicon-shopping-cart'></span> Add to cart</button>&nbsp".$display_customize_btn."</p><br/><br/>";
			echo "<p><h4>Product Description</h4></p><br/><p>".$row['product_description']."</p>";
			echo "</div><!--close div col-md-6--></div><!--close div row -->";
		}
	}
?>

</div><!--close container-->
    <footer class='navbar navbar-default navbar-fixed-bottom'>
    <div class='container'>     
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='#'>powered by &copy Webception</a></li>
      </ul>
    </div>
  </footer>
  </body>
  </html>