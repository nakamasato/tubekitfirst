<?



$category = array(0 => 'All',1 => 'Autos',2 => 'Comedy',3 => 'Education',4 => 'Entertainment', 5 => 'Film', 6 => 'Gaming', 7 => 'Howto', 8 => 'News',9 => 'Nonprofits', 10 => 'People', 11 => 'Pets', 12 => 'Science',13 => 'Sports', 14 => 'Travel');



for($i=0; $i < 15; $i++){
 echo("if you want ".$category[$i]. " then put ".$i. "\n");
}


$input = (int) fgets(STDIN,4096);
//echo($category[$input]. "\n");


if($input == 0){
$ca = "";
}else{ 
$ca ="_".$category[$input]."?v=2";
}
//echo $ca;
  $url = "https://gdata.youtube.com/feeds/api/standardfeeds/most_viewed$ca";
print($url. "\n");

$cv = $ca.$url;
print $cv;
/*

if (is_int($input)){
  echo("int!!");		 
}
echo($input. "\n");
print_r($category);

if ($input == 0){ 
  echo("otherwise\n");
}elseif($input == 3){
  echo("news\n");
}else{
  echo("mistaken\n");
}  
$a = 4;
echo($a."\n");
print($input. "\n");
print($argv[1]."\n");
*/

?>
