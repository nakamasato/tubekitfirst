<?php



$contents = @file_get_contents('stopword.txt');
$contents = explode(' ',$contents);

$size = count($contents);
echo $size;
for($i = 0; $i < $size; $i++){
$contents[$i] = trim($contents[$i]);
$hash[$content[$i]]='1';
echo($contents[$i]."\n");
}
var_dump($hash);



?>