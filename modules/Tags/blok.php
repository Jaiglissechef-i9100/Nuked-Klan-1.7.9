<?php

/*
|--------| Copyright |----------------------------------|
|Basé sur TagCloud-a-like script v1.1                   |
|Module Tags by NatzoX http://www.nuked-klan.org        |
|-------------------------------------------------------|
*/
if (eregi("blok.php", $_SERVER['PHP_SELF']))
{
    die ("You cannot open this page directly");
} 

global $nuked;
$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);
if ($active == 1 || $active ==2 || $active == 3 || $active == 4)
{

$min = '8'; // Minimum font size in pixel.
$max = '22'; // Maximum font size in pixel.
$decor = 'text-decoration:none;font-weight:100;'; // Inline CSS per link.

$array = array();
if ($nuked['tags'] == "keyword") {
$cible = $nuked['keyword'];
}
else {
$sql = mysql_query("SELECT titre FROM " . NEWS_TABLE . " ORDER BY date DESC LIMIT 0, 15");
while(list($title) = mysql_fetch_array($sql))
{
	$cible .= "".$title.",";
}
}
$tags = explode(",", $cible);
if( isset($tags) )
{
  for ($t = 0; $t < count($tags); $t++)
  {
array_push($array,"<a style=\"font-size: ".rand($min,$max)."px; " . $decor . "\" href=\"./tag.php?$tags[$t]\">$tags[$t]</a>");
// Que l'on remplacera évidemment par la requete MySQL de son choix

  }
}

shuffle($array); // This will asure link random appearance.
ksort($array);
foreach ($array as $key => $val)
  {
    echo "$val ";
  }
}
?>