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

	include 'modules/Admin/design.php';
    // inclusion du fichier langue    
    translate('modules/Video/lang/' . $language . '.lang.php');

	/* COnstante table */
	define('VIDEO_TABLE', $nuked['prefix'] . '_video');
	define('VIDEO_CAT_TABLE', $nuked['prefix'] . '_video_cat');
	define('COMMENT_MOD_TABLE', $nuked['prefix'] . '_comment_mod');
	$visiteur = $user ? $user[1] : 0;
	$ModName = basename(dirname(__FILE__));
	$level_admin = admin_mod($ModName);
	$nb_video = 1;
		$sql = mysql_query("SELECT id FROM ". VIDEO_TABLE )or die(mysql_error()."\n".$sql);
		$count = mysql_num_rows($sql);
		if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
		$start = $_REQUEST['p'] * $nb_video - $nb_video;
if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}
if ($visiteur == 9)
{


function accueil()
	{
		global $nuked ;
		$sql=mysql_query("SELECT COUNT(idcat) FROM ". VIDEO_CAT_TABLE ."" ); 
		list($idcat) = mysql_fetch_array($sql)or die(mysql_error()."\n".$sql);
		echo "<script type=\"text/javascript\">\n"
			. "<!--\n"
			. "\n"
			. "function del(idcat)\n"
			. "{\n"
			. "if (confirm('" . _DELETECAT . " '+idcat+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Video&page=admin&op=del&mid='+idcat;}\n"
			. "}\n"
			. "\n"
			. "// -->\n"
			. "</script>\n";
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Help.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "" . _CAT. " | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video\">" . _VID . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video_attente\">" . _ATTENTE . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "</div><br />\n";
		echo "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Video&amp;page=admin&amp;op=categories\"><b>" . _ADDCAT . "</b></a> ]</div>";
		echo "<br /><form method=\"post\" action=\"index.php?file=Video&amp;page=admin&amp;op=add_cat\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n";
		$sql = mysql_query("SELECT idcat, categorie, statuscat FROM " . VIDEO_CAT_TABLE . " ORDER BY idcat DESC");


		echo "<table style=\"margin-left: auto;margin-right: auto; text-align: center;\" width=\"90%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 5%;\"><b>N°</b></td>\n"
			. "<td style=\"width: 20%;\"><b>" . _NOMCAT . "</b></td>\n"
			. "<td style=\"width: 5%;\" align=\"center\"><b>" . _STATUS . "</b></td>\n"
			. "<td style=\"width: 5%;\"><b>"._DELETETUBE."</b></td>\n";
		if ($idcat == 0)
			{
		echo "<tr><td colspan=\"5\" align=\"center\">" . _NOCAT . "</td></tr>\n";
			}
		while (list($idcat, $categorie, $statuscat) = mysql_fetch_array($sql))
		{
		echo "<tr>\n"
			. "<td style=\"width: 10%;\">" . $idcat . "</td>\n"
			. "<td style=\"width: 10%;\">" . $categorie . "</td>\n";
			if ($statuscat == '1'){
			echo "<td style=\"width: 5%;\"><a href=\"index.php?file=Video&page=admin&op=statuscat&mid=" . $idcat . "\"><img style=\"border: 0;\" src=\"modules/Video/images/on.png\" /></a></td>\n";
	    }
		    if ($statuscat == '0')
		{
		echo "<td style=\"width: 5%;\"><a href=\"index.php?file=Video&page=admin&op=statuscat&mid=" . $idcat . "\"><img style=\"border: 0;\" src=\"modules/Video/images/off.png\" /></a></td>\n";
		}
		echo "<td style=\"width: 5%;\"><a href=\"#\" onclick=\"javascript:del('".$idcat."');\"><img style=\"border: 0;\" src=\"modules/Video/images/del.gif\" alt=\"\" title=\""._DELETECAT."\" /></a></td></tr>\n";
		}
		echo "</table><br />\n";
		echo "</table><br>\n";
		echo"<div style=\"text-align: center;\">[ <a href=\"index.php?file=Video&page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
	}



function categories()
	{
		global $nuked ;
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Help.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "" . _CAT. " | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video\">" . _VID . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video_attente\">" . _ATTENTE . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | "
			. "<a href=\"index.php?file=Video&page=admin&op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "</div><br />\n";
		echo "<br /><form method=\"post\" action=\"index.php?file=Video&amp;page=admin&amp;op=add_cat\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
			. "<tr><td align=\"center\"><big><b>"._ADDCAT."</b></big></td></tr>\n"
			. "<tr><td><b>" . _NOMCAT . " : </b><input type=\"text\" name=\"categorie\" size=\"30\" /></td></tr>\n"
			. "<tr><td align=\"center\"><br /><input type=\"submit\" class=\"bouton\" value=\""._ADD."\" /></td></tr></table></form><br />\n"
			. "<br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Video&page=admin\"><b>" . _BACK . "</b></a> ]</div><br /><br />\n";
	}


function add_cat($categorie)
    {
		global $nuked, $user, $categorie;
		$categories = $_POST["categorie"];
		$sql  = "SELECT COUNT(*) AS nbr FROM " . VIDEO_CAT_TABLE . " WHERE categorie = '".$_POST['categorie']."'";
		$res  = mysql_query($sql);
		$alors  = mysql_fetch_assoc($res);
		if(isset($_POST['categorie']))
		{
		if(!($alors['nbr'] == 0))
		{
		echo  "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. _CATEXISTE."\n"
			. "</div>\n"
			. "</div>\n";
			redirect("index.php?file=Video&page=admin&op=categories", 3);
		}
		elseif ($_POST["categorie"] == "")
		{
		echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. _CATVIDE."\n"
			. "</div>\n"
			. "</div>\n";
			redirect("index.php?file=Video&page=admin&op=categories", 3);
		}
		else
		{
		// Action
		$texteaction = "". _ACTIONADDCAT .": ".$categories." ". _ACTIONADDBDD ." ";
		$acdate = time();
		$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		//Fin action
		$add = mysql_query("INSERT INTO " . VIDEO_CAT_TABLE . " ( `idcat` , `categorie`, `statuscat` ) VALUES ( '' , '" . $categories . "', '1' )");
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. _CATAJOUTE."\n"
			. "</div>\n"
			. "</div>\n";
			redirect("index.php?file=Video&page=admin", 3);
		}
	}
	}


	function del_cat($mid, $idcat)
	{
		global $nuked, $user;
		// Action
		$texteaction = "". _ACTIONDELCAT ."";
		$acdate = time();
		$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		//Fin action
		$sql = mysql_query("DELETE FROM " . VIDEO_CAT_TABLE . " WHERE idcat = '" . $mid . "'");
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. _DELETECATOK . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin", 2);
	}



function video()
	{
		global $nuked, $user;
		$nb_video = $nuked['max_video'];
		if ($_REQUEST['letter'] == "Autres"){
            $and = "AND titre NOT REGEXP '^[a-zA-Z].'";
        } 
        else if ($_REQUEST['letter'] != "" && preg_match("`^[A-Z]+$`", $_REQUEST['letter'])){
            $and = "AND titre LIKE '" . $_REQUEST['letter'] . "%'";
        } 
        else{
            $and = "";
        }
		$sql=mysql_query("SELECT COUNT(id) FROM ".VIDEO_TABLE."" ); 
		list($id) = mysql_fetch_array($sql)or die(mysql_error()."\n".$sql);
		$count = mysql_num_rows($sql);
		if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_video - $nb_video;
		echo "<script type=\"text/javascript\">\n"
			. "<!--\n"
			. "\n"
			. "function del_video(id)\n"
			. "{\n"
			. "if (confirm('" . _DELVID . " '+id+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Video&page=admin&op=del_video&mid='+id;}\n"
			. "}\n"
			. "\n"
			. "// -->\n"
			. "</script>\n";
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Banlist.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<b><a href=\"index.php?file=Video&amp;page=admin\">" . _CAT . "</a></b> | "
			. "" . _VID . " | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video_attente\">" . _ATTENTE . "</a></b> | "
			. "<td><b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | </td>"
			. "<b><a href=\"index.php?file=Video&page=admin&op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Video&amp;page=admin&amp;op=add_video\"><b>" . _ADDVID . "</b></a> ]</div><br>\n"
			. "</div><br />\n";
		echo "<table style=\"margin-left: auto;margin-right: auto; text-align: center;\" width=\"90%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 5%;\"><b>N°</b></td>\n"
			. "<td style=\"width: 15%;\"><b>" . _TITRETUBE . "</b></td>\n"
			. "<td style=\"width: 25%;\"><b>"._DESCTUBE."</b></td>\n"
			. "<td style=\"width: 5%;\"><b>"._IMGTUBE."</b></td>\n"
			. "<td style=\"width: 10%;\"><b>"._LIENTUBE."</b></td>\n"
			. "<td style=\"width: 5%;\" align=\"center\"><b>" . _STATUS . "</b></td>\n"
			. "<td style=\"width: 5%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
			. "<td style=\"width: 5%;\"><b>"._DELETETUBE."</b></td>\n";
		if ($id == 0)
			{
		echo "<tr><td colspan=\"5\" align=\"center\">" . _NOVID . "</td></tr>\n";
			}
		$sql=mysql_query("SELECT COUNT(id) FROM ".VIDEO_TABLE." WHERE status = '1'" ); 
		list($id) = mysql_fetch_array($sql)or die(mysql_error()."\n".$sql);
		$count = mysql_num_rows($sql);
		if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_video - $nb_video;
		$sql = mysql_query("SELECT id, titre, description, image, status, lien FROM " . VIDEO_TABLE . "  WHERE status = '1' ORDER BY id DESC LIMIT " . $start . ", " . $nb_video)or die(mysql_error()."\n".$sql);
		while (list($id, $titre, $description, $image, $status, $lien) = mysql_fetch_array($sql))
		{
		$titre = printSecuTags($titre);
		$description = printSecuTags($description);
		echo "<tr>\n"
			. "<td style=\"width: 5%;\">" . $id . "</td>\n"
			. "<td style=\"width: 15%;\">" . $titre . "</td>\n"
			. "<td style=\"width: 25%;\">" .substr($description, 0, 200). "</td>\n"
			. "<td style=\"width: 5%;\"><br><img style=\"border: 0; max-width: 50px; max-height: 50px; \" src=\"" . $image . "\" /></a></td>\n"
			. "<td style=\"width: 10%;\">" . $lien . "</td>\n";
		if ($status == '1'){
			echo "<td style=\"width: 5%;\"><a href=\"index.php?file=Video&page=admin&op=status&mid=" . $id . "\"><img style=\"border: 0;\" src=\"modules/Video/images/on.png\" /></a></td>\n";
			}
		if ($status == '0')
			{
		echo "<td style=\"width: 5%;\"><a href=\"index.php?file=Video&page=admin&op=status&mid=" . $id . "\"><img style=\"border: 0;\" src=\"modules/Video/images/off.png\" /></a></td>\n";
			}
			echo "<td style=\"width: 5%;\" align=\"center\"><a href=\"index.php?file=Video&page=admin&op=edit_video&amp;id=" . $id . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISTEAM . "\" /></a></td>\n"
			. "<td style=\"width: 5%;\"><a href=\"#\" onclick=\"javascript:del_video('".$id."');\"><img style=\"border: 0;\" src=\"modules/Video/images/del.gif\" alt=\"\" title=\""._DELETE."\" /></a></td></tr>\n";
			}	
		echo "</table><br />\n";
		if ($count > $nb_video)
		{
		$url_video = "index.php?file=Video&op=categorie&idcat=".$idcat."" . $_REQUEST['letter'];
            number($count, $nb_video, $url_video);
        }
		echo"<div style=\"text-align: center;\">[ <a href=\"index.php?file=Video&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
	}

function video_attente()
	{
		global $nuked, $user;
		$nb_video = $nuked['max_video'];
		$sql=mysql_query("SELECT COUNT(id) FROM ".VIDEO_TABLE."" ); 
		list($id) = mysql_fetch_array($sql)or die(mysql_error()."\n".$sql);
		$count = mysql_num_rows($sql);
		if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_video - $nb_video;
		echo "<script type=\"text/javascript\">\n"
			. "<!--\n"
			. "\n"
			. "function del_video(id)\n"
			. "{\n"
			. "if (confirm('" . _DELETEN . " '+id+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Video&page=admin&op=del_video&mid='+id;}\n"
			. "}\n"
			. "\n"
			. "// -->\n"
			. "</script>\n";
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Banlist.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<b><a href=\"index.php?file=Video&amp;page=admin\">" . _CAT . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video\">" . _VID . "</a></b> | "
			. "" . _ATTENTE . " | "
			. "<td><b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | </td>"
			. "<b><a href=\"index.php?file=Video&page=admin&op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Video&amp;page=admin&amp;op=add_video\"><b>" . _ADDVID . "</b></a> ]</div><br>\n"
			. "</div><br />\n";
		echo "<table style=\"margin-left: auto;margin-right: auto; text-align: center;\" width=\"90%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 5%;\"><b>N°</b></td>\n"
			. "<td style=\"width: 15%;\"><b>" . _TITRETUBE . "</b></td>\n"
			. "<td style=\"width: 25%;\"><b>"._DESCTUBE."</b></td>\n"
			. "<td style=\"width: 5%;\"><b>"._IMGTUBE."</b></td>\n"
			. "<td style=\"width: 10%;\"><b>"._LIENTUBE."</b></td>\n"
			. "<td style=\"width: 5%;\" align=\"center\"><b>" . _STATUS . "</b></td>\n"
			. "<td style=\"width: 5%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
			. "<td style=\"width: 5%;\"><b>"._DELETETUBE."</b></td>\n";
		if ($id == 0)
			{
		echo "<tr><td colspan=\"5\" align=\"center\">" . _NOVID . "</td></tr>\n";
			}
		$sql = mysql_query("SELECT id, titre, description, image, status, lien FROM " . VIDEO_TABLE . "  WHERE status = '0' ORDER BY id DESC LIMIT " . $start . ", " . $nb_video)or die(mysql_error()."\n".$sql);
		while (list($id, $titre, $description, $image, $status, $lien) = mysql_fetch_array($sql))
		{
		$titre = printSecuTags($titre);
		$description = printSecuTags($description);
		echo "<tr>\n"
			. "<td style=\"width: 5%;\">" . $id . "</td>\n"
			. "<td style=\"width: 15%;\">" . $titre . "</td>\n"
			. "<td style=\"width: 25%;\">" .substr($description, 0, 200). "</td>\n"
			. "<td style=\"width: 5%;\"><br><img style=\"border: 0; max-width: 50px; max-height: 50px; \" src=\"" . $image . "\" /></a></td>\n"
			. "<td style=\"width: 10%;\">" . $lien . "</td>\n";
		if ($status == "1"){
			echo "<td style=\"width: 5%;\"><a href=\"index.php?file=Video&page=admin&op=status&mid=" . $id . "\"><img style=\"border: 0;\" src=\"modules/Video/images/on.png\" /></a></td>\n";
			}
		if ($status == "0")
			{
			echo "<td style=\"width: 5%;\"><a href=\"index.php?file=Video&page=admin&op=status&mid=" . $id . "\"><img style=\"border: 0;\" src=\"modules/Video/images/off.png\" /></a></td>\n";
			}
			echo "<td style=\"width: 5%;\" align=\"center\"><a href=\"index.php?file=Video&page=admin&op=edit_video&amp;id=" . $id . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISTEAM . "\" /></a></td>\n"
			. "<td style=\"width: 5%;\"><a href=\"#\" onclick=\"javascript:del_video('".$id."');\"><img style=\"border: 0;\" src=\"modules/Video/images/del.gif\" alt=\"\" title=\""._DELETE."\" /></a></td></tr>\n";
			}
		echo "</table><br />\n";
		echo"<div style=\"text-align: center;\">[ <a href=\"index.php?file=Video&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
	}



function add_video()
	{
		global $nuked ;
		
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Help.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<b><a href=\"index.php?file=Video&amp;page=admin\">" . _CAT . "</a></b> | "
			. "" . _VID . " | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video_attente\">" . _ATTENTE . "</a></b> | "
			. "<td><b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | </td>"
			. "<b><a href=\"index.php?file=Video&page=admin&op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "</div><br />\n";
		echo "<br /><form method=\"post\" action=\"index.php?file=Video&amp;page=admin&amp;op=send_video\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
			. "<tr><td align=\"center\"><big><b>"._ADDVID."</b></big></td></tr>\n"
			. "<tr><td><b>" . _URLVID . " : </b><input type=\"text\" name=\"lien\" size=\"30\" /></td></tr>\n"
			. "<tr><td align=\"center\"><br /><input type=\"submit\" class=\"bouton\" value=\""._ADD."\" /></td></tr></table></form><br />\n"
			. "<br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Video&page=admin\"><b>" . _BACK . "</b></a> ]</div><br /><br />\n";
	}


function status($id, $status)
	{
		global $nuked ;
		$id = printSecuTags($id);
		$sql = mysql_query("SELECT status FROM " . VIDEO_TABLE . "  WHERE id = '".$id."'")or die(mysql_error()."\n".$sql);
		while (list($status) = @mysql_fetch_array($sql))
		if ($status == "1")
		{
		$sql = mysql_query("UPDATE " . VIDEO_TABLE . " SET status = '0' WHERE id = '" . $id . "'");
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _VIDOFF . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=video_attente", 2);
		}
		else
		{
		$sql = mysql_query("UPDATE " . VIDEO_TABLE . " SET status = '1' WHERE id = '" . $id . "'");
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _VIDON . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=video", 2);
		}
	}


function statuscat($idcat)
	{
		global $nuked ;
		$idcat = printSecuTags($idcat);
		$sql = mysql_query("SELECT statuscat FROM " . VIDEO_CAT_TABLE . "  WHERE idcat = '".$idcat."'")or die(mysql_error()."\n".$sql);
		while (list($statuscat) = @mysql_fetch_array($sql))
		if ($statuscat == "1")
		{
		$sql = mysql_query("UPDATE " . VIDEO_CAT_TABLE . " SET statuscat = '0' WHERE idcat = '" . $idcat . "'");
		$sql = mysql_query("UPDATE " . VIDEO_TABLE . " SET status = '0' WHERE cat_id = '" . $idcat . "'");
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _CATOFF . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin", 2);
		}
		else
		{
		$sql = mysql_query("UPDATE " . VIDEO_CAT_TABLE . " SET statuscat = '1' WHERE idcat = '" . $idcat . "'");
		$sql = mysql_query("UPDATE " . VIDEO_TABLE . " SET status = '1' WHERE cat_id = '" . $idcat . "'");
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _CATON . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin", 2);
		}
	}

function send_video($lien)
	{
		global $nuked, $user, $lien;
		$lien = ($_POST["lien"]);
		$cat_id = printSecuTags($cat_id);
		$tubeinfo = getVideoInfo($lien);
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Help.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<b><a href=\"index.php?file=Video&amp;page=admin\">" . _CAT . "</a></b> | "
			. "" . _VID . " | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video_attente\">" . _ATTENTE . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | "
			. "<a href=\"index.php?file=Video&page=admin&op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "</div><br />\n";
		echo "<br /><form method=\"post\" action=\"index.php?file=Video&amp;page=admin&amp;op=send_video_ok\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
			. "</td></tr>\n"
			. "<table style=\"margin-left: auto;margin-right: auto; text-align: center;\" width=\"90%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 20%;\"><b>" . _TITRETUBE . "</b></td>\n"
			. "<td style=\"width: 20%;\"><b>"._DESCTUBE."</b></td>\n"
			. "<td style=\"width: 10%;\"><b>"._IMGTUBE."</b></td>\n"
			. "<td style=\"width: 10%;\"><b>"._CAT."</b></td>\n"
			. "<td style=\"width: 5%;\"><b>"._LIENTUBE."</b></td>\n"
			. "<td style=\"width: 5%;\"><b>&nbsp;</b></td></tr>\n";
		echo "<tr>\n"
			. "<td style=\"width: 20%;\">" .utf8_decode($tubeinfo["titre"]). "</td>\n"
			. "<td style=\"width: 20%;\">" .utf8_decode(substr($tubeinfo["description"], 0, 200)). "</td>\n"
			. "<td style=\"width: 10%;\"><img style=\"border: 0; max-width: 50px; max-height: 50px;\" src=\"" .utf8_decode($tubeinfo["img"]). "\" alt=\"\" title=\"\" /></a></td>\n"
			. "<td style=\"width: 10%;\"><SELECT id=\"idcat\" name=\"idcat\">\n";
		$sql = mysql_query('SELECT idcat, categorie FROM ' . VIDEO_CAT_TABLE . ' GROUP BY idcat');
		while (list($idcat, $categorie) = mysql_fetch_array($sql)){
		$idcat = printSecuTags($idcat);
		$categorie = printSecuTags($categorie);
		echo "<option value=\"" . $idcat . "\">" . $categorie . "</option>\n";
		}
		echo "<td style=\"width: 10%;\">" . $lien . "</td>\n"
			. "<td style=\"width: 5%;\"></td></tr>\n"
			. "</table><br />\n"
			. "<tr><td align=\"center\"><br /><center><input type=\"submit\" class=\"bouton\" value=\""._ADD."\" /></td></tr></table></form><br />\n"
			. "<input type=\"HIDDEN\" name=\"titre\" value=\"" .utf8_decode($tubeinfo["titre"]). "\"> \n"
			. "<input type=\"HIDDEN\" name=\"description\" value=\"" .utf8_decode($tubeinfo["description"]). "\"> \n"
			. "<input type=\"HIDDEN\" name=\"img\" value=\"" .utf8_decode($tubeinfo["img"]). "\"> \n"
			. "<input type=\"HIDDEN\" name=\"type\" value=\"" .utf8_decode($tubeinfo["type"]). "\"> \n"
			. "<input type=\"HIDDEN\" name=\"lien\" value=\"" .$lien. "\"> \n"
			. "<br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Video&page=admin\"><b>" . _BACK . "</b></a> ]</div><br /><br />\n";
	}


function send_video_ok($lien)
	{
		global $nuked, $user, $lien;
		$lien = ($_POST["lien"]);
		$type = ($_POST["type"]);
		$idcat = ($_POST["idcat"]);
		$titre = ($_POST["titre"]);
		$description = ($_POST["description"]);
		$img = ($_POST["img"]);
		$sql  = "SELECT COUNT(*) AS nbr FROM " . VIDEO_TABLE . " WHERE lien = '".$_POST['lien']."'";
		$res  = mysql_query($sql);
		$alors  = mysql_fetch_assoc($res);
		if(!($alors['nbr'] == 0))
		{
		echo  "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. _VIDEXISTE."\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=video", 5);
		}
		elseif ($_POST["lien"] == "")
		{
		echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. _NOLIEN."\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=video", 5);
		}
		elseif($type == "")
		{
		echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. _BADVIDEO."\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=video", 5);
		}
		else
		{
		$sql = mysql_query("INSERT INTO " . VIDEO_TABLE . " ( `id` , `cat_id`, `type`, `titre`, `description`, `image`, `status`, `lien` ) VALUES ( '' , '".$idcat."' , '" . $type . "', '" . $titre . "' , '" . $description . "', '" . $img . "', '1', '" . $lien . "')");
		
		// Action
		$texteaction = "". _ACTIONADDVIDEO .": ".$titre."";
		$acdate = time();
		$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		//Fin action
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _VIDADD . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=video", 2);
	}
	
}

function getVideoInfo($lien){
		global $bgcolor1, $bgcolor2, $bgcolor3, $theme, $nuked, $idcat;
		//Détermine le "type" de vidéo : 
		if(eregi("youtube",$lien))			$type="youtube";
		else if(eregi("dailymotion",$lien))	$type="dailymotion";
		else if(eregi("vimeo",$lien))		$type="vimeo";
		else return false;
		//Déterme  l'"ID" de la vidéo :
		if($type=="youtube"){
			$debut_id = explode("v=",$lien,2);
			$id_et_fin_url = explode("&",$debut_id[1],2);
			$id = $id_et_fin_url[0];
		}
		else if($type=="dailymotion"){
			$debut_id = explode("/video/",$lien,2);
			$id_et_fin_url = explode("_",$debut_id[1],2);
			$id = $id_et_fin_url[0];
		}
		else if($type=="vimeo"){
			$l_id= eregi("([0-9]+)$",$lien,$lid);
			$id = $lid[0];
		}
		//Analyse et stockage des informations de la vidéo
		if($type=="youtube"){
			$xml = @file_get_contents("https://gdata.youtube.com/feeds/api/videos/".$id);
			//titre
			preg_match('#<title(.*?)>(.*)<\/title>#is',$xml,$resultTitre);
			$titre = $resultTitre[count($resultTitre)-1];
			//description
			preg_match('#<content(.*?)>(.*)<\/content>#is',$xml,$resultDescription);
			$description = $resultDescription[count($resultDescription)-1];
			//Image
			$img = "https://img.youtube.com/vi/".$id."/1.jpg";
			//Code HTML
			$code = '<object type="application/x-shockwave-flash" width="100%" height="350" data="https://www.youtube.com/v/'.$id.'&amp;hl=fr">
        <param name="movie" value="https://www.youtube.com/v/'.$id.'&amp;hl=fr" />
        <param name="wmode" value="transparent" /></object>';
		}
		else if ($type=="dailymotion"){
			$tags = json_decode(file_get_contents("https://www.dailymotion.com/services/oembed?format=json&url=https://www.dailymotion.com/embed/video/".$id.""), true);
			//titre
			$titre = ($tags["title"]);
			$tags2 = get_meta_tags("https://www.dailymotion.com/video/".$id);
			//description
			$description = ($tags2['description']);
			//image 
			$img = "https://www.dailymotion.com/thumbnail/160x120/video/".$id;
			// code HTML
			$code = '<object type="application/x-shockwave-flash" width="100%" height="350" data="https://www.dailymotion.com/swf/'.$id.'&amp;v3=1&amp;related=1">
        <param name="movie" value="https://www.dailymotion.com/swf/'.$id.'&amp;v3=1&amp;related=1" />
        <param name="wmode" value="transparent" /></object>';
		}
		else if ($type=="vimeo"){
			$xml_string = @file_get_contents("https://vimeo.com/api/v2/video/".$id.".xml");
			//titre
			$xml_title_debut = explode("<tags>",$xml_string,2);
			$xml_title_fin = explode("</tags>",$xml_title_debut[1],2);
			$titre = $xml_title_fin[0];
			//description
			$xml_description_debut = explode("<description>",$xml_string,2);
			$xml_description_fin = explode("</description>",$xml_description_debut[1],2);
			$description = $xml_description_fin[0];
			//image
			$xml_image_debut = explode("<thumbnail_small>",$xml_string,2);
			$xml_image_fin = explode("</thumbnail_small>",$xml_image_debut[1],2);
			$img = $xml_image_fin[0];
			//code HTML
			$xml_code = @file_get_contents("https://vimeo.com/api/oembed.xml?url=https%3A//vimeo.com/".$id);
			$xml_code_debut = explode("<html>",$xml_code,2);
			$xml_code_fin = explode("</html>",$xml_code_debut[1],2);
			$code = '<object type="application/x-shockwave-flash" width="100%" height="350" data="https://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com&amp;color=00adef&amp;fullscreen=1">
        <param name="movie" value="https://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com&amp;color=00adef&amp;fullscreen=1" />
        <param name="wmode" value="transparent" /></object>';
		}

		return array("id"=>$id,"type"=>$type,"titre"=>$titre,"description"=>$description,"img"=>$img,"code"=>$code, "lien"=>$lien);
	}


function edit_video($id)
	{
		global $nuked, $language, $user;
		$sql = mysql_query("SELECT id, cat_id, type, titre, description, image, lien FROM " . VIDEO_TABLE . " WHERE id = '" . $id . "'");
		list($id, $cat_id, $type, $titre, $description, $image, $lien) = mysql_fetch_array($sql);
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Help.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "" . _CAT. " | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video\">" . _VID . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video_attente\">" . _ATTENTE . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "</div><br />\n"
			. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Video&page=admin&op=update_video&id=" . $id . "\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr><td><b>" . _TITRETUBE . " :</b></td><td><input type=\"text\" name=\"titre\" size=\"100\" maxlength=\"200\" value=\"" . $titre . "\" /> *</td></tr>\n"
			. "<td><b>"._CAT."</b></td>\n"
			. "<td><SELECT id=\"idcat\" name=\"idcat\">\n";
		$sql = mysql_query('SELECT idcat, categorie FROM ' . VIDEO_CAT_TABLE . ' GROUP BY idcat');
		while (list($idcat, $categorie) = mysql_fetch_array($sql)){
		$idcat = printSecuTags($idcat);
		$categorie = printSecuTags($categorie);
		echo "<option value=\"" . $idcat . "\">" . $categorie . "</option>\n";
		}
		echo "<tr><td><b>" . _DESCTUBE . " : </b></td><td><textarea class=\"editor\" name=\"description\" cols=\"65\" rows=\"15\"\">" . $description . "</textarea></td></tr>\n"
			. "<tr><td><b>" . _IMGTUBE . " : </b></td><td><input type=\"text\" name=\"image\" size=\"30\" maxlength=\"30\" readonly=\"readonly\" value=\"" . $image . "\" /></td></tr>\n"
			."<tr><td><b>" . _LIENTUBE . " : </b></td><td><input type=\"text\" name=\"lien\" size=\"30\" maxlength=\"30\" readonly=\"readonly\" value=\"" . $lien . "\" /></td></tr>\n"
			. "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"" . _MODIFTUBE . "\" /></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Video&page=admin&op=video\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
	}



function update_video($id, $idcat, $titre, $description, $image, $lien)
	{
		global $nuked, $user;
		if ($titre == "")
		{
		echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. _NOTITRE."\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=edit_video&id=".$id."", 5);
		}
		elseif ($description == "")
		{
		echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. _NODESC."\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=edit_video&id=".$id."", 5);
		}
		else
		{
		$sql = mysql_query("UPDATE " . VIDEO_TABLE . " SET cat_id = '" . $idcat . "', titre = '" . $titre . "', cat_id = '" . $idcat . "', description = '" . $description . "', image = '" . $image . "', lien = '" . $lien . "' WHERE id = '" . $id . "'");
		// Action
		$texteaction = "". _ACTIONMODIFTUBE .": ".$titre."";
		$acdate = time();
		$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		//Fin action
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _VIDMODIF . "\n"
			."</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=video", 2);
		}
	}



	function del_video($mid, $id)
	{
		global $nuked, $user;
		$titre = ($_POST["titre"]);
		$sql = mysql_query("DELETE FROM " . VIDEO_TABLE . " WHERE id = '" . $mid . "'");
		$sql = mysql_query("DELETE FROM " . COMMENT_TABLE . " WHERE im_id = '" . $mid . "'");
		// Action
		$texteaction = "". _ACTIONDELTUBE .": ".$titre."";
		$acdate = time();
		$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		//Fin action
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _TUBEDELETE . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=video", 2);
	}



	function del($mid, $id)
	{
		global $nuked, $user;
		$titre = ($_POST["titre"]);
		// Action
		$texteaction = "". _ACTIONDELTUBE .":".$titre."";
		$acdate = time();
		$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		//Fin action
		$sql = mysql_query("DELETE FROM " . VIDEO_CAT_TABLE . " WHERE idcat = '" . $mid . "'");
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. _DELETECATOK . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin", 2);
	}



function recherche()
	{
		global $nuked, $user;
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Help.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "" . _CAT. " | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video\">" . _VID . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video_attente\">" . _ATTENTE . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
		. "</div><br />\n";
		if(isset($_POST['requete']) && $_POST['requete'] != NULL)
		{
		$requete = htmlspecialchars($_POST['requete']);
		$sql = mysql_query("SELECT * FROM " . VIDEO_TABLE . " WHERE titre LIKE '%$requete%' OR description LIKE '%$requete%'  GROUP BY id LIMIT 10") or die (mysql_error());
		list($id, $cat_id, $type, $titre, $description, $image, $lien) = mysql_fetch_array($sql);{
		$id = mysql_real_escape_string($id);
		$titre = mysql_real_escape_string($titre);
		$lien = mysql_real_escape_string($lien);
		if ($titre == "")
		{
		echo "<div>\n"
			. _NORESULT . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=recherche", 3);
		}
		elseif ($titre != "") 
		{
		echo "<table style=\"margin-left: auto;margin-right: auto; text-align: center;\" width=\"90%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 5%;\"><b>N°</b></td>\n"
			. "<td style=\"width: 20%;\"><b>" . _TITRETUBE . "</b></td>\n"
			. "<td style=\"width: 20%;\"><b>"._DESCTUBE."</b></td>\n"
			. "<td style=\"width: 10%;\"><b>"._IMGTUBE."</b></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
			. "<td style=\"width: 5%;\"><b>"._DELETETUBE."</b></td>\n"
			. "<td style=\"width: 5%;\"><b>&nbsp;</b></td></tr>\n";
		echo "<tr>\n";
		echo "<td style=\"width: 5%;\">" . $id . "</td>\n"
			. "<td style=\"width: 20%;\">" . $titre . "</td>\n"
			. "<td style=\"width: 20%;\">" .utf8_decode(substr($description, 0, 200)). "</td>\n"
			. "<td style=\"width: 10%;\"><img style=\"border: 0; max-width: 50px; max-height: 50px;\" src=\"" . $image . "\" /></a></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><a href=\"index.php?file=Video&page=admin&op=edit_video&amp;id=" . $id . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISTEAM . "\" /></a></td>\n"
			. "<td style=\"width: 5%;\"><a href=\"#\" onclick=\"javascript:del_video('".$id."');\"><img style=\"border: 0;\" src=\"modules/Video/images/del.gif\" alt=\"\" title=\""._DELETE."\" /></a></td></tr>\n";
			}
		echo "</table><br />\n";
		}
		}
		else
		{
		echo "<br /><form method=\"post\" action=\"index.php?file=Video&page=admin&op=recherche\"\">\n"
			. "<table style=\"margin-left: auto;margin-left: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
			. "<tr><td align=\"center\"><big><b>" . _RECHTUBE . "</b></big></td></tr>\n"
			. "<tr><td><b>" . _TITRETUBE . " :</b><form action=\"index.php?file=Video&page=admin&op=recherche\" method=\"Post\">
			. <b><input type=\"text\" name=\"requete\" size=\"100\">
			. <b><input type=\"submit\" value=\""._RECH."\">
			. </form></td></tr>\n";
		}
	}



function main_pref()
	{
		global $nuked, $language;
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINTUBE. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Help.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<b><a href=\"index.php?file=Video&amp;page=admin\">" . _CAT . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video\">" . _VID . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=video_attente\">" . _ATTENTE . "</a></b> | "
			. "<b><a href=\"index.php?file=Video&page=admin&op=recherche\">" . _RECH . "</a></b> | "
			. "</b>" . _PREFS . "</b></div><br />\n"
			. "<form method=\"post\" action=\"index.php?file=Video&amp;page=admin&amp;op=change_pref\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n"
			. "<tr><td colspan=\"2\" align=\"center\"><big>" . _PREFS . "</big></td></tr>\n";
			$sql = mysql_query("SELECT bid, titre FROM " . BLOCK_TABLE . " WHERE module = 'video'") or die (mysql_error());
		    list($bid, $titre) = mysql_fetch_array($sql);
			$bid = mysql_real_escape_string($bid);
			$titre = mysql_real_escape_string($titre);
			echo "<tr><td>" . _MODIFNOMBLOCK . " :</td><td><input type=\"text\" name=\"nomblock\" size=\"12\" value=\"" . $titre . "\" /></td></tr>\n"
			. "<tr><td>" . _NBVID . " :</td><td><input type=\"text\" name=\"max_video\" size=\"2\" value=\"" . $nuked['max_video'] . "\" /></td></tr>\n"
			. "<tr><td>" . _CATIDEM . " :</td><td>\n";
			if( $nuked['cat_idem'] == 0){
			echo "<select name=\"cat_idem\" />n"
			. "<option value=\"0\">"._DESACTIVER . "</option>\n"
			. "<option value=\"1\">". _ACTIVER ."</option></select></td></tr>\n";
			}
			else
			{
			echo "<select name=\"cat_idem\" />n"
			. "<option value=\"1\">". _ACTIVER. "</option>\n"
			. "<option value=\"0\">"._DESACTIVER ."</option></select></td></tr>\n";
			}
			echo "<tr><td>" . _COMMENTAIRES . " :</td><td>\n";
			$sql = mysql_query("SELECT module, active FROM " . $nuked['prefix'] . "_comment_mod WHERE module = 'video'");
			while(list($module, $active) = mysql_fetch_array($sql)){
			if ( $active == 0){
			echo "<select name=\"video\" />n"
			. "<option value=\"0\">"._DESACTIVER . "</option>\n"
			. "<option value=\"1\">". _ACTIVER ."</option></select></td></tr>\n";
			}
			else
			{
			echo "<select name=\"video\" />n"
			. "<option value=\"1\">". _ACTIVER. "</option>\n"
			. "<option value=\"0\">"._DESACTIVER ."</option></select></td></tr>\n";
			}
			}
			echo "</table>\n"
			. "<div style=\"text-align: center;\"><br /><input type=\"submit\" name=\"Submit\" value=\"" . _SEND . "\" /></div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Video&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
	} 



function change_pref($max_video, $cat_idem, $video, $nomblock){
		global $nuked, $user;
		$upd = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $max_video . "' WHERE name = 'max_video'");
		$upd = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $cat_idem . "' WHERE name = 'cat_idem'");
		$upd = mysql_query("UPDATE " . COMMENT_MOD_TABLE . " SET active = '" . $video . "' WHERE module = 'video'");
		$upd = mysql_query("UPDATE " . BLOCK_TABLE . " SET titre = '" . $nomblock . "' WHERE module = 'Video'");
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _PREFUPDATED . "\n"
			. "</div>\n"
			. "</div>\n";
		redirect("index.php?file=Video&page=admin&op=main_pref", 2);
	}



switch($_REQUEST['op'])
	{
		case "del":
			admintop();
			del($_REQUEST['mid'], $_REQUEST['id']);
			adminfoot();
		break;

		case "del_video":
			admintop();
			del_video($_REQUEST['mid'], $_REQUEST['id']);
			adminfoot();
		break;

		case "status":
			admintop();
			status($_REQUEST['mid'], $_REQUEST['id'], $_REQUEST['status']);
			adminfoot();
		break;
		
		case "statuscat":
			admintop();
			statuscat($_REQUEST['mid'], $_REQUEST['idcat'], $_REQUEST['statuscat']);
			adminfoot();
		break;

		case "categories":
			admintop();
			categories();
			adminfoot();
		break;

		case "add_cat":
			admintop();
			add_cat($_REQUEST['categorie']);
			adminfoot();
		break;

		case "edit_video":
			admintop();
			edit_video($_REQUEST['id']);
			adminfoot();
		break;

		case "update_video":
			admintop();
			update_video($_REQUEST['id'], $_REQUEST['idcat'], $_REQUEST['titre'], $_REQUEST['description'], $_REQUEST['image'], $_REQUEST['lien']);
			adminfoot();
		break;

		case "video":
			admintop();
			video($_REQUEST['cat_id'], $_REQUEST['lien']);
			adminfoot();
		break;

		case "video_attente":
			admintop();
			video_attente();
			adminfoot();
		break;

		case "send_video":
			admintop();
			send_video($_REQUEST['cat_id'], $_REQUEST['lien']);
			adminfoot();
		break;

		case "send_video_ok":
			admintop();
			send_video_ok($_REQUEST['description'], $_REQUEST['lien'], $_REQUEST['titre'], $_REQUEST['img'], $_REQUEST['idcat']);
			adminfoot();
		break;

		case "add_video":
			admintop();
			add_video();
			adminfoot();
		break;

		case "main_pref":
			admintop(); 
			main_pref();
			adminfoot();
		break;

		case "change_pref":
			admintop(); 
			change_pref($_REQUEST['max_video'], $_REQUEST['cat_idem'], $_REQUEST['video'], $_REQUEST['nomblock']);
			adminfoot();
		break;

		case "recherche":
			admintop();
			recherche();
			adminfoot();
		break;

		default:
			admintop();
			accueil();
			adminfoot();
		break;
    }

} else if ($level_admin == -1) {
?>
	<div class="notification error png_bg">
	<div>
	<br /><br /><div style="text-align: center;"><?php echo _MODULEOFF; ?><br /><br /><a href="javascript:history.back()"><b><?php echo _BACK; ?></b></a></div><br /><br />
	</div>
	</div>
<?php
} else if ($visiteur > 1) {
?>
	<div class="notification error png_bg">
	<div>
	<br /><br /><div style="text-align: center;"><?php echo _NOENTRANCE; ?><br /><br /><a href="javascript:history.back()"><b><?php echo _BACK; ?></b></a></div><br /><br />
	</div>
	</div>
<?php
} else {
?>
	<div class="notification error png_bg">
	<div>
	<br /><br /><div style="text-align: center;"><?php echo _ZONEADMIN; ?><br /><br /><a href="javascript:history.back()"><b><?php echo _BACK; ?></b></a></div><br /><br />
	</div>
	</div>
<?php
}
?>