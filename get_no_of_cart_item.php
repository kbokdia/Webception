<?php
	session_start();

	$counter = 0;
	foreach ($_SESSION['products'] as $value) {
		$counter++;
	}

	echo $counter;
?>