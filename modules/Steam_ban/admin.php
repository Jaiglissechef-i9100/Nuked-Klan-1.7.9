<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined("INDEX_CHECK") or die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");

global $nuked, $language, $user;

translate("modules/Steam_ban/lang/" . $language . ".lang.php");

/* Définition des constantes */
define('STEAMBAN_TABLE', $nuked['prefix'] . '_steam_ban');

$visiteur = $user ? $user[1] : 0;

include 'modules/Admin/design.php';
admintop();

$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1) 
{

	function main()
	{
		global $nuked,$language, $bgcolor3, $bgcolor1, $p,$copyleft;
		$sql1=mysql_query("SELECT sid FROM ".STEAMBAN_TABLE);
		$count = mysql_num_rows($sql1);

		if ($op == "suite" || $op == "index_comment")
		{
			$where = "WHERE sid = '" . $news_id . "'";
		} 

		$sql_nbnews = mysql_query("SELECT sid FROM ".STEAMBAN_TABLE." " . $where);
		$nb_news = mysql_num_rows($sql_nbnews);
		$max_ban = $nuked[adm_ban];
		$url = "index.php?file=Steam_ban&page=admin";

		if (!$p) $p = 1;
		$start = $p * $max_ban - $max_ban;

		if ($op == "suite")
		{
			$sql = mysql_query("SELECT sid,pseudo,steamid FROM ".STEAMBAN_TABLE." WHERE sid = '" . $news_id . "'");
		}else{
			$sql = mysql_query("SELECT sid,pseudo,steamid FROM ".STEAMBAN_TABLE." ORDER BY steamid DESC LIMIT " . $start . ", " . $max_ban);
		} 


		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ASG. "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Steam_ban.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . _ACCUEILSTBAN . " | "
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=add\">" . _ASG1 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=gestion\">" . _CONF . "</a></b>\n"
	           . "</div><br />\n";

				if($count == 0)
				{
					echo"<div style=\"text-align: center;\"><br />"._NOSTEAM."<br /><br /></div>";
				}else{
					
					echo" 	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
							<tr>
								<td style=\"text-align: center; width: 40%;\"><b>"._PSG."</b></td>
								<td style=\"text-align: center; width: 40%;\"><b>"._PSG1."</b></td>
								<td style=\"text-align: center; width: 20%;\"><b>"._DETAIL."</b></td>
							</tr>";

						while (list($sid,$pseudo,$steamid) = mysql_fetch_array($sql))
						{
							if($pseudo!=""){$pseudo="$pseudo";}else{$pseudo="&nbsp;";}
							if ($j == 0){$bg = $bgcolor2;$j++;}else{$bg = $bgcolor1;$j = 0;} 

					echo"	<tr>
								<td style=\"text-align: center; width: 40%;\">".$steamid."</td>
								<td style=\"text-align: center; width: 40%;\">".$pseudo."</td>
								<td style=\"text-align: center; width: 20%;\"><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=detail&amp;sid=".$sid."&amp;steamid=".$steamid."\">"._DETAIL2."</a></td>
							</tr>";
						}

					echo"	</table>\n"
				. "<div style=\"text-align: center;\"><br /><br />[ <a href=\"index.php?file=Steam_ban&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
				}

		if ($nb_news > $max_ban)
		{
			echo "&nbsp;";
			number($nb_news, $max_ban, $url);
			echo "<br /><br />";
		}
	}


	function add()
	{
		global $nuked,$user, $language, $bgcolor3,$copyleft;

		$upload_max_filesize = @ini_get('upload_max_filesize');
		$file_uploads = @ini_get('file_uploads');
		
		if ($file_uploads == 1 && $upload_max_filesize != "")
		{
		    list($maxfilesize) = split('M', $upload_max_filesize);
		    $upload_status = "(" . _MAX . " : " . $maxfilesize . "&nbsp;" . _MO . ")";
		}
		else
		{
		    $upload_status = "";
		}

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ASG. " - "._ASG2."</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Steam_ban.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin\">" . _ACCUEILSTBAN . "</a></b> | "
	           . _ASG1 . " | "
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=gestion\">" . _CONF . "</a></b>\n"
	           . "</div><br />\n";


	        echo "<form method=\"post\" name=\"formulaire\" action=\"index.php?file=Steam_ban&amp;page=admin&amp;op=add_ban\" enctype=\"multipart/form-data\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
				. "<div style=\"text-align: left;\"><br />&nbsp;" . _OBLIGATOIRE . "<br /><br /></div>\n"
				. "<tr><td><b>" . _PSG . " :</b> <input type=\"text\" name=\"steamid\" size=\"40\" /> *</td></tr>\n"
				. "<tr><td align=\"left\" colspan=\"2\"><b>" . _PSG1 . " :</b> <input type=\"text\" name=\"pseudo\" size=\"41\" /> *</td></tr>\n"
				. "<tr><td align=\"left\"><b>" . _PSG2 . " :</b> <input type=\"text\" name=\"raison\" size=\"45\" /> *</td></tr>\n"
				. "<tr><td align=\"left\"><b>" . _PSG3 . " :</b> <input type=\"text\" value=\"\" name=\"temps\" size=\"45\" /></td></tr>\n"
				. "<tr><td align=\"left\"><b>" . _PERMANENT . " :</b> <input type=\"checkbox\" value=\"permanent\" name=\"permanent\" />&nbsp;"._COCH."</td></tr>\n"
				. "<tr><td align=\"left\"><b>" . _PSG4 . " :</b> <input id=\"ki\" type=\"hidden\" value=\"".$user[2]."\" name=\"ki\" size=\"39\" />&nbsp;".$user[2]."</td></tr>\n"
				. "<tr><td><b>" . _COMMENTAIRE . " : </b><br />\n"
				. "<textarea id=\"dl_texte\" class=\"editor\" name=\"commentaire\" rows=\"10\" cols=\"65\"></textarea></td></tr>\n"
				. "<tr><td>&nbsp;</td></tr>\n"
				. "<tr><td><b>" . _VIDEO . " :</b> <input type=\"text\" name=\"url_video\" size=\"55\" value=\"http://\" /></td></tr>\n"
				. "<tr><td>&nbsp;</td></tr>\n"
				. "<tr><td><b>" . _SCREENSHOT . " :</b> <input type=\"text\" name=\"screenshot\" size=\"42\" value=\"http://\" /> *</td></tr>\n"
				. "<tr><td><b>" . _SCREENSHOT . " :</b> <input type=\"file\" name=\"screen2\" />&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_screen\" value=\"1\" /> " . _REPLACE . "</td></tr>\n"
				. "<tr><td>&nbsp;</td></tr>\n"
				. "<tr><td align=\"center\"><input type=\"submit\" value=\"" . _ADDD . "\" /></td></tr>\n"
				. "</table>	</b>\n"
				. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Steam_ban&amp;page=admin\"><b>" . _BACK . "</b></a> ]<br /></div></form><br />\n";

    } 


	function add_ban($pseudo,$steamid,$raison,$temps,$permanent,$ki,$url_video,$screenshot,$screen2,$ecrase_screen,$commentaire)
	{
		global $nuked, $language, $user, $bgcolor3;
		
		$sql = mysql_query("SELECT * FROM " . $nuked['prefix'] . "_steam_ban WHERE steamid = '" . $steamid . "'");
		$test = mysql_num_rows($sql);
		
		$commentaire = addslashes($commentaire);
		$steamid = addslashes($steamid);
		$pseudo = addslashes($pseudo);
		$raison = addslashes($raison);
		$racine_up = "upload/Steam_ban/";
		
		$date =  time();

		if ($url_video == "http://") $url_video = "";
		if ($screenshot == "http://") $screenshot = "";

		if ($url_video != "" && !eregi("http://", $url_video)){$url_video = "http://" . $url_video;}

		if ($screenshot != "" && !eregi("http://", $screenshot)){ $screenshot = $screenshot; } 

		if($permanent == "permanent"){ $temps = $permanent; }else{ $temps = $temps; }

		if($test == 0)
		{
			if($pseudo != "" && $steamid != "" && $raison != "" && $ki != "" &&$_FILES['screen2']['name'] != "" || $screenshot != "")
			{
				 if ($_FILES['screen2']['name'] != "" || $screenshot != "")
				 {        

					$filename = $_FILES['screen2']['name'];
					$filename = str_replace(" ", "_", $filename);
					$url_screen = $racine_up . $filename;
		
					if ($_FILES['screen2']['name'] != "") $screenshot = $url_screen;
						
					if (($_FILES['screen2']['name'] == "" && $screenshot != "") || (!is_file($url_screen) || ( $ecrase_screen == 1 && is_file($url_screen))))
					{
						if ($_FILES['screen2']['name'] != "" && (!is_file($url_screen) || ( $ecrase_screen == 1 && is_file($url_screen))))
						{
							move_uploaded_file($_FILES['screen2']['tmp_name'], $url_screen) or die ("<div align=\"center\" style=\"\">" . _UPLOADFAILED . "<br /><br /><a href=\"javascript:history.back()\" /><b>" . _BACK . "</a></div>");
						}

		
						$sql = mysql_query("INSERT INTO ".STEAMBAN_TABLE."  ( `sid` , `pseudo` , `steamid` , `raison` , `temps` , `ki` , `url_video` , `screenshot` , `commentaire` , `date` )  VALUES ('','".$pseudo."','".$steamid."','".$raison."','".$temps."','".$ki."','".$url_video."','".$screenshot."','".$commentaire."','".$date."')");
						echo "<br /><br /><div style=\"text-align: center;\">" . _ADDSUCC . "</div><br /><br />";
						redirect("index.php?file=Steam_ban&page=admin", 2);
					}
					else
					{
						echo "<br /><br /><div style=\"text-align: center;\">" . _DEJASCREEN . "<br />" . _REPLACEIT . " ". _REPLACE ."<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
					}
				}
			}
			else
			{
				echo "<br /><br /><div style=\"text-align: center;\">"._URLORTITLEFAILDED."<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
			}
		}
		else
		{
			echo "<br /><br /><div style=\"text-align: center;\">"._ALREADYUSESTEAM."<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
		}
	}

	function edit($sid)
	{
		global $nuked, $language, $bgcolor3;

		$resMod =mysql_query("SELECT sid, pseudo, steamid, raison, temps, ki, url_video, screenshot, commentaire FROM ".STEAMBAN_TABLE." WHERE sid = '".$sid."' "); 
		list($sid, $pseudo, $steamid, $raison, $temps, $ki, $url_video, $screenshot, $commentaire) = mysql_fetch_array($resMod);

		$commentaire = stripslashes($commentaire);
		$steamid = stripslashes($steamid);
		$pseudo = stripslashes($pseudo);
		$raison = stripslashes($raison);

		$upload_max_filesize = @ini_get('upload_max_filesize');
		$file_uploads = @ini_get('file_uploads');
		
		if ($file_uploads == 1 && $upload_max_filesize != "")
		{
		    list($maxfilesize) = split('M', $upload_max_filesize);
		    $upload_status = "(" . _MAX . " : " . $maxfilesize . "&nbsp;" . _MO . ")";
		}
		else
		{
		    $upload_status = "";
		}

		if($temps == "permanent"){$checked = "checked";}else{$checked = "";} 


		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ASG. "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Steam_ban.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin\">"._ACCUEILSTBAN . "</a></b> | "
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=add\">" . _ASG1 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=gestion\">" . _CONF . "</a></b>\n"
	           . "</div><br />\n";

        echo "<form method=\"post\" name=\"formulaire\" action=\"index.php?file=Steam_ban&amp;page=admin&amp;op=edit_ban&sid=".$sid."\" enctype=\"multipart/form-data\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
				. "<div style=\"text-align: left;\"><br />&nbsp;" . _OBLIGATOIRE . "<br /><br /></div>\n"
				. "<tr><td><b>" . _PSG . " :</b> <input type=\"text\" value=\"$steamid\" name=\"steamid\" size=\"40\" /> *</td></tr>\n"
				. "<tr><td align=\"left\" colspan=\"2\"><b>" . _PSG1 . " :</b> <input type=\"text\" value=\"".$pseudo."\" name=\"pseudo\" size=\"41\" /> *</td></tr>\n"
				. "<tr><td align=\"left\"><b>" . _PSG2 . " :</b> <input type=\"text\" value=\"".$raison."\" name=\"raison\" size=\"45\" /> *</td></tr>\n"
				. "<tr><td align=\"left\"><b>" . _PSG3 . " :</b> <input type=\"text\" value=\"".$temps."\" name=\"temps\" size=\"45\" /></td></tr>\n"
				. "<tr><td align=\"left\"><b>" . _PERMANENT . " :</b> <input type=\"checkbox\" value=\"permanent\" name=\"permanent\" " . $checked . " />&nbsp;"._COCH."</td></tr>\n"
				. "<tr><td align=\"left\"><b>" . _PSG4 . " :</b> <input id=\"ki\" type=\"hidden\" value=\"".$ki."\" name=\"ki\" size=\"39\" />".$ki."</td></tr>\n"
				. "<tr><td><b>" . _COMMENTAIRE . " : </b><br />\n"
				. "<textarea id=\"dl_texte\" class=\"editor\" name=\"commentaire\" rows=\"10\" cols=\"65\">".$commentaire."</textarea></td></tr>\n"
				. "<tr><td>&nbsp;</td></tr>\n"
				. "<tr><td><b>" . _VIDEO . " :</b> <input type=\"text\" value=\"".$url_video."\" name=\"url_video\" size=\"55\" value=\"http://\" /></td></tr>\n"
				. "<tr><td>&nbsp;</td></tr>\n"
				. "<tr><td><b>" . _SCREENSHOT . " :</b> <input type=\"text\" value=\"".$screenshot."\" name=\"screenshot\" size=\"42\" value=\"http://\" /> *</td></tr>\n"
				. "<tr><td><b>" . _SCREENSHOT . " :</b> <input type=\"file\" name=\"screen2\" />&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_screen\" value=\"1\" /> " . _REPLACE . "</td></tr>\n"
				. "<tr><td>&nbsp;</td></tr>\n"
				. "</table>\n"
				. "<table style=\"width: 100%; border: 0px solid\" cellspacing=\"0\" cellpadding=\"3\">\n"
				. "<tr><td style=\"text-align: center;\"><input type=\"hidden\" name=\"sid\" value=\"".$sid."\"><input type=\"submit\" value=\""._MODIF1."\" /></form></td></tr>\n"
				. "</table>\n"
				. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Steam_ban&amp;page=admin\"><b>" . _BACK . "</b></a> ]<br /><br /></div>\n";
	}

	Function edit_ban($sid,$pseudo,$steamid,$raison,$temps,$permanent,$ki,$url_video,$screenshot,$screen2,$ecrase_screen,$commentaire)
	{
		global $nuked, $language, $user, $bgcolor3;
		
		$commentaire = addslashes($commentaire);
		$steamid = addslashes($steamid);
		$pseudo = addslashes($pseudo);
		$raison = addslashes($raison);

		$racine_up = "upload/Steam_ban/";
		
		$date = time();

		if ($url_video == "http://") $url_video = "";
		if ($screenshot == "http://") $screenshot = "";
		if ($url_video != "" && !eregi("http://", $url_video)){$url_video = "http://" . $url_video;} 
		if ($screenshot != "" && !eregi("http://", $screenshot)){$screenshot = "http://".$nuked['url']."/" . $screenshot;} 
		if($permanent == "permanent"){$temps = $permanent;}else{$temps = $temps;}

		if($pseudo != "" && $steamid != "" && $raison != "" && $ki != "" &&$_FILES['screen2']['name'] != "" || $screenshot != "")
		{
			if ($_FILES['screen2']['name'] != "" || $screenshot != "")
			{        

				$filename = $_FILES['screen2']['name'];
				$filename = str_replace(" ", "_", $filename);
				$url_screen = $racine_up . $filename;
	
				if ($_FILES['screen2']['name'] != "") $screenshot = $url_screen;
					
				if (($_FILES['screen2']['name'] == "" && $screenshot != "") || (!is_file($url_screen) || ( $ecrase_screen == 1 && is_file($url_screen))))
				{
					if ($_FILES['screen2']['name'] != "" && (!is_file($url_screen) || ( $ecrase_screen == 1 && is_file($url_screen))))
					{
						move_uploaded_file($_FILES['screen2']['tmp_name'], $url_screen) or die ("<div align=\"center\" style=\"\">" . _UPLOADFAILED . "<br /><br /><a href=\"javascript:history.back()\" /><b>" . _BACK . "</a></div>");
					}
		
					$sql = mysql_query("UPDATE ".STEAMBAN_TABLE." SET pseudo='" . $pseudo . "', steamid='" . $steamid . "', raison='" . $raison . "', temps='" . $temps . "', ki='" . $ki . "', url_video='" . $url_video . "', screenshot='" . $screenshot . "' , commentaire='" . $commentaire . "' WHERE sid = '" . $sid . "' ");
					echo "<br /><br /><div style=\"text-align: center;\">"._MODIFSUCC."</div><br /><br />";
					redirect("index.php?file=Steam_ban&page=admin", 2);
				}
				else
				{
					echo "<br /><br /><div style=\"text-align: center;\">" . _DEJASCREEN . "<br />" . _REPLACEIT . " ". _REPLACE ."<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
				}
			}
		}
		else
		{
			echo "<br /><br /><div style=\"text-align: center;\">"._URLORTITLEFAILDED."<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
		}
	}


	function del_ban($sid)
	{
		global $nuked;

		$del=mysql_query("DELETE FROM ".STEAMBAN_TABLE." WHERE sid='".$sid."'");
		$del_com=mysql_query("DELETE FROM ".STEAMBAN_TABLE." module='Steam_ban'");
		$sql = mysql_query("DELETE FROM " . COMMENT_TABLE . " WHERE im_id = '" . $sid . "' AND module='Steam_ban' ");
		echo"<div style=\"text-align: center;\"><br /><b><h3>"._STEAMDEL."</h3></b><br /></div>";
		redirect("index.php?file=Steam_ban&page=admin",2);
	}

	function detail($sid)
	{
		global $nuked, $language, $user, $bgcolor3;
		$sql=mysql_query("SELECT sid, steamid,pseudo, raison, temps, ki,url_video,screenshot,commentaire,date FROM ".STEAMBAN_TABLE." WHERE sid='".$sid."'"); 
		list($sid, $steamid, $pseudo, $raison, $temps, $ki, $url_video, $screenshot, $commentaire, $date) = mysql_fetch_array($sql);
		
		echo '<script type="text/javascript"><!--'."\n"
		. 'document.write(\'<link rel="stylesheet" type="text/css" href="media/shadowbox/shadowbox.css">\');'."\n"
		. '--></script>'."\n"
		. '<script type="text/javascript" src="media/shadowbox/shadowbox.js"></script>'."\n"
		. '<script type="text/javascript">'."\n"
		. 'Shadowbox.init();'."\n"
		. '</script>'."\n";

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ASG. " - "._DETAIL3." ".$pseudo."</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Steam_ban.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin\">"._ACCUEILSTBAN . "</a></b> | "
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=add\">" . _ASG1 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=gestion\">" . _CONF . "</a></b>\n"
	           . "</div><br />\n";

			echo "	<script type=\"text/javascript\">\n"
				."<!--\n"
				."\n"
				. "function delcat(pseudo, sid)\n"
				. "{\n"
				. "if (confirm('" . _DELETEFILE . " '+pseudo+' ! " . _CONFIRM . "'))\n"
				. "{document.location.href = 'index.php?file=Steam_ban&page=admin&op=del_ban&sid='+sid;}\n"
				. "}\n"
			    	. "\n"
				. "// -->\n"
				. "</script>\n";

				if($user[1]>= "$nuked[pref2_ban]"){$delete="<form method=\"post\" action=\"javascript:delcat('" . addslashes($pseudo) . "', '" . $sid . "');\"><input type=\"submit\" value=\""._DEL2."\"></form>";}else{$delete="<input type=\"submit\" value=\""._DEL2."\" onclick=\"alert('"._BADACCES."');\"><br />";}
				if($user[1]>= "$nuked[pref1_ban]"){$editer="<form method=\"post\" action=\"index.php?file=Steam_ban&amp;page=admin&amp;op=edit&amp;sid=".$sid."\"><input type=\"submit\" value=\""._EDIT1."\"></form>";}else{$editer="<input type=\"submit\" value=\""._EDIT1."\" onclick=\"alert('"._BADACCES2."');\"><br />";}

				$commentaire = stripslashes($commentaire);

				if($screenshot!=""){ 
					$screenshot="<a href=\"".$screenshot."\" rel=\"shadowbox\"  alt=\"\" title=\"" . _VIEWSCREEN . "\">" . _VIEWSCREEN . "</a>";
				}else{
					$screenshot = $nuked[url]."/images/noimage.gif";
				}

		echo"	<table cellspacing=\"0\" cellpadding=\"5\">
					<tr>
						<td style=\"width: 20%; text-align: left;\"><b>"._PSG." :</b></td>
						<td style=\"width: 80%; text-align: left;\"><i>".$steamid."</i></td>
					</tr>
					<tr>
						<td style=\"width: 20%; text-align: left;\"><b>"._PSG1." :</b></td>
						<td style=\"width: 80%; text-align: left;\"><i>".$pseudo."</i></td>
					</tr>
					<tr>
						<td style=\"width: 20%; text-align: left;\"><b>"._PSG2." :</b></td>
						<td style=\"width: 80%; text-align: left;\"><i>".$raison."</i></td>
					</tr>
					<tr>
						<td style=\"width: 20%; text-align: left;\"><b>"._PSG3." :</b></td>
						<td style=\"width: 80%; text-align: left;\"><i>".$temps."</i></td>
					</tr>
					<tr>
						<td style=\"width: 20%; text-align: left;\"><b>"._PSG4." :</b></td>
						<td style=\"width: 80%; text-align: left;\"><i><a href=\"index.php?file=Userbox&amp;op=post_message&amp;for=$ki\" title=\""._SENDMP."\">".$ki."</a></i></td>
					</tr>
					<tr>
						<td style=\"width: 20%; text-align: left;\"><b>"._VIDEO." :</b></td>
						<td style=\"width: 80%; text-align: left;\"><i>".$url_video."</i></td>
					</tr>
					<tr>
						<td style=\"width: 20%; text-align: left;\"><b>"._SCREENSHOT." :</b></td>
						<td style=\"width: 80%; text-align: left;\"><i>".$screenshot."</i></td>
					</tr>
					<tr>
						<td style=\"width: 20%; text-align: left;\"><b>"._DESCRIPTION." :</b></td>
						<td style=\"width: 80%; text-align: left;\"><i>".$commentaire."</i></td>
					</tr>
				</table>
				<table  style=\"width: 100%; text-align: center; vertical-align: middle;\" cellspacing=\"0\" cellpadding=\"0\">
					<tr>
						<td style=\"text-align: center;\"><br />".$editer."<br /></td>
						<td style=\"text-align: center; \"><br />".$delete."<br /></td>
					</tr>
				</table>";
		echo"<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Steam_ban&amp;page=admin\"><b>" . _BACK . "</b></a> ]<br /><br /></div>";
	}

	function gestion()
	{
		global $nuked,$user, $language;

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ASG. " - "._CONF."</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Steam_ban.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin\">"._ACCUEILSTBAN . "</a></b> | "
	           . "<b><a href=\"index.php?file=Steam_ban&amp;page=admin&amp;op=add\">" . _ASG1 . "</a></b> | "
	           . _CONF . "\n"
	           . "</div><br />\n";

		if($user[1]=="9")
		{

		echo "	<form method=\"post\" action=\"index.php?file=Steam_ban&amp;page=admin&amp;op=change_pref\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n"
				. "<tr><td>" . _NUMBERBAN . " :  <input type=\"text\" name=\"max_ban\" size=\"2\" value=\"" . $nuked['max_ban'] . "\" /></td></tr>\n"
				. "<tr><td>" . _NUMBERADM . " :  <input type=\"text\" name=\"adm_ban\" size=\"2\" value=\"" . $nuked['adm_ban'] . "\" /></td></tr>\n"
				. "<tr><td>" . _NUMBERPREF1 . " :  <input type=\"text\" name=\"pref1_ban\" size=\"2\" value=\"" . $nuked['pref1_ban'] . "\" /></td></tr>\n"
				. "<tr><td>" . _NUMBERPREF2 . " :  <input type=\"text\" name=\"pref2_ban\" size=\"2\" value=\"" . $nuked['pref2_ban'] . "\" /></td></tr>\n"
				. "</table><div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _SEND . "\" /></div>\n"
				. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Steam_ban&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
		}else{

			echo "	<form method=\"post\" action=\"index.php?file=Steam_ban&amp;page=admin&amp;op=change_pref\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n"
				. "<tr><td>" . _NUMBERBAN . " :</td><td> <input type=\"text\" name=\"max_ban\" size=\"2\" value=\"" . $nuked['max_ban'] . "\" /></td></tr>\n"
				. "<tr><td>" . _NUMBERADM . " :</td><td> <input type=\"text\" name=\"adm_ban\" size=\"2\" value=\"" . $nuked['adm_ban'] . "\" />\n"
				. "<input type=\"hidden\" name=\"pref1_ban\" value=\"" . $nuked['pref1_ban'] . "\"><input type=\"hidden\" name=\"pref2_ban\" value=\"" . $nuked['pref2_ban'] . "\"></td></tr>\n"
				. "</table><div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _SEND . "\" /></div>\n"
				. "$copyleft<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Steam_ban&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
			}
	}

	function change_pref($max_ban,$adm_ban,$pref1_ban,$pref2_ban)
	{
		global $nuked;

		$upd1 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $max_ban . "' WHERE name = 'max_ban'");
		$upd2 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $adm_ban . "' WHERE name = 'adm_ban'");
		$upd3 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $pref1_ban . "' WHERE name = 'pref1_ban'");
		$upd4 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $pref2_ban . "' WHERE name = 'pref2_ban'");
		echo "<br /><br /><div style=\"text-align: center;\">" . _PREFUPDATED . "</div><br /><br />";

		redirect("index.php?file=Steam_ban&page=admin", 2);
	} 

	switch ($_REQUEST['op'])
	{
		case "main":
		main();
		break;

		case "gestion":
		gestion();
		break;

		case "change_pref":
		change_pref($_REQUEST['max_ban'], $_REQUEST['adm_ban'], $_REQUEST['pref1_ban'], $_REQUEST['pref2_ban']);
		break;

		case "add_ban":
		add_ban($_REQUEST['pseudo'], $_REQUEST['steamid'], $_REQUEST['raison'], $_REQUEST['temps'], $_REQUEST['permanent'], $_REQUEST['ki'], $_REQUEST['url_video'], $_REQUEST['screenshot'], $_REQUEST['screen2'], $_REQUEST['ecrase_screen'], $_REQUEST['commentaire']);
		break;

		case "add":
		add();
		break;

		case "edit":
		edit($_REQUEST['sid']);
		break;

		case "edit_ban":
		edit_ban($_REQUEST['sid'], $_REQUEST['pseudo'], $_REQUEST['steamid'], $_REQUEST['raison'], $_REQUEST['temps'], $_REQUEST['permanent'], $_REQUEST['ki'], $_REQUEST['url_video'], $_REQUEST['screenshot'], $_REQUEST['screen2'], $_REQUEST['ecrase_screen'], $_REQUEST['commentaire']);
		break;

		case "del_ban":
		del_ban($_REQUEST['sid']);
		break;

		case "detail":
		detail($_REQUEST['sid']);
		break;

		default:
		main();
		break;
	}


} else if ($level_admin == -1) {
	echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
} else if ($visiteur > 1) {
	echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
} else {
	echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
}

adminfoot();

?>
