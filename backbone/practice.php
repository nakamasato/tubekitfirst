<?php 
  require_once("config.php");
  require_once("../".$mpdirectory."/rss_fetch.inc");
  require_once("parseRSS.php");
  $tablename = "TRY6";


//input method

$sql = "SHOW TABLES FROM backbone";
$result = mysql_query($sql);
echo "which table do you want to use as keyword? Select the number.\n";
$number = 0;
$table = array();
while ($row = mysql_fetch_row($result)) {
    echo ($number.": {$row[0]}\n");
    $table[$number] = $row[0];
    $number++;
}

$input = (int) fgets(STDIN,4096);
echo($table[$input]. "\n"); 

$v = " music";
  $select = "select * from $table[$input] where keyword ='$v'";
  $vresult = mysql_query($select) or die(" ". mysql_error());
  $num_rows = mysql_num_rows($vresult);
  echo	$num_rows;
  while($line =  mysql_fetch_array ($vresult, MYSQL_ASSOC)){
  echo $line['name'];
  $a = fgets(STDIN,4096);	
  }
/*
  $query = "select * from $tablename";
  $vresult = mysql_query($query) or die(" ". mysql_error());
  $the_number = 0;

  while ($line = mysql_fetch_array ($vresult, MYSQL_ASSOC)){
    $count[$the_number]["0"] = $line['name'];
    $count[$the_number]["1"] = $line['title'];   
    $count[$the_number]["2"] = $line['view_count'];   
    $count[$the_number]["3"] = $line['keyword'];   
    $the_number++;
  }


echo($the_number);

$j=0;
while($j < $the_number ){
if ($count[$j]["2"] >=  "300000000"){
echo ($count[$j]["3"]. "\n");
 }
$j++;
}

$asobi = "name";
$query2 = "select $asobi from $tablename where query_id > 1350";
$vresult2 = mysql_query($query2) or die(" ". mysql_error());

$t=0;
  while ($line = mysql_fetch_array ($vresult2, MYSQL_ASSOC)){
    $count1[$t] = $line['name'];
    $t++;
  }

echo($t. "\n");
*/



?>