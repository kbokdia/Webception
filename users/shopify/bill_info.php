<?php 
session_start();
	if(isset($_GET['store_id'])){

		$store_id = $_GET['store_id'];

		$session_var = $store_id.'products';

		if(isset($_SESSION[$session_var]))
		{
			$counter = 1;

			$total = 0;

			$str = "<table class='table table-hover'><tr>";
			$str .= '<th>S.No.</th>';
			$str .= "<th>Product Name</th>";
			$str .= '<th></th>';
			$str .= "<th>Quantity</th>";
			$str .= '<th>Product Price</th>';
			$str .= "<th>Total Price</th>";
			$str .= "<th></th></tr>";

			foreach ($_SESSION[$session_var] as $key => $value) {
				$str .= "<tr>";
				$str .= "<td>".$counter."</td>";
				$str .= "<td><img src='".$value['image']."' width='50px' style='height:50px;' /></td>";
				$str .= "<td>".$value['name']."</td>";
				$str .= "<td><input type='hidden' class='product_id' value='".$value['id']."' /><input class='product_quantity' type='number' value='".$value['quantity']."' min='1' max='10' onchange='changeQuantity(event)' maxlength='2' style='width:75px;' /></td>";
				$str .= "<td>".$value['price']."</td>";
				$str .= "<td>".$value['price'] * $value['quantity']."</td>";
				$str .= "<td><button class='btn btn-danger btn-xs' onclick='removeItem(event);'>Remove</button></td>";
				$str .= "</tr>";

				$total += $value['price'] * $value['quantity'];
				$counter++;
			}

			$str .= "<tr><td></td><td></td><td></td><td></td><td><label>Total</label></td><td><label>".$total."</label></td><td></td>";
			$str .= "<table>";
			echo $str;
		}
		else{
			echo "<em>Cart is empty...<em>";
		}
	}
?>
