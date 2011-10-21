<?php

require_once("stop.php");

var_dump($hash);
for($i=0;$i<5;$i++){
$input1 =  fgets(STDIN,4096);
$input1 = trim($input1);
if (empty($hash[$input1])){
continue;
}else{
echo"is a stopword\n";
}
echo"ここは？\n";
}
/*
$sum = 0;
for($i=1;$i<10;$i++){
	if($i%2!=0){continue;}
echo($i."\n");
	$sum += $i;
}
echo $sum;
*/
?>