<?




function a($i){
  if (preg_match("/a/i",$i)){
      echo("OK\n");
      return $i;
    }
}
$ii="aa";
a('aaaa');
$result =a($ii);
echo("result : ".$result."\n");


for($i=0;$i<3;$i++){
$a[$i]=array('a'=>$i,'c'=>($i+1),'b'=>'1');
}
natsort($a);
var_dump($a);




?>