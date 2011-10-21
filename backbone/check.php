<?php


  require_once("config.php");
  require_once("../".$mpdirectory."/rss_fetch.inc");
  require_once("parseRSS.php");
  require_once("stop.php");
        $sql = "SHOW TABLES FROM backbone";
        $result = mysql_query($sql);
        echo "which table do you want to use as keyword? Select the number.\n";
        $number = 0;
        $table = array();
        while ($row = mysql_fetch_row($result)) {
            echo ($number.": {$row[0]}\n");
            $table[$number] = $row[0];
            $number++;
        }
        $input = (int) fgets(STDIN,4096);
        $query = "SELECT distinct keyword FROM $table[$input]";
        $vresult = mysql_query($query) or die(" ". mysql_error());
	$i=0;
        while ($line = mysql_fetch_array($vresult, MYSQL_ASSOC)) //Returns an array of strings that corresponds to the fetched row
        {   
	    $ke[$i]=$line['keyword'];
	    $key = $line['keyword'];
            $v[$key] = "1";
	    $i++;
	}
	$size = $i;

        $sql = "SHOW TABLES FROM backbone";
        $result = mysql_query($sql);
        echo "which table do you want to use as keyword? Select the number.\n";
        $number = 0;
        $table = array();
        while ($row = mysql_fetch_row($result)) {
            echo ($number.": {$row[0]}\n");
            $table[$number] = $row[0];
            $number++;
        }
        $input = (int) fgets(STDIN,4096);
        $query = "SELECT distinct keyword FROM $table[$input]";
        $vresult = mysql_query($query) or die(" ". mysql_error());
        $j=0;
	while ($line = mysql_fetch_array($vresult, MYSQL_ASSOC)) //Returns an array of strings that corresponds to the fetched row
        {   
            $v2[$j] = $line['keyword'];
	    $j++;
	}
	$size2 = $j;

	$plural=0;
for($j=0;$j<$size2;$j++){
        $k=$v2[$j];
	if (empty($v[$k])){
	   echo($k." doesnt exist in new table.\n");
		  $plural++;
	}else{

	}
}
echo"\n";
for($j=0;$j<$size;$j++){
        $k=$v2[$j];

	if (!empty($hash[$k])){
	   echo($k." is a stopword in the old table.\n");
	   continue;
	   echo("after continue\n");
	}
	echo($j."\n");
}
echo"\n";
for($i=0;$i<$size;$i++){
        $k=$ke[$i];
	if (!empty($hash[$k])){
	   echo($k." is a stopword in the new table.\n");
	}
}
echo"\n";

/*

	for($i=0;$i<$size;$i++){
		for($j=0;$j<$size2;$j++){
			if($v[$i] == $v2[$j]){
				  echo($v[$i]."\n");
		
			
		 	}
			
		}
	}
*/
	echo($size."\n");
	echo($size2."\n");
	echo($plural."\n");






?>
