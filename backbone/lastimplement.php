<?
require_once("Last.php");


$mysql = "show tables from backbone";
$result = mysql_query($mysql) or die(" ".mysql_errr());
$number = 0;
$table = array();
while ( $row =mysql_fetch_row($result)){
  if((endsWith($row[0],"People_weekkey50"))||(endsWith($row[0],"Entertainment_weekkey50"))){
    echo($number." : ". $row[0]."\n");
    $table[$number] = $row[0];
    $number++;
  }
}



function all($database){
  addcolumnpoint($database);
  $keywords =extractkeywordfromdatabase($database);
  for($i=0;$i< sizeof($keywords); $i++){
    $keyword=$keywords[$i];
    $ids=  extract1000vfromkeyword($keyword,$database);
    var_dump($ids);
    $totalview=0;
    $num=0;
    echo($j."             totalview                    ".$totalview."\n");
    for($j=0;$j< sizeof($ids);$j++){
      $id=$ids[$j];
      $str=fileget($id);
      $view=main($database,$str);
      $totalview += $view;
      if($view>0){$num++;}
      echo($j."             totalview                    ".$totalview."\n");
    }
    if(($num == 0)||($totalview == 0)){
      $average = 0;
    }else{
      $average = $totalview / (float)$num;
    }
    $sql = "update $database set point = $totalview , average = $average where keyword = '$keywords[$i]'";
    echo($sql."\n");
    $result = mysql_query($sql) or die(" ". mysql_error());
  }
}



for($i=0;$i < sizeof($table); $i++){
  $database = $table[$i];
  all($database);
}
?>