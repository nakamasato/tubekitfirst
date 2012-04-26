<?php


require_once("config.php");
require_once("../".$mpdirectory."/rss_fetch.inc");
require_once("parseRSS.php");
require_once("endwith.php");
require_once("startwith.php");
require_once("stop.php");

   $category = array(0 => 'All',1 => 'Autos',2 => 'Comedy',3 => 'Education',4 => 'Entertainment', 5 => 'Film', 6 => 'Gaming', 7 => 'Howto', 8 => 'News',9 => 'Nonprofits', 10 => 'People', 11 => 'Pets', 12 => 'Science',13 => 'Sports', 14 => 'Travel');
   $categoryinverse = array('All'=>0,'Autos'=>1,'Comedy'=>2,'Education'=>3, 'Entertainment'=>4, 'Film'=>5,  'Gaming'=>6, 'Howto'=>7, 'News'=>8, 'Nonprofits'=>9, 'People'=>10,  'Pets'=>11,  'Science'=>12, 'Sports'=>13,  'Travel'=>14);


echo("select month\n");
$month = (int)fgets(STDIN,4096);
echo("select day\n");
$day = (int)fgets(STDIN,4096);
if($day<10){
$a = '2011_'.$month."_0$day";
}else{
$a = '2011_'.$month."_$day";
}
   $mysql = "show tables from backbone";
   $result = mysql_query($mysql);
   $number = 0;
   $table = array();
while ( $row = mysql_fetch_row($result)){
  if(startsWith($row[0],$a)){
    echo($number." : ". $row[0]."\n");
    $table[$number] = $row[0];   
    $number++;
  }
}
$size=$number;
$i=0;
echo("select category\n");
$select = (int)fgets(STDIN,4096);


for($number=0;$number<$size;$number++){
  if(preg_match("/week100/",$table[$number])){
    echo($number.":".$table[$number]."\n");
    $week100 = $table[$number];
  }
}


function cate($i2){
  if(preg_match("/all/i",$i2)){return "All";}
  else if(preg_match("/autos/i",$i2)){return "Autos";}
  else if(preg_match("/howto/i",$i2)){return "Howto";}
  else if(preg_match("/news/i",$i2)){return "News";}
  else if(preg_match("/people/i",$i2)){return "People";}
  else if(preg_match("/sports/i",$i2)){return "Sports";}
  else if(preg_match("/travel/i",$i2)){return "Travel";eco("!!!!!!!!!!!!!\n");}
  else if(preg_match("/comedy/i",$i2)){return "Comedy";}
  else if(preg_match("/education/i",$i2)){return "Education";}
  else if(preg_match("/entertainment/i",$i2)){return "Entertainment";}
  else if(preg_match("/film/i",$i2)){return "Film";}
  }  
$cate = cate($table[$select]);
var_dump($cate);




$s = "select video_count from $table[$select] limit 1";
$r = mysql_query($s);
$i=0;
while( $line = mysql_fetch_array($r,MYSQL_ASSOC)){
  $viewoftop = $line['video_count'];
  $i++;
}

$s = "select * from $week100 where category = '$cate'";
$r = mysql_query($s);
$i=0;
while( $line = mysql_fetch_array($r,MYSQL_ASSOC)){
  $week[$i][0] = $line['id'];
  $week[$i][1] = $line['category'];
  $week[$i][2] = $line['video_id'];  
  $week[$i][4] = $viewoftop/($i+1);
  $id = trim($line['video_id']);
  $point = $week[$i][4];
  $discrimination[$id]= $point;
  // echo($i." ".$id." ".$point."\n");
  $i++;
}
$sizeweek=$i;

$s = "select keyword,video_id,video_count from $table[$select] order by keyword";
$r = mysql_query($s);
$num = -1;
$i=0;
while( $line = mysql_fetch_array($r,MYSQL_ASSOC)){
  $key = $line['keyword'];
  if(!empty($hash[$key])){continue;}
  $vid = $line['video_id'];
  $abc = $discrimination[$vid];
  if(empty($abc)){continue;}
  $video[$i][0] = $line['video_id'];
  $video[$i][1] = $line['keyword'];
  $video[$i][2] = $line['video_count'];
  $p = $discrimination[$vid];
  if($keycheck !=$key ){
    $num++;
    //    echo($num.$key."\n");
    $keypoint[$num][0]=$key;
    $keypoint[$num][1]=$p;
    $keycheck=$key;
    $numbertable[$num]=$i;
  }else{
    $plural[$num]++;
    $keypoint[$num][1]+=$p;
    //    echo($num.$key."\n");
  }
  $i++;
  
}
natsort($keypoint);
$size=$num;
for($i=0;$i<$size;$i++){
  if($keypoint[$i][1]>10000)
    var_dump($keypoint[$i]);
}

var_damp($plural);



?>
