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
   	 if(endsWith($row[0],"week100")){
		echo($number." : ". $row[0]."\n");
		$table[$number] = $row[0];   
   		$number++;
	 }
   }

   echo "select a table.\n";
   $input = (int) fgets(STDIN,4096);
   echo "select a table.\n";
   $input2 = (int) fgets(STDIN,4096);

   $query = "select video_id, category from $table[$input]";
   $vresult = mysql_query($query) or die(" ". mysql_error());
   $i=0;
   while($line = mysql_fetch_array($vresult, MYSQL_ASSOC)){
   $video[$i][0] = $line['video_id'];
   $video[$i][1] = $line['category']; 
   $video = $line['video_id'];
   $video[$i][0] = strtolower($videoid[$i][0]);
   $video = strtolower($video);
   $switch[$video] = "1";
   $i++;
   }
   $size = $i;


   echo($size."\n");

/*
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
echo("the latter has ".$size2."words\n");
echo("only the former has ".$former."words\n");
echo("both has ".$both."words\n");



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

echo("the former has ".$size."words\n");
echo("only the latter has ".$latter."words\n");
echo("both has ".$both."words\n");


*/

?>
