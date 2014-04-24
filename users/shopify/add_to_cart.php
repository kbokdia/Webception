<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <title>Trendzzz...</title>
      <link href='../../css/bootstrap.css' rel='stylesheet' type='text/css'>
      <script src='../../js/jquery-1.10.2.js'></script>
      <script src='../../js/bootstrap.js'></script>

      
    </head>
    <body>
      <!--Container-->
    <div class='container'>

      <!--Title-->
      <div class='center-block page-header'>
        <h2 class='text-center' id='store_title'><a href='index.php'>Trendzzz...</a><label class='pull-right'><button id='cartBtn' onload='getNoOfProducts();' class='btn btn-default'><span class='glyphicon glyphicon-shopping-cart'></span> Cart(0)</button></label></h2>
      </div><!--close title div--><?php
session_start();

if (isset($_POST['add_to_cart'])) {

	include("addslashes_to_POST.php");
	
	$new_product = array('id'=>$_POST['product_id'], 'name'=>$_POST['product_name'], 'price'=>$_POST['product_price']);	

	if (isset($_SESSION['products'])) {
		array_push($_SESSION['products'], $new_product);		
	}
	elseif(!isset($_SESSION['products'])) {
		
		$_SESSION['products'] = array($new_product);
	}

	echo "<pre>";
	print_r($_SESSION['products']);
	echo "</pre>";
}
?></div><!--close container-->
    <script type='text/javascript'>
       
      function getNoOfProducts(){
          $.get('get_no_of_cart_item.php').done(function(data){
            var str = '<span class=\'glyphicon glyphicon-shopping-cart\'></span> Cart(';
              str += data;
              str += ')'
            $('#cartBtn').html(str);
          });
        }
      </script>
    <footer class='navbar navbar-default navbar-fixed-bottom'>
    <div class='container'>     
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='#'>powered by &copy Webception</a></li>
      </ul>
    </div>
  </footer>
  </body>
  </html>