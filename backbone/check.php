<?php


  require_once("config.php");
  require_once("../".$mpdirectory."/rss_fetch.inc");
  require_once("parseRSS.php");
  require_once("stop.php");
        $sql = "SHOW TABLES FROM backbone";
        $result = mysql_query($sql);
        $number = 0;
        $table = array();
        while ($row = mysql_fetch_row($result)) {
            echo ($number.": {$row[0]}\n");
            $table[$number] = $row[0];
            $number++;
        }
        echo "Select a new table.\n";
        $input = (int) fgets(STDIN,4096);
        $query = "SELECT distinct keyword FROM $table[$input]";
        $vresult = mysql_query($query) or die(" ". mysql_error());
	$i=0;
        while ($line = mysql_fetch_array($vresult, MYSQL_ASSOC)) //Returns an array of strings that corresponds to the fetched row
        {   
	    $ke[$i]=$line['keyword'];
	    $key = $line['keyword'];
	    $ke[$i]=strtolower($key);
	    $key=strtolower($key);
            $v[$key] = "1";
	    $i++;
	}
	$size = $i;

        $sql = "SHOW TABLES FROM backbone";
        $result = mysql_query($sql);
        $number = 0;
        $table = array();
        while ($row = mysql_fetch_row($result)) {
            echo ($number.": {$row[0]}\n");
            $table[$number] = $row[0];
            $number++;
        }
        echo "Select a old table.\n";
        $input = (int) fgets(STDIN,4096);
        $query = "SELECT distinct keyword FROM $table[$input]";
        $vresult = mysql_query($query) or die(" ". mysql_error());
        $j=0;
	while ($line = mysql_fetch_array($vresult, MYSQL_ASSOC)) //Returns an array of strings that corresponds to the fetched row
        {   
            $v2[$j] = $line['keyword'];
	    $v2[$j] = strtolower($v2[$j]);
	    $j++;
	}
	$size2 = $j;
	$exist=0;
	$plural=0;
for($j=0;$j<$size2;$j++){
        $k=$v2[$j];
	if (empty($v[$k])){
	   echo($k." doesnt exist in new table.\n");
		  $plural++;
	}else{
	   echo($k."\n");
		$exist++;
	}
}
echo"\n";
$stopold=0;
for($j=0;$j<$size2;$j++){
        $k=$v2[$j];

	if (!empty($hash[$k])){
	   echo($k." is a stopword in the old table.\n");
	   $stopold++;
	   continue;
	   echo("after continue\n");
	}
//	echo($j."\n");
}
echo"\n";
$stopnew=0;
for($i=0;$i<$size;$i++){
        $k=$ke[$i];
	if (!empty($hash[$k])){
	   echo($k." is a stopword in the new table.\n");
	   $stopnew++;
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
	echo($size."keywords in new tables\n");
	echo($size2."keywords in old  tables\n");
	echo($plural."keywords in old but not in new\n");
	echo($stopnew."stopwords in new\n");
	echo($stopold."stopwords in old\n");
	echo($exist. "keywords in both\n");



?>
