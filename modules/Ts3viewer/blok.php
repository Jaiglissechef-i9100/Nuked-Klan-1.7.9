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
defined('INDEX_CHECK') or die ('<div style="text-align: center;">You cannot open this page directly</div>');

global $bgcolor1, $bgcolor2, $bgcolor3, $nuked, $user;
		
		include_once('includes/class.ts3viewer.php');
		
		$sql2=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer_pref');
	  	while($req2 = mysql_fetch_object($sql2))
	  {	
	  	$srvid= $req2->srvid;
		$width_module = $req2->width_module;
		$width_blok = $req2->width_blok;
	  }
	$sql1=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer WHERE id = '.$srvid.'');
	  	while($req1 = mysql_fetch_object($sql1))
	  {	
	  	$ip= $req1->ip;
		$q_port = $req1->q_port ;
	  }
		$ts3 = new ts3viewer($ip, $q_port, 1);
		$ts3->build();

$Str = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '$bid'");
list($active) = mysql_fetch_array($Str);

$listStyle = ($active == 3 or $active == 4) ? 'list-style:none' : 'list-style:inline';
$margin = ($active == 3 or $active == 4) ? '5px' : '11px';

	if ($active == 3 or $active == 4) {
		
		echo "<table id=\"ts3table\" style=\"margin-left: auto;margin-right: auto;text-align: center;background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";width: " . $width_blok . "px\" cellpadding=\"2\" cellspacing=\"1\">\n"
        . "<tr style=\"background: ". $bgcolor3 . ";color:#FFF;text-align: center\">\n"
		. "<td style=\"width: 50%;\" align=\"center\"><b><a href=\"ts3server://".$ip."?port=".$port."?name=".$user[2]."\"><font color=\"#fff\">". $ts3->tree_head() ."</font></a><br>". $ts3->useron() ."</b></td>\n"
		. "</tr>\n"
		. "<tr style=\"background: ". $bgcolor3 . ";color:#FFF;\"><td colspan=\"2\">" .$ts3->tree(). "</td></tr></table>\n"
		. "<div style=\"text-align:center;margin-top:10px;\">Codage by <a href=\"http://nexcraft.fr\" target=\"_blank\">Nex@n$</a></div>\n";
		
	} else {
	  
		echo "<table id=\"ts3table\" style=\"margin-left: auto;margin-right: auto;text-align: center;background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";width: " . $width_blok . "px\" cellpadding=\"2\" cellspacing=\"1\">\n"
        . "<tr style=\"background: ". $bgcolor3 . ";color:#FFF;text-align: center\">\n"
		. "<td style=\"width: 50%;\" align=\"center\"><b><a href=\"ts3server://".$ip."?port=".$port."?name=".$user[2]."\"><font color=\"#fff\">". $ts3->tree_head() ."</font></a><br>". $ts3->useron() ."</b></td>\n"
		. "</tr>\n"
		. "<tr style=\"background: ". $bgcolor3 . ";color:#FFF;\"><td colspan=\"2\">" .$ts3->tree(). "</td></tr></table>\n"
		. "<div style=\"text-align:center;margin-top:10px;\">Codage by <a href=\"http://nexcraft.fr\" target=\"_blank\">Nex@n$</a></div>\n";
	    
	
}

?>