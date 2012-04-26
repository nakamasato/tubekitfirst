<?php


require_once("config.php");
require_once("../".$mpdirectory."/rss_fetch.inc");
require_once("parseRSS.php");
require_once("endwith.php");


//$str = file_get_contents('url');
//$database="2011_10_07_17_30_24_query_mst_vwd_tdy";



function viewcalculate($baselast,$baseupload,$basedatabase,$yvalue,$coefficient){

  $new=$baselast-$basedatabase;
  $old=$basedatabase-$baseupload;
  for($j=0;$j < sizeof($yvalue);$j++){
    echo($yvalue[$j].", ");
  }

  echo("new:".$new." sizeofyvalue:".sizeof($yvalue)." ");
  echo("old:".$old."\n");
  $i=$old*((float)(sizeof($yvalue)-1))/($new+$old);
  echo("i:".$i."\n");
  $start=(int)$i;
  $end=$start+1;
  echo("start:".$start."\n");
  //echo("yvalue[start]:".$yvalue[$start]."\nyvalue[end]:".$yvalue[$end]."\n");
  $view=$yvalue[$start]+($i-$start)*($yvalue[$end]-$yvalue[$start]);
  echo("normalized view(max83.3?):".$view."\n");
  // var_dump($view);
  $view=$view*$coefficient;
  echo("view:".$view."\n");
  return $view;
}





function main($database, $str){
  //get the total view count
  //  if(preg_match('/再生回数の合計: ([0-9]*,[0-9]+)*\s*/u',$str,$view_count)){
  if(preg_match('/watch-stats-title-text\">\s.* ([0-9]*,[0-9]+)*[0-9]+\s*/ ',$str,$view_count)){
    var_dump($view_count);
    $view_count = trim($view_count[0]);
    $view_count = str_replace(",","",$view_count);
    $view_count = str_replace(" ","",$view_count);
    preg_match('/[0-9]+/',$view_count, $view_count);
    $v= $view_count[0];
    $view_count = (int) $v;
    //var_dump($view_count);

    // get the URL of the view count chart
    $str = split("\n",$str);
    $size = sizeof($str);
    for($i=0;$i<$size; $i++){
      $str[$i] = trim($str[$i]);
      if(strpos($str[$i],"<img src=",0)===0){
	$wanted = $str[$i];
      }
    }
  }else{
    return null;
  }

  if(preg_match("/http:\/\/.*?\"/",$wanted, $url1)){
    $url1 = $url1[0];


    //parse the URL
    $url1 = split("&amp;",$url1);
    //var_dump($url1);



    //extract normalized yvalue. 
    for($i=0;$i< sizeof($url1);$i++){

      if(preg_match("/chd=t/",$url1[$i])){
	$x=split(":",$url1[$i]);
	if(sizeof($x)===2){
	  //echo("OK\n");
	  $yvalue=split(",",$x[1]);
	  //var_dump($yvalue);
	}else{
	  echo("yvalue is not determined\n");
	}
      }
      if(preg_match("/chxl=/",$url1[$i])){
	$date=split("\|",$url1[$i]);
	//var_dump($date);
      }
    }


    //convert yvalue into float        
    for($i=0; $i < sizeof($yvalue); $i++){
      $yvalue[$i]=(float)$yvalue[$i];
    }

    //caluculate the coefficient
    //var_dump($yvalue);
    $coefficient = $view_count / $yvalue[sizeof($yvalue)-1];
    var_dump($coefficient);


    //calculate time
    $lastday=split("\/",$date[(sizeof($date)-1)]);
    $uploadday=split("\/",$date[1]);
    for($i=0;$i<3;$i++){
      $lastday[$i]=(int)$lastday[$i];
      $uploadday[$i]=(int)$uploadday[$i];
    }

    $database=split("_",$database);
    for($i=0;$i<3;$i++){
      $database[$i]=(int)$database[$i];
    }
    $database[0]-=2000;
    //    var_dump($lastday);
    //var_dump($database);
    //var_dump($uploadday);
    $baselast=mktime(0,0,0,$lastday[1],$lastday[2],$lastday[0]+2000);
    $baseupload=mktime(0,0,0,$uploadday[1],$uploadday[2],$uploadday[0]+2000);
    $basedatabase=mktime(0,0,0,$database[1],$database[2],$database[0]+2000);
    if($basedatabase < $baseupload){
      $basedatabase = $baseupload;
    }
    echo("regular!!!!!!!!!!!!!!!!!!:".$baselast." ".$basedatabase." ".$baseupload."\n");
    $view = viewcalculate($baselast,$baseupload,$basedatabase,$yvalue,$coefficient);
    //echo($view."\n");
    if(($basedatabase - (86400 * 7)) >= $baseupload){
      $basedatabase -= (86400 * 7);
    }else{
      $basedatabase = $baseupload;
    }
    echo("weekbefore!!!!!!!!!!!!!!!!!:".$baselast." ".$basedatabase." ".$baseupload."\n");
    $viewweekbefore = viewcalculate($baselast,$baseupload,$basedatabase,$yvalue,$coefficient);
    //  echo($viewweekbefore."\n");
    $viewthisweek = $view - $viewweekbefore;
    //echo($viewthisweek."\n");
    return $viewthisweek;
  }else{
    return null;
  }
}

//main($database,$str);

function extractid($database){
  $i=0;
  $sql = "select * from $database";
  $result = mysql_query($sql)  or die(" ". mysql_error());
  while ($line = mysql_fetch_array($result, MYSQL_ASSOC)){
    $video_id[$i] = $line['video_id'];
    $i++;
  }
  return $video_id;
}


function fileget($id){
$url = "http://www.youtube.com/insight_ajax?action_get_statistics_and_data=1&v=$id";
$str = file_get_contents($url);
return $str;
}


function addcolumn($database){
  $mysql="show fields from $database";
  $result = mysql_query($mysql) or die(" ". mysql_error());
  $checkweekview=0;
  while ( $row = mysql_fetch_row($result)){
    if($row[0]==="weekview"){
      $checkweekview=1;
    }
  }
  if($checkweekview==0){
    $sql = "ALTER TABLE $database ADD weekview int(10)";
    $result = mysql_query($sql) or die(" ". mysql_error());
  }
}


function updateinfo($database,$weekview,$video_id){
  $sql = "update $database set weekview = $weekview where video_id = '$video_id'";
  $result = mysql_query($sql) or die(" ". mysql_error());
}

function selectdatabase(){
  $i=0;
  $sql = "show tables from backbone";
  $result = mysql_query($sql) or die(" ". mysql_error());
  while($row = mysql_fetch_row($result)){
    if((endsWith($row[0],"100"))||(endsWith($row[0],"key50"))){
      $database[$i]=$row[0];
      $i++;
    }
  }
  return $database;
}



function databaseToweekview($database){
  addcolumn($database);
  $video_ids = extractid($database);
  $check="";

  for($i=0;$i < sizeof($video_ids);$i++){
    $video_id = $video_ids[$i];
    //var_dump($video_id);
    if($video_id === $check){
      //echo($check.":".$video_id."continue\n");
      continue;
    }else{
      echo("done\n");
      $check = $video_ids[$i];
      $str = fileget($video_id);
      //echo($str);
      $weekview = main($database,$str);
    }
    if($weekview==null){
      continue;
    }else{
      updateinfo($database,$weekview,$video_id);
    }
  }
}






?>
