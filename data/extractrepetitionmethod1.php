<?

require_once("../backbone/config.php");

$sql = "show tables like '%key50'";
$result = mysql_query($sql) or die(" ".mysql_error());
while($row = mysql_fetch_row($result)){
  $sql = "show columns from $row[0] like 'weekview'";
  $res = mysql_query($sql);
  while($r = mysql_fetch_row($res)){
  echo($j."  ".$row[0]."\n");
  $table[$j]=$row[0];
  $j++;
  }
}
$input = (int)fgets(STDIN,4096);
$selected = $table[$input];

  $sql = "select * from $selected order by keyword";
$result = mysql_query($sql) or die(" ". mysql_error());
$i=-1;
$check="";
while($line = mysql_fetch_array($result)){
  $keyword = trim($line['keyword']);
  //  $keyword = strtolower($keyword);
  $weekview = (int)$line['weekview'];
  //  echo($weekview);
  if(strcasecmp($keyword,$check)==0){
    $point[1][$i]+=$weekview;
  }else{
    $check = $keyword;
    $i++;
    $point[0][$i]=$keyword;
    $point[1][$i]=$weekview;
  }
  //echo($point[0][$i]."\n");
}
echo(sizeof($point[0]));
/*
for($i=0;$i< sizeof($point[0]);$i++){
  if($point[1][$i] > 100000){
    echo($point[0][$i]." ");
  }
}
    echo("\n");

    //var_dump($point);
    */
array_multisort($point[1],$point[0]);
/*
for($i=0;$i < sizeof($point[0]);$i++){
  if($point[1][$i] > 100000){
    echo($point[0][$i]." ");
  }
  //  echo($i." ".$point[0][$i]." ".$point[1][$i]."\n");
}

*/

for($i=0;$i < sizeof($point[0]);$i++){
  $p[$i][0]=$point[0][$i];
  $p[$i][1]=$point[1][$i];
  echo($p[$i][0]." ".$p[$i][1]."\n");
}
echo(sizeof($p));
//     var_dump($p);



?>
