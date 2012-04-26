<?php
require_once("stop.php");
require_once("weekview.php");
require_once("../".$mpdirectory."/rss_fetch.inc");


function extractkeywordfromdatabase($database){

  $sql = "select distinct keyword from $database where point is null or point = 0";
  $result = mysql_query($sql) or die(" ".mysql_error());
  $i=0;
  while($line = mysql_fetch_array($result)){
    $keyword=trim($line['keyword']);
    if(!empty($hash[$keyword])){continue;}
    $keywords[$i] = $keyword;
    $i++;
  }
  return $keywords;
}





function extract1000vfromkeyword($keyword,$database){

  $j=0;
  $database=split("_",$database);
  for($i=0;$i<3;$i++){
    $database[$i]=(int)$database[$i];
  }
  $basedatabase=mktime(0,0,0,$database[1],$database[2],$database[0]);

  $key = trim($keyword);
  $key = str_replace(" ","%2C",$key);
  for($i=0;$i<1;$i++){
    $k = 50 * $i + 1;
    $url = "http://gdata.youtube.com/feeds/api/videos?category=$key&max-results=50&start-index=$k&time=this_month&orderby=viewCount";
    echo($url);
    $rss = fetch_rss($url);
    foreach($rss->items as $item){
      $yt_url=$item['link'];
      $ytIDs[$j] = substr($yt_url,31,11);
      $title = $item['title'];
      if(preg_match('/viewcount=\"[0-9]*\"/',$title,$viewcount)){
	$viewcount=split("\"",$viewcount[0]);
	$viewcount=(int)$viewcount[1];
      }
      if($viewcount < 1000){
	continue;
      }
      if(empty($item['published'])){
	if(preg_match('/published >[0-9]+-[0-9]+-[0-9][0-9]/ ',$title,$published)){
	  $published = split(">",$published[0]);
	  $published = split("-",$published[1]);
	  for($num=0;$num<3;$num++){
	    $pub_date[$j][$num]=(int)$published[$num];
	  }
	  //	var_dump($pub_date);
	}
      }else{
	$published = $item['published'];
	$pub_date[$j][0]=substr($published,0,4);
	$pub_date[$j][1]=substr($published,5,2);
	$pub_date[$j][2]=substr($published,8,2);
      }
      //	var_dump($pub_date);
      //	var_dump($database);
      $baseupload=mktime(0,0,0,$pub_date[$j][1],$pub_date[$j][2],$pub_date[$j][0]);
      if($basedatabase < $baseupload){
	continue;
      }
      $j++;
    }
  }
  return $ytIDs;
  //    var_dump($rss);
}
//$aa = renshu($keyword,$database);
//var_dump($aa);


function databaseTOviewthisweek($database){
  $keywords = extractkeywordfromdatabase($database);
  for($i=0;$i< sizeof($keywords); $i++){
    $keyword = $keywords[$i];
    $ids = extract1000vfromkeyword($keyword,$database);
    var_dump($ids);
    for($j=0;$j< sizeof($ids);$j++){
      $id = $ids[$j];
      $str = fileget($id);
      //var_dump($str);
      $viewthisweeks[$i][$j] = main($database,$str);
    }
  }
  return $viewthisweeks;
}



function addcolumnpoint($database){
  $mysql="show fields from $database";
  $result = mysql_query($mysql) or die(" ". mysql_error());
  $checkpoint =0;
  $checkavg=0;
  while ( $row = mysql_fetch_row($result)){
    if($row[0]==="point"){
      $checkpoint=1;    
    }
    if($row[0]==="average"){
      $checkavg=1;
    }
  }
  if($checkpoint==0){
    $sql = "ALTER TABLE $database ADD point int(15)";
    $result = mysql_query($sql) or die(" ". mysql_error());
  }
  if($checkavg==0){
    $sql = "ALTER TABLE $database ADD average int(10)";
    $result = mysql_query($sql) or die(" ". mysql_error());
  }
}

//$database = "2011_11_08_18_26_59Travel_weekkey50vinfoweek40";
//addcolumnpoint($database);




function evaluatepoint($viewthisweeks){
  for($i=0;$i< sizeof($viewthisweeks); $i++){
    for($j=0;$j< sizeof($viewthisweeks[$i]);$j++){
      $totalviews[$i] += $viewthisweeks[$i][$j];
    }
  }
  return $totalviews;
}

  


function updatepoint($database,$totalviews){
  $keywords = extractkeywordfromdatabase($database);
  for($i=0;$i < sizeof($keywords); $i++){
    $sql = "update $database set point = $totalviews[$i] where keyword = '$keywords[$i]'";
    $result = mysql_query($sql) or die(" ". mysql_error());
  }
}


?>