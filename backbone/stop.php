<?php



$contents = @file_get_contents('stopword.txt');
$contents = explode(' ',$contents);

$size = count($contents);
for($i = 0; $i < $size; $i++){
$contents[$i] = trim($contents[$i]);
$key = $contents[$i];
$hash[$key]='1';

}


$input1 =  fgets(STDIN,4096);
$input1 = trim($input1);
if (empty($hash[$input1])){
echo" is not a stopword\n";
}else{
echo"is a stopword\n";
}


?>