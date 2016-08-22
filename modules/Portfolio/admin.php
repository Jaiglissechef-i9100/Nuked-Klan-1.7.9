<?php
//-------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify   //
//  it under the terms of the GNU General Public License as published by   //
//  the Free Software Foundation; either version 2 of the License.         //
//-------------------------------------------------------------------------//

 if (!defined("INDEX_CHECK")) {
         die ("<center>You cannot open this page directly</center>");
    }

global $nuked, $user, $language;
translate("modules/Portfolio/lang/".$language.".lang.php");
include("modules/Admin/design.php");

if (!$user)
{
    $visiteur = 0;
} 
else
{
    $visiteur = $user[1];
} 
$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1)
{

admintop();

function main()
{
global $nuked, $language, $bgcolor3;
	
        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>Administration - Portfolio</h3>\n"
        . "<div style=\"text-align:right;\"><img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></div></div>\n"
		. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
		. "<b>"._CREA."</b> |\n" 
		. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=add\" style=\"text-decoration:none\"><b>"._ADDCREA."</b></a> |\n" 
		. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=cat\" style=\"text-decoration:none\"><b>"._GESCAT."</b></a> |\n" 
		. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=pref\" style=\"text-decoration:none\"><b>"._PREF."</b></a></div><br />\n"	
        . "<table width=\"100%\" border=\"\" cellspacing=\"0\" cellpadding=\"3\" align=\"center\"><tr>\n" 
	    . "<td style=\"text-align: center;\" width=\"10%\"><b>"._ID."</b></td>\n"
	    . "<td style=\"text-align: center;\" width=\"15%\"><b>"._DATE."</b></td>\n"
	    . "<td style=\"text-align: center;\" width=\"20%\"><b>"._CAT."</b></td>\n"
	    . "<td style=\"text-align: center;\" width=\"25%\"><b>"._TITLE."</b></td>\n"
	    . "<td style=\"text-align: center;\" width=\"15%\"><b>"._EDIT."</b></td>\n"
	    . "<td style=\"text-align: center;\" width=\"15%\"><b>"._DEL."</b></td></tr>";

       $sql=mysql_query("SELECT id,titre,cat,date,description,url_site,url_apercu,url_vignette FROM ".$nuked[prefix]."_portfolio_crea ORDER BY date");
       $nb_crea = mysql_num_rows($sql);
       while (list($id,$titre,$cat,$date,$description,$url_site,$url_apercu,$url_vignette) = mysql_fetch_array($sql)){

       $jour = date("d",$date);
       $mois = date("m",$date);
       $annee = date("Y",$date);

       echo" <tr><td style=\"text-align: center;\"width=\"5%\">".$id."</td>\n"
	   . "<td style=\"text-align: center;\" width=\"15%\">".$jour."/".$mois."/".$annee."</td>\n"
	   . "<td style=\"text-align: center;\"width=\"20%\">".$cat."</td>\n"
	   . "<td style=\"text-align: center;\"width=\"45%\">".$titre."</td>\n"
	   . "<td style=\"text-align: center;\"width=\"5%\"><a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=edit&amp;id=".$id."\" style=\"text-decoration:none\" title=\""._EDITTHISCREA."\"><img src=\"images/edit.gif\" border=\"0\" alt=\"\" /></a></td>\n"
	   . "<td style=\"text-align: center;\"width=\"10%\"><a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=do_del&amp;id=".$id."\" style=\"text-decoration:none\" title=\""._DELTHISCREA."\"><img src=\"images/del.gif\" border=\"0\" alt=\"\" /></a></td></tr>";
}
       echo" </td></tr></table><br /><center><a href=\"index.php?file=Admin\">[ <b>"._BACK."</b> ]</a></center><br /></div></div>";
}

function add()
{
global $nuked, $language;

$listcat = "";
$reqcat=mysql_query("SELECT id, nom FROM ".$nuked[prefix]."_portfolio_cat");
while(list($id, $nom)=mysql_fetch_array($reqcat))
	{
		$listcat .= "<option value=\"".$nom."\">".$nom."</option>";
	}
    echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>Ajouter une création</h3>\n"
    . "<div style=\"text-align:right;\"><img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></div></div>\n"
	. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=main\" style=\"text-decoration:none\"><b>"._CREA."</b></a> |\n" 
	. "<b>"._ADDCREA."</b> |\n" 
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=cat\" style=\"text-decoration:none\"><b>"._GESCAT."</b></a> |\n" 
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=pref\" style=\"text-decoration:none\"><b>"._PREF."</b></a><br /><br />\n"
    . " <b><font color=\"red\">Important : Avant d'ajouter une création ne pas oublier de créer une catégorie.</font></b></div><br />\n" 
	. "<form method=\"post\" enctype=\"multipart/form-data\" name=\"formulaire\" action=\"index.php?file=Portfolio&amp;page=admin&amp;op=do_add\">"
	. "<table width=\"60%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\"><tr>"
 	. "<td width=\"100%\"><b>"._TITLE." :</b>&nbsp;<input type=\"text\" name=\"crea_titre\" maxlength=\"100\" size=\"44\" value=\"\" />"
    . "</td></tr><tr><td align=\"left\"><b>"._CAT." :</b> <select name=\"crea_cat\">".$listcat."</select>"
    . "</td></tr><tr><td align=\"left\"><b>"._DESCRIPTION." :</b></td></tr><tr><td align=\"center\">"
    . "</td></tr><tr><td align=\"left\"><textarea name=\"crea_description\" cols=\"60\" rows=\"10\"></textarea>"
    . "</td></tr><tr><td align=\"center\"><p>"
    . "</td></tr><tr><td align=\"left\"><b>"._URLSITE." :</b> <input type=\"text\" name=\"url_site\" size=\"54\" value=\"\" />"
    . "</td></tr><tr><td align=\"left\"><b>"._URLAPERCU." :</b> <input type=\"text\" name=\"url\" size=\"55\" value=\"http://\" />"
    . "</td></tr><tr><td align=\"left\"><img src=\"images/puces/tree-L.gif\" alt=\"\" /> <b>"._UPLOAD." :</b> <input type=\"file\" name=\"copy\" />&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_file\" value=\"1\" /> Ecraser"
    . "</td></tr><tr><td align=\"left\"><b>"._URLVIGNETTE." :</b> <input type=\"text\" name=\"screen\" size=\"42\" value=\"http://\" />"
    . "</td></tr><tr><td align=\"left\"><img src=\"images/puces/tree-L.gif\" alt=\"\" /> <b>"._UPLOAD." :</b> <input type=\"file\" name=\"screen2\" />&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_screen\" value=\"1\" /> Ecraser"
    . "</td></tr><tr><td align=\"center\"><br /><input type=\"submit\" value=\""._ADD."\" /></td></tr></form></table><br /><br />"
    . "<center><a href=\"index.php?file=Portfolio&amp;page=admin\"><b>"._BACK."</b></a><br></center><br /></div></div>";
}

function do_add($crea_titre,$date,$crea_cat,$crea_description,$url_site,$url,$screen,$screen2,$copy,$ecrase_file,$ecrase_screen)
{
global $nuked, $user;
    $crea_description = secu_html(html_entity_decode($crea_description));
    $crea_description = mysql_real_escape_string(stripslashes($crea_description));
    $crea_titre = mysql_real_escape_string(stripslashes($crea_titre));
    $date = time();
    if ($url == "http://") $url = "";
    if ($screen == "http://") $screen = "";
    $racine_up = "upload/Portfolio/";
      $racine_down = "";
        if ($_FILES['copy']['name'] != "")
        {
            $filename = $_FILES['copy']['name'];
            $filesize = $_FILES['copy']['size'];
            $taille = $filesize / 1024;
            $taille = (round($taille * 100)) / 100;
            $url_file = $racine_up . $filename;
            if (!is_file($url_file) || $ecrase_file == 1)
            {
                 if (!preg_match("`\.php`i", $filename) && !preg_match("`\.htm`i", $filename) && !preg_match("`\.[a-z]htm`i", $filename) && $filename != ".htaccess")
                {
		              move_uploaded_file($_FILES['copy']['tmp_name'], $url_file) or die ("Upload file failed !!!");
                    @chmod ($url_file, 0644);
                }
                else
                {
                    echo "<br /><br /><div style=\"text-align: center;\">Unauthorized file !!!</div><br /><br />";
                    redirect("index.php?file=Portfolio&page=admin&op=add", 2);
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
            if ($url == "") $url = $url_full;
            else if ($url2 == "") $url2 = $url_full;
            else if ($url3 == "") $url3 = $url_full;
            else $url = $url_full;
        }

        if ($_FILES['screen2']['name'] != "")

        {
            $screenname = $_FILES['screen2']['name'];
	        $ext = pathinfo($_FILES['screen2']['name'], PATHINFO_EXTENSION);
            $filename2 = str_replace($ext, "", $screenname);
            $url_screen = $racine_up . $filename2 . $ext;
            if (!is_file($url_screen) || $ecrase_screen == 1)
            {
                if (!preg_match("`\.php`i", $screenname) && !preg_match("`\.htm`i", $screenname) && !preg_match("`\.[a-z]htm`i", $screenname) && (preg_match("`jpg`i", $ext) || preg_match("`jpeg`i", $ext) || preg_match("`gif`i", $ext) || preg_match("`png`i", $ext)))
                {
                    move_uploaded_file($_FILES['screen2']['tmp_name'], $url_screen) or die ("Upload screen failed !!!");
                    @chmod ($url_screen, 0644);
		}
		else
		{			echo "<div class=\"notification error png_bg\">\n"
					. "<div>\n"
                    . "<div style=\"text-align: center;\">Pas d'image !!!</div><br />\n"
					."</div></div>\n";
                    redirect("index.php?file=Portfolio&page=admin&op=add", 2);
                    adminfoot();
                    footer();
                    exit();
		}

            }
            else
            {
                $deja_screen = 1;

            }

            $url_full_screen = $racine_down . $url_screen;
            $screen = $url_full_screen;
        }

        if ($deja_file == 1 || $deja_screen == 1)
        {
			echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n";
            if ($deja_file == 1) echo _DEJAFILE;
            if ($deja_screen == 1) echo "&nbsp;" . _DEJASCREEN;
            echo "<br />" . _REPLACEIT . "<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
			echo "</div>\n"
			. "</div>\n";
        }
        else if ($url != "" && $crea_titre != "" && $crea_cat != "")
        {
	$sql=mysql_query("INSERT INTO ".$nuked[prefix]."_portfolio_crea VALUES('','".$crea_titre."','".$crea_description."','".$crea_cat."','".$date."','".$url_site."','".$url."','".$screen."')");
	echo "<div class=\"notification success png_bg\">\n"
	. "<div>\n"
	. "" . _CREAADD . "\n"
	. "</div>\n"
	. "</div>\n";
}
else
{
	echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
    . "<div style=\"text-align: center;\">"._CREANOTADD."</div><br />\n"
	."</div></div>\n";
}
redirect("index.php?file=Portfolio&page=admin",2);

}

function edit($id)
{
global $nuked, $language;

$crea=mysql_query("SELECT id,titre,description,cat,url_site,url_apercu,url_vignette FROM ".$nuked[prefix]."_portfolio_crea WHERE id = '".$id."'");
list($id,$titre,$description,$cat,$url_site,$url_apercu,$url_vignette)=mysql_fetch_array($crea);                          
$listcat = "";
$reqcat=mysql_query("SELECT nom FROM ".$nuked[prefix]."_portfolio_cat");
while(list($nom)=mysql_fetch_array($reqcat))
	{
		if($nom == $cat)
		{
			$listcat .= "<option value=\"".$nom."\" SELECTED>".$nom."</option>";
		}
		else
		{
			$listcat .= "<option value=\"".$nom."\">".$nom."</option>";
		}
	}

echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
. "<div class=\"content-box-header\"><h3>Edition d'une création</h3>\n"
. "<div style=\"text-align:right;\"><img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></div></div>\n"
. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=main\" style=\"text-decoration:none\"><b>"._CREA."</b></a> |\n" 
. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=add\" style=\"text-decoration:none\"><b>"._ADDCREA."</b></a> |\n" 
. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=cat\" style=\"text-decoration:none\"><b>"._GESCAT."</b></a> |\n" 
. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=pref\" style=\"text-decoration:none\"><b>"._PREF."</b></a></div><br />\n"
. "<form method=\"post\" enctype=\"multipart/form-data\" name=\"formulaire\" action=\"index.php?file=Portfolio&amp;page=admin&amp;op=do_edit\">\n"
. "<table width=\"60%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\"><tr>\n"
. "<td width=\"100%\"><b>"._TITLE." :</b>&nbsp;<input type=\"hidden\" name=\"id\" value=\"".$id."\"><input type=\"text\" name=\"crea_titre\" maxlength=\"100\" size=\"44\" value=\"".$titre."\" />\n"
. "</td></tr><tr><td align=\"left\"><b>"._CAT." :</b> <select name=\"crea_cat\">".$listcat."</select>\n"
. "</td></tr><tr><td align=\"left\"><b>"._DESCRIPTION." :</b></td></tr><tr><td align=\"center\">\n"
. "</td></tr><tr><td align=\"left\"><textarea id=\"com_texte\" name=\"crea_description\" cols=\"70\" rows=\"10\" ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">".$description."</textarea>\n"
. "</td></tr><tr><td align=\"center\"><p>\n"
. "</td></tr><tr><td align=\"left\"><b>"._URLSITE." :</b> <input type=\"text\" name=\"url_site\" size=\"54\" value=\"".$url_site."\" />\n"
. "</td></tr><tr><td align=\"left\"><b>"._URLAPERCU." :</b> <input type=\"text\" name=\"url\" size=\"55\" value=\"" . $url_apercu . "\" />"
    . "</td></tr><tr><td align=\"left\"><img src=\"images/puces/tree-L.gif\" alt=\"\" /> <b>"._UPLOAD." :</b> <input type=\"file\" name=\"copy\" />&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_file\" value=\"1\" /> Ecraser"
    . "</td></tr><tr><td align=\"left\"><b>"._URLVIGNETTE." :</b> <input type=\"text\" name=\"screen\" size=\"42\" value=\"" . $url_vignette . "\" />"
    . "</td></tr><tr><td align=\"left\"><img src=\"images/puces/tree-L.gif\" alt=\"\" /> <b>"._UPLOAD." :</b> <input type=\"file\" name=\"screen2\" />&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_screen\" value=\"1\" /> Ecraser"
    . "</td></tr><tr><td align=\"center\"><br /><input type=\"submit\" value=\""._ADD."\" /></td></tr></form><br /><br />"
. "<center><a href=\"index.php?file=Portfolio&amp;page=admin\"><b>"._BACK."</b></a><br><br></center></table></div></div><br />";
}

function do_edit($crea_titre,$crea_cat,$crea_description,$url_site,$url,$screen,$screen2,$copy,$ecrase_file,$ecrase_screen)
{
global $nuked, $user;

$id = $_POST['id'];
$crea_description = secu_html(html_entity_decode($crea_description));
$crea_description = mysql_real_escape_string(stripslashes($crea_description));
$crea_titre = mysql_real_escape_string(stripslashes($crea_titre));
$date = time();
    if ($url == "http://") $url = "";
    if ($screen == "http://") $screen = "";
    $racine_up = "upload/Portfolio/";
        $racine_down = "";
        if ($_FILES['copy']['name'] != "")
         {
            $filename = $_FILES['copy']['name'];
            $filesize = $_FILES['copy']['size'];
            $taille = $filesize / 1024;
            $taille = (round($taille * 100)) / 100;
            $url_file = $racine_up . $filename;
            if (!is_file($url_file) || $ecrase_file == 1)
            {
                 if (!preg_match("`\.php`i", $filename) && !preg_match("`\.htm`i", $filename) && !preg_match("`\.[a-z]htm`i", $filename) && $filename != ".htaccess")
                {
		              move_uploaded_file($_FILES['copy']['tmp_name'], $url_file) or die ("Upload file failed !!!");
                    @chmod ($url_file, 0644);
                }
                else
                {
                    echo "<br /><br /><div style=\"text-align: center;\">Unauthorized file !!!</div><br /><br />";
                    redirect("index.php?file=Portfolio&page=admin&op=add", 2);
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
            if ($url == "") $url = $url_full;
            else if ($url2 == "") $url2 = $url_full;
            else if ($url3 == "") $url3 = $url_full;
            else $url = $url_full;
        }
        if ($_FILES['screen2']['name'] != "")
        {
            $screenname = $_FILES['screen2']['name'];
	        $ext = pathinfo($_FILES['screen2']['name'], PATHINFO_EXTENSION);
            $filename2 = str_replace($ext, "", $screenname);
            $url_screen = $racine_up . $filename2 . $ext;
            if (!is_file($url_screen) || $ecrase_screen == 1)
            {
                if (!preg_match("`\.php`i", $screenname) && !preg_match("`\.htm`i", $screenname) && !preg_match("`\.[a-z]htm`i", $screenname) && (preg_match("`jpg`i", $ext) || preg_match("`jpeg`i", $ext) || preg_match("`gif`i", $ext) || preg_match("`png`i", $ext)))
                {
                    move_uploaded_file($_FILES['screen2']['tmp_name'], $url_screen) or die ("Upload screen failed !!!");
                    @chmod ($url_screen, 0644);
		}
		else
		{			echo "<div class=\"notification error png_bg\">\n"
					. "<div>\n"
                    . "<div style=\"text-align: center;\">No image file !!!</div><br />\n"
					."</div></div>\n";
                    redirect("index.php?file=Portfolio&page=admin&op=add", 2);
                    adminfoot();
                    footer();
                    exit();
		}
            }
            else
            {
                $deja_screen = 1;
            }
            $url_full_screen = $racine_down . $url_screen;
            $screen = $url_full_screen;
        }
        if ($deja_file == 1 || $deja_screen == 1)
        {
			echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n";
            if ($deja_file == 1) echo _DEJAFILE;
            if ($deja_screen == 1) echo "&nbsp;" . _DEJASCREEN;
            echo "<br />" . _REPLACEIT . "<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
			echo "</div>\n"
			. "</div>\n";
        }
        else if ($url != "" && $crea_titre != "")
        {
	$sql=mysql_query("UPDATE ".$nuked[prefix]."_portfolio_crea SET titre='".$crea_titre."',description='".$crea_description."',cat='".$crea_cat."',url_site='".$url_site."',url_apercu='".$url."',url_vignette='".$screen."' WHERE id='".$id."'");
	echo "<div class=\"notification success png_bg\">\n"
	. "<div>\n"
	. "" . _CREAEDIT . "\n"
	. "</div>\n"
	. "</div>\n";
}
else
{
	echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
    . "<div style=\"text-align: center;\">"._CREANOTEDIT."</div><br />\n"
	."</div></div>\n";
}
redirect("index.php?file=Portfolio&page=admin",2);
}

function do_del($id)
{

global  $nuked;

$del = mysql_query("DELETE FROM ".$nuked[prefix]."_portfolio_crea WHERE id='".$id."'");
$del_com = mysql_query("DELETE FROM " . COMMENT_TABLE . "  WHERE im_id ='".$id."' AND module='Portfolio'");
echo "<div class=\"notification success png_bg\">\n"
. "<div>\n"
. "" . _CREADEL . "\n"
. "</div>\n"
. "</div>\n";
redirect("index.php?file=Portfolio&page=admin",2);
}

function cat()
{

global $nuked, $language, $bgcolor3;

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>Administration des Catègories</h3>\n"
        . "<div style=\"text-align:right;\"><img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></div></div>\n"
		. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
		. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=main\" style=\"text-decoration:none\"><b>"._CREA."</b></a> |\n" 
		. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=add\" style=\"text-decoration:none\"><b>"._ADDCREA."</b></a> |\n" 
		. "<b>"._GESCAT."</b> |\n" 
		. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=pref\" style=\"text-decoration:none\"><b>"._PREF."</b></a></div><br />\n" 
        . "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" align=\"center\"><tr>\n"
		. "<td style=\"text-align: center;\" width=\"25%\"><b>"._ID."</b></td>\n"  
	    . "<td style=\"text-align: center;\" width=\"25%\"><b>"._CAT."</b></td>\n" 
	    . "<td style=\"text-align: center;\" width=\"25%\"><b>"._EDIT."</b></td>\n" 
	    . "<td style=\"text-align: center;\" width=\"25%\"><b>"._DEL."</b></td></tr>";

$sql=mysql_query("SELECT id,nom FROM ".$nuked[prefix]."_portfolio_cat ORDER BY nom");
while (list($id,$nom) = mysql_fetch_array($sql)){

       echo"<tr><td style=\"text-align: center;\" width=\"25%\">".$id."</td>\n" 
	   . "<td style=\"text-align: center;\" width=\"25%\">".$nom."</td>\n" 
	   . "<td style=\"text-align: center;\" width=\"25%\"><a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=edit_cat&amp;id=".$id."\" style=\"text-decoration:none\" title=\""._EDITTHISCAT."\"><img src=\"images/edit.gif\" border=\"0\" alt=\"\" /></a></td>\n" 
	   . "<td style=\"text-align: center;\" width=\"25%\"><a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=do_del_cat&amp;id=".$id."\" style=\"text-decoration:none\" title=\""._DELTHISCAT."\"><img src=\"images/del.gif\" border=\"0\" alt=\"\" /></a></td></tr>";
}

       echo"</td></tr></table><br /><center><a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=add_cat\">[ <b>"._ADDCAT."</b> ]</a><br />";

       echo"<br /><a href=\"index.php?file=Admin\">[ <b>"._BACK."</b> ]</a></center><br /></div></div>";
}

function add_cat()
{

global $nuked, $language, $bgcolor3;

	echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>Ajouter une Catègorie</h3>\n"
    . "<div style=\"text-align:right;\"><img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></div></div>\n"
	. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
    . "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=main\" style=\"text-decoration:none\"><b>"._CREA."</b></a> |\n" 
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=add\" style=\"text-decoration:none\"><b>"._ADDCREA."</b></a> |\n" 
	. "<b>"._GESCAT."</b> |\n" 
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=pref\" style=\"text-decoration:none\"><b>"._PREF."</b></a></div><br />\n"
	. "<form method=\"post\" name=\"formulaire\" action=\"index.php?file=Portfolio&amp;page=admin&amp;op=do_add_cat\">\n"
	. "<table width=\"60%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\"><tr>\n"
 	. "<td width=\"100%\"><b>"._CAT." :</b>&nbsp;<input type=\"text\" name=\"cat\" size=\"40\" value=\"\">\n"
    . "</td></tr><tr><td align=\"center\"><br /><input type=button value=\"Ajouter\" onclick=document.formulaire.submit()></form><br /><br />\n"
    . "<center><a href=\"index.php?file=Portfolio&amp;page=admin\"><b>"._BACK."</b></a><br><br></center></table></div></div><br />";
}

function do_add_cat($cat)
{

global $nuked;

$ajout_cat=mysql_query("INSERT INTO ".$nuked[prefix]."_portfolio_cat VALUES('','".$cat."')");
echo "<div class=\"notification success png_bg\">\n"
. "<div>\n"
. "" . _CATADD . "\n"
. "</div>\n"
. "</div>\n";
redirect("index.php?file=Portfolio&page=admin&op=cat",2);

}

function edit_cat($id)
{

global $nuked, $language, $bgcolor3;

$cat = mysql_query("SELECT nom FROM ".$nuked[prefix]."_portfolio_cat WHERE id='".$id."'");
$nom = mysql_result($cat,0,nom);

echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>Editer une Catègorie</h3>\n"
    . "<div style=\"text-align:right;\"><img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></div></div>\n"
	. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=main\" style=\"text-decoration:none\"><b>"._CREA."</b></a> |\n" 
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=add\" style=\"text-decoration:none\"><b>"._ADDCREA."</b></a> |\n" 
	. "<b>"._GESCAT."</b> |\n" 
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=pref\" style=\"text-decoration:none\"><b>"._PREF."</b></a></div><br />\n"
    . "<form method=\"post\" name=\"formulaire\" action=\"index.php?file=Portfolio&amp;page=admin&amp;op=do_edit_cat\">\n"
	. "<table width=\"60%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\"><tr>\n"
 	. "<td width=\"100%\"><b>"._CAT." :</b>&nbsp;<input type=\"text\" name=\"nom\" size=\"40\" value=\"".$nom."\"><input type=\"hidden\" name=\"id\" size=\"10\" value=\"".$id."\">\n"
    . "</td></tr><tr><td align=\"center\"><br /><input type=button value=\""._EDIT."\" onclick=document.formulaire.submit()></form><br /><br />\n"
    . "<center><a href=\"index.php?file=Portfolio&amp;page=admin\"><b>"._BACK."</b></a><br><br></center></table></div></div><br />";
}

function do_edit_cat($id,$nom)
{

global $nuked;

$cat = mysql_query("SELECT nom FROM ".$nuked[prefix]."_portfolio_cat WHERE id='".$id."'");
$cat_name = mysql_result($cat,0,nom);
$add=mysql_query("UPDATE ".$nuked[prefix]."_portfolio_cat SET nom='".$nom."' WHERE id='".$id."'");
$sql=mysql_query("UPDATE ".$nuked[prefix]."_portfolio_crea SET cat='".$nom."' WHERE cat='".$cat_name."'");
echo "<div class=\"notification success png_bg\">\n"
. "<div>\n"
. "" . _CATEDIT . "\n"
. "</div>\n"
. "</div>\n";
redirect("index.php?file=Portfolio&page=admin&op=cat",2);

}

function do_del_cat($id)
{

global $nuked;

$del=mysql_query("DELETE FROM ".$nuked[prefix]."_portfolio_cat WHERE id='".$id."'");
echo "<div class=\"notification success png_bg\">\n"
. "<div>\n"
. "" . _CATDEL . "\n"
. "</div>\n"
. "</div>\n";
redirect("index.php?file=Portfolio&page=admin&op=cat",2);

}

function pref()
{

global $nuked, $language, $bgcolor3;

$nbcrea = mysql_query("SELECT nb_crea FROM ".$nuked[prefix]."_portfolio_pref");
$nbpage = mysql_result($nbcrea,0,nb_crea);

echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>Préférences</h3>\n"
    . "<div style=\"text-align:right;\"><img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></div></div>\n"
	. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
    . "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=main\" style=\"text-decoration:none\"><b>"._CREA."</b></a> |\n" 
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=add\" style=\"text-decoration:none\"><b>"._ADDCREA."</b></a> |\n" 
	. "<a href=\"index.php?file=Portfolio&amp;page=admin&amp;op=cat\" style=\"text-decoration:none\"><b>"._GESCAT."</b></a> |\n" 
	. "<b>"._PREF."</b></div><br />\n"
	. "<form method=\"post\" name=\"formulaire\" action=\"index.php?file=Portfolio&amp;page=admin&amp;op=edit_pref\">\n"
	. "<table width=\"60%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\"><tr>\n"
 	. "<td width=\"100%\" align=\"center\"><b>"._NBCREA." :</b>&nbsp;<input type=\"text\" name=\"creapage\" size=\"5\" value=\"".$nbpage."\">\n"
    . "</td></tr><tr><td align=\"center\"><br /><input type=button value=\""._EDIT."\" onclick=document.formulaire.submit()></form><br /><br />\n"
    . "<center><a href=\"index.php?file=Portfolio&amp;page=admin\"><b>"._BACK."</b></a><br><br></center></table></div></div><br />";
}

function edit_pref($creapage,$nbpage)
{
global $nuked;

$add=mysql_query("UPDATE ".$nuked[prefix]."_portfolio_pref SET nb_crea='".$creapage."'");
echo "<div class=\"notification success png_bg\">\n"
. "<div>\n"
. "" . _PREFEDIT . "\n"
. "</div>\n"
. "</div>\n";
redirect("index.php?file=Portfolio&page=admin",2);

}

switch ($_REQUEST['op'])
  {

 	case "add":
 	 add();
 	break;

 	case "do_add":
 	 do_add($_REQUEST['crea_titre'],$_REQUEST['date'],$_REQUEST['crea_cat'],$_REQUEST['crea_description'],$_REQUEST['url_site'],$_REQUEST['url'], $_REQUEST['screen'], $_REQUEST['screen2'], $_REQUEST['copy'], $_REQUEST['ecrase_file'], $_REQUEST['ecrase_screen']);
 	break;

 	case "edit":
 	 edit($_REQUEST['id']);
 	break;

 	case "do_edit":
 	 do_edit($_REQUEST['crea_titre'],$_REQUEST['crea_cat'],$_REQUEST['crea_description'],$_REQUEST['url_site'],$_REQUEST['url'], $_REQUEST['screen'], $_REQUEST['screen2'], $_REQUEST['copy'], $_REQUEST['ecrase_file'], $_REQUEST['ecrase_screen']);
 	break;

 	case "do_del":
 	 do_del($_REQUEST['id']);
 	break;

 	case "cat":
         cat();
        break;

 	case "add_cat":
         add_cat();
        break;
        
 	case "do_add_cat":
         do_add_cat($_REQUEST['cat']);
        break;

 	case "edit_cat":
         edit_cat($_REQUEST['id']);
        break;
        
 	case "do_edit_cat":
         do_edit_cat($_REQUEST['id'],$_REQUEST['nom']);
        break;

 	case "do_del_cat":
 	 do_del_cat($_REQUEST['id']);
 	break;

	case "pref":
         pref();
        break;
	
	case "edit_pref":
         edit_pref($_REQUEST['creapage'],$_REQUEST['nbpage']);
        break;

    	case "index":
         main();
        break;

 	case "main":
         main();
        break;

     	default:
       	 main();
	break;
 }
 
 adminfoot();

}
else
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    closetable();
} 


?>
