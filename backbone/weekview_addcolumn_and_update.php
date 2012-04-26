<?php
require_once("weekview.php");


$database=selectdatabase();
var_dump($database);
for($i=0;$i < sizeof($database);$i++){
  $i=sizeof($database)-1;
  $db=$database[$i];
  var_dump($db);
  databaseToweekview($db);
}








?>