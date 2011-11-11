<?php

function startsWith($haystack, $needle){
	 $length = (strlen($haystack) - strlen($needle));
	 if($length < 0) return FALSE;
	 return strpos($haystack, $needle) === 0;
}



?>
