<?php
	function clean($string) {
	   $string = str_replace(' ', '_', $string); // Replaces all spaces with underscore.
	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
?>