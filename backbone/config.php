<?php
 $dbh = mysql_connect('localhost','root','masato') or die('Cannot connect to the database: '. mysql_error());
 $db_selected = mysql_select_db('backbone') or die ('Cannot connect to the database: ' . mysql_error());
$project="backbone";
$prefix="bck";
//$numvideos=100;
$fdirectory="/var/www/TubeKit/backbone/flash";
$mdirectory="/var/www/TubeKit/backbone/mpeg";
$mpdirectory="tools/magpierss-0.72";
$ytdldirectory="/var/www/TubeKit/tools";
?>
