
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
			echo "<p><h2 id='product_name'>".$row['name']."</h2><small class='text-muted'>Model: ".$row['product_model_no']."</small></p><br/>";
			echo "<p><h3>Rs.<label id='product_price'>".$row['price']."</label><h3></p>";
			echo "<p><button onclick='addCartBtn();' class='btn btn-primary btn-lg'><span class='glyphicon glyphicon-shopping-cart'></span> Add to cart</button>&nbsp".$display_customize_btn."</p><br/><br/>";
			echo "<p><h4>Product Description</h4></p><br/><p>".$row['product_description']."</p>";
			echo "</div><!--close div col-md-6--></div><!--close div row -->";
			echo "<input type='hidden' id='product_id' value='".$product_id."' />";
		}
	}
?>

<script type="text/javascript">

	var btn = document.getElementById('cartBtn');
	
	function postProduct(){
		var name = $('#product_name').text();
		var price = $('#product_price').text();
		var id = $('#product_id').val();

		$.post('add_to_cart.php',{add_to_cart:1, product_id: id, product_name: name, product_price: price })
			.done(function(data){
				getNoOfProducts();
			});
	}

	function addCartBtn(){		
		postProduct();		
	}

	function getNoOfProducts(){
		$.get('get_no_of_cart_item.php').done(function(data){
			btn.innerHTML = "<span class='glyphicon glyphicon-shopping-cart'></span> Cart("+data+")";
		});
	}
</script>