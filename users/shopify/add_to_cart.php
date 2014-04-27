<?php
session_start();

if (isset($_POST['add_to_cart'])) {

	include("addslashes_to_POST.php");
	
	$new_product = array('id'=>$_POST['product_id'], 'name'=>$_POST['product_name'], 'quantity'=>1 ,'image'=>$_POST['product_image'] ,'price'=>$_POST['product_price']);	

	$session_var = $_POST['store_id'].'products';

	if (isset($_SESSION[$session_var])) {
		array_push($_SESSION[$session_var], $new_product);		
	}
	elseif(!isset($_SESSION[$session_var])) {
		
		$_SESSION[$session_var] = array($new_product);
	}
}
elseif (isset($_POST['change_quantity'])) {
	$session_var = $_POST['store_id'].'products';

	foreach ($_SESSION[$session_var] as $key => $value) {
		if($value['id'] == $_POST['product_id']){
			$_SESSION[$session_var][$key]['quantity'] = $_POST['product_quantity'];
			echo $_SESSION[$session_var][$key]['quantity'];
			break;
		}
	}
}
elseif (isset($_POST['remove_item'])) {
	$session_var = $_POST['store_id'].'products';

	if (count($_SESSION[$session_var]) == 1) {
		unset($_SESSION[$session_var]);
	}
	else{
		foreach ($_SESSION[$session_var] as $key => $value) {
			if($value['id'] == $_POST['product_id']){
				unset($_SESSION[$session_var][$key]);
				break;
			}
		}
	}
}
?>