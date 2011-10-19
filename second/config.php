<?php
 $dbh = mysql_connect('localhost','root','masato') or die('Cannot connect to the database: '. mysql_error());
 $db_selected = mysql_select_db('second') or die ('Cannot connect to the database: ' . mysql_error());
$project="second";
$prefix="sec";
$numvideos=100;
$fdirectory="/var/www/TubeKit/second/flash";
$mdirectory="/var/www/TubeKit/second/mpeg";
$mpdirectory="tools/magpierss-0.72";
$ytdldirectory="/var/www/TubeKit/tools";
?>
