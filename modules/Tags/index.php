<?php

/*
|--------| Copyright |----------------------------------|
|TagCloud-a-like script v1.1                            |
|Copyright (c) 2008 Sasha Khamkov                       |
|http://www.sanusart.com                                |
|mail@sanusart.com, scamme@gmail.com                    |
|                                                       |
|--------| Usage |--------------------------------------|
|Add links to the "$array" in the predefined structure. |
|Use "include('cloud.php')" to call the script.         |
|-------------------------------------------------------|
*/
global $nuked;
OpenTable();

$min = '8'; // Minimum font size in pixel.
$max = '22'; // Maximum font size in pixel.
$decor = 'text-decoration:none;font-weight:100;'; // Inline CSS per link.

$array = array();
if ($nuked['tags'] == "keyword") {
$cible = $nuked['keyword'];
}
else {
$sql = mysql_query("SELECT title FROM " . SECTIONS_TABLE . " ORDER BY counter DESC LIMIT 0, 15");
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


  }
}

shuffle($array);
ksort($array);
foreach ($array as $key => $val)
  {
    echo "$val ";
  }
  
CloseTable();
?>