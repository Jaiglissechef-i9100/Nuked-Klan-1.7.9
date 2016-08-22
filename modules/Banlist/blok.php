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

global $nuked, $theme, $language, $bgcolor1, $bgcolor2, $bgcolor3;
translate("modules/Banlist/lang/" . $language . ".lang.php");


	$sql = mysql_query("SELECT id, identifiant, pseudo, raison, admin, date FROM $nuked[prefix]"._banlist." ORDER BY id DESC LIMIT 0, 10");
	$count = mysql_num_rows($sql);
	$l = 0;

    if($count == 0)
    {
        echo"<br><div style=\"text-align: center;\">"._NOBAN."</div><br>";
    }

	while (list($id, $identifiant, $pseudo, $raison, $admin, $date) = mysql_fetch_array($sql))
	{
        if ($i == 0)
        {
            $bg = $bgcolor2;
            $i++;
        } 
        else
        {
            $bg = $bgcolor1;
            $i = 0;
        } 

    	echo "<table><tr style=\"background: " . $bg . ";\">\n"
    	    . "<td style=\"width: 80%;\" align=\"left\">" . $identifiant . "</td>\n"
    	    . "<td style=\"width: 10%;\" align=\"left\">" . nkDate($date) . "</td>\n"
    	    . "<td style=\"width: 10%;\" align=\"left\">[<a href='index.php?file=Banlist&amp;op=details&amp;mid=".$id."'>+</a>]</td>\n"
    	    . "</tr></table>\n";
    }

    if($count != 0)
    {
	   echo"<br><div style=\"text-align: center;\"><b><a href='index.php?file=Banlist'>"._SEEALL."</a></b></div>\n";
    }
?>