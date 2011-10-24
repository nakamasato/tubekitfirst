<?php

require_once("stop.php");
require_once("config.php");
$query = "select distinct keyword from 2011_";
$result = mysql_query($query);
$not = 0;
$stop = 0;
$space = 0;
while($line = mysql_fetch_array($result)){
	    $keyword = $line['keyword'];
	    $keyword = strtolower($keyword);
	    $keyword = trim($keyword);
	    if(preg_match("/\s/",$keyword)){
	    $space++;	    
	    continue;
	    }
	    if(empty($hash[$keyword])){
	    echo($keyword. " is not a stopword.\n");
	    $not++;
	    }else{
	    echo($keyword. " is a stopword.\n");
	    $stop++;
	    }
}
echo($not."nonstopwords\n");
echo($stop."stopwords\n");
echo($space."spaces\n");





//check 3 word if they are stopword or not
for($i=0;$i<4;$i++){
$input1 =  fgets(STDIN,4096);
$input1 = strtolower($input1);
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