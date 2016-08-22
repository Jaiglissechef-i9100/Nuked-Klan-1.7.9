<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

global $nuked, $language, $user;
translate('modules/Banlist/lang/' . $language . '.lang.php');

/* COnstante table */
define('BANLIST_TABLE', $nuked['prefix'] . '_banlist');
define('BANLIST_CONFIG_TABLE', $nuked['prefix'] . '_banlist_config');


$visiteur = ($user) ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

    function index()
    {
		global $nuked, $user, $bgcolor1, $bgcolor2, $bgcolor3, $language;

		$sql=mysql_query("SELECT * FROM ".BANLIST_CONFIG_TABLE." where id='1'" ); 
		list($id, $iden) = mysql_fetch_array($sql);

	     echo "<br /><div style=\"text-align: center;\"><big><u><b>"._LISTOFBAN."</b></u></big></div><br />\n"
		. "<table style=\"margin-left: auto;margin-right: auto;text-align: left; background: " . $bgcolor2 . ";\" width=\"90%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
		. "<tr style=\"background: ".$bgcolor3.";\">\n"
		. "<td style=\"width: 5%; text-align: center;\"><b>N°</b></td>\n"
		. "<td style=\"width: 15%; text-align: center;\"><b>".$iden."</b></td>\n"
		. "<td style=\"width: 30%; text-align: center;\"><b>"._PSEUDOBAN."</b></td>\n"
		. "<td style=\"width: 15%; text-align: center;\"><b>"._RAISONBAN."</b></td>\n"
		. "<td style=\"width: 20%; text-align: center;\"><b>"._DATEBAN."</b></td>\n"
		. "<td style=\"width: 5%; text-align: center;\"><b>"._INFOSBAN."</b></td>\n";

		$sql = mysql_query("SELECT id, identifiant, pseudo, raison, admin, date FROM " . BANLIST_TABLE . " ORDER BY id DESC ");
		$count = mysql_num_rows($sql);
		$l = 0;
		while (list($id, $identifiant, $pseudo, $raison, $admin, $date) = mysql_fetch_array($sql))
		{
		    $l++;
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

			$raison2 = strlen(strip_tags($raison)) > 12 ? substr(strip_tags($raison), 0, 12).'...' : $raison;

		    echo "<tr style=\"background: " . $bg . ";\">\n"
		    . "<td style=\"width: 5%; text-align: center;\">" . $id . "</td>\n"
		    . "<td style=\"width: 15%; text-align: center;\">" . $identifiant . "</td>\n"
		    . "<td style=\"width: 30%; text-align: center;\">" . $pseudo . "</td>\n"
		    . "<td style=\"width: 15%; text-align: center;\"><a href=\"#\" onmouseover=\"AffBulle('"._RAISONBAN."', '" . htmlentities(mysql_real_escape_string($raison), ENT_NOQUOTES) . "', 150)\" onmouseout=\"HideBulle()\">" . $raison2 . "</a></td>\n"
		    . "<td style=\"width: 20%; text-align: center;\">" . nkdate($date) . "</td>\n"
		    . "<td style=\"width: 5%; text-align: center;\"><a href='index.php?file=Banlist&amp;op=details&amp;mid=".$id."'>[+]</a></td>\n";
		}
		echo"</tr></table><br />";

		if ($count == 0) echo "<br /><div style=\"text-align: center;\">"._NOBAN."</div><br />\n";
    }

    function details($mid)
    {
		global $nuked, $user, $language;
	
		$sql = mysql_query("SELECT * FROM ".BANLIST_TABLE." WHERE id = '" . $mid . "'");
		list($id, $identifiant, $pseudo, $raison, $admin, $date, $serveur, $record) = mysql_fetch_array($sql);
		{
			echo "<br><center><big><u><b>"._INFOBAN." ".$pseudo."</u></b></big></center><br><br>\n"
			. "<table align=center border=0 width=400 ><tr><td><b>"._IDENTBAN." :</b> ".$identifiant."</td></tr>\n"
			. "<tr><td><b>"._PSEUDOBAN." : </b>".$pseudo."</td></tr>\n"
			. "<tr><td><b>"._BANFOR." : </b>".$raison."</td></tr>\n"
			. "<tr><td><b>"._BYADMIN.": </b>".$admin."</td></tr>\n"
			. "<tr><td><b>"._BANTHE." : </b>" . nkdate($date) . "</td></tr>\n"
			. "<tr><td><b>"._SERVERBAN." : </b>".$serveur."</td></tr>\n"
			. "<tr><td><b>"._LIENBAN." : </b><a href='".$record."' title='"._DOWNBAN."' target='_blank'>"._DOWNBAN."</a></td></tr>\n"
			. "</table><br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Banlist\"><b>" . _BACK . "</b></a> ]</div><br />\n";
		}	
    }


    switch($_REQUEST['op'])
	{ 
		case"index":
			index();
			break;

		case "details":
		details($_REQUEST['mid']);
		break;


		default:
			index();
			break;
    }

} 
else if ($level_access == -1){
    opentable();
    echo '<br /><br /><div style="text-align: center">' . _MODULEOFF . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a><br /><br /></div>';
    closetable();
} 
else if ($level_access == 1 && $visiteur == 0){
    opentable();
    echo '<div style="text-align: center; margin: 10px 0">' . _USERENTRANCE . '<br /><br /><b><a href="index.php?file=User&amp;op=login_screen">' . _LOGINUSER . '</a> | <a href="index.php?file=User&amp;op=reg_screen">' . _REGISTERUSER . '</a></b>/div>';
    closetable();
} 
else{
    opentable();
    echo '<br /><br /><div style="text-align: center">' . _NOENTRANCE . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a><br /><br /></div>';
    closetable();
} 
?>