<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK")) exit('You can\'t run this file alone.');

global $nuked, $language, $user;
translate("modules/Steam_ban/lang/" . $language . ".lang.php");

/* Définition des constantes */
define('STEAMBAN_TABLE', $nuked['prefix'] . '_steam_ban');

$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);
if ($active == 3 || $active == 4)
{

	$sql=mysql_query("SELECT sid, pseudo, steamid, raison, temps, ki, url_video, screenshot FROM ".STEAMBAN_TABLE."  ORDER BY rand() LIMIT 5"); 
	$count=mysql_num_rows($sql);

	if($count == 0)
	{

		echo"	<div style=\"width: 100%; text-align: center;\">"._XMSG1."</div>\n";

	}else{

		echo"	<table style=\"width: 100%;\" cellspacing=\"0\" cellpadding=\"1\">
				<tr style=\"vertical-align: top;\">
					<td style=\"border: 1px solid " . $bgcolor3 . "; width: 30%; text-align: center; background-color: " . $bgcolor1 . ";\"><b>"._PSG."</b></td>
					<td style=\"border: 1px solid " . $bgcolor3 . "; width: 25%; text-align: center; background-color: " . $bgcolor1 . ";\"><b>"._PSG1."</b></td>
					<td style=\"border: 1px solid " . $bgcolor3 . "; width: 25%; text-align: center; background-color: " . $bgcolor1 . ";\"><b>"._PSG2."</b></td>
					<td style=\"border: 1px solid " . $bgcolor3 . "; width: 20%; text-align: center; background-color: " . $bgcolor1 . ";\"><b>"._PSG3."</b></td>
				<tr>
			</table>
			<table style=\"width: 100%;\" cellspacing=\"0\" cellpadding=\"3\">";

		while (list($sid, $pseudo, $steamid, $raison, $temps, $ki, $url_video, $screenshot) = mysql_fetch_array($sql))
		{
			$sql2=mysql_query("SELECT id FROM ".USER_TABLE." WHERE pseudo='".$ki."' "); 
			list($iduser) = mysql_fetch_array($sql2);


			echo"	<tr>
						<td style=\"width: 30%; text-align: center; background-color: " . $bgcolor1 . ";\">" . $steamid . "</td>
						<td style=\"width: 25%; text-align: center; background-color: " . $bgcolor1 . ";\"><a href=\"index.php?file=Steam_ban&amp;op=details&amp;id=" . $steamid . "\">" . $pseudo . "</a></td>
						<td style=\"width: 25%; text-align: center; background-color: " . $bgcolor1 . ";\">" . $raison . "</td>
						<td style=\"width: 20%; text-align: center; background-color: " . $bgcolor1 . ";\">" . $temps . "</td>
					</tr>\n";
		}
		echo"	</table>";

		if($count != 0)
		{
			echo"	<table style=\"width: 100%; text-align: center;\" cellspacing=\"0\" cellpadding=\"5\">
						<tr>
							<td style=\"height: 30px;\"><br /><a href=\"#\" onclick=\"javascript:window.open('index.php?file=Steam_ban&amp;nuked_nude=index&amp;op=generer','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,top=310,left=340,width=400,height=170');return(false)\">"._DLBANNED2."</a></td>
						</tr>
					</table>";
		}
	}

}else{

	echo" 	<table  style=\"width: 100%;\">\n";

			$sql=mysql_query("SELECT steamid,raison,pseudo FROM ".STEAMBAN_TABLE." ORDER BY rand() LIMIT 5"); 
			$count=mysql_num_rows($sql);
			while (list($steamid, $raison,$pseudo) = mysql_fetch_array($sql))
			{
				echo"<tr><td  style=\"width: 100%; text-align: center;\"><a href=\"index.php?file=Steam_ban&amp;op=details&amp;id=".$steamid."\">".$pseudo."</a></td></tr>\n";
			}

			if($count == 0){echo"	<br /><div style=\"width: 100%; text-align: center;\">"._XMSG1."</div>\n";}

	echo"	</table><br />";


		if($count != 0)
		{
			echo"<div style=\"text-align: center;\"><a href=\"index.php?file=Steam_ban\"><b>"._DETAIL2."</b></a></div>
				<br />
				<div style=\"text-align: center;\">[ <a href=\"#\" onclick=\"javascript:window.open('index.php?file=Steam_ban&amp;nuked_nude=index&amp;op=generer','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,top=310,left=340,width=400,height=170');return(false)\">"._DLBANNED2."</a> ]</div>\n";
		}
}
?>