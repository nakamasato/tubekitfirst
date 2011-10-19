<?php 

require_once("config.php");
require_once("../".$mpdirectory."/rss_fetch.inc");
require_once("parseRSS.php");

//echo date("Y年m月d日 H時i分s秒"); // 現在時刻を表示します




$date = date("Y_m_d_H_i_s");
$query = $date."_query_most_viewed_today";
echo($query. "\n");

?>