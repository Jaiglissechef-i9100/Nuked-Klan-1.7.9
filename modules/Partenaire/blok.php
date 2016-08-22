<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// Ce programme n'est pas un logiciel libre.                                //
// Vous pouvez donc pas le redistribuer et / ou modifier                    //
// Module Partenaire Flash pour NK 1.7.9  RC6                               //
// Créer par Stive @ PalaceWaR.eu / nk-create.com                           //
// Version 1.00 Compressé                                                   //
// Dernier teste effectue le 07/03/2012 13h00 Version Beta                  //
// -------------------------------------------------------------------------//
defined("INDEX_CHECK") or  die ("<div style=\"text-align: center;\">Vous ne pouvez pas ouvrir cette page directement</div>");


global $nuked, $file, $language;
translate("modules/Partenaire/lang/" . $language . ".lang.php");

$visiteur = $user ? $user[1] : 0;
	
$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);

if ($active == 1 || $active == 2)
{	
			echo "<div style=\"text-align:center;margin-top:10px;\">\n"
			. "<object type=\"application/x-shockwave-flash\" data=\"modules/Partenaire/Banner_88-31.swf\" width=\"88\" height=\"31\">\n"
			. "<param name=\"movie\" value=\"modules/Partenaire/Banner_88-31.swf\" />\n"
			. "<param name=\"pluginurl\" value=\"http://www.macromedia.com/go/getflashplayer\" />\n"
			. "<param name=\"wmode\" value=\"transparent\" />\n"
			. "<param name=\"menu\" value=\"false\" />\n"
			. "<param name=\"quality\" value=\"best\" />\n"
			. "<param name=\"scale\" value=\"autohigh\" />\n"
			. "<param name=\"salign\" value=\"center\" />\n"
			. "</object>\n"
			. "</div>\n"
			. "<div style=\"position:relative; bottom:0;text-align:right;font-size:10px \">&brvbar;<a href=\"index.php?file=Partenaire\">" . _PROPOSER . "</a>&brvbar;</div>\n";
}
if ($active == 3 || $active == 4)
{	
			echo "<div style=\text-align:center;margin-top:10px;\">\n"
			. "<object type=\"application/x-shockwave-flash\" data=\"modules/Partenaire/Banner_460-60.swf\" width=\"460\" height=\"60\">\n"
			. "<param name=\"movie\" value=\"modules/Partenaire/Banner_460-60.swf\" />\n"
			. "<param name=\"pluginurl\" value=\"http://www.macromedia.com/go/getflashplayer\" />\n"
			. "<param name=\"wmode\" value=\"transparent\" />\n"
			. "<param name=\"menu\" value=\"false\" />\n"
			. "<param name=\"quality\" value=\"best\" />\n"
			. "<param name=\"scale\" value=\"autohigh\" />\n"
			. "<param name=\"salign\" value=\"center\" />\n"
			. "</object>\n"
			. "</div>\n"
			. "<div style=\"position:relative; bottom:0;text-align:right;font-size:10px \">&brvbar;<a href=\"index.php?file=Partenaire&op=main\">" . _PROPOSER . "</a>&brvbar;</div>\n";
}
?>