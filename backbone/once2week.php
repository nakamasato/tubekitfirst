<?phpchdir('/var/www/TubeKit/backbone');	ini_set("memory_limit","100M");	require_once("config.php");	require_once("../".$mpdirectory."/rss_fetch.inc");//TubeKit/first/collectOnce.php,, TubeKit/tools/magpierss-0.72 .	require_once("parseRSS.php");	$access=0;	$copy=0;	$time = 1.0;// MASATO MADE.	$t=getdate();        $today=date('Y-m-d',$t[0]);	$oTableName = "todaykeryword";	$sql = "SHOW TABLES FROM backbone";	$result = mysql_query($sql);	echo "which table do you want to use as keyword? Select the number.\n";	$number = 0;	$table = array();	while ($row = mysql_fetch_row($result)) {	    echo ($number.": {$row[0]}\n");	    $table[$number] = $row[0];            $number++;	}        $input = (int) fgets(STDIN,4096);        $num = (int) $input;	$newtable = $table[$input]. "vinfoweek50";        $query2 = "create table $newtable ( id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(id),original_video_name varchar(100),keyword varchar(100),picked_video varchar(100),view_count integer(15), videoID varchar(11),timestamp int(11),rating_count int(10), rating_avg varchar(5))";	$vresult2 = mysql_query($query2) or die(" ". mysql_error());	$query = "SELECT * FROM $table[$input]"; 	//echo $query;	$vresult = mysql_query($query) or die(" ". mysql_error());	while ($line = mysql_fetch_array($vresult, MYSQL_ASSOC)) //Returns an array of strings that corresponds to the fetched row	{	    $originalvideo = $line['name'];            $v2 = $line['keyword'];	    $v2 = trim($v2);	    //echo($v2."\n");		    $query = "SELECT * from $newtable WHERE keyword='$v2'";	    //echo($query. "\n");            $result = mysql_query($query) or mysql_error();            $num_rows = mysql_num_rows($result);	    echo($num_rows. "\n");				            if ($num_rows == 0)            {	    $access+=1;	    $vquery = urlencode($v2);	    $qid = $line['id'];		$numvideos = 50;			$maxIndex = $numvideos-49;		for ($index=1; $index<=$maxIndex; $index+=50)//index=1,11,21..		{			$url = "http://gdata.youtube.com/feeds/api/videos/-/$v2?max-results=50&start-index=$index&v=2&time=this_week";			//echo($url."before fetch_rss\n");			$rss = fetch_rss($url);			//var_dump($rss);			//echo("\n\n\n\n\n");				foreach ($rss->items as $item) 			{				$yt_url = $item['link'];				$ytID = substr($yt_url,31,11);					$feedURL = "http://gdata.youtube.com/feeds/api/videos/$ytID";					//echo($feedURL. "in for each\n");					sleep($time);					if(file_get_contents($feedURL))					{						$time = 0.8 * $time ;						$entry = simplexml_load_file($feedURL);//Convert the well-formed XML document in the given file to an object.						$video = parseVideoEntry($entry);						$timestamp = time();						$title = $video->title;											$upload_time = $video->published;						$duration = $video->length;						$category = $video->category;						$video_url = $video->watchURL;												$keywords = $video->keywords;						$view_count = $video->viewCount;						$rating_count = $video->numrating;						$rating_avg = $video->rating;												$q = "insert into $newtable VALUES ('','$originalvideo','$v2','$title','$view_count','$ytID','$timestamp',$rating_count,$rating_avg)";                                                //echo($q. "insertquery\n");                                                $r = mysql_query($q) or mysql_error();					}else{					$time = $time + 5.0;					echo("failed\n");					}//if(file_get_contents($feedURL))			} // foreach ($rss->items as $item) 		} // for ($index=1; $index<=51; $index+=50)	  }else{	     echo("num>1\n");	     $copy += 1;                                        while ($line2= mysql_fetch_array($result, MYSQL_ASSOC)){                                              $title = $line2['picked_video'];                                              $view_count = $line2['view_count'];                                              $ytID = $line2['videoID'];                                              $timestamp = $line2['timestamp'];					      $rating_count = $line2['rating_count'];					      $rating_avg = $line2['rating_avg'];                                              $q = "insert into $newtable VALUES ('','$originalvideo','$v2','$title','$view_count','$ytID','$timestamp','$rating_count','rating_avg')";                                              echo($q. "insertquery\n");                                              $r = mysql_query($q) or mysql_error();                                        }//while($line2 = mysql_fetch_array($result, MYSQL_ASSOC))	  }//if($num_rows == 0)	}		echo("access is".$access."times\n");echo("copy is".$copy."times\n"); ?>