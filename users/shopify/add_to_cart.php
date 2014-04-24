<?php
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
?>