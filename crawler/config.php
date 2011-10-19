<?php
 $dbh = mysql_connect('localhost','root','masato') or die('Cannot connect to the database: '. mysql_error());
 $db_selected = mysql_select_db('crawler') or die ('Cannot connect to the database: ' . mysql_error());
$project="crawler";
$prefix="cra";
$numvideos=100;
$fdirectory="/home/naka/tubekitfirst/crawler/flash";
$mdirectory="/var/www/TubeKit/crawler/mpeg";
$mpdirectory="/home/naka/tubekitfirst/tools/magpierss-0.72";
$ytdldirectory="/home/naka/tubekitfirst/tools";
?>
