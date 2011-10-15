<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>

<?php


//Qtd, lastID

include 'class.twitter.php';
include 'JSON.php';


$TWITTER_CACHE_FILE = 'twitter-cache.json';
$EXPIRE_TIME = .001;//1 = 1hora

$flaQuery = "MeuRioÉFla OR MeuRIoEFla OR MeuRioÉFlamengo OR MeuRIoEFlamengo";
$fluQuery = "MeuRioÉFlu OR MeuRIoEFlu OR MeuRioÉFluminense OR MeuRioEFluminense OR MeuRIoENense OR MeuRIoÉNense";
$vascoQuery = "MeuRioÉVasco OR MeuRIoEVasco";
$botaQuery = "MeuRioÉBota OR MeuRIoEBota OR MeuRioÉFogo OR MeuRIoEFogo OR MeuRioÉBotafogo OR MeuRIoEBotafogo";


$json = new Services_JSON();
$cache_content = file_get_contents($TWITTER_CACHE_FILE);
$cached = $json->decode( $cache_content );

$current_time = time(); 
$expire_time = $EXPIRE_TIME * 60 * 60; 
$file_time = filemtime($TWITTER_CACHE);

if(file_exists($TWITTER_CACHE_FILE) && ($current_time - $expire_time < $file_time)) {
	//echo 'returning from cached file';
	//return file_get_contents($TWITTER_CACHE);
}
else {
	$t = new summize();

	$timeline = $t->search($flaQuery);
	$cached->flamengo += count($timeline->results);

	$timeline = $t->search($fluQuery);
	$cached->fluminense += count($timeline->results);

	$timeline = $t->search($vascoQuery);
	$cached->vasco += count($timeline->results);

	$timeline = $t->search($botaQuery);
	$cached->botafogo += count($timeline->results);
	
	file_put_contents($TWITTER_CACHE_FILE,$json->encode($cached));
}

echo "MeuRioéFla: " . $cached->flamengo . "<br/><hr />";

echo "MeuRioéFlu: " . $cached->fluminense . "<br/><hr />";

echo "MeuRioéVasco: " . $cached->vasco . "<br/><hr />";

echo "MeuRioéFogo: " . $cached->botafogo . "<br/><hr />";






//Codigo ruim
/*for ($i = 0; $i < count($array); $i++) {
    echo "Bom: " . $array[$i]->text . "<br/><hr />";
}

foreach( $timeline as $tweet ) {

  // Get the Tweet itself.
  $text = $tweet->text;

  // Twitter uses GMT+0 but I convert it to my local time.
  $date = date('M j, Y @ h:i A', strtotime($tweet->created_at));

  echo $text . "<br />" . $date . "<hr />";

}


echo'<pre>';
print_r( $t->search("design") );
echo'</pre>';
*/


/*$array = $timeline.results;

for ($i = 0; $i < count($array); $i++) {
    echo "Bom: " . $array[$i].text . "<br/><hr />";
}*/
?>

</body>
</html>