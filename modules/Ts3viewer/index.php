<link rel="stylesheet" type="text/css" href="modules/Ts3viewer/styles.css" />
<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// Module TS3Viewer Pour NK 1.7.9                                           //
// Créer par Nexans @ nexcraft.fr                                           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK")){
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $nuked, $user, $language;

translate("modules/Ts3viewer/lang/" . $language . ".lang.php");

opentable();
$visiteur = (!$user) ? 0 : $user[1];
$level_access = nivo_mod("Ts3viewer");
if ($visiteur >= $level_access && $level_access > -1)
{
    function index()
    {
        global $bgcolor1, $bgcolor2, $bgcolor3, $nuked, $user;
		
		include_once('includes/class.ts3viewer.php');
		
	$sql2=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer_pref');
	  	while($req2 = mysql_fetch_object($sql2))
	  {	
	  	$srvid= $req2->srvid;
		$width_module= $req2->width_module;
	  }
	$sql1=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer WHERE id = '.$srvid.'');
	  	while($req1 = mysql_fetch_object($sql1))
	  {	
	  	$ip= $req1->ip;
		$q_port = $req1->q_port ;
	  }
		$ts3 = new ts3viewer($ip, $q_port, 1);
		$ts3->build();
	  
		echo "<div style=\"text-align: center;\"><big><b>TeamSpeak 3</b></big></div>\n"
		. "<table id=\"ts3table\" style=\"margin-left: auto;margin-right: auto;text-align: center;background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";width: " . $width_module . "px\" cellpadding=\"2\" cellspacing=\"1\">\n"
        . "<tr style=\"background: ". $bgcolor3 . ";color:#FFF;text-align: center\">\n"
		. "<td style=\"width: 50%;\" align=\"center\"><b><a href=\"ts3server://".$ip."?port=".$port."?name=".$user[2]."\"><font color=\"#fff\">". $ts3->tree_head() ."</font></a><br>". $ts3->useron() ."</b></td>\n"
		. "<td style=\"width: 50%;\" align=\"center\"><b>".$ts3->banner()."<br>".$ts3->website()."</b><br><br></td></tr>\n"
		. "<tr style=\"background: ". $bgcolor3 . ";color:#FFF;\"><td colspan=\"2\">" .$ts3->tree(). "</td></tr></table>\n"
		. "<div style=\"text-align:center;margin-top:10px;\">Codage by <a href=\"http://nexcraft.fr\" target=\"_blank\">Nex@n$</a></div>\n";
}

switch ($_REQUEST['op'])
    {
        case"index":
            index();
            break;
		default:
            index();
            break;
    }
}
else if ($level_access == -1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _TSWMODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _TSWBACK . "</b></a></div><br /><br />";
}
else if ($level_access == 1 && $visiteur == 0)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _TSWUSERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _TSWLOGINUSER . "</a> | <a href=\"index.php?file=User&amp;op=reg_screen\">" . _TSWREGISTERUSER . "</a></b></div><br /><br />";
}
else
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _TSWNOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _TSWBACK . "</b></a></div><br /><br />";
}
CloseTable();
?>	