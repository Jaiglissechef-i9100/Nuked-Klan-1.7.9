<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}
function affich_block_video($blok){
    $blok['content'] = block_video($blok['content']);
    return $blok;
}
global $nuked, $user, $theme, $language, $bgcolor1, $bgcolor2, $bgcolor3;
translate("modules/Video/lang/" . $language . ".lang.php");
	define('VIDEO_TABLE', $nuked['prefix'] . '_video');
	define('VIDEO_CAT_TABLE', $nuked['prefix'] . '_video_cat');
	$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);
if ($active == 1 || $active == 2){
		echo "<div class=\"bottom\">
		<ul style=\"list-style: none; padding: 0\">
		<li class=\"titlemenu\" style=\"padding-left: 20px\"><b>"._CAT."</b></li>";
		$sql2 = mysql_query("SELECT idcat, categorie, statuscat FROM " . VIDEO_CAT_TABLE . " WHERE statuscat = '1' GROUP BY idcat")or die(mysql_error()."\n".$sql);
		while (list($idcat, $categorie) = mysql_fetch_array($sql2)){
		$idcat = printSecuTags($idcat);
		$categorie = printSecuTags($categorie);
		echo"<li><a class=\"menu\" style=\"padding-left: 10px\" title=\"\" href=\"index.php?file=Video&amp;op=categorie&amp;idcat=".$idcat."\">".$categorie."</a></li>";
		}
		echo"</ul></div>";
}
?>