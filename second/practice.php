<?php 

require_once("config.php");
require_once("../".$mpdirectory."/rss_fetch.inc");
require_once("parseRSS.php");

$tablename = "sec_queries";
$query = "select * from $tablename";
$vresult = mysql_query($query) or die(" ". mysql_error());
$i = 0;
while ($line = mysql_fetch_array ($vresult, MYSQL_ASSOC))
{
echo($line['query']. "\n");
$i++;
echo($i."\n");
}

?>