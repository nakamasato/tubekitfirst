<?php



$contents = @file_get_contents('stopword.txt');
$contents = explode(' ',$contents);

$size = count($contents);
for($i = 0; $i < $size; $i++){
$contents[$i] = trim($contents[$i]);
$key = $contents[$i];
$hash[$key]='1';

}

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