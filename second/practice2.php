<?php 

require_once("config.php");
require_once("../".$mpdirectory."/rss_fetch.inc");
require_once("parseRSS.php");

$date = date("Y_m_d_H_i_s");


$query = "create table $date ( id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(id),name VARCHAR(100),keyword VARCHAR(1000))";
$vresult = mysql_query($query) or die(" ". mysql_error());







?>