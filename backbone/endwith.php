<?php

function endsWith($haystack, $needle){
	 $length = (strlen($haystack) - strlen($needle));
	 if($length < 0) return FALSE;
	 return strpos($haystack, $needle, $length) !== FALSE;
}



?>
