<?php


////////////////////////////////////////////////
//	Module creer par Maxxi		                //
//	http://Nuked-Host.tk                      //
//  ----------------------------------------- //
//	Module 1.0 par Tassin                     //
//  Module mis à jour pour la 1.7.9 par YurtY //
//  www.nkhelp.fr                             //
//	Module V2.0 & 3.0 par Zdav                //
//  www.nuked-klan.org                        //
////////////////////////////////////////////////


if (!defined("INDEX_CHECK")) {
	die ("<center>You cannot open this page directly</center>");
}

$ModName = basename( dirname( __FILE__ ) );
if ($user[1]>=admin_mod($ModName)){

include("modules/Replays/lang/".$language.".lang.php");
include("modules/Replays/constants.php");
include("modules/Admin/design.php");

function getPosition($param)
{
	switch($param)
	{
		case "replays":return 0;break;
		case "add":return 1;break;
		case "race":return 2;break;
		case "maps":return 3;break;
		case "main_config":return 4;break;
		default : return -1;
	}
}

function menu($param)
{
	$position = getPosition($param);
	echo "<div class=\"content-box\">\n"
	."<div class=\"content-box-header\"><h3>" ._ADMREPLAYS."</h3><br/></div>\n";
	
	switch($position)
	{
		case"0" : echo '<div class=\"tab-content\" id=\"tab2\"><center>'._LISTREPLAYS.' <b>| <a href="index.php?file=Replays&amp;page=admin&amp;op=add">'._ADDREPLAY.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=race">'._ADDRACE.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=maps">'._ADDMAPS.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=main_config">'._REPCONFIG.'</a></b>
		</center></div><br/>';break;
		case"1" : echo '<div class=\"tab-content\" id=\"tab2\"><center><b><a href="index.php?file=Replays&amp;page=admin">'._LISTREPLAYS.'</a> |</b> '._ADDREPLAY.' <b>| <a href="index.php?file=Replays&amp;page=admin&amp;op=race">'._ADDRACE.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=maps">'._ADDMAPS.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=main_config">'._REPCONFIG.'</a></b>
		</center></div><br/>';break;
		case"2" : echo '<div class=\"tab-content\" id=\"tab2\"><center><b><a href="index.php?file=Replays&amp;page=admin">'._LISTREPLAYS.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=add">'._ADDREPLAY.'</a> |</b> '._ADDRACE.' <b>| <a href="index.php?file=Replays&amp;page=admin&amp;op=maps">'._ADDMAPS.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=main_config">'._REPCONFIG.'</a></b>
		</center></div><br/>';break;
		case"3" : echo '<div class=\"tab-content\" id=\"tab2\"><center><b><a href="index.php?file=Replays&amp;page=admin">'._LISTREPLAYS.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=add">'._ADDREPLAY.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=race">'._ADDRACE.'</a> |</b> '._ADDMAPS.' <b>| <a href="index.php?file=Replays&amp;page=admin&amp;op=main_config">'._REPCONFIG.'</a></b>
		</center></div><br/>';break;
		case"4" : echo '<div class=\"tab-content\" id=\"tab2\"><b><center><a href="index.php?file=Replays&amp;page=admin">'._LISTREPLAYS.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=add">'._ADDREPLAY.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=race">'._ADDRACE.'</a> | <a href="index.php?file=Replays&amp;page=admin&amp;op=maps">'._ADDMAPS.'</a> |</b> '._REPCONFIG.'
		</center></div><br/>';
		default :break;
	}
}

function main($param)
{
	global $nuked, $langname;
	echo "<script language=\"javascript\">
		function supprimerReplay(id, titre, idEquipe)
		{
			if (confirm('"._DELETEREPLAY." '+titre+'   '))
			{
				document.location.href ='index.php?file=Replays&page=admin&op=del_ban&id='+id+'&idEquipe='+idEquipe;
			}
		}
		</script>";

	menu($param);

	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\"><tr>\n"
	."<td align=\"center\"><b>"._TITRE."</b></td>\n"
	."<td align=\"center\"><b>" . _GAMES . "</b></td>\n"	
	."<td align=\"center\"><b>" . _MAP . "</b></td>\n"
	."<td align=\"center\"><b>"._VERSION."</b></td>\n"
	."<td align=\"center\"><b>"._TYPEREPLAY."</b></td>\n"
	."<td align=\"center\"><b>"._EDI."</b></td>\n"
	."<td align=\"center\"><b>"._SUP."</b></td></tr>\n";
	
	$sql=mysql_query("SELECT id, titre, map, version, type, id_equipe, game FROM " . REPLAYSTABLE . "  ORDER BY id");
	$nb_replays = mysql_num_rows($sql);
	
	while (list($id, $titre, $map, $version, $type, $id_equipe, $game) = mysql_fetch_array($sql)){
	
		$sql_map = mysql_query("SELECT nom FROM " . MAPSTABLE . " WHERE image='" . $map . "'");
		$nb_maps = mysql_num_rows($sql_map);
		
		if($nb_maps == 0) {
			$img_name = _ERRORIMG;
			$img_file = "";
		} else {
			list($img_name) = mysql_fetch_row($sql_map);
			$img_file = "modules/Replays/images/maps/" . $map;
		}

    $sql_game = mysql_query('SELECT name, icon FROM ' . GAMES_TABLE . ' WHERE id = \'' . $game . '\' ');
      list($game_name, $icon) = mysql_fetch_array($sql_game);
      $game_name = htmlentities($game_name);

      if ($icon != '' && is_file($icon)){
      $icone = $icon;
      } 
      else{
      $icone = 'images/games/nk.gif';
      } 
		
		if($type == 1) {
			$typeReplay = "1 VS 1";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2 FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = "<ul><li>". $joueur1."</li><li>".$joueur2."</li></ul>";
		} else if($type == 2) {
			$typeReplay = "2 VS 2";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _EQUIPE1."<ul><li>". $joueur1."</li><li>".$joueur2."</li></ul>" . _EQUIPE2 . "<ul><li>".$joueur3."</li><li>".$joueur4."</li></ul>";
		} else if($type == 3) {
			$typeReplay = "3 VS 3";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _EQUIPE1."<ul><li>". $joueur1."</li><li>".$joueur2."</li><li>".$joueur3."</li></ul>" . _EQUIPE2 . "<ul><li>".$joueur4."</li><li>".$joueur5."</li><li>".$joueur6."</li></ul>";
		} else if($type == 4) {
			$typeReplay = "4 VS 4";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _EQUIPE1."<ul><li>". $joueur1."</li><li>".$joueur2."</li><li>".$joueur3."</li><li>".$joueur4."</li></ul>" . _EQUIPE2 . "<ul><li>".$joueur5."</li><li>".$joueur6."</li><li>".$joueur7."</li><li>".$joueur8."</li></ul>";
		} else if($type == 5) {
			$typeReplay = "2 VS 2 VS 2";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _EQUIPE1."<ul><li>". $joueur1."</li><li>".$joueur2."</li></ul>" . _EQUIPE2 . "<ul><li>".$joueur3."</li><li>".$joueur4."</li></ul>" . _EQUIPE3 . "<ul><li>".$joueur5."</li><li>".$joueur6."</li></ul>";
		} else if($type == 6) {
			$typeReplay = "2 VS 2 VS 2 VS 2";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _EQUIPE1."<ul><li>". $joueur1."</li><li>".$joueur2."</li></ul>" . _EQUIPE2 . "<ul><li>".$joueur3."</li><li>".$joueur4."</li></ul>" . _EQUIPE3 . "<ul><li>".$joueur5."</li><li>".$joueur6."</li></ul>" . _EQUIPE4 . "<ul><li>".$joueur7."</li><li>".$joueur8."</li></ul>";
		} else if($type == 7) {
			$typeReplay = "" . _FFA3PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _JOUEUR1."<ul><li>". $joueur1."</li></ul>" . _JOUEUR2 . "<ul><li>".$joueur2."</li></ul>" . _JOUEUR3 . "<ul><li>".$joueur3."</li></ul>";
		} else if($type == 8) {
			$typeReplay = "" . _FFA4PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _JOUEUR1."<ul><li>". $joueur1."</li></ul>" . _JOUEUR2 . "<ul><li>".$joueur2."</li></ul>" . _JOUEUR3 . "<ul><li>".$joueur3."</li></ul>" . _JOUEUR4 . "<ul><li>".$joueur4."</li></ul>";
		} else if($type == 9) {
			$typeReplay = "" . _FFA5PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _JOUEUR1."<ul><li>". $joueur1."</li></ul>" . _JOUEUR2 . "<ul><li>".$joueur2."</li></ul>" . _JOUEUR3 . "<ul><li>".$joueur3."</li></ul>" . _JOUEUR4 . "<ul><li>".$joueur4."</li></ul>" . _JOUEUR5 . "<ul><li>".$joueur5."</li></ul>";
		} else if($type == 10) {
			$typeReplay = "" . _FFA6PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _JOUEUR1."<ul><li>". $joueur1."</li></ul>" . _JOUEUR2 . "<ul><li>".$joueur2."</li></ul>" . _JOUEUR3 . "<ul><li>".$joueur3."</li></ul>" . _JOUEUR4 . "<ul><li>".$joueur4."</li></ul>" . _JOUEUR5 . "<ul><li>".$joueur5."</li></ul>" . _JOUEUR6 . "<ul><li>".$joueur6."</li></ul>";
		} else if($type == 11) {
			$typeReplay = "" . _FFA8PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _JOUEUR1."<ul><li>". $joueur1."</li></ul>" . _JOUEUR2 . "<ul><li>".$joueur2."</li></ul>" . _JOUEUR3 . "<ul><li>".$joueur3."</li></ul>" . _JOUEUR4 . "<ul><li>".$joueur4."</li></ul>" . _JOUEUR5 . "<ul><li>".$joueur5."</li></ul>" . _JOUEUR6 . "<ul><li>".$joueur6."</li></ul>" . _JOUEUR7 . "<ul><li>".$joueur7."</li></ul>" . _JOUEUR8 . "<ul><li>".$joueur8."</li></ul>";
		} else if($type == 12) {
			$typeReplay = "5 VS 5";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, joueur9, joueur10  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10) = mysql_fetch_row($sql_joueurs);
			$affichage_joueur = _EQUIPE1."<ul><li>". $joueur1."</li><li>".$joueur2."</li><li>".$joueur3."</li><li>".$joueur4."</li><li>".$joueur5."</li></ul>" . _EQUIPE2 . "<ul><li>".$joueur6."</li><li>".$joueur7."</li><li>".$joueur8."</li><li>".$joueur9."</li><li>".$joueur10."</li></ul>";
		}
		
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
	
		echo "<tr style=\"background: " . $bg . ";\"><td align=\"center\">" . $titre . "</td>\n"
      ."<td align=\"center\"><img src=\"" . $icone . "\" alt=\"\" height=\"16px\" width=\"16px\" title=\"" . $game_name . "\" /></td>\n"
			."<td align=\"center\"><span>" . $img_name . "</span>&nbsp;&nbsp;<img style=\"cursor: pointer;vertical-align: middle;\" width=\"16\" height=\"16\" src=\"modules/Replays/images/zoom_in.png\" onmouseOver=\"AffBulle('" . $img_name . "', '<img src=\'" . $img_file . "\'/>', 100);\" onmouseOut=\"HideBulle();\" /></td>\n"
			."<td align=\"center\">" . $version . "</td>\n"
			."<td align=\"center\"><span>" . $typeReplay . "</span>&nbsp;&nbsp;<img style=\"cursor: pointer;vertical-align: middle;\" width=\"16\" height=\"16\" src=\"modules/Replays/images/zoom_in.png\" onmouseOver=\"AffBulle('" . _EQUIPES . "', '" . $affichage_joueur . "', 150);\" onmouseOut=\"HideBulle();\" /></td>\n"
			."<td align=\"center\"><a href=\"index.php?file=Replays&page=admin&op=edit&id=" . $id . "\" style=\"text-decoration:none\" title=\""._EDITREPLAY."\"><img src=\"images/edit.gif\" border=\"0\"></a></td>\n"
			."<td align=\"center\"><a href=\"javascript:supprimerReplay('" . $id . "', '" . $titre . "', '" . $id_equipe . "');\" style=\"text-decoration:none\" title=\""._DELETEREPLAY."\"><img src=\"images/del.gif\" border=\"0\"></a></td>\n"
			."</tr>";
	}

	if($nb_replays == 0) {
		echo "<tr><td align=\"center\" colspan=\"8\">" . _NOREPLAYSINDB . "</td></tr>\n";
	}
	echo "</table>\n";
	
	echo "<br/><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin\"><b>"._BACK."</b></a> ]</div><br />";
	
}

function add($param)
{
	global $nuked;
	
	menu($param);
	
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
	
	echo "<div style=\"text-align: center;\"><em>"._REQUIRED."</em></div><br />";
	
	echo "<link rel=\"stylesheet\" href=\"modules/Replays/css/style.css\" type=\"text/css\" media=\"screen\" />\n"
		."<script src=\"modules/Replays/js/function.js\" type=\"text/javascript\"></script>\n"
		."<form onsubmit=\"return checkFile();\" method=\"post\" action=\"index.php?file=Replays&page=admin&op=add_ban\" enctype=\"multipart/form-data\">\n"
		."<div class=\"formulaire\">\n"
		."<div class=\"row\">\n"
		."<label for=\"titre\">" . _TITRE . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"titre\" size=\"25\" value=\"\" /> *</span>\n"
		."</div>\n"
//Ajout du Jeu		
		."<div class=\"row\">\n"
		."<label for=\"game\">" . _GAME . "&nbsp:</label>\n"
		."<span class=\"formw\"><select name=\"game\">\n";
            $sql3 = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
            while (list($id, $name) = mysql_fetch_array($sql3)){
                $name = htmlentities($name);
                if ($id == $game){
                    $checked4 = "selected=\"selected\"";
                } 
                else{
                    $checked4 = "";
                }
                echo "<option value=\"" . $id . "\" " . $checked4 . ">" . $name . "</option>\n";
            } 
            echo "</select></span></div>\n"		
//Fin Ajout du jeu
		."<div class=\"row\">\n"
		."<label for=\"map\">" . _NOMMAP . "&nbsp:</label>\n"
		."<span class=\"formw\"><select onchange=\"changeImageMap();\" id=\"map\" name=\"map\">\n";
	select_map();
	echo "</select></span></div>\n"
		."<div class=\"row\">\n"
		."<label class=\"imgMap\">" . _PREVIEWMAP . "&nbsp:</label>\n"
		."<span class=\"formw\"><div id=\"img_map\" style=\"width: 100px; height: 100px;\"></div></span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"evenement\">" . _EVENEMENT . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"evenement\" size=\"25\" value=\"\" /> *</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"duree\">" . _DUREE . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"duree\" size=\"10\" value=\"\" />&nbsp;Min *</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"taille\">" . _TAILLE . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"taille\" size=\"10\" value=\"\" />&nbsp;Ko *</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"version\">" . _VERSION . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"version\" size=\"10\" value=\"\" /> *</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"url\">" . _URL . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" id=\"url\" name=\"url\" size=\"50\" value=\"upload/Replays/\" /></span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"url\">" . _UPFILE . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"file\" id=\"copy\" name=\"copy\" onChange=\"checkFile();\" />&nbsp;" . $upload_status . "&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_file\" value=\"1\" /> " . _REPLACE . "</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"type\">" . _TYPEREPLAY . "&nbsp:</label>\n"
		."<span class=\"formw\"><select onchange=\"changeType();\" id=\"typeReplay\" name=\"typeReplay\">\n";
	select_type();	
	echo "</select></span></div>\n"
      
      ."<div id=\"un\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur1\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur1\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(1)\" id=\"joueur1race\" name=\"joueur1race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race1\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur2\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur2\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(2)\" id=\"joueur2race\" name=\"joueur2race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race2\"></span> *</div></div>\n"
		
			."<div id=\"deux\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur3\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur3\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(3)\" id=\"joueur3race\" name=\"joueur3race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race3\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur4\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur4\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(4)\" id=\"joueur4race\" name=\"joueur4race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race4\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur5\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur5\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(5)\" id=\"joueur5race\" name=\"joueur5race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race5\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur6\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur6\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(6)\" id=\"joueur6race\" name=\"joueur6race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race6\"></span> *</div></div>\n"
			
			."<div id=\"trois\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur7\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur7\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(7)\" id=\"joueur7race\" name=\"joueur7race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race7\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur8\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur8\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(8)\" id=\"joueur8race\" name=\"joueur8race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race8\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur9\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur9\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(9)\" id=\"joueur9race\" name=\"joueur9race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race9\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur10\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur10\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(10)\" id=\"joueur10race\" name=\"joueur10race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race10\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur11\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur11\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(11)\" id=\"joueur11race\" name=\"joueur11race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race11\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur12\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur12\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(12)\" id=\"joueur12race\" name=\"joueur12race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race12\"></span> *</div></div>\n"
			
			."<div id=\"quatre\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur13\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur13\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(13)\" id=\"joueur13race\" name=\"joueur13race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race13\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur14\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur14\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(14)\" id=\"joueur14race\" name=\"joueur14race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race14\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur15\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur15\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(15)\" id=\"joueur15race\" name=\"joueur15race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race15\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur16\">" . _EQUIPE1JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur16\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(16)\" id=\"joueur16race\" name=\"joueur16race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race16\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur17\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur17\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(17)\" id=\"joueur17race\" name=\"joueur17race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race17\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur18\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur18\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(18)\" id=\"joueur18race\" name=\"joueur18race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race18\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur19\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur19\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(19)\" id=\"joueur19race\" name=\"joueur19race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race19\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur20\">" . _EQUIPE2JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur20\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(20)\" id=\"joueur20race\" name=\"joueur20race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race20\"></span> *</div></div>\n"

			."<div id=\"cinq\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur21\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur21\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(21)\" id=\"joueur21race\" name=\"joueur21race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race21\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur22\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur22\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(22)\" id=\"joueur22race\" name=\"joueur22race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race22\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur23\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur23\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(23)\" id=\"joueur23race\" name=\"joueur23race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race23\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur24\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur24\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(24)\" id=\"joueur24race\" name=\"joueur24race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race24\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur25\">" . _EQUIPE3JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur25\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(25)\" id=\"joueur25race\" name=\"joueur25race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race25\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur26\">" . _EQUIPE3JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur26\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(26)\" id=\"joueur26race\" name=\"joueur26race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race26\"></span> *</div></div>\n"

			."<div id=\"six\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur27\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur27\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(27)\" id=\"joueur27race\" name=\"joueur27race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race27\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur28\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur28\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(28)\" id=\"joueur28race\" name=\"joueur28race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race28\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur29\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur29\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(29)\" id=\"joueur29race\" name=\"joueur29race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race29\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur30\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur30\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(30)\" id=\"joueur30race\" name=\"joueur30race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race30\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur31\">" . _EQUIPE3JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur31\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(31)\" id=\"joueur31race\" name=\"joueur31race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race31\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur32\">" . _EQUIPE3JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur32\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(32)\" id=\"joueur32race\" name=\"joueur32race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race32\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur33\">" . _EQUIPE4JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur33\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(33)\" id=\"joueur33race\" name=\"joueur33race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race33\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur34\">" . _EQUIPE4JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur34\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(34)\" id=\"joueur34race\" name=\"joueur34race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race34\"></span> *</div></div>\n"

			."<div id=\"sept\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur35\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur35\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(35)\" id=\"joueur35race\" name=\"joueur35race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race35\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur36\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur36\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(36)\" id=\"joueur36race\" name=\"joueur36race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race36\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur37\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur37\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(37)\" id=\"joueur37race\" name=\"joueur37race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race37\"></span> *</div></div>\n"

			."<div id=\"huit\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur38\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur38\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(38)\" id=\"joueur38race\" name=\"joueur38race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race38\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur39\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur39\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(39)\" id=\"joueur39race\" name=\"joueur39race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race39\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur40\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur40\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(40)\" id=\"joueur40race\" name=\"joueur40race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race40\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur41\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur41\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(41)\" id=\"joueur41race\" name=\"joueur41race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race41\"></span> *</div></div>\n"

			."<div id=\"neuf\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur42\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur42\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(42)\" id=\"joueur42race\" name=\"joueur42race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race42\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur43\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur43\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(43)\" id=\"joueur43race\" name=\"joueur43race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race43\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur44\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur44\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(44)\" id=\"joueur44race\" name=\"joueur44race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race44\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur45\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur45\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(45)\" id=\"joueur45race\" name=\"joueur45race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race45\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur46\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur46\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(46)\" id=\"joueur46race\" name=\"joueur46race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race46\"></span> *</div></div>\n"

			."<div id=\"dix\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur47\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur47\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(47)\" id=\"joueur47race\" name=\"joueur47race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race47\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur48\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur48\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(48)\" id=\"joueur48race\" name=\"joueur48race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race48\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur49\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur49\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(49)\" id=\"joueur49race\" name=\"joueur49race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race49\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur50\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur50\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(50)\" id=\"joueur50race\" name=\"joueur50race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race50\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur51\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur51\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(51)\" id=\"joueur51race\" name=\"joueur51race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race51\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur52\">" . _JOUEUR6 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur52\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(52)\" id=\"joueur52race\" name=\"joueur52race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race52\"></span> *</div></div>\n"

			."<div id=\"onze\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur53\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur53\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(53)\" id=\"joueur53race\" name=\"joueur53race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race53\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur54\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur54\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(54)\" id=\"joueur54race\" name=\"joueur54race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race54\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur55\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur55\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(55)\" id=\"joueur55race\" name=\"joueur55race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race55\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur56\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur56\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(56)\" id=\"joueur56race\" name=\"joueur56race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race56\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur57\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur57\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(57)\" id=\"joueur57race\" name=\"joueur57race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race57\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur58\">" . _JOUEUR6 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur58\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(58)\" id=\"joueur58race\" name=\"joueur58race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race58\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur59\">" . _JOUEUR7 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur59\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(59)\" id=\"joueur59race\" name=\"joueur59race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race59\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur60\">" . _JOUEUR8 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur60\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(60)\" id=\"joueur60race\" name=\"joueur60race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race60\"></span> *</div></div>\n"

			."<div id=\"douze\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur61\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur61\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(61)\" id=\"joueur61race\" name=\"joueur61race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race61\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur62\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur62\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(62)\" id=\"joueur62race\" name=\"joueur62race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race62\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur63\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur63\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(63)\" id=\"joueur63race\" name=\"joueur63race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race63\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur64\">" . _EQUIPE1JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur64\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(64)\" id=\"joueur64race\" name=\"joueur64race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race64\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur65\">" . _EQUIPE1JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur65\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(65)\" id=\"joueur65race\" name=\"joueur65race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race65\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur66\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur66\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(66)\" id=\"joueur66race\" name=\"joueur66race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race66\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur67\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur67\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(67)\" id=\"joueur67race\" name=\"joueur67race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race67\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur68\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur68\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(68)\" id=\"joueur68race\" name=\"joueur68race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race68\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur69\">" . _EQUIPE2JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur69\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(69)\" id=\"joueur69race\" name=\"joueur69race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race69\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur70\">" . _EQUIPE2JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur70\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(70)\" id=\"joueur70race\" name=\"joueur70race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race70\"></span> *</div></div>\n"
	
	
		."<div class=\"row\">\n"
		."<label for=\"titre\">" . _TEXTE . "&nbsp:</label>\n"
		."<span class=\"formw\"><textarea class=\"editor\" name=\"texte\" wrap=\"VIRTUAL\" cols=\"52\" rows=\"8\"></textarea></span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<span class=\"formw\"><input type=\"submit\" value=\""._ADDREPLAYS."\"></span></div>\n"
		."</div></form>\n";
	/*<tr><td  align=\"right\"><b>"._URL2.":&nbsp;&nbsp;</b></td><td  align=\"left\"><input type=\"text\" value=\"modules/Replays/video/\" name=\"url2\" size=\"50\"></td></tr>*/

	echo "<script language=\"javascript\">
			changeImageRace(1);
			changeImageRace(2);
			changeImageRace(3);
			changeImageRace(4);
			changeImageRace(5);
			changeImageRace(6);
			changeImageRace(7);
			changeImageRace(8);
			changeImageRace(9);
			changeImageRace(10);
			changeImageRace(11);
			changeImageRace(12);
			changeImageRace(13);
			changeImageRace(14);
			changeImageRace(15);
			changeImageRace(16);
			changeImageRace(17);
			changeImageRace(18);
			changeImageRace(19);
			changeImageRace(20);
			changeImageRace(21);
			changeImageRace(22);
			changeImageRace(23);
			changeImageRace(24);
			changeImageRace(25);
			changeImageRace(26);
			changeImageRace(27);
			changeImageRace(28);
			changeImageRace(29);
			changeImageRace(30);
			changeImageRace(31);
			changeImageRace(32);
			changeImageRace(33);
			changeImageRace(34);
			changeImageRace(35);
			changeImageRace(36);
			changeImageRace(37);
			changeImageRace(38);
			changeImageRace(39);
			changeImageRace(40);
			changeImageRace(41);
			changeImageRace(42);
			changeImageRace(43);
			changeImageRace(44);
			changeImageRace(45);
			changeImageRace(46);
			changeImageRace(47);
			changeImageRace(48);
			changeImageRace(49);
			changeImageRace(50);
			changeImageRace(51);
			changeImageRace(52);
			changeImageRace(53);
			changeImageRace(54);
			changeImageRace(55);
			changeImageRace(56);
			changeImageRace(57);
			changeImageRace(58);
			changeImageRace(59);
			changeImageRace(60);
			changeImageRace(61);
			changeImageRace(62);
			changeImageRace(63);
			changeImageRace(64);
			changeImageRace(65);
			changeImageRace(66);
			changeImageRace(67);
			changeImageRace(68);
			changeImageRace(69);
			changeImageRace(70);
			changeImageMap();
			changeType();
		  </script>";


	echo "<br/><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Replays&page=admin\"><b>"._BACK."</b></a> ]</div><br />";
}

	function select_type($type) {
    global $nuked;

		$sql_config = mysql_query("SELECT 1vs1, 2vs2, 3vs3, 4vs4, 5vs5, 2vs2vs2, 2vs2vs2vs2, ffa3pl, ffa4pl, ffa5pl, ffa6pl, ffa8pl FROM ". $nuked['prefix'] ."_replays_config");
		list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12) = mysql_fetch_array($sql_config);
		
		$selected1 = "";
		$selected2 = "";
		$selected3 = "";
		$selected4 = "";
		$selected5 = "";
		$selected6 = "";
		$selected7 = "";
		$selected8 = "";
		$selected9 = "";
		$selected10 = "";
		$selected11 = "";
		$selected12 = "";
	
		
		if($type == "" || $type == "1") {
			$selected1 = "selected=\"selected\"";
			
		} else if($type == "2") {
			$selected2 = "selected=\"selected\"";
			
		} else if($type == "3") {
			$selected3 = "selected=\"selected\"";
			
		} else if($type == "4") {
			$selected4 = "selected=\"selected\"";

		} else if($type == "5") {
			$selected5 = "selected=\"selected\"";
		
		} else if($type == "6") {
			$selected6 = "selected=\"selected\"";
		
		} else if($type == "7") {
			$selected7 = "selected=\"selected\"";
		
		} else if($type == "8") {
			$selected8 = "selected=\"selected\"";
		
		} else if($type == "9") {
			$selected9 = "selected=\"selected\"";
		
		} else if($type == "10") {
			$selected10 = "selected=\"selected\"";

		} else if($type == "11") {
			$selected11 = "selected=\"selected\"";

		} else if($type == "12") {
			$selected12 = "selected=\"selected\"";

		} 
		if ($c1 == 'on'){echo "<option " . $selected1 . " value=\"1\">1 VS 1</option>";}
		if ($c2 == 'on'){echo "<option " . $selected2 . " value=\"2\">2 VS 2</option>";}
		if ($c3 == 'on'){echo "<option " . $selected3 . " value=\"3\">3 VS 3</option>";}
		if ($c4 == 'on'){echo "<option " . $selected4 . " value=\"4\">4 VS 4</option>";}
		if ($c5 == 'on'){echo "<option " . $selected12 . " value=\"12\">5 VS 5</option>";}		
		if ($c6 == 'on'){echo "<option " . $selected5 . " value=\"5\">2 VS 2 VS 2</option>";}
		if ($c7 == 'on'){echo "<option " . $selected6 . " value=\"6\">2 VS 2 VS 2 VS 2</option>";}
		if ($c8 == 'on'){echo "<option " . $selected7 . " value=\"7\">" . _FFA3PL . "</option>";}
		if ($c9 == 'on'){echo "<option " . $selected8 . " value=\"8\">" . _FFA4PL . "</option>";}
		if ($c10 == 'on'){echo "<option " . $selected9 . " value=\"9\">" . _FFA5PL . "</option>";}
		if ($c11 == 'on'){echo "<option " . $selected10 . " value=\"10\">" . _FFA6PL . "</option>";}
		if ($c12 == 'on'){echo "<option " . $selected11 . " value=\"11\">" . _FFA8PL . "</option>";}
	}


function select_map($map) {
	
	global $nuked;
	
	$sql=mysql_query("SELECT nom, image FROM ".MAPSTABLE." ORDER BY id"); 
	
	while(list($nom, $image) = mysql_fetch_array($sql)){ 
		
		$selected = "";
		if($map == $image) {
			$selected = "selected=\"selected\"";
		}
		
		echo "<option " . $selected . " value=\"" . $image . "\">" . $nom . "</option>";
	}
}

function select_joueur($race) {
	global $nuked;
	
	$sql=mysql_query("SELECT nom, image FROM " . RACETABLE . " ORDER BY id"); 
	
	while(list($nom, $image) = mysql_fetch_array($sql)) { 
		
		$selected = "";
		if($race == $image) {
			$selected = "selected=\"selected\"";
		}
	
		echo"<option " . $selected . " value=\"" . $image . "\">" . $nom . "</option>";
	}
}

function add_ban($titre, $map, $evenement, $duree, $taille, $version, $url, $copy, $ecrase_file, $typeReplay, $game, $joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10, $joueur11, $joueur12, $joueur13, $joueur14, $joueur15, $joueur16, $joueur17, $joueur18, $joueur19, $joueur20, $joueur21, $joueur22, $joueur23, $joueur24, $joueur25, $joueur26, $joueur27, $joueur28, $joueur29, $joueur30, $joueur31, $joueur32, $joueur33, $joueur34, $joueur35, $joueur36, $joueur37, $joueur38, $joueur39, $joueur40, $joueur41, $joueur42, $joueur43, $joueur44, $joueur45, $joueur46, $joueur47, $joueur48, $joueur49, $joueur50, $joueur51, $joueur52, $joueur53, $joueur54, $joueur55, $joueur56, $joueur57, $joueur58, $joueur59, $joueur60, $joueur61, $joueur62, $joueur63, $joueur64, $joueur65, $joueur66, $joueur67, $joueur68, $joueur69, $joueur70, $joueur1race, $joueur2race, $joueur3race, $joueur4race, $joueur5race, $joueur6race, $joueur7race, $joueur8race, $joueur9race, $joueur10race, $joueur11race, $joueur12race, $joueur13race, $joueur14race, $joueur15race, $joueur16race, $joueur17race, $joueur18race, $joueur19race, $joueur20race, $joueur21race, $joueur22race, $joueur23race, $joueur24race, $joueur25race, $joueur26race, $joueur27race, $joueur28race, $joueur29race, $joueur30race, $joueur31race, $joueur32race, $joueur33race, $joueur34race, $joueur35race, $joueur36race, $joueur37race, $joueur38race, $joueur39race, $joueur40race, $joueur41race, $joueur42race, $joueur43race, $joueur44race, $joueur45race, $joueur46race, $joueur47race, $joueur48race, $joueur49race, $joueur50race, $joueur51race, $joueur52race, $joueur53race, $joueur54race, $joueur55race, $joueur56race, $joueur57race, $joueur58race, $joueur59race, $joueur60race, $joueur61race, $joueur62race, $joueur63race, $joueur64race, $joueur65race, $joueur66race, $joueur67race, $joueur68race, $joueur69race, $joueur70race, $texte)
	{
	global $nuked, $user;
	
	$error = false;
	$error_string = "<div style=\"text-align: center;\"><ul>";
	if(trim($titre) == "") {
		$error_string .= "<li>" . _NOTITRE . "</li>";
		$error = true;
	}
	
	if(trim($evenement) == "") {
		$error_string .="<li>" . _NOEVENT . "</li>";
		$error = true;
	}
	
	if(trim($duree) == "") {
		$error_string .="<li>" . _NODUREE . "</li>";
		$error = true;
	}
	
	if(trim($taille) == "" && $_FILES['copy']['name'] == "") {
		$error_string .="<li>" . _NOTAILLE . "</li>";
		$error = true;
	}
	
	if(trim($version) == "") {
		$error_string .="<li>" . _NOVERSION . "</li>";
		$error = true;
	}
	
		if($typeReplay == 1) {
			if(trim($joueur1) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur2) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 2) {
			if(trim($joueur3) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur4) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur5) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur6) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 3) {
			if(trim($joueur7) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur8) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur9) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur10) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur11) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur12) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 4) {
			if(trim($joueur13) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur14) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur15) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur16) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur17) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur18) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur19) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur20) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
    } else if($typeReplay == 5) {
			if(trim($joueur21) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur22) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur23) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur24) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur25) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur26) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}			
		} else if($typeReplay == 6) {
			if(trim($joueur27) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur28) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur29) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur30) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur31) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur32) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur33) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur34) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
    } else if($typeReplay == 7) {
			if(trim($joueur35) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur36) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur37) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 8) {
			if(trim($joueur38) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur39) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur40) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur41) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 9) {
			if(trim($joueur42) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur43) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur44) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur45) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur46) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 10) {
			if(trim($joueur47) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur48) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur49) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur50) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur51) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur52) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}			
		} else if($typeReplay == 11) {
			if(trim($joueur53) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur54) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur55) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur56) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur57) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur58) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur59) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur60) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
    } else if($typeReplay == 12) {
			if(trim($joueur61) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur62) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur63) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur64) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur65) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur66) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur67) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur68) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
			
			if(trim($joueur69) == "") {
				$error_string .="<li>" . _NOJOUEUR9 . "</li>";
				$error = true;
			}
			
			if(trim($joueur70) == "") {
				$error_string .="<li>" . _NOJOUEUR10 . "</li>";
				$error = true;
			}
    }
	
	$error_string .="</ul><br/><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div>";
	
	if($error) {
		echo $error_string;
	} else {
	
		// Upload du fichier si il est fourni
		$racine_up = "upload/Replays/";
        $racine_down = "";
		
		if(!is_dir("upload/Replays")) {
			mkdir("upload/Replays");
		}

        if ($_FILES['copy']['name'] != "")
        {
            $filename = $_FILES['copy']['name'];
            $filesize = $_FILES['copy']['size'];
            $taille = $filesize / 1024;
            $taille = (round($taille * 100)) / 100;

            $url_file = $racine_up . $filename;

            if (!is_file($url_file)  || $ecrase_file == 1)
            {
                if (!eregi("\.php", $filename) && !eregi("\.htm", $filename) && !eregi("\.[a-z]htm", $filename) && $filename != ".htaccess")
                {
					move_uploaded_file($_FILES['copy']['tmp_name'], $url_file) or die ("Upload file failed !!!");
					@chmod ($url_file, 0644);
                }
                else
                {
                    echo "<br /><br /><div style=\"text-align: center;\">Unauthorized file !!!</div><br /><br />";
                    redirect("index.php?file=Replays&page=admin&op=add", 2);
                    adminfoot();
                    footer();
                    exit();
                }
            }
			else
            {
                $deja_file = 1;
            }

            $url_full = $racine_down . $url_file;
            $url_full = $url_file;

            $url = $url_full;
        }
		
		if ($deja_file == 1)
        {
            echo "<br /><br /><div style=\"text-align: center;\">" . _DEJAFILE;
            echo "<br />" . _REPLACEIT . "<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
        } else {
			if($typeReplay == 1) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, racejoueur1, racejoueur2) VALUES('" . $joueur1 . "', '" . $joueur2 . "', '" . $joueur1race . "', '" . $joueur2race . "')");
				} else if($typeReplay == 2) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4) VALUES('" . $joueur3 . "', '" . $joueur4 . "', '" . $joueur5 . "', '" . $joueur6 . "', '" . $joueur3race . "', '" . $joueur4race . "', '" . $joueur5race . "', '" . $joueur6race . "')");
				} else if($typeReplay == 3) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6) VALUES('" . $joueur7 . "', '" . $joueur8 . "', '" . $joueur9 . "', '" . $joueur10 . "', '" . $joueur11 .  "', '" . $joueur12 .  "', '" . $joueur7race . "', '" . $joueur8race .  "', '" . $joueur9race .  "', '" . $joueur10race . "', '" . $joueur11race . "', '" . $joueur12race . "')");
				} else if($typeReplay == 4) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8) VALUES('" . $joueur13 . "', '" . $joueur14 . "', '" . $joueur15 . "', '" . $joueur16 . "', '" . $joueur17 . "', '" . $joueur18 . "', '" . $joueur19 . "', '" . $joueur20 .  "', '" . $joueur13race . "', '" . $joueur14race .  "', '" . $joueur15race . "', '" . $joueur16race .  "', '" . $joueur17race . "', '" . $joueur18race . "', '" . $joueur19race . "', '" . $joueur20race . "')");
				} else if($typeReplay == 5) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6) VALUES('" . $joueur21 . "', '" . $joueur22 . "', '" . $joueur23 . "', '" . $joueur24 . "', '" . $joueur25 .  "', '" . $joueur26 .  "', '" . $joueur21race . "', '" . $joueur22race .  "', '" . $joueur23race .  "', '" . $joueur24race . "', '" . $joueur25race . "', '" . $joueur26race . "')");				
				} else if($typeReplay == 6) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8) VALUES('" . $joueur27 . "', '" . $joueur28 . "', '" . $joueur29 . "', '" . $joueur30 . "', '" . $joueur31 . "', '" . $joueur32 . "', '" . $joueur33 . "', '" . $joueur34 .  "', '" . $joueur27race . "', '" . $joueur28race .  "', '" . $joueur29race . "', '" . $joueur30race .  "', '" . $joueur31race . "', '" . $joueur32race . "', '" . $joueur33race . "', '" . $joueur34race . "')");
				} else if($typeReplay == 7) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, racejoueur1, racejoueur2, racejoueur3) VALUES('" . $joueur35 . "', '" . $joueur36 . "', '" . $joueur37 . "', '" . $joueur35race . "', '" . $joueur36race . "', '" . $joueur37race . "')");
				} else if($typeReplay == 8) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4) VALUES('" . $joueur38 . "', '" . $joueur39 . "', '" . $joueur40 . "', '" . $joueur41 . "', '" . $joueur38race . "', '" . $joueur39race . "', '" . $joueur40race . "', '" . $joueur41race . "')");
				} else if($typeReplay == 9) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5) VALUES('" . $joueur42 . "', '" . $joueur43 . "', '" . $joueur44 . "', '" . $joueur45 . "', '" . $joueur46 . "', '" . $joueur42race . "', '" . $joueur43race . "', '" . $joueur44race . "', '" . $joueur45race . "', '" . $joueur46race . "')");
				} else if($typeReplay == 10) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6) VALUES('" . $joueur47 . "', '" . $joueur48 . "', '" . $joueur49 . "', '" . $joueur50 . "', '" . $joueur51 .  "', '" . $joueur52 .  "', '" . $joueur47race . "', '" . $joueur48race .  "', '" . $joueur49race .  "', '" . $joueur50race . "', '" . $joueur51race . "', '" . $joueur52race . "')");				
				} else if($typeReplay == 11) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8) VALUES('" . $joueur53 . "', '" . $joueur54 . "', '" . $joueur55 . "', '" . $joueur56 . "', '" . $joueur57 . "', '" . $joueur58 . "', '" . $joueur59 . "', '" . $joueur60 .  "', '" . $joueur53race . "', '" . $joueur54race .  "', '" . $joueur55race . "', '" . $joueur56race .  "', '" . $joueur57race . "', '" . $joueur58race . "', '" . $joueur59race . "', '" . $joueur60race . "')");
				} else if($typeReplay == 12) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, joueur9, joueur10, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8, racejoueur9, racejoueur10) VALUES('" . $joueur61 . "', '" . $joueur62 . "', '" . $joueur63 . "', '" . $joueur64 . "', '" . $joueur65 . "', '" . $joueur66 . "', '" . $joueur67 . "', '" . $joueur68 . "', '" . $joueur69 . "', '" . $joueur70 .  "', '" . $joueur61race . "', '" . $joueur62race .  "', '" . $joueur63race . "', '" . $joueur64race .  "', '" . $joueur65race .  "', '" . $joueur66race .  "', '" . $joueur67race . "', '" . $joueur68race . "', '" . $joueur69race . "', '" . $joueur70race . "')");
				}
			
			
			
			
			$id_equipe = mysql_insert_id();
			$auj = time();
			$add=mysql_query("INSERT INTO " . REPLAYSTABLE . "(titre, texte, evenement, map, duree, taille, version, url, id_equipe, type, id_user, date_ajout, game ) VALUES ('" . $titre . "', '" . $texte . "', '" . $evenement . "', '" . $map . "', '" . $duree . "', '" . $taille . "', '" . $version . "', '" . $url . "', " . $id_equipe . ", " . $typeReplay . ", '" . $user[0] . "', '" . $auj . "', '" . $game . "')");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _REPLAYADDSUCCESS . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Replays&page=admin",2);
		}
	}
}

function edit($id)
{
	global $nuked;

	$sql =mysql_query("SELECT id, titre, texte, evenement, map, duree, taille, version, url, id_equipe, type, game FROM ".REPLAYSTABLE." WHERE id='" . $id . "'"); 
	list($id, $titre, $texte, $evenement, $map, $duree, $taille, $version, $url, $id_equipe, $type, $game) = mysql_fetch_row($sql);
	
	if($type == 1) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, racejoueur1, racejoueur2 FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $racejoueur1, $racejoueur2) = mysql_fetch_row($sql_joueurs);
	} else if($type == 2) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
	} else if($type == 3) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
	} else if($type == 4) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
	} else if($type == 5) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
	} else if($type == 6) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
	} else if($type == 7) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, racejoueur1, racejoueur2, racejoueur3  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $racejoueur1, $racejoueur2, $racejoueur3) = mysql_fetch_row($sql_joueurs);
	} else if($type == 8) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
	} else if($type == 9) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5) = mysql_fetch_row($sql_joueurs);
	} else if($type == 10) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
	} else if($type == 11) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
	} else if($type == 12) {
		$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, joueur9, joueur10, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8, racejoueur9, racejoueur10  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
		list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8, $racejoueur9, $racejoueur10) = mysql_fetch_row($sql_joueurs);
	} 
	
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
	
	echo "<br/><br/><div style=\"text-align: center;\"><em>"._REQUIRED."</em></div><br />";
	
	echo "<link rel=\"stylesheet\" href=\"modules/Replays/css/style.css\" type=\"text/css\" media=\"screen\" />\n"
		."<script src=\"modules/Replays/js/function.js\" type=\"text/javascript\"></script>\n"
		."<form onsubmit=\"return checkFile();\" method=\"post\" action=\"index.php?file=Replays&page=admin&op=edit_ban\" enctype=\"multipart/form-data\">\n"
		."<div class=\"formulaire\">\n"
		."<div class=\"row\">\n"
		."<label for=\"titre\">" . _TITRE . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"titre\" size=\"25\" value=\"" . $titre . "\" /> *</span>\n"
		."</div>\n"
//Ajout du Jeu		
		."<div class=\"row\">\n"
		."<label for=\"game\">" . _GAME . "&nbsp:</label>\n"
		."<span class=\"formw\"><select name=\"game\">\n";
            $sql3 = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
            while (list($id_game, $name) = mysql_fetch_array($sql3)){
                $name = htmlentities($name);
                if ($id_game == $game){
                    $checked4 = "selected=\"selected\"";
                } 
                else{
                    $checked4 = "";
                }
                echo "<option value=\"" . $id_game . "\" " . $checked4 . ">" . $name . "</option>\n";
            } 
  echo "</select></span></div>\n"		
//Fin Ajout du jeu		
		."<div class=\"row\">\n"
		."<label for=\"map\">" . _NOMMAP . "&nbsp:</label>\n"
		."<span class=\"formw\"><select onchange=\"changeImageMap();\" id=\"map\" name=\"map\">\n";
	select_map($map);
	echo "</select></span></div>\n"
		."<div class=\"row\">\n"
		."<label class=\"imgMap\">" . _PREVIEWMAP . "&nbsp:</label>\n"
		."<span class=\"formw\"><div id=\"img_map\" style=\"width: 100px; height: 100px;\"></div></span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"evenement\">" . _EVENEMENT . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"evenement\" size=\"25\" value=\"" . $evenement . "\" /> *</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"duree\">" . _DUREE . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"duree\" size=\"10\" value=\"" . $duree . "\" />&nbsp;Min *</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"taille\">" . _TAILLE . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"taille\" size=\"10\" value=\"" . $taille . "\" />&nbsp;Ko *</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"version\">" . _VERSION . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" name=\"version\" size=\"10\" value=\"" . $version . "\" /> *</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"url\">" . _URL . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"text\" id=\"url\" name=\"url\" size=\"50\" value=\"" . $url . "\" /></span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"url\">" . _UPFILE . "&nbsp:</label>\n"
		."<span class=\"formw\"><input type=\"file\" id=\"copy\" name=\"copy\" onChange=\"checkFile();\" />&nbsp;" . $upload_status . "&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_file\" value=\"1\" /> " . _REPLACE . "</span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<label for=\"type\">" . _TYPEREPLAY . "&nbsp:</label>\n"
		."<span class=\"formw\"><select onchange=\"changeType();\" id=\"typeReplay\" name=\"typeReplay\">\n";
	select_type($type);	
	echo "</select></span></div>\n"
	
      ."<div id=\"un\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur1\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur1\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(1)\" id=\"joueur1race\" name=\"joueur1race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race1\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur2\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur2\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(2)\" id=\"joueur2race\" name=\"joueur2race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race2\"></span> *</div></div>\n"
		
			."<div id=\"deux\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur3\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur3\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(3)\" id=\"joueur3race\" name=\"joueur3race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race3\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur4\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur4\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(4)\" id=\"joueur4race\" name=\"joueur4race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race4\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur5\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur5\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(5)\" id=\"joueur5race\" name=\"joueur5race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race5\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur6\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur6\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(6)\" id=\"joueur6race\" name=\"joueur6race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race6\"></span> *</div></div>\n"
			
			."<div id=\"trois\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur7\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur7\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(7)\" id=\"joueur7race\" name=\"joueur7race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race7\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur8\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur8\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(8)\" id=\"joueur8race\" name=\"joueur8race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race8\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur9\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur9\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(9)\" id=\"joueur9race\" name=\"joueur9race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race9\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur10\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur10\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(10)\" id=\"joueur10race\" name=\"joueur10race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race10\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur11\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur11\" size=\"25\" value=\"" . $joueur5 . "\" />&nbsp;<select onchange=\"changeImageRace(11)\" id=\"joueur11race\" name=\"joueur11race\"></span>\n";
		select_joueur($racejoueur5);
		echo "</select>&nbsp;<span id=\"img_race11\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur12\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur12\" size=\"25\" value=\"" . $joueur6 . "\" />&nbsp;<select onchange=\"changeImageRace(12)\" id=\"joueur12race\" name=\"joueur12race\"></span>\n";
		select_joueur($racejoueur6);
		echo "</select>&nbsp;<span id=\"img_race12\"></span> *</div></div>\n"
			
			."<div id=\"quatre\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur13\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur13\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(13)\" id=\"joueur13race\" name=\"joueur13race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race13\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur14\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur14\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(14)\" id=\"joueur14race\" name=\"joueur14race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race14\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur15\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur15\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(15)\" id=\"joueur15race\" name=\"joueur15race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race15\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur16\">" . _EQUIPE1JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur16\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(16)\" id=\"joueur16race\" name=\"joueur16race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race16\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur17\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur17\" size=\"25\" value=\"" . $joueur5 . "\" />&nbsp;<select onchange=\"changeImageRace(17)\" id=\"joueur17race\" name=\"joueur17race\"></span>\n";
		select_joueur($racejoueur5);
		echo "</select>&nbsp;<span id=\"img_race17\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur18\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur18\" size=\"25\" value=\"" . $joueur6 . "\" />&nbsp;<select onchange=\"changeImageRace(18)\" id=\"joueur18race\" name=\"joueur18race\"></span>\n";
		select_joueur($racejoueur6);
		echo "</select>&nbsp;<span id=\"img_race18\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur19\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur19\" size=\"25\" value=\"" . $joueur7 . "\" />&nbsp;<select onchange=\"changeImageRace(19)\" id=\"joueur19race\" name=\"joueur19race\"></span>\n";
		select_joueur($racejoueur7);
		echo "</select>&nbsp;<span id=\"img_race19\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur20\">" . _EQUIPE2JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur20\" size=\"25\" value=\"" . $joueur8 . "\" />&nbsp;<select onchange=\"changeImageRace(20)\" id=\"joueur20race\" name=\"joueur20race\"></span>\n";
		select_joueur($racejoueur8);
		echo "</select>&nbsp;<span id=\"img_race20\"></span> *</div></div>\n"

			."<div id=\"cinq\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur21\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur21\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(21)\" id=\"joueur21race\" name=\"joueur21race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race21\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur22\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur22\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(22)\" id=\"joueur22race\" name=\"joueur22race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race22\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur23\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur23\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(23)\" id=\"joueur23race\" name=\"joueur23race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race23\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur24\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur24\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(24)\" id=\"joueur24race\" name=\"joueur24race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race24\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur25\">" . _EQUIPE3JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur25\" size=\"25\" value=\"" . $joueur5 . "\" />&nbsp;<select onchange=\"changeImageRace(25)\" id=\"joueur25race\" name=\"joueur25race\"></span>\n";
		select_joueur($racejoueur5);
		echo "</select>&nbsp;<span id=\"img_race25\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur26\">" . _EQUIPE3JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur26\" size=\"25\" value=\"" . $joueur6 . "\" />&nbsp;<select onchange=\"changeImageRace(26)\" id=\"joueur26race\" name=\"joueur26race\"></span>\n";
		select_joueur($racejoueur6);
		echo "</select>&nbsp;<span id=\"img_race26\"></span> *</div></div>\n"

			."<div id=\"six\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur27\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur27\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(27)\" id=\"joueur27race\" name=\"joueur27race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race27\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur28\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur28\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(28)\" id=\"joueur28race\" name=\"joueur28race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race28\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur29\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur29\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(29)\" id=\"joueur29race\" name=\"joueur29race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race29\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur30\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur30\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(30)\" id=\"joueur30race\" name=\"joueur30race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race30\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur31\">" . _EQUIPE3JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur31\" size=\"25\" value=\"" . $joueur5 . "\" />&nbsp;<select onchange=\"changeImageRace(31)\" id=\"joueur31race\" name=\"joueur31race\"></span>\n";
		select_joueur($racejoueur5);
		echo "</select>&nbsp;<span id=\"img_race31\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur32\">" . _EQUIPE3JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur32\" size=\"25\" value=\"" . $joueur6 . "\" />&nbsp;<select onchange=\"changeImageRace(32)\" id=\"joueur32race\" name=\"joueur32race\"></span>\n";
		select_joueur($racejoueur6);
		echo "</select>&nbsp;<span id=\"img_race32\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur33\">" . _EQUIPE4JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur33\" size=\"25\" value=\"" . $joueur7 . "\" />&nbsp;<select onchange=\"changeImageRace(33)\" id=\"joueur33race\" name=\"joueur33race\"></span>\n";
		select_joueur($racejoueur7);
		echo "</select>&nbsp;<span id=\"img_race33\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur34\">" . _EQUIPE4JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur34\" size=\"25\" value=\"" . $joueur8 . "\" />&nbsp;<select onchange=\"changeImageRace(34)\" id=\"joueur34race\" name=\"joueur34race\"></span>\n";
		select_joueur($racejoueur8);
		echo "</select>&nbsp;<span id=\"img_race34\"></span> *</div></div>\n"

			."<div id=\"sept\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur35\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur35\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(35)\" id=\"joueur35race\" name=\"joueur35race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race35\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur36\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur36\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(36)\" id=\"joueur36race\" name=\"joueur36race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race36\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur37\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur37\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(37)\" id=\"joueur37race\" name=\"joueur37race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race37\"></span> *</div></div>\n"

			."<div id=\"huit\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur38\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur38\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(38)\" id=\"joueur38race\" name=\"joueur38race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race38\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur39\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur39\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(39)\" id=\"joueur39race\" name=\"joueur39race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race39\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur40\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur40\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(40)\" id=\"joueur40race\" name=\"joueur40race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race40\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur41\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur41\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(41)\" id=\"joueur41race\" name=\"joueur41race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race41\"></span> *</div></div>\n"

			."<div id=\"neuf\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur42\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur42\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(42)\" id=\"joueur42race\" name=\"joueur42race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race42\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur43\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur43\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(43)\" id=\"joueur43race\" name=\"joueur43race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race43\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur44\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur44\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(44)\" id=\"joueur44race\" name=\"joueur44race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race44\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur45\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur45\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(45)\" id=\"joueur45race\" name=\"joueur45race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race45\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur46\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur46\" size=\"25\" value=\"" . $joueur5 . "\" />&nbsp;<select onchange=\"changeImageRace(46)\" id=\"joueur46race\" name=\"joueur46race\"></span>\n";
		select_joueur($racejoueur5);
		echo "</select>&nbsp;<span id=\"img_race46\"></span> *</div></div>\n"

			."<div id=\"dix\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur47\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur47\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(47)\" id=\"joueur47race\" name=\"joueur47race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race47\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur48\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur48\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(48)\" id=\"joueur48race\" name=\"joueur48race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race48\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur49\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur49\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(49)\" id=\"joueur49race\" name=\"joueur49race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race49\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur50\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur50\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(50)\" id=\"joueur50race\" name=\"joueur50race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race50\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur51\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur51\" size=\"25\" value=\"" . $joueur5 . "\" />&nbsp;<select onchange=\"changeImageRace(51)\" id=\"joueur51race\" name=\"joueur51race\"></span>\n";
		select_joueur($racejoueur5);
		echo "</select>&nbsp;<span id=\"img_race51\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur52\">" . _JOUEUR6 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur52\" size=\"25\" value=\"" . $joueur6 . "\" />&nbsp;<select onchange=\"changeImageRace(52)\" id=\"joueur52race\" name=\"joueur52race\"></span>\n";
		select_joueur($racejoueur6);
		echo "</select>&nbsp;<span id=\"img_race52\"></span> *</div></div>\n"

			."<div id=\"onze\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur53\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur53\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(53)\" id=\"joueur53race\" name=\"joueur53race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race53\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur54\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur54\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(54)\" id=\"joueur54race\" name=\"joueur54race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race54\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur55\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur55\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(55)\" id=\"joueur55race\" name=\"joueur55race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race55\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur56\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur56\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(56)\" id=\"joueur56race\" name=\"joueur56race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race56\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur57\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur57\" size=\"25\" value=\"" . $joueur5 . "\" />&nbsp;<select onchange=\"changeImageRace(57)\" id=\"joueur57race\" name=\"joueur57race\"></span>\n";
		select_joueur($racejoueur5);
		echo "</select>&nbsp;<span id=\"img_race57\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur58\">" . _JOUEUR6 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur58\" size=\"25\" value=\"" . $joueur6 . "\" />&nbsp;<select onchange=\"changeImageRace(58)\" id=\"joueur58race\" name=\"joueur58race\"></span>\n";
		select_joueur($racejoueur6);
		echo "</select>&nbsp;<span id=\"img_race58\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur59\">" . _JOUEUR7 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur59\" size=\"25\" value=\"" . $joueur7 . "\" />&nbsp;<select onchange=\"changeImageRace(59)\" id=\"joueur59race\" name=\"joueur59race\"></span>\n";
		select_joueur($racejoueur7);
		echo "</select>&nbsp;<span id=\"img_race59\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur60\">" . _JOUEUR8 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur60\" size=\"25\" value=\"" . $joueur8 . "\" />&nbsp;<select onchange=\"changeImageRace(60)\" id=\"joueur60race\" name=\"joueur60race\"></span>\n";
		select_joueur($racejoueur8);
		echo "</select>&nbsp;<span id=\"img_race60\"></span> *</div></div>\n"

			."<div id=\"douze\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur61\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur61\" size=\"25\" value=\"" . $joueur1 . "\" />&nbsp;<select onchange=\"changeImageRace(61)\" id=\"joueur61race\" name=\"joueur61race\"></span>\n";
		select_joueur($racejoueur1);
		echo "</select>&nbsp;<span id=\"img_race61\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur62\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur62\" size=\"25\" value=\"" . $joueur2 . "\" />&nbsp;<select onchange=\"changeImageRace(62)\" id=\"joueur62race\" name=\"joueur62race\"></span>\n";
		select_joueur($racejoueur2);
		echo "</select>&nbsp;<span id=\"img_race62\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur63\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur63\" size=\"25\" value=\"" . $joueur3 . "\" />&nbsp;<select onchange=\"changeImageRace(63)\" id=\"joueur63race\" name=\"joueur63race\"></span>\n";
		select_joueur($racejoueur3);
		echo "</select>&nbsp;<span id=\"img_race63\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur64\">" . _EQUIPE1JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur64\" size=\"25\" value=\"" . $joueur4 . "\" />&nbsp;<select onchange=\"changeImageRace(64)\" id=\"joueur64race\" name=\"joueur64race\"></span>\n";
		select_joueur($racejoueur4);
		echo "</select>&nbsp;<span id=\"img_race64\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur65\">" . _EQUIPE1JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur65\" size=\"25\" value=\"" . $joueur5 . "\" />&nbsp;<select onchange=\"changeImageRace(65)\" id=\"joueur65race\" name=\"joueur65race\"></span>\n";
		select_joueur($racejoueur5);
		echo "</select>&nbsp;<span id=\"img_race65\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur66\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur66\" size=\"25\" value=\"" . $joueur6 . "\" />&nbsp;<select onchange=\"changeImageRace(66)\" id=\"joueur66race\" name=\"joueur66race\"></span>\n";
		select_joueur($racejoueur6);
		echo "</select>&nbsp;<span id=\"img_race66\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur67\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur67\" size=\"25\" value=\"" . $joueur7 . "\" />&nbsp;<select onchange=\"changeImageRace(67)\" id=\"joueur67race\" name=\"joueur67race\"></span>\n";
		select_joueur($racejoueur7);
		echo "</select>&nbsp;<span id=\"img_race67\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur68\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur68\" size=\"25\" value=\"" . $joueur8 . "\" />&nbsp;<select onchange=\"changeImageRace(68)\" id=\"joueur68race\" name=\"joueur68race\"></span>\n";
		select_joueur($racejoueur8);
		echo "</select>&nbsp;<span id=\"img_race68\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur69\">" . _EQUIPE2JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur69\" size=\"25\" value=\"" . $joueur9 . "\" />&nbsp;<select onchange=\"changeImageRace(69)\" id=\"joueur69race\" name=\"joueur69race\"></span>\n";
		select_joueur($racejoueur9);
		echo "</select>&nbsp;<span id=\"img_race69\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur70\">" . _EQUIPE2JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur70\" size=\"25\" value=\"" . $joueur10 . "\" />&nbsp;<select onchange=\"changeImageRace(70)\" id=\"joueur70race\" name=\"joueur70race\"></span>\n";
		select_joueur($racejoueur10);
		echo "</select>&nbsp;<span id=\"img_race70\"></span> *</div></div>\n"
	

	
		."<div class=\"row\">\n"
		."<label for=\"titre\">" . _TEXTE . "&nbsp:</label>\n"
		."<span class=\"formw\"><textarea class=\"editor\" name=\"texte\" wrap=\"VIRTUAL\" cols=\"52\" rows=\"8\">" . $texte . "</textarea></span>\n"
		."</div>\n"
		."<div class=\"row\">\n"
		."<span class=\"formw\"><input type=\"submit\" value=\""._MODIFREPLAY."\"></span></div>\n"
		."</div><input type=\"hidden\" name=\"id\" value=\"" . $id . "\" /><input type=\"hidden\" name=\"id_equipe\" value=\"" . $id_equipe . "\" /></form>\n";
	/*<tr><td  align=\"right\"><b>"._URL2.":&nbsp;&nbsp;</b></td><td  align=\"left\"><input type=\"text\" value=\"modules/Replays/video/\" name=\"url2\" size=\"50\"></td></tr>*/

	echo "<script language=\"javascript\">
      changeImageRace(1);
			changeImageRace(2);
			changeImageRace(3);
			changeImageRace(4);
			changeImageRace(5);
			changeImageRace(6);
			changeImageRace(7);
			changeImageRace(8);
			changeImageRace(9);
			changeImageRace(10);
			changeImageRace(11);
			changeImageRace(12);
			changeImageRace(13);
			changeImageRace(14);
			changeImageRace(15);
			changeImageRace(16);
			changeImageRace(17);
			changeImageRace(18);
			changeImageRace(19);
			changeImageRace(20);
			changeImageRace(21);
			changeImageRace(22);
			changeImageRace(23);
			changeImageRace(24);
			changeImageRace(25);
			changeImageRace(26);
			changeImageRace(27);
			changeImageRace(28);
			changeImageRace(29);
			changeImageRace(30);
			changeImageRace(31);
			changeImageRace(32);
			changeImageRace(33);
			changeImageRace(34);
			changeImageRace(35);
			changeImageRace(36);
			changeImageRace(37);
			changeImageRace(38);
			changeImageRace(39);
			changeImageRace(40);
			changeImageRace(41);
			changeImageRace(42);
			changeImageRace(43);
			changeImageRace(44);
			changeImageRace(45);
			changeImageRace(46);
			changeImageRace(47);
			changeImageRace(48);
			changeImageRace(49);
			changeImageRace(50);
			changeImageRace(51);
			changeImageRace(52);
			changeImageRace(53);
			changeImageRace(54);
			changeImageRace(55);
			changeImageRace(56);
			changeImageRace(57);
			changeImageRace(58);
			changeImageRace(59);
			changeImageRace(60);
			changeImageRace(61);
			changeImageRace(62);
			changeImageRace(63);
			changeImageRace(64);
			changeImageRace(65);
			changeImageRace(66);
			changeImageRace(67);
			changeImageRace(68);
			changeImageRace(69);
			changeImageRace(70);						
		changeImageMap();
		changeType();
	  </script>";

	echo "<br/><br/><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Replays&page=admin\"><b>"._BACK."</b></a> ]</div><br />";
}



function edit_ban($id, $id_equipe, $titre, $map, $evenement, $duree, $taille, $version, $url, $copy, $ecrase_file, $typeReplay, $game, $joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10, $joueur11, $joueur12, $joueur13, $joueur14, $joueur15, $joueur16, $joueur17, $joueur18, $joueur19, $joueur20, $joueur21, $joueur22, $joueur23, $joueur24, $joueur25, $joueur26, $joueur27, $joueur28, $joueur29, $joueur30, $joueur31, $joueur32, $joueur33, $joueur34, $joueur35, $joueur36, $joueur37, $joueur38, $joueur39, $joueur40, $joueur41, $joueur42, $joueur43, $joueur44, $joueur45, $joueur46, $joueur47, $joueur48, $joueur49, $joueur50, $joueur51, $joueur52, $joueur53, $joueur54, $joueur55, $joueur56, $joueur57, $joueur58, $joueur59, $joueur60, $joueur61, $joueur62, $joueur63, $joueur64, $joueur65, $joueur66, $joueur67, $joueur68, $joueur69, $joueur70, $joueur1race, $joueur2race, $joueur3race, $joueur4race, $joueur5race, $joueur6race, $joueur7race, $joueur8race, $joueur9race, $joueur10race, $joueur11race, $joueur12race, $joueur13race, $joueur14race, $joueur15race, $joueur16race, $joueur17race, $joueur18race, $joueur19race, $joueur20race, $joueur21race, $joueur22race, $joueur23race, $joueur24race, $joueur25race, $joueur26race, $joueur27race, $joueur28race, $joueur29race, $joueur30race, $joueur31race, $joueur32race, $joueur33race, $joueur34race, $joueur35race, $joueur36race, $joueur37race, $joueur38race, $joueur39race, $joueur40race, $joueur41race, $joueur42race, $joueur43race, $joueur44race, $joueur45race, $joueur46race, $joueur47race, $joueur48race, $joueur49race, $joueur50race, $joueur51race, $joueur52race, $joueur53race, $joueur54race, $joueur55race, $joueur56race, $joueur57race, $joueur58race, $joueur59race, $joueur60race, $joueur61race, $joueur62race, $joueur63race, $joueur64race, $joueur65race, $joueur66race, $joueur67race, $joueur68race, $joueur69race, $joueur70race, $texte)
{
	global $nuked;
	$error = false;
	$error_string = "<div style=\"text-align: center;\"><ul>";
	
	if(trim($titre) == "") {
		$error_string .= "<li>" . _NOTITRE . "</li>";
		$error = true;
	}
	
	if(trim($evenement) == "") {
		$error_string .="<li>" . _NOEVENT . "</li>";
		$error = true;
	}
	
	if(trim($duree) == "") {
		$error_string .="<li>" . _NODUREE . "</li>";
		$error = true;
	}
	
	if(trim($taille) == "" && $_FILES['copy']['name'] == "") {
		$error_string .="<li>" . _NOTAILLE . "</li>";
		$error = true;
	}
	
	if(trim($version) == "") {
		$error_string .="<li>" . _NOVERSION . "</li>";
		$error = true;
	}
	
	if($typeReplay == 1) {
			if(trim($joueur1) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur2) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 2) {
			if(trim($joueur3) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur4) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur5) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur6) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 3) {
			if(trim($joueur7) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur8) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur9) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur10) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur11) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur12) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 4) {
			if(trim($joueur13) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur14) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur15) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur16) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur17) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur18) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur19) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur20) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
    } else if($typeReplay == 5) {
			if(trim($joueur21) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur22) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur23) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur24) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur25) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur26) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}			
		} else if($typeReplay == 6) {
			if(trim($joueur27) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur28) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur29) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur30) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur31) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur32) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur33) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur34) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
    } else if($typeReplay == 7) {
			if(trim($joueur35) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur36) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur37) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 8) {
			if(trim($joueur38) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur39) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur40) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur41) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 9) {
			if(trim($joueur42) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur43) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur44) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur45) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur46) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 10) {
			if(trim($joueur47) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur48) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur49) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur50) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur51) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur52) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}			
		} else if($typeReplay == 11) {
			if(trim($joueur53) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur54) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur55) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur56) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur57) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur58) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur59) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur60) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
    } else if($typeReplay == 12) {
			if(trim($joueur61) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur62) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur63) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur64) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur65) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur66) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur67) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur68) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
			
			if(trim($joueur69) == "") {
				$error_string .="<li>" . _NOJOUEUR9 . "</li>";
				$error = true;
			}
			
			if(trim($joueur70) == "") {
				$error_string .="<li>" . _NOJOUEUR10 . "</li>";
				$error = true;
			}
    }
	
	$error_string .="</ul><br/><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div>";
	
	if($error) {
		echo $error_string;
	} else {
	
		// Upload du fichier si il est fourni
		$racine_up = "upload/Replays/";
        $racine_down = "";
		
		if(!is_dir("upload/Replays")) {
			mkdir("upload/Replays");
		}

        if ($_FILES['copy']['name'] != "")
        {
            $filename = $_FILES['copy']['name'];
            $filesize = $_FILES['copy']['size'];
            $taille = $filesize / 1024;
            $taille = (round($taille * 100)) / 100;

            $url_file = $racine_up . $filename;

            if (!is_file($url_file)  || $ecrase_file == 1)
            {
                if (!eregi("\.php", $filename) && !eregi("\.htm", $filename) && !eregi("\.[a-z]htm", $filename) && $filename != ".htaccess")
                {
					move_uploaded_file($_FILES['copy']['tmp_name'], $url_file) or die ("Upload file failed !!!");
					@chmod ($url_file, 0644);
                }
                else
                {
                    echo "<br /><br /><div style=\"text-align: center;\">Unauthorized file !!!</div><br /><br />";
                    redirect("index.php?file=Replays&page=admin&op=add", 2);
                    adminfoot();
                    footer();
                    exit();
                }
            }
			else
            {
                $deja_file = 1;
            }

            $url_full = $racine_down . $url_file;
            $url_full = $url_file;

            $url = $url_full;
        }
		
		if ($deja_file == 1)
        {
            echo "<br /><br /><div style=\"text-align: center;\">" . _DEJAFILE;
            echo "<br />" . _REPLACEIT . "<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
        } else {
			if($typeReplay == 1) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur1 . "', joueur2='" . $joueur2 . "', joueur3='', joueur4='', racejoueur1='" . $joueur1race . "', racejoueur2='" . $joueur2race . "', racejoueur3='', racejoueur4='' WHERE id=".$id_equipe);
			} else if($typeReplay == 2) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur3 . "', joueur2='" . $joueur4 . "', joueur3='" . $joueur5 . "', joueur4='" . $joueur6 . "', racejoueur1='" . $joueur3race . "', racejoueur2='" . $joueur4race . "', racejoueur3='" . $joueur5race . "', racejoueur4='" . $joueur6race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 3) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur7 . "', joueur2='" . $joueur8 . "', joueur3='" . $joueur9 . "', joueur4='" . $joueur10 . "', joueur5='" . $joueur11 . "', joueur6='" . $joueur12 . "', racejoueur1='" . $joueur7race . "', racejoueur2='" . $joueur8race . "', racejoueur3='" . $joueur9race . "', racejoueur4='" . $joueur10race . "', racejoueur5='" . $joueur11race . "', racejoueur6='" . $joueur12race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 4) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur13 . "', joueur2='" . $joueur14 . "', joueur3='" . $joueur15 . "', joueur4='" . $joueur16 . "', joueur5='" . $joueur17 . "', joueur6='" . $joueur18 . "', joueur7='" . $joueur19 . "', joueur8='" . $joueur20 . "', racejoueur1='" . $joueur13race . "', racejoueur2='" . $joueur14race . "', racejoueur3='" . $joueur15race . "', racejoueur4='" . $joueur16race . "', racejoueur5='" . $joueur17race . "', racejoueur6='" . $joueur18race . "', racejoueur7='" . $joueur19race . "', racejoueur8='" . $joueur20race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 5) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur21 . "', joueur2='" . $joueur22 . "', joueur3='" . $joueur23 . "', joueur4='" . $joueur24 . "', joueur5='" . $joueur25 . "', joueur6='" . $joueur26 . "', racejoueur1='" . $joueur21race . "', racejoueur2='" . $joueur22race . "', racejoueur3='" . $joueur23race . "', racejoueur4='" . $joueur24race . "', racejoueur5='" . $joueur25race . "', racejoueur6='" . $joueur26race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 6) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur27 . "', joueur2='" . $joueur28 . "', joueur3='" . $joueur29 . "', joueur4='" . $joueur30 . "', joueur5='" . $joueur31 . "', joueur6='" . $joueur32 . "', joueur7='" . $joueur33 . "', joueur8='" . $joueur34 . "', racejoueur1='" . $joueur27race . "', racejoueur2='" . $joueur28race . "', racejoueur3='" . $joueur29race . "', racejoueur4='" . $joueur30race . "', racejoueur5='" . $joueur31race . "', racejoueur6='" . $joueur32race . "', racejoueur7='" . $joueur33race . "', racejoueur8='" . $joueur34race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 7) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur35 . "', joueur2='" . $joueur36 . "', joueur3='" . $joueur37 . "', racejoueur1='" . $joueur35race . "', racejoueur2='" . $joueur36race . "', racejoueur3='" . $joueur37race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 8) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur38 . "', joueur2='" . $joueur39 . "', joueur3='" . $joueur40 . "', joueur4='" . $joueur41 . "', racejoueur1='" . $joueur38race . "', racejoueur2='" . $joueur39race . "', racejoueur3='" . $joueur40race . "', racejoueur4='" . $joueur41race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 9) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur42 . "', joueur2='" . $joueur43 . "', joueur3='" . $joueur44 . "', joueur4='" . $joueur45 . "', joueur5='" . $joueur46 . "', racejoueur1='" . $joueur42race . "', racejoueur2='" . $joueur43race . "', racejoueur3='" . $joueur44race . "', racejoueur4='" . $joueur45race . "', racejoueur5='" . $joueur46race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 10) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur47 . "', joueur2='" . $joueur48 . "', joueur3='" . $joueur49 . "', joueur4='" . $joueur50 . "', joueur5='" . $joueur51 . "', joueur6='" . $joueur52 . "', racejoueur1='" . $joueur47race . "', racejoueur2='" . $joueur48race . "', racejoueur3='" . $joueur49race . "', racejoueur4='" . $joueur50race . "', racejoueur5='" . $joueur51race . "', racejoueur6='" . $joueur52race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 11) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur53 . "', joueur2='" . $joueur54 . "', joueur3='" . $joueur55 . "', joueur4='" . $joueur56 . "', joueur5='" . $joueur57 . "', joueur6='" . $joueur58 . "', joueur7='" . $joueur59 . "', joueur8='" . $joueur60 . "', racejoueur1='" . $joueur53race . "', racejoueur2='" . $joueur54race . "', racejoueur3='" . $joueur55race . "', racejoueur4='" . $joueur56race . "', racejoueur5='" . $joueur57race . "', racejoueur6='" . $joueur58race . "', racejoueur7='" . $joueur59race . "', racejoueur8='" . $joueur60race . "' WHERE id=".$id_equipe);
			} else if($typeReplay == 12) {
				$add_equipe = mysql_query("UPDATE " . EQUIPESTABLE . " SET joueur1='" . $joueur61 . "', joueur2='" . $joueur62 . "', joueur3='" . $joueur63 . "', joueur4='" . $joueur64 . "', joueur5='" . $joueur65 . "', joueur6='" . $joueur66 . "', joueur7='" . $joueur67 . "', joueur8='" . $joueur68 . "', joueur9='" . $joueur69 . "', joueur10='" . $joueur70 . "', racejoueur1='" . $joueur61race . "', racejoueur2='" . $joueur62race . "', racejoueur3='" . $joueur63race . "', racejoueur4='" . $joueur64race . "', racejoueur5='" . $joueur65race . "', racejoueur6='" . $joueur66race . "', racejoueur7='" . $joueur67race . "', racejoueur8='" . $joueur68race . "', racejoueur9='" . $joueur69race . "', racejoueur10='" . $joueur70race . "' WHERE id=".$id_equipe);
			}
			$update = mysql_query("UPDATE " . REPLAYSTABLE . " SET titre='" . $titre . "', texte='" . $texte . "', evenement='" . $evenement . "', map='" . $map . "', duree='" . $duree . "', taille='" . $taille . "', version='" . $version . "', url='" . $url . "', type='" . $typeReplay . "', game='" . $game . "' WHERE id=".$id);

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _SUCCESS . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Replays&page=admin",2);
		}
	}
}



function del_ban($id)
{
	global $nuked;
	
	$del=mysql_query("DELETE FROM ".REPLAYSTABLE." WHERE id='" . $id . "'");
	
	$del_com = mysql_query("DELETE FROM " . COMMENT_TABLE . " WHERE im_id = '" . $id . "' AND module = 'Replays'");
    $del_vote = mysql_query("DELETE FROM " . VOTE_TABLE . " WHERE vid = '" . $id . "' AND module = 'Replays'");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _SUPSUCCESS . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Replays&page=admin",2);
}



function maps($param)
{
	global $nuked, $langname;
	
	menu($param);
	
	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		."<tr><td align=\"center\" width=\"10%\"><b>"._IDM."</b></td>\n"
		."<td align=\"center\" width=\"60%\"><b>"._MAP."</b></td>\n"
		."<td align=\"center\" width=\"30%\"><b>"._SUPP."</b></td></tr>";
	
	$sql=mysql_query("SELECT id, nom, image FROM ".MAPSTABLE."   ORDER BY id"); 
	$nb_maps = mysql_num_rows($sql);
	
	while (list($id, $nom, $image) = mysql_fetch_array($sql)) {
	
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
		
		$chemin_img = "modules/Replays/images/maps/".$image;
	
		echo "<tr style=\"background: " . $bg . ";\"><td align=\"center\">" . $id . "</td>\n"
			."<td align=\"center\"><span>" . $nom . "</span>&nbsp;<img src=\"modules/Replays/images/zoom_in.png\" style=\"cursor: pointer;vertical-align: middle;\" onmouseOver=\"AffBulle('Image', '<img src=\'" . $chemin_img . "\'/>', 100)\" onmouseOut=\"HideBulle()\" /></td>\n"
			."<td align=\"center\"><a href=\"javascript:supprimer_maps('".$id."','".$nom."');\" style=\"text-decoration:none\" title=\""._DELMAPS."&nbsp;" . $nom . "\"><img src=\"images/del.gif\" border=\"0\"></a>\n"
			."</td></tr>";
	}
	
	if($nb_maps == 0) {
		echo "<tr><td align=\"center\" colspan=\"8\">" . _NOMAPINDB . "</td></tr>\n";
	}
	echo "</table>\n";
	
	echo "<br/><hr style=\"border: 0;border-bottom: 1px dashed #FFF;width: 80%\"><br/><div style=\"text-align: center;\">\n"
		."<span id=\"add_map\" style=\"cursor:pointer;\"><b>"._ADDAMAPS."</b><img style=\"vertical-align:middle\" src=\"modules/Replays/images/updown.gif\"/></span></div><br/>\n"
		."<div style=\"display:none;margin-left: 15%;margin-right: 15%;padding: 15px;\" id=\"view_champ\">\n"
		."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
		."<form method=\"post\" action=\"index.php?file=Replays&page=admin&op=b_maps\">\n"
		."<tr><td width=\"36%\" align=\"right\"><b>"._NOMMAP.":&nbsp;&nbsp;</b></td><td  align=\"left\"><input type=\"text\" value=\"\" name=\"nom\" size=\"40\"></td></tr>\n";
		
		if ($handle = opendir('./modules/Replays/images/maps')) {
			
			$i = 0;
			
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && strpos($file, ".jpg") == true) {
					$tab_files[$i++] = $file;
				}
				elseif ($file != "." && $file != ".." && strpos($file, ".png") == true) {
					$tab_files[$i++] = $file;
				}
			}
			closedir($handle);
		}
		
		
	echo "<tr><td align=\"right\"><em>*</em>&nbsp;<b>"._MAPS.":&nbsp;&nbsp;</b></td><td  align=\"left\">\n";
	select_map_img($tab_files);
	echo "</td></tr>\n";
	echo "<tr><td align=\"right\"><b>". _PREVIEWMAP .":&nbsp;&nbsp;</b></td><td align=\"left\"><div id=\"img_map\" style=\"padding: 10px 0;width: 100px; height: 100px;\"></div>\n"
		."<tr><td align=\"center\" colspan=\"2\"><em>* Les images des maps sont à déposer dans le répertoire <br/> /modules/Replays/images/maps</em></td></tr>\n"
		."<tr><td>&nbsp;</td></tr>\n"
		."<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"" . _ADDMAP . "\" /></td></tr></form></table></div>";
	
	echo "<script language=\"javascript\">
		function supprimer_maps(id,nom)
		{
			if (confirm('"._DELETECLAN." '+nom+'   '))
			{
				document.location.href ='index.php?file=Replays&page=admin&op=del_map&id='+id;
			}
		}
		
		function changeImage() {
			var src = \"modules/Replays/images/maps/\" + $(\"#image :selected\").val();
			$(\"#img_map\").html(src ? \"<img width='100' height='100' src='\" + src + \"'>\" : \"\");
		}
		
		$(document).ready(function() {
			$(\"#image\").change(changeImage);
		
			$('#add_map').click(function() {
				if($('#view_champ').is(\":hidden\")) {
					$('#view_champ').slideDown('slow');
					changeImage();
				} else {
					$('#view_champ').slideUp('slow');
				}
			});
		});
	  </script>";
	  
	echo "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Replays&page=admin\"><b>"._BACK."</b></a> ]</div><br />";
}

function select_map_img($tab_files) {
	
	echo "<select id=\"image\" name=\"image\">";
	
	$taille = count($tab_files);
	
	for($i=0;$i<$taille;$i++){
		$selected = "";
		if($i == 0) {
			$selected = "selected = \"selected\"";
		}
		echo "<option $selected value=\"". $tab_files[$i] ."\">$tab_files[$i]</option>";
	}
	
	echo "</select>";
}

function del_map($id,$nom)
{
	global $nuked;
	
	$del=mysql_query("DELETE FROM ".MAPSTABLE." WHERE id='$id'");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _MAPSUPSUCCESS . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Replays&page=admin&op=maps",2);
}

function b_maps($nom, $image)
{
	global $nuked;

	$add=mysql_query("INSERT INTO ".MAPSTABLE."(nom, image) VALUES ('" . $nom . "','" . $image ."')");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _MAPSADDSUCCESS . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Replays&page=admin&op=maps",2);
}

function race($param)
{
	global $nuked, $langname;	 

	menu($param);

	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		."<tr><td align=\"center\" width=\"10%\"><b>"._IDR."</b></td>\n"
		."<td align=\"center\" width=\"60%\"><b>"._RACE."</b></td>\n"
		."<td align=\"center\" width=\"30%\"><b>"._SUPP."</b></td></tr>";
	
	$sql=mysql_query("SELECT id, nom, image FROM ".RACETABLE."   ORDER BY id");
	$nb_race = mysql_num_rows($sql);
	
	while (list($id, $nom, $image) = mysql_fetch_array($sql)) {
	
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
		
		$chemin_img = "modules/Replays/images/race/".$image;
	
		echo "<tr style=\"background: " . $bg . ";\"><td align=\"center\">". $id ."</td>\n"
			."<td align=\"center\"><span>" . $nom . "</span>&nbsp;<img src=\"modules/Replays/images/zoom_in.png\" style=\"cursor: pointer;vertical-align: middle;\" onmouseOver=\"AffBulle('Image', '<img src=\'" . $chemin_img . "\'/>', 75)\" onmouseOut=\"HideBulle()\" /></td>\n"
			."<td align=\"center\"><a href=\"javascript:supprimer_race('".$id."','".$nom."');\" style=\"text-decoration:none\" title=\"". _DELRACE ."&nbsp;". $nom ."\"><img src=\"images/del.gif\" border=\"0\"></a>\n"
			."</td></tr>";
	}
	
	if($nb_race == 0) {
		echo "<tr><td align=\"center\" colspan=\"8\">" . _NORACEINDB . "</td></tr>\n";
	}
	echo "</table>\n";
	
	echo "<br/><hr style=\"border: 0;border-bottom: 1px dashed #FFF;width: 80%\"><br/><div style=\"text-align: center;\">\n"
		."<span id=\"add_race\" style=\"cursor:pointer;\"><b>"._ADDARACE."</b><img style=\"vertical-align:middle\" src=\"modules/Replays/images/updown.gif\"/></span></div><br/>\n"
		."<div style=\"display:none;margin-left: 15%;margin-right: 15%;padding: 15px;\" id=\"view_champ\">\n"
		."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
		."<form method=\"post\" action=\"index.php?file=Replays&page=admin&op=s_race\">\n"
		."<tr><td width=\"36%\" align=\"right\"><b>"._RACE.":&nbsp;&nbsp;</b><td  align=\"left\"><input type=\"text\" value=\"\" name=\"nom\" size=\"40\"></td></tr>\n";
		
		if ($handle = opendir('./modules/Replays/images/race')) {
			
			$i = 0;
			
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && strpos($file, ".gif") == true) {
					$tab_files[$i++] = $file;
				}
				elseif ($file != "." && $file != ".." && strpos($file, ".png") == true) {
					$tab_files[$i++] = $file;
				}
			}
			closedir($handle);
		}
		
		
	echo "<tr><td align=\"right\"><em>*</em>&nbsp;<b>"._RACEIMG.":&nbsp;&nbsp;</b><td  align=\"left\">\n";
	select_race_img($tab_files);
	echo "</td></tr>\n";
	echo "<tr><td align=\"right\"><b>". _PREVIEWRACE .":&nbsp;&nbsp;</b><td align=\"left\"><div id=\"img_race\" style=\"padding: 10px 0;width: 42px; height: 42px;\"></div>\n"
		."<tr><td align=\"center\" colspan=\"2\"><em>* Les images des races sont à déposer dans le répertoire <br/> /modules/Replays/images/race</em></td></tr>\n"
		."<tr><td>&nbsp;</td></tr>\n"
		."<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"" . _ADRACE . "\" /></td></tr></form></table></div>";
	
	echo "<script language=\"javascript\">
		function supprimer_race(id, nom)
		{
			if (confirm('"._DELETERACE." '+nom+'   '))
			{
				document.location.href ='index.php?file=Replays&page=admin&op=de_race&id='+id;
			}
		}
		
		function changeImage() {
			var src = \"modules/Replays/images/race/\" + $(\"#race :selected\").val();
			$(\"#img_race\").html(src ? \"<img width='42' height='42' src='\" + src + \"'>\" : \"\");
		}
		
		$(document).ready(function() {
			$(\"#race\").change(changeImage);
		
			$('#add_race').click(function() {
				if($('#view_champ').is(\":hidden\")) {
					$('#view_champ').slideDown('slow');
					changeImage();
				} else {
					$('#view_champ').slideUp('slow');
				}
			});
		});
	  </script>";
	  
	echo "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Replays&page=admin\"><b>"._BACK."</b></a> ]</div><br />";
}

function select_race_img($tab_files) {
	echo "<select id=\"race\" name=\"race\">";
	
	$taille = count($tab_files);
	
	for($i=0;$i<$taille;$i++){
		$selected = "";
		if($i == 0) {
			$selected = "selected = \"selected\"";
		}
		echo "<option $selected value=\"". $tab_files[$i] ."\">$tab_files[$i]</option>";
	}
	
	echo "</select>";
}

function de_race($id,$race)
{
	global $nuked;
	
	$del=mysql_query("DELETE FROM ".RACETABLE." WHERE id='" . $id . "'");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _RACESUPSUCCESS . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Replays&page=admin&op=race",2);

}



function s_race($nom, $race)
{
	global $nuked;
	
	$add=mysql_query("INSERT INTO " . RACETABLE . "(nom, image) VALUES ('" . $nom . "','". $race . "')");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _RACEADDSUCCESS . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Replays&page=admin&op=race",2);

}



	    function main_config($param)
    {
        global $nuked, $language;
        
        	menu($param);
        
		$sql = mysql_query("SELECT 1vs1, 2vs2, 3vs3, 4vs4, 5vs5, 2vs2vs2, 2vs2vs2vs2, ffa3pl, ffa4pl, ffa5pl, ffa6pl, ffa8pl, max_replays FROM ". $nuked['prefix'] ."_replays_config");
		list($v11, $v22, $v33, $v44, $v55, $v222, $v2222, $ffa3pl, $ffa4pl, $ffa5pl, $ffa6pl, $ffa8pl, $maxreplay) = mysql_fetch_array($sql);
		
		if ($v11 == "on"){$checked_v11 = "checked=\"checked\"";}
		if ($v22 == "on"){$checked_v22= "checked=\"checked\"";}
		if ($v33 == "on"){$checked_v33 = "checked=\"checked\"";}
		if ($v44 == "on"){$checked_v44 = "checked=\"checked\"";} 
		if ($v55 == "on"){$checked_v55 = "checked=\"checked\"";}
		if ($v222 == "on"){$checked_v222 = "checked=\"checked\"";}
		if ($v2222 == "on"){$checked_v2222 = "checked=\"checked\"";}
		if ($ffa3pl == "on"){$checked_ffa3pl = "checked=\"checked\"";}
		if ($ffa4pl == "on"){$checked_ffa4pl = "checked=\"checked\"";}
		if ($ffa5pl == "on"){$checked_ffa5pl = "checked=\"checked\"";} 
		if ($ffa6pl == "on"){$checked_ffa6pl = "checked=\"checked\"";}
		if ($ffa8pl == "on"){$checked_ffa8pl = "checked=\"checked\"";}
		
		
		
	 echo	 "<form method=\"post\" name=\"selection\" action=\"index.php?file=Replays&page=admin&op=send_config\"\">\n"
		. "<table width=\"100\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		. "<tr><td width=\"20%\"><b>" . _TYPEREPLAY . "</b></td><td><b>" . _VALIDTYPE . "</b></td></tr>\n"
		. "<tr><td width=\"20%\"><b>" . _1v1 . " :</b></td><td width=\"80%\"><input type=\"checkbox\" name=\"1vs1\" value=\"on\" " . $checked_v11 . "></td></tr>\n"
		. "<tr><td><b>" . _2v2 . " :</b></td><td><input type=\"checkbox\" name=\"2vs2\" value=\"on\" " . $checked_v22 . "></td></tr>\n"
		. "<tr><td><b>" . _3v3 . " :</b></td><td><input type=\"checkbox\" name=\"3vs3\" value=\"on\" " . $checked_v33 . "></td></tr>\n"
		. "<tr><td><b>" . _4v4 . " :</b></td><td><input type=\"checkbox\" name=\"4vs4\" value=\"on\" " . $checked_v44 . "></td></tr>\n"
		. "<tr><td><b>" . _5v5 . " :</b></td><td><input type=\"checkbox\" name=\"5vs5\" value=\"on\" " . $checked_v55 . "></td></tr>\n"
		. "<tr><td><b>" . _2v2v2 . " :</b></td><td><input type=\"checkbox\" name=\"2vs2vs2\" value=\"on\" " . $checked_v222 . "></td></tr>\n"
		. "<tr><td><b>" . _2v2v2v2 . " :</b></td><td><input type=\"checkbox\" name=\"2vs2vs2vs2\" value=\"on\" " . $checked_v2222 . "></td></tr>\n"
		. "<tr><td><b>" . _FFA3PL . " :</b></td><td><input type=\"checkbox\" name=\"ffa3pl\" value=\"on\" " . $checked_ffa3pl . "></td></tr>\n"
		. "<tr><td><b>" . _FFA4PL . " :</b></td><td><input type=\"checkbox\" name=\"ffa4pl\" value=\"on\" " . $checked_ffa4pl . "></td></tr>\n"
		. "<tr><td><b>" . _FFA5PL . " :</b></td><td><input type=\"checkbox\" name=\"ffa5pl\" value=\"on\" " . $checked_ffa5pl . "></td></tr>\n"
		. "<tr><td><b>" . _FFA6PL . " :</b></td><td><input type=\"checkbox\" name=\"ffa6pl\" value=\"on\" " . $checked_ffa6pl . "></td></tr>\n"
		. "<tr><td><b>" . _FFA8PL . "</td><td><input type=\"checkbox\" name=\"ffa8pl\" value=\"on\" " . $checked_ffa8pl . "></td></tr>\n"
		. "<tr><td>" . _NUMBERREPLAYS . " :</td><td> <input type=\"text\" name=\"max_replays\" size=\"2\" value=\"" . $maxreplay . "\" /></td></td></tr>\n"
		. "<tr><td align=\"center\"><input type=\"submit\" value=\"" . _MODIFCONFIG . "\" /></td><td><input type=\"button\" value=\"" . _COTOUT . "\" onclick=\"toutcocher();\"> - \n"
        . "<input type=\"button\" value=\"" . _DECOTOUT . "\" onclick=\"toutdecocher();\"></td></tr>\n"
		. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Replays&page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
		
	 echo '<script language="javascript">
		  function toutcocher() 
		  {
		  for(i=0;i<document.selection.length;i++) 
		  { 
		  if(document.selection.elements[i].type=="checkbox") 
		  document.selection.elements[i].checked=true; 
		  } 
		  }
		  function toutdecocher()
		  {
		  for(i=0;i<document.selection.length;i++) 
		  {
		  if(document.selection.elements[i].type=="checkbox"); 
		  document.selection.elements[i].checked=false;; 
		  } 
		  }
		  </script>';

	}
	    function send_config($v11, $v22, $v33, $v44, $v55, $v222, $v2222, $ffa3pl, $ffa4pl, $ffa5pl, $ffa6pl, $ffa8pl, $maxreplay)
    {       
	    global $nuked, $user;
	    if ($v11 != 'on'){$v11 = "off";} if ($v22 != 'on'){$v22 = "off";} if ($v33 != 'on'){$v33 = "off";} if ($v44 != 'on'){$v44 = "off";} if ($v55 != 'on'){$v55 = "off";}
	    if ($v222 != 'on'){$v222 = "off";} if ($v2222 != 'on'){$v2222 = "off";} if ($ffa3pl != 'on'){$ffa3pl = "off";} if ($ffa4pl != 'on'){$ffa4pl = "off";} 
		if ($ffa5pl != 'on'){$ffa5pl = "off";} if ($ffa6pl != 'on'){$ffa6pl = "off";} if ($ffa8pl != 'on'){$ffa8pl = "off";}
     
	    $update_config = mysql_query("UPDATE ". $nuked['prefix'] ."_replays_config SET 1vs1 = '" . $v11 . "' , 2vs2 = '" . $v22 . "' , 3vs3 = '" . $v33 . "' , 4vs4 = '" . $v44 . "', 5vs5 = '" . $v55 . "' , 2vs2vs2 = '" . $v222 . "' , 2vs2vs2vs2 = '" . $v2222 . "' , ffa3pl = '" . $ffa3pl . "' , ffa4pl = '" . $ffa4pl . "' , ffa5pl = '" . $ffa5pl . "' , ffa6pl = '" . $ffa6pl . "' , ffa8pl = '" . $ffa8pl . "', max_replays = '" . $maxreplay . "' WHERE id='1'");
		
		$texteaction = "". _ACTIONMODIFCONFIG .".";
		$acdate = time();
		$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _CONFIGUPDATED . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Replays&page=admin", 2);
	}









switch($_REQUEST['op'])
{
	case "main":
	admintop();
	main();
	adminfoot();
	break;

	case "add_ban":
	admintop();
	add_ban($_REQUEST['titre'], $_REQUEST['map'], $_REQUEST['evenement'], $_REQUEST['duree'], $_REQUEST['taille'], $_REQUEST['version'], $_REQUEST['url'], $_REQUEST['copy'], $_REQUEST['ecrase_file'], $_REQUEST['typeReplay'], $_REQUEST['game'], $_REQUEST['joueur1'], $_REQUEST['joueur2'], $_REQUEST['joueur3'], $_REQUEST['joueur4'], $_REQUEST['joueur5'], $_REQUEST['joueur6'], $_REQUEST['joueur7'], $_REQUEST['joueur8'], $_REQUEST['joueur9'], $_REQUEST['joueur10'], $_REQUEST['joueur11'], $_REQUEST['joueur12'], $_REQUEST['joueur13'], $_REQUEST['joueur14'], $_REQUEST['joueur15'], $_REQUEST['joueur16'], $_REQUEST['joueur17'], $_REQUEST['joueur18'], $_REQUEST['joueur19'], $_REQUEST['joueur20'], $_REQUEST['joueur21'], $_REQUEST['joueur22'], $_REQUEST['joueur23'], $_REQUEST['joueur24'], $_REQUEST['joueur25'], $_REQUEST['joueur26'], $_REQUEST['joueur27'], $_REQUEST['joueur28'], $_REQUEST['joueur29'], $_REQUEST['joueur30'], $_REQUEST['joueur31'], $_REQUEST['joueur32'], $_REQUEST['joueur33'], $_REQUEST['joueur34'], $_REQUEST['joueur35'], $_REQUEST['joueur36'], $_REQUEST['joueur37'], $_REQUEST['joueur38'], $_REQUEST['joueur39'], $_REQUEST['joueur40'], $_REQUEST['joueur41'], $_REQUEST['joueur42'], $_REQUEST['joueur43'], $_REQUEST['joueur44'], $_REQUEST['joueur45'], $_REQUEST['joueur46'], $_REQUEST['joueur47'], $_REQUEST['joueur48'], $_REQUEST['joueur49'], $_REQUEST['joueur50'], $_REQUEST['joueur51'], $_REQUEST['joueur52'], $_REQUEST['joueur53'], $_REQUEST['joueur54'], $_REQUEST['joueur55'], $_REQUEST['joueur56'], $_REQUEST['joueur57'], $_REQUEST['joueur58'], $_REQUEST['joueur59'], $_REQUEST['joueur60'], $_REQUEST['joueur61'], $_REQUEST['joueur62'], $_REQUEST['joueur63'], $_REQUEST['joueur64'], $_REQUEST['joueur65'], $_REQUEST['joueur66'], $_REQUEST['joueur67'], $_REQUEST['joueur68'], $_REQUEST['joueur69'], $_REQUEST['joueur70'], $_REQUEST['joueur1race'], $_REQUEST['joueur2race'], $_REQUEST['joueur3race'], $_REQUEST['joueur4race'], $_REQUEST['joueur5race'], $_REQUEST['joueur6race'], $_REQUEST['joueur7race'], $_REQUEST['joueur8race'], $_REQUEST['joueur9race'], $_REQUEST['joueur10race'], $_REQUEST['joueur11race'], $_REQUEST['joueur12race'], $_REQUEST['joueur13race'], $_REQUEST['joueur14race'], $_REQUEST['joueur15race'], $_REQUEST['joueur16race'], $_REQUEST['joueur17race'], $_REQUEST['joueur18race'], $_REQUEST['joueur19race'], $_REQUEST['joueur20race'], $_REQUEST['joueur21race'], $_REQUEST['joueur22race'], $_REQUEST['joueur23race'], $_REQUEST['joueur24race'], $_REQUEST['joueur25race'], $_REQUEST['joueur26race'], $_REQUEST['joueur27race'], $_REQUEST['joueur28race'], $_REQUEST['joueur29race'], $_REQUEST['joueur30race'], $_REQUEST['joueur31race'], $_REQUEST['joueur32race'], $_REQUEST['joueur33race'], $_REQUEST['joueur34race'], $_REQUEST['joueur35race'], $_REQUEST['joueur36race'], $_REQUEST['joueur37race'], $_REQUEST['joueur38race'], $_REQUEST['joueur39race'], $_REQUEST['joueur40race'], $_REQUEST['joueur41race'], $_REQUEST['joueur42race'], $_REQUEST['joueur43race'], $_REQUEST['joueur44race'], $_REQUEST['joueur45race'], $_REQUEST['joueur46race'], $_REQUEST['joueur47race'], $_REQUEST['joueur48race'], $_REQUEST['joueur49race'], $_REQUEST['joueur50race'], $_REQUEST['joueur51race'], $_REQUEST['joueur52race'], $_REQUEST['joueur53race'], $_REQUEST['joueur54race'], $_REQUEST['joueur55race'], $_REQUEST['joueur56race'], $_REQUEST['joueur57race'], $_REQUEST['joueur58race'], $_REQUEST['joueur59race'], $_REQUEST['joueur60race'], $_REQUEST['joueur61race'], $_REQUEST['joueur62race'], $_REQUEST['joueur63race'], $_REQUEST['joueur64race'], $_REQUEST['joueur65race'], $_REQUEST['joueur66race'], $_REQUEST['joueur67race'], $_REQUEST['joueur68race'], $_REQUEST['joueur69race'], $_REQUEST['joueur70race'], $_REQUEST['texte']);
	adminfoot();
	break;

	case "add":
	admintop();
	add("add");
	adminfoot();
	break;

	case "b_maps":
	admintop();
	b_maps($_REQUEST['nom'], $_REQUEST['image']);
	adminfoot();
	break;

	case "maps":
	admintop();
	maps("maps");
	adminfoot();
	break;

	case "race":
	admintop();
	race("race");
	adminfoot();
	break;

	case "s_race":
	admintop();
	s_race($_REQUEST['nom'], $_REQUEST['race']);
	adminfoot();
	break;

	case "edit":
	admintop();
	edit($_REQUEST['id']);
	adminfoot();
	break;

	case "edit_ban":
	admintop();
	edit_ban($_REQUEST['id'], $_REQUEST['id_equipe'], $_REQUEST['titre'], $_REQUEST['map'], $_REQUEST['evenement'], $_REQUEST['duree'], $_REQUEST['taille'], $_REQUEST['version'], $_REQUEST['url'], $_REQUEST['copy'], $_REQUEST['ecrase_file'], $_REQUEST['typeReplay'], $_REQUEST['game'], $_REQUEST['joueur1'], $_REQUEST['joueur2'], $_REQUEST['joueur3'], $_REQUEST['joueur4'], $_REQUEST['joueur5'], $_REQUEST['joueur6'], $_REQUEST['joueur7'], $_REQUEST['joueur8'], $_REQUEST['joueur9'], $_REQUEST['joueur10'], $_REQUEST['joueur11'], $_REQUEST['joueur12'], $_REQUEST['joueur13'], $_REQUEST['joueur14'], $_REQUEST['joueur15'], $_REQUEST['joueur16'], $_REQUEST['joueur17'], $_REQUEST['joueur18'], $_REQUEST['joueur19'], $_REQUEST['joueur20'], $_REQUEST['joueur21'], $_REQUEST['joueur22'], $_REQUEST['joueur23'], $_REQUEST['joueur24'], $_REQUEST['joueur25'], $_REQUEST['joueur26'], $_REQUEST['joueur27'], $_REQUEST['joueur28'], $_REQUEST['joueur29'], $_REQUEST['joueur30'], $_REQUEST['joueur31'], $_REQUEST['joueur32'], $_REQUEST['joueur33'], $_REQUEST['joueur34'], $_REQUEST['joueur35'], $_REQUEST['joueur36'], $_REQUEST['joueur37'], $_REQUEST['joueur38'], $_REQUEST['joueur39'], $_REQUEST['joueur40'], $_REQUEST['joueur41'], $_REQUEST['joueur42'], $_REQUEST['joueur43'], $_REQUEST['joueur44'], $_REQUEST['joueur45'], $_REQUEST['joueur46'], $_REQUEST['joueur47'], $_REQUEST['joueur48'], $_REQUEST['joueur49'], $_REQUEST['joueur50'], $_REQUEST['joueur51'], $_REQUEST['joueur52'], $_REQUEST['joueur53'], $_REQUEST['joueur54'], $_REQUEST['joueur55'], $_REQUEST['joueur56'], $_REQUEST['joueur57'], $_REQUEST['joueur58'], $_REQUEST['joueur59'], $_REQUEST['joueur60'], $_REQUEST['joueur61'], $_REQUEST['joueur62'], $_REQUEST['joueur63'], $_REQUEST['joueur64'], $_REQUEST['joueur65'], $_REQUEST['joueur66'], $_REQUEST['joueur67'], $_REQUEST['joueur68'], $_REQUEST['joueur69'], $_REQUEST['joueur70'], $_REQUEST['joueur1race'], $_REQUEST['joueur2race'], $_REQUEST['joueur3race'], $_REQUEST['joueur4race'], $_REQUEST['joueur5race'], $_REQUEST['joueur6race'], $_REQUEST['joueur7race'], $_REQUEST['joueur8race'], $_REQUEST['joueur9race'], $_REQUEST['joueur10race'], $_REQUEST['joueur11race'], $_REQUEST['joueur12race'], $_REQUEST['joueur13race'], $_REQUEST['joueur14race'], $_REQUEST['joueur15race'], $_REQUEST['joueur16race'], $_REQUEST['joueur17race'], $_REQUEST['joueur18race'], $_REQUEST['joueur19race'], $_REQUEST['joueur20race'], $_REQUEST['joueur21race'], $_REQUEST['joueur22race'], $_REQUEST['joueur23race'], $_REQUEST['joueur24race'], $_REQUEST['joueur25race'], $_REQUEST['joueur26race'], $_REQUEST['joueur27race'], $_REQUEST['joueur28race'], $_REQUEST['joueur29race'], $_REQUEST['joueur30race'], $_REQUEST['joueur31race'], $_REQUEST['joueur32race'], $_REQUEST['joueur33race'], $_REQUEST['joueur34race'], $_REQUEST['joueur35race'], $_REQUEST['joueur36race'], $_REQUEST['joueur37race'], $_REQUEST['joueur38race'], $_REQUEST['joueur39race'], $_REQUEST['joueur40race'], $_REQUEST['joueur41race'], $_REQUEST['joueur42race'], $_REQUEST['joueur43race'], $_REQUEST['joueur44race'], $_REQUEST['joueur45race'], $_REQUEST['joueur46race'], $_REQUEST['joueur47race'], $_REQUEST['joueur48race'], $_REQUEST['joueur49race'], $_REQUEST['joueur50race'], $_REQUEST['joueur51race'], $_REQUEST['joueur52race'], $_REQUEST['joueur53race'], $_REQUEST['joueur54race'], $_REQUEST['joueur55race'], $_REQUEST['joueur56race'], $_REQUEST['joueur57race'], $_REQUEST['joueur58race'], $_REQUEST['joueur59race'], $_REQUEST['joueur60race'], $_REQUEST['joueur61race'], $_REQUEST['joueur62race'], $_REQUEST['joueur63race'], $_REQUEST['joueur64race'], $_REQUEST['joueur65race'], $_REQUEST['joueur66race'], $_REQUEST['joueur67race'], $_REQUEST['joueur68race'], $_REQUEST['joueur69race'], $_REQUEST['joueur70race'], $_REQUEST['texte']);
	adminfoot();
	break;

	case "del_ban":
	admintop();
	del_ban($_REQUEST['id'],$_REQUEST['titre']);
	adminfoot();
	break;

	case "del_map":
	admintop();
	del_map($_REQUEST['id'],$_REQUEST['titre']);
	adminfoot();
	break;

	case "de_race":
	admintop();
	de_race($_REQUEST['id'],$_REQUEST['race']);
	adminfoot();
	break;

  case "main_config":
  admintop();
  main_config("main_config");
 	adminfoot(); 
  break;
			
	case "send_config":
	admintop();
	send_config($_REQUEST['1vs1'], $_REQUEST['2vs2'], $_REQUEST['3vs3'], $_REQUEST['4vs4'], $_REQUEST['5vs5'], $_REQUEST['2vs2vs2'], $_REQUEST['2vs2vs2vs2'], $_REQUEST['ffa3pl'], $_REQUEST['ffa4pl'], $_REQUEST['ffa5pl'], $_REQUEST['ffa6pl'], $_REQUEST['ffa8pl'], $_REQUEST['max_replays']);
	adminfoot();
	break;

	default:
	admintop();
	main("replays");
	adminfoot();
	break;
}

	}else if($user[1] > 1){ echo"<br>"._NOENTRANCE."<br>";}
	else{echo "<br>"._ZONEADMIN."<br>";}

?>