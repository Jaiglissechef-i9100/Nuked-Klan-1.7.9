<?php
//-------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify   //
//  it under the terms of the GNU General Public License as published by   //
//  the Free Software Foundation; either version 2 of the License.         //
//-------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
} 

global $nuked, $language;
translate("modules/Syndication/lang/" . $language . ".lang.php");

opentable();

echo "<br /><div style=\"text-align: center;\"><big><b>" . _SYNDICATE . "&nbsp;" . $nuked['name'] . "</b></big><br /><br />" . $nuked['name'] . ",  " . _SYNDICATERSS . "</div><br />\n";

$rep = Array();
$handle = @opendir("rss");
while (false !== ($f = readdir($handle)))
{
    if ($f != ".." && $f != "." && $f != "index.html")
    {
	list ($nom, $ext) = split ('[.]', $f);
	$nom = eregi_replace("_rss", "", $nom);

        if ($nom == "news")
        {
            $name = _NEWSRSS;
            $pos = 1;
        } 
        else if ($nom == "sections")
        {
            $name = _SECTIONSRSS;
            $pos = 2;
        } 
        else if ($nom == "download")
        {
            $name = _DOWNLOADRSS;
            $pos = 3;
        } 
        else if ($nom == "links")
        {
            $name = _LINKSRSS;
            $pos = 4;
        } 
        else if ($nom == "gallery")
        {
            $name = _GALLERYRSS;
            $pos = 5;
        } 
        else if ($nom == "forum")
        {
            $name = _FORUMRSS;
            $pos = 6;
        } 
        else
        {
            $name = $nom;
            $pos = 6;
        } 
        array_push($rep, $pos . "|" . $name . "|" . $f);
    }
}
closedir($handle);

echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n";

natcasesort($rep);
foreach($rep as $value)
{
    $rss = explode("|", $value);
    echo "<tr><td><a href=\"rss/" . $rss[2] . "\" onclick=\"window.open(this.href); return false;\"><img style=\"border: 0;\" src=\"modules/Syndication/images/rss.png\" alt=\"\" title=\"RSS 2.0 (xml)\" /></a></td><td valign=\"middle\"><b>" . $rss[1] ."</b></td></tr>\n";
} 

echo "</table><br />\n";

closetable();

?>