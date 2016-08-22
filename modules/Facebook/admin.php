<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined('INDEX_CHECK')) die('<div style="text-align:center;">You cannot open this page directly</div>');

global $user, $language;
translate("modules/Facebook/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");
admintop();
$visiteur = (!$user) ? 0 : $user[1];
$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);

if ($visiteur >= $level_admin && $level_admin > -1)
{
	
    function main()
    {
        global $nuked, $language;				
			
		$sql = mysql_query("SELECT id_facebook FROM " . $nuked['prefix'] . "_facebook WHERE id = '1'");
		list($id_facebook) = mysql_fetch_array($sql);
			
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
				. "<div class=\"content-box-header\"><h3>" . _ADMINFACEBOOK . "</h3></div><br />\n"
				. "<form method=\"post\" action=\"index.php?file=Facebook&amp;page=admin&amp;op=update\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" align=\"left\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\">\n"
				. "<tr>\n"
				. "<td style=\"text-align: right;\" width=\"50%\"><b>" . _FACEBOOKID . ":</b></td>\n"
				. "<td style=\"text-align: left;\" width=\"50%\"><input type=\"text\" id=\"id_facebook\" name=\"id_facebook\" value=\"" . $id_facebook . "\" /></td>\n"
				. "</tr></table>\n"
				. "<div style=\"text-align:center;\"><input type=\"submit\" style=\"margin-top: 10px; margin-bottom: 10px;\" name=\"send\" value=\"" . _SEND . "\" /></div>\n";
	} 

    function update($id_facebook)
    {
        global $nuked, $user;				
			
		$sqls = mysql_query("SELECT id_facebook FROM " . $nuked['prefix'] . "_facebook WHERE id = '1'");
		$count = mysql_num_rows($sqls);
		list($facebook) = mysql_fetch_array($sqls);

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFACEBOOK . "</h3></div><br />\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: center;\" width=\"50%\" align=\"center\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\">\n"
			. "<tr><td style=\"text-align: center;\"><big><b>\n";
		
				if(!$id_facebook)
				{			
						
							echo _FACEBOOKNOID;				
							echo"<div style=\"text-align: center; padding-bottom: 8px;\"><br />[ <a href=\"index.php?file=Facebook&page=admin\"><b>" . _BACK . "</b></a> ]</div>\n";
				
				}else if($count){
					
						$upd = mysql_query("UPDATE " . $nuked['prefix'] . "_facebook SET id_facebook = '" . $id_facebook . "' WHERE id = '1'");

						if($upd)
						{
							echo  _FACEBOOKUP;		
							redirect("index.php?file=Facebook&page=admin", 2);
						}else{
							echo _FACEBOOKNOUP;				
							echo"<div style=\"text-align: center; padding-bottom: 8px;\"><br />[ <a href=\"index.php?file=Facebook&page=admin\"><b>" . _BACK . "</b></a> ]</div>\n";		
						}
				}else{	
						$upd = mysql_query("INSERT INTO " . $nuked['prefix'] . "_facebook ( `id` , `id_facebook` ) VALUES ( '1' , '$id_facebook' )");
						if($upd)
						{
								echo _FACEBOOKADD;		
								redirect("index.php?file=Facebook&page=admin", 2);
								
							}else{
								echo _FACEBOOKNOADD;						
								echo"<div style=\"text-align: center; padding-bottom: 8px;\"><br />[ <a href=\"index.php?file=Facebook&page=admin\"><b>" . _BACK . "</b></a> ]</div>\n";
						}
				
				}
		echo"</b></big></td></tr></table></div>";
    } 
	
	

    switch ($_REQUEST['op'])
    {
			
        case "update":
			opentable();
				update($_REQUEST['id_facebook']);
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

?>
