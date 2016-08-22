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

global $user,$nuked, $language;
translate("modules/Server/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");

admintop();

if (!$user)
{
    $visiteur = 0;
} 
else
{
    $visiteur = $user[1];
} 
$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1)
{
    function main()
    {
		echo '<div style="text-align: center;"><b>Administration du module Tags</b><br /><br />'
		. '<form action="index.php?file=Tags&page=admin&op=change" method="post">'
		. '<b>Quel tags afficher :</b> Mots-clefs<input type="radio" name="key" value="keyword">&nbsp;&nbsp;&nbsp;'
		. '15 meilleurs articles<input type="radio" name="key" value="sections"><br /><br /><input type="submit" value="Modifier"></form></div>';
	}
	
	function change($key)
	{
		global $nuked;
		
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '".$key."' WHERE name = 'tags'");
		echo '<div style="text-align: center;">Changement effectué</div>';
		redirect("index.php?file=Tags&page=admin", 2);
	}
	
	
    switch ($_REQUEST['op'])
    {
        case "main":
            opentable(); 
            main();
            closetable();
            break;

        case "change":
            opentable(); 
            
            change($_REQUEST['key']);
            closetable();
            break;
			
        default:
            opentable();
            main();
            closetable();
            break;
    } 

} 
else if ($level_admin == -1)
{
    echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
}
else if ($visiteur > 1)
{
    echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
}
else
{
    echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
}	 

adminfoot();