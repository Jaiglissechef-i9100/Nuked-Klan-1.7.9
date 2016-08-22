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
translate('modules/Steam_ban/lang/' . $language . '.lang.php');
include ("modules/Comment/index.php");

/* Définition des constantes */
define('STEAMBAN_TABLE', $nuked['prefix'] . '_steam_ban');

$visiteur = ($user) ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

	function main()
	{
		global $nuked,$langname, $bgcolor3, $bgcolor2, $bgcolor1, $p;
		opentable();

		$sql1 = mysql_query("SELECT sid FROM ".STEAMBAN_TABLE);
		$count = mysql_num_rows($sql1);

		$sql_nbnews = mysql_query("SELECT sid FROM ".STEAMBAN_TABLE);
		$nb_news = mysql_num_rows($sql_nbnews);

		$max_ban = $nuked[max_ban];
		$url = "index.php?file=Steam_ban";

		if(!$_REQUEST['p']) $_REQUEST['p'] = 1;
		$start = $_REQUEST['p'] * $max_ban - $max_ban;

		$sql = mysql_query("SELECT sid, pseudo, steamid, temps FROM ".STEAMBAN_TABLE." ORDER BY steamid DESC LIMIT " . $start . ", " . $max_ban);
		
		if($count == 0)
		{
			echo"	<table style=\"width: 100%; text-align: center;\" cellspacing=\"0\" cellpadding=\"0\">
						<tr>
							<td style=\"text-align: center;\"><br /><h3>"._NOSTEAM."</h3><br /></td>
						</tr>
					</table>";

		}else{

			echo" 	<table style=\"width: 100%; border: 0px solid;\" cellspacing=\"0\" cellpadding=\"0\">
						<tr>
							<td style=\"width: 100%; text-align: center;\"><br /><H3>"._XMSG2."</h3><br /></td>
						</tr>
					</table>";

			echo" 	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
						<tr style=\"background: " . $bgcolor3 . ";\">
							<td style=\"text-align: center; width: 40%;\"><b>"._PSG."</b></td>
							<td style=\"text-align: center; width: 40%;\"><b>"._PSG1."</b></td>
							<td style=\"text-align: center; width: 20%;\"><b>"._DETAIL."</b></td>
						</tr>";

						while (list($sid,$pseudo,$steamid) = mysql_fetch_array($sql))
						{
							$sql6=mysql_query("SELECT id FROM ".USER_TABLE." WHERE pseudo='".$ki."' "); 
							list($iduser) = mysql_fetch_array($sql6);

							$sql4 = mysql_query("SELECT im_id FROM " . COMMENT_TABLE . " WHERE im_id = '" . $sid . "' AND module = 'Steam_ban'");
							$nb_comment = mysql_num_rows($sql4);

							if($url_video!=""){$url_video="<a href=# onclick=\"javascript:window.open('".$url_video."','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0');return(false)\">"._VIEWVIDEO."</a>";}
							
							if ($j == 0){$bg = $bgcolor2;$j++;}else{$bg = $bgcolor1;$j = 0;} 

							echo"	<tr style=\"background: " . $bg . ";\">
										<td style=\"text-align: center; width: 40%;\">$steamid</td>
										<td style=\"text-align: center; width: 40%;\">$pseudo</td>
										<td style=\"text-align: center; width: 20%;\"><a href=\"index.php?file=Steam_ban&amp;op=details&amp;id=".$steamid."\">"._DETAIL2."</a></td>
									</tr>";
						}

			echo"	</table><br /><br />";

			echo"<div style=\"text-align: center;\"><input type=\"submit\" value=\""._DLBANNED."\"  onclick=\"javascript:window.open('index.php?file=Steam_ban&amp;nuked_nude=index&amp;op=generer','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,top=320,left=370,width=400,height=200');return(false)\" /></div><br />";
		}

		if ($nb_news > $max_ban)
		{
			echo "<div style=\"text-align: right;\"";
			number($nb_news, $max_ban, $url);
			echo "</div><br /><br />";
		}

		closetable();
	}


	///////////// GENERATION DU BANNED.XML //////////////
	function generer()
	{
		global $nuked,$language,$bgcolor1,$bgcolor3;

		$banned="modules/Steam_ban/temp/" . $nuked[name] . ".banned.cfg";
		$file= fopen("$banned", "w");

		$sql=mysql_query("SELECT steamid FROM ".STEAMBAN_TABLE." WHERE temps='permanent' ");
		while(list($steamid) = mysql_fetch_array($sql))
		{
			$fla .= "banid 0.0 ".$steamid."\n";
		}

		fwrite($file, $fla);
		fclose($file);

		echo"	<table cellspacing=\"0\" cellpadding=\"0\">
					<tr>
						<td style=\"text-align: center; vertical-align: top\"><br /><br /><b>"._BAN1."<br />"._BAN2."<br />"._BAN3."<br /><br /></b></td>
					</tr>
				</table>";

		redirect("index.php?file=Steam_ban&nuked_nude=index&op=banned", 5);
	}



	///////////// ZIP DU FICHIER BANNED.CFG ////////////////
	function banned()
	{
		global $nuked,$language,$user,$bgcolor3,$bgcolor1;

		include("modules/Steam_ban/Config/zip.lib.php");

		$chemin = "modules/Steam_ban/temp/";
		$nomcfg = $nuked[name] . ".banned.cfg";
		$nomzip = $nuked[name] . ".banned.cfg.zip";

		$zipfile = new zipfile();
		$zipfile -> addFile(implode("",file("" . $chemin . "" . $nomcfg . "")), $nomcfg);
		$f2=fopen($chemin.$nomzip . "","w");
		fputs($f2,$zipfile -> file()); 
		fclose($f2);

		echo" <table style=\"width: 100%; text-align: center;\" cellspacing=\"0\" cellpadding=\"5\">
				<tr>
					<td style=\"text-align: center; vertical-align: top\"><br /><br /><b>"._COMPRESSION."<br /><br /></b></td>
				</tr>
			</table>";

		@unlink($chemin.$nomcfg);
		redirect("index.php?file=Steam_ban&nuked_nude=index&op=dl_ban&fichier=" . $chemin.$nomzip . "", 0);
	}



	function details($id)
	{
		global $nuked, $visiteur, $bgcolor3,$bgcolor1;
		opentable();

		echo '<script type="text/javascript"><!--'."\n"
		. 'document.write(\'<link rel="stylesheet" type="text/css" href="media/shadowbox/shadowbox.css">\');'."\n"
		. '--></script>'."\n"
		. '<script type="text/javascript" src="media/shadowbox/shadowbox.js"></script>'."\n"
		. '<script type="text/javascript">'."\n"
		. 'Shadowbox.init();'."\n"
		. '</script>'."\n";

		include("modules/Steam_ban/Config/color.php");

		$sql = mysql_query("SELECT sid, pseudo, steamid, raison, temps, ki, url_video, screenshot, commentaire, date FROM ".STEAMBAN_TABLE." WHERE steamid = '" . $id . "'");
		list($sid, $pseudo, $steamid, $raison, $temps, $ki, $url_video, $screenshot, $commentaire, $date) = mysql_fetch_array($sql);

		$sql6=mysql_query("SELECT id FROM ".USER_TABLE." WHERE pseudo = '".$ki."' "); 
		list($iduser) = mysql_fetch_array($sql6);

		$date = nkdate($date);

		if ($visiteur >= admin_mod("Steam_ban"))
		{
		echo "	<script type=\"text/javascript\">\n"
			."<!--\n"
			."\n"
			. "function deldown(pseudo, sid)\n"
			. "{\n"
			. "if (confirm('" . _DELETEFILE . " '+pseudo+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Steam_ban&page=admin&op=del_ban&amp;sid='+sid;}\n"
			. "}\n"
		    	. "\n"
			. "// -->\n"
			. "</script>\n";

			echo "<div style=\"text-align: right;\"><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=edit&amp;sid=".$sid."\"><img style=\"border: 0;\" src=\"images/edition.gif\" alt=\"\" title=\"" . _EDIT . "\" /></a>"
			. "&nbsp;<a href=\"javascript:deldown('" . addslashes($pseudo) . "', '" . $sid . "');\"><img style=\"border: 0;\" src=\"images/delete.gif\" alt=\"\" title=\"" . _DEL . "\" /></a></div>\n";
		} 

		echo"<table style=\"width: 100%; text-align: center;\" cellspacing=\"1\" cellpadding=\"1\">
				<tr>
					<td style=\"background: ".$fond." none repeat scroll 0%; text-align: center;\" colspan=\"2\"><h3>"._INFOR." ".$pseudo."</h3></td>
				</tr>
				<tr>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><b>"._PSG.":</b></td>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><i>&nbsp;".$steamid."</i></td>
				</tr>
				<tr>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><b>"._PSG1.":</b></td>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><i>&nbsp;".$pseudo."</i></td>
				</tr>
				<tr>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><b>"._PSG2.":</b></td>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><i>&nbsp;".$raison."</i></td>
				</tr>
				<tr>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><b>"._PSG3.":</b></td>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><i>&nbsp;".$temps."</i></td>
				</tr>
				<tr>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><b>"._PSG4.":</b></td>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><i>&nbsp;<a href=\"index.php?file=Userbox&amp;op=post_message&amp;for=".$iduser."\" title=\""._SENDMP."\">".$ki."</a></i></td>
				</tr>
				<tr>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><b>" . _AJOUTELE . " :</b></td>
					<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\">&nbsp;".$date."</td>
				</tr>";

				if($url_video != "")
				{
					echo"<tr>
							<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><b>"._VIDEO." :</b></td>
							<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><i>&nbsp;<a href=\"#\" onclick=\"javascript:window.open('".$url_video."','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0');return(false)\">"._VIEWVIDEO."</a></i></td>
						</tr>";
				}		

				if($commentaire != "")
				{
					echo"<tr style=\"vertical-align: top;\">
							<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><b>"._DESCRIPTION." :</b></td>
							<td style=\"width: 50%; text-align: left; background-color: " . $details . ";\"><i>&nbsp;".$commentaire."</i></td>
						</tr>";
				}

				if($screenshot != "")
				{
					echo"<tr>
							<td style=\"background: ".$fond." none repeat scroll 0%; vertical-align: top; text-align: center;\" colspan=2><br />
								<a href=\"".$screenshot."\" rel=\"shadowbox\" title=\"" . _VIEWSCREEN . "\"><img src=\"".$screenshot . "\" alt=\"\" style=\" width: 120px;\" /></a><br /><br />
							</td>
						</tr>";
				}

				echo"<tr>
						<td style=\"background-color: " . $details . ";\" colspan=\"2\">"; com_index("Steam_ban", $sid); echo"	</td>
					</tr>
			</table>";

			if($temps == "permanent")
			{
				echo"<div style=\"text-align: center;\" colspan=\"2\"><br /><input type=\"submit\" value=\""._DLBANNED."\"  onclick=\"javascript:window.open('index.php?file=Steam_ban&amp;nuked_nude=index&amp;op=generer','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,top=320,left=370,width=400,height=200');return(false)\" /></div>";
			}

			echo"<div style=\"text-align: center;\"><a href=\"index.php?file=Steam_ban\"><b>"._BACK."</b></a></div><br />";

		closetable();
	}

	function dl_ban($fichier)
	{
		global $nuked, $visiteur, $bgcolor3,$bgcolor1;

		$fichier = urldecode($fichier);

		echo"	<head><meta http-equiv=\"refresh\" content=\"5; URL=".$fichier."\"></head>";

		echo"	<table style=\"text-align: center; width: 100%;\">
		    		<tr>
		        		<td style=\"text-align: center; border: 0px solid; width: 100%\"><b>" . _DLENCOUR . "</b>
						<br /><b>"._DL1."</b>
						<br /><b>"._DL2."</b>
						<br /><br /><a href=\"".$fichier."\"><b>" . _DLBANNED . "</b></a></td>
		    		</tr>
			</table>";
	}


	switch ($_REQUEST['op'])
	{
		case "banned":
		banned();
		break;

		case "dl_ban":
		dl_ban($_REQUEST['fichier']);
		break;

		case "generer":
		generer();
		break;

		case "details":
		details($_REQUEST['id']);
		break;

		default:
		main();
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