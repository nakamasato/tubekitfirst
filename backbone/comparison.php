<?php


  require_once("config.php");
  require_once("../".$mpdirectory."/rss_fetch.inc");
  require_once("parseRSS.php");

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
	    $video[$i] = $line['picked_video'];
	    $count[$i] = (int) $line['view_count'];
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
	    $video2[$j] = $line['keyword'];
	    $count2[$j] = (int) $line['view_count'];
	    $j++;
	}
	$size2 = $j;
	$exist=0;
	$plural=0;

echo"\n";
/*
for($i=0;$i<$size;$i++){
	for($j=0;$j<$size2;$j++){
		if($video[$i] == $video2[$j]){
			$view = $count[$i] - $count2[$j];
			echo("video name:".$video[$i].",viewcount:".$view."\n");
			continue;
		}
		echo("video name:".$video[$i]."\n");					
	}
}

echo"\n";
	echo($size."keywords in new tables\n");
	echo($size2."keywords in old  tables\n");
	echo($plural."keywords in old but not in new\n");
	echo($stopnew."stopwords in new\n");
	echo($stopold."stopwords in old\n");
	echo($exist. "keywords in both\n");
*/


?>
