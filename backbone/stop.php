<?php



$contents = @file_get_contents('stopword.txt');
$contents = explode(' ',$contents);

$size = count($contents);
for($i = 0; $i < $size; $i++){
$contents[$i] = trim($contents[$i]);
$key = $contents[$i];
$hash[$key]='1';

}

?>