<?php
	session_start();

	$counter = 0;

	$session_var = $_GET['store_id'].'products';
	
	if(isset($_SESSION[$session_var])){
		foreach ($_SESSION[$session_var] as $value) {
			$counter++;
		}
	}

	echo $counter;
?>