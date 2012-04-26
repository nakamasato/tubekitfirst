<?php
   require_once("config.php");
   require_once("../".$mpdirectory."/rss_fetch.inc");
   require_once("parseRSS.php");
   require_once("endwith.php");


   $category = array(0 => 'All',1 => 'Autos',2 => 'Comedy',3 => 'Education',4 => 'Entertainment', 5 => 'Film', 6 => 'Gaming', 7 => 'Howto', 8 => 'News',9 => 'Nonprofits', 10 => 'People', 11 => 'Pets', 12 => 'Science',13 => 'Sports', 14 => 'Travel');
   $categoryinverse = array('All'=>0,'Autos'=>1,'Comedy'=>2,'Education'=>3, 'Entertainment'=>4, 'Film'=>5,  'Gaming'=>6, 'Howto'=>7, 'News'=>8, 'Nonprofits'=>9, 'People'=>10,  'Pets'=>11,  'Science'=>12, 'Sports'=>13,  'Travel'=>14);


   $mysql = "show tables from backbone";
   $result = mysql_query($mysql);
   $number = 0;
   $table = array();
   while ( $row =mysql_fetch_row($result)){
   	 if(endsWith($row[0],"week100")){
	   //		echo($number." : ". $row[0]."\n");
		$table[$number] = $row[0];   
   		$number++;
	 }
   }



for($j=0; $j < $number; $j++){
  $query = "select video_id, category from $table[$j]";
  $vresult = mysql_query($query) or die(" ". mysql_error());
  $i = 1;
  $num = 0;
  $numbertable[$j][$num] = 1;
  while($line = mysql_fetch_array($vresult, MYSQL_ASSOC)){
    $cat = $line['category'];
    $cat = $categoryinverse[$cat];
    $data[$j][$i] = array($line['video_id'], $cat );   
    if($num == $cat - 1){
      $num = $cat;  $numbertable[$j][$num] = $i; 
    }else if($num == $cat - 2){
      $numbertable[$j][$num+1] = $i;$num = $cat;$numbertable[$j][$num] = $i;
    }else if($num == $cat - 3){
      $numbertable[$j][$num+1] = $i;$numbertable[$j][$num+2] = $i; $num = $cat; $numbertable[$j][$num] = $i;
    }
    $i++;
  }
  $size[$j] = $i-1;
  $numbertable[$j][$num+1] = $i;
}



for($i=0;$i < $number-1;$i++){
  $j=$i+1;
  echo("this is comparison between ".$table[$i]." and ".$table[$j]." .\n");
for($k=0; $k < 15; $k++){
  switch($k){
  case 6:
  case 9:
  case 11:
  case 12: break;
  case 0:
  case 1:
  case 2:
  case 3:
  case 4:
  case 5:
  case 7:
  case 8:
  case 10:
  case 13:
  case 14:
    for($l=$numbertable[$i][$k]; $l < $numbertable[$i][$k+1]; $l++){
      for($m=$numbertable[$j][$k]; $m < $numbertable[$j][$k+1]; $m++){
	if($data[$i][$l][0] == $data[$j][$m][0]){
	  $both[$i][$j][$k]++;
	}
      }
    }
    echo("In the ".$category[$k].", both have ".$both[$i][$j][$k]." common videos.\n");
      }
}
}






for($k=0;$k<15;$k++){
  for($i=0;$i<$number-1;$i++){
    $j=$i+1;
$b[$k]+=$both[$i][$j][$k];
//echo($i." and ".$j."category:".$category[$k]."both have ".$both[$i][$j][$k]." videos\n");
  }
  echo($category[$k].":".$b[$k]/($number-1.0)."\n");
}




/*





for($j=0; $j < 2; $j++){
  echo "select a table.\n";
  $input = (int) fgets(STDIN,4096);
  $query = "select video_id, category from $table[$input]";
  $vresult = mysql_query($query) or die(" ". mysql_error());
  $i = 1;
  $num = 0;
  $numbertable[$j][$num] = 1;
  while($line = mysql_fetch_array($vresult, MYSQL_ASSOC)){
    $cat = $line['category'];
    $cat = $categoryinverse[$cat];
    $data[$j][$i] = array($line['video_id'], $cat );   
    if($num == $cat - 1){
      $num = $cat;  $numbertable[$j][$num] = $i; 
    }else if($num == $cat - 2){
      $numbertable[$j][$num+1] = $i;$num = $cat;$numbertable[$j][$num] = $i;
    }else if($num == $cat - 3){
      $numbertable[$j][$num+1] = $i;$numbertable[$j][$num+2] = $i; $num = $cat; $numbertable[$j][$num] = $i;
    }
    $i++;
  }
  $size[$j] = $i-1;
  $numbertable[$j][$num+1] = $i;
  var_dump($numbertable);
}





for($i=0; $i < 15; $i++){
  switch($i){
  case 6:
  case 9:
  case 11:
  case 12 :break;
  case 0:
  case 1:
  case 2:
  case 3:
  case 4:
  case 5:
  case 7:
  case 8:
  case 10:
  case 13:
  case 14:
    $both[$i]=0;
    for($j=1; $j < $size[0]+1; $j++){
      for($k=1; $k < $size[1]+1; $k++){
	if($data[0][$j][1] == $i){
	  if($data[1][$k][1] == $i){
	    if($data[0][$j][0] == $data[1][$k][0]){
	      
	      $both[$i]++;
	    }
	  }
	}
      }
    }  
  echo("In the ".$category[$i].", both have ".$both[$i]." common videos.\n");
  }
}
*/

?>
