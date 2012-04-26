<?php
   require_once("config.php");
   require_once("../".$mpdirectory."/rss_fetch.inc");
   require_once("parseRSS.php");
require_once("endwith.php");

   $mysql = "show tables from backbone";
   $result = mysql_query($mysql);
   $number = 0;
   $table = array();
   while ( $row =mysql_fetch_row($result)){
     if(endsWith($row[0],"vinfoweek40")){
       echo($number." : ". $row[0]."\n");
       $table[$number] = $row[0];
       $number++;
     }
   }

   echo "select a table.\n";
   $input = (int) fgets(STDIN,4096);
   echo "select a table.\n";
   $input2 = (int) fgets(STDIN,4096);

   $query = "select distinct videoID from $table[$input]";
   $vresult = mysql_query($query) or die(" ". mysql_error());
   $i=0;
   while($line = mysql_fetch_array($vresult, MYSQL_ASSOC)){
   $videoid[$i] = $line['videoID'];
   $video = $line['videoID'];
   $videoid[$i] = strtolower($videoid[$i]);
   $video = strtolower($video);
   $switch[$video] = "1";
   $i++;
   }
   $size = $i;

   $query = "select distinct videoID from $table[$input2]";
   $vresult = mysql_query($query) or die(" ". mysql_error());
   $j=0;
   while($line = mysql_fetch_array($vresult, MYSQL_ASSOC)){
   $videoid2[$j] = $line['videoID'];
   $video = $line['videoID'];
   $videoid2[$j] = strtolower($videoid2[$j]);
   $video = strtolower($video);
   $switch2[$video] = "1";
   $j++;
   }
   $size2 = $j;
   echo($size2."\n");
   echo($size."\n");
$former=0;
$both=0;

  for($j=0; $j<$size2;$j++){
  	    $v=$videoid2[$j];
	    if(empty($switch[$v])){
		$former++;

	    }else{
		$both++;

	    }		
  }
echo("the latter has ".$size2."videos\n");
echo("only the former has ".$former."videos\n");
echo("both has ".$both."videos\n");



$latter=0;
$both=0;

  for($i=0; $i<$size;$i++){
  	    $v=$videoid[$i];
	    if(empty($switch2[$v])){
		$latter++;

	    }else{
		$both++;

	    }		
  }

echo("the former has ".$size."videos\n");
echo("only the latter has ".$latter."videos\n");
echo("both has ".$both."videos\n");




?>
