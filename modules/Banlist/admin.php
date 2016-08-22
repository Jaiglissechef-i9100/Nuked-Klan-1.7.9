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
    translate('modules/Banlist/lang/' . $language . '.lang.php');

	/* COnstante table */
	define('BANLIST_TABLE', $nuked['prefix'] . '_banlist');
	define('BANLIST_CONFIG_TABLE', $nuked['prefix'] . '_banlist_config');

$visiteur = $user ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);

if ($visiteur >= $level_admin && $level_admin > -1)
{
    function main()
    {
        global $nuked ;

		$sql=mysql_query("SELECT * FROM ".BANLIST_CONFIG_TABLE." where id='1'" ); 
		list($id, $iden, $raison1, $raison2, $raison3, $raison4, $raison5, $raison6, $raison7, $raison8, $raison9, $raison10, $serveur1, $serveur2, $serveur3, $serveur4, $serveur5, $serveur6, $serveur7, $serveur8, $serveur9, $serveur10) = mysql_fetch_array($sql);

	     echo "<script type=\"text/javascript\">\n"
		. "<!--\n"
		. "\n"
		. "function verifi_banform()\n"
		. "{\n"
		. "if (document.getElementById('banlist_identifiant').value.length == 0)\n"
		. "{\n"
		. "alert('"._MOT1." ".$iden."');\n"
		. "return false;\n"
		. "}\n"
		. "if (document.getElementById('banlist_pseudo').value.length == 0)\n"
		. "{\n"
		. "alert('"._MOT2."');\n"
		. "return false;\n"
		. "}\n"
		. "if (document.getElementById('banlist_raison').value.length == 0)\n"
		. "{\n"
		. "alert('"._MOT3."');\n"
		. "return false;\n"
		. "}\n"
		. "if (document.getElementById('banlist_serveur').value.length == 0)\n"
		. "{\n"
		. "alert('"._MOT4."');\n"
		. "return false;\n"
		. "}\n"
		. "return true;\n"
		. "}\n"
		. "\n"
		. "// -->\n"
		. "</script>\n";

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINBANLIST. "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Banlist.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "" . _ADMBAN0 . " | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=gestion\">" . _ADMBAN1 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=pref\">" . _ADMBAN2 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=banned\">"._ADMBAN3."</a></b>\n"
	           . "</div><br />\n";

	     echo "<br /><form method=\"post\" action=\"index.php?file=Banlist&amp;page=admin&amp;op=add\" onsubmit=\"return verifi_banform()\">\n"
		. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
		. "<tr><td align=\"center\"><big><b>"._ADDBAN."</b></big></td></tr>\n"
		. "<tr><td><b>".$iden." : </b>&nbsp;<br /><input id=\"banlist_identifiant\" type=\"text\" name=\"identifiant\" value=\"\" size=\"30\" maxlength=\"25\" /></td></tr>\n"
		. "<tr><td><b>"._PSEUDOBAN." : </b>&nbsp;<br /><input id=\"banlist_pseudo\" type=\"text\" name=\"pseudo\" value=\"\" size=\"30\" /></td></tr>\n"
		. "<tr><td><b>"._RAISONBAN." : </b>&nbsp;<br /><SELECT id=\"banlist_raison\" name=\"raison\">\n"
		. "<OPTION VALUE=\"".$raison1."\">".$raison1."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison2."\">".$raison2."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison3."\">".$raison3."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison4."\">".$raison4."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison5."\">".$raison5."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison6."\">".$raison6."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison7."\">".$raison7."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison8."\">".$raison8."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison9."\">".$raison9."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison10."\">".$raison10."</OPTION>\n"
		. "</td></tr>\n"
		. "<tr><td><b>"._SERVERBAN." : </b>&nbsp;<br /><SELECT id=\"banlist_serveur\" name=\"serveur\">\n"
		. "<OPTION VALUE=\"".$serveur1."\">".$serveur1."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur2."\">".$serveur2."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur3."\">".$serveur3."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur4."\">".$serveur4."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur5."\">".$serveur5."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur6."\">".$serveur6."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur7."\">".$serveur7."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur8."\">".$serveur8."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur9."\">".$serveur9."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur10."\">".$serveur10."</OPTION>\n"
		. "</td></tr>\n"
		. "<tr><td><b>"._LIENBAN." : </b>&nbsp;<br /><input type=\"text\" name=\"record\" value=\"\" size=\"40\" /></td></tr>\n"
		. "<tr><td align=\"center\"><br /><input type=\"submit\" class=\"bouton\" value=\""._ADD."\" /></td></tr></table></form><br />\n"
		. "<br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Admin\"><b>" . _BACK . "</b></a> ]</div><br /><br />\n";
	}

    function modif($mid)
    {
        global $nuked ;

		$sql=mysql_query("SELECT * FROM ".BANLIST_CONFIG_TABLE." where id='1'" ); 
		list($id, $iden, $raison1, $raison2, $raison3, $raison4, $raison5, $raison6, $raison7, $raison8, $raison9, $raison10, $serveur1, $serveur2, $serveur3, $serveur4, $serveur5, $serveur6, $serveur7, $serveur8, $serveur9, $serveur10) = mysql_fetch_array($sql);

		$sql=mysql_query("SELECT * FROM ".BANLIST_TABLE." WHERE id = '" . $mid . "'");
		list($id, $identifiant, $pseudo, $raison, $admin, $date, $serveur, $record) = mysql_fetch_array($sql);

	     echo "<script type=\"text/javascript\">\n"
		. "<!--\n"
		. "\n"
		. "function verifi_banform()\n"
		. "{\n"
		. "if (document.getElementById('banlist_identifiant').value.length == 0)\n"
		. "{\n"
		. "alert('"._MOT1." ".$iden."');\n"
		. "return false;\n"
		. "}\n"
		. "if (document.getElementById('banlist_pseudo').value.length == 0)\n"
		. "{\n"
		. "alert('"._MOT2."');\n"
		. "return false;\n"
		. "}\n"
		. "if (document.getElementById('banlist_raison').value.length == 0)\n"
		. "{\n"
		. "alert('"._MOT3."');\n"
		. "return false;\n"
		. "}\n"
		. "if (document.getElementById('banlist_serveur').value.length == 0)\n"
		. "{\n"
		. "alert('"._MOT4."');\n"
		. "return false;\n"
		. "}\n"
		. "return true;\n"
		. "}\n"
		. "\n"
		. "// -->\n"
		. "</script>\n";

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINBANLIST. "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Banlist.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "<b><a href=\"index.php?file=Banlist&amp;page=admin\">" . _ADMBAN0 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=gestion\">" . _ADMBAN1 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=pref\">" . _ADMBAN2 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=banned\">"._ADMBAN3."</a></b>\n"
	           . "</div><br />\n";

	     echo "<br /><form method=\"post\" action=\"index.php?file=Banlist&page=admin&op=add_modif&mid=$id\" onsubmit=\"return verifi_banform()\">\n"
		. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
		. "<tr><td align=\"center\"><big><b>"._MODIFBAN."</b></big></td></tr>\n"
		. "<tr><td><b>"._ID." : </b>&nbsp;<input type=\"hidden\" name=\"id\" value=\"$id\" size=\"5\" maxlength=\"25\" />".$id."</td></tr>\n"
		. "<tr><td><b>"._ADMINBAN." : </b>&nbsp;<input type=\"hidden\" name=\"admin\" value=\"". $admin . "\" size=\"5\" maxlength=\"25\" />" . $admin . "</td></tr>\n"
		. "<tr><td><b>"._DATE." : </b>&nbsp;<input type=\"hidden\" name=\"date\" value=\"day\" size=\"5\" maxlength=\"25\" />" . nkdate($date) . "</td></tr>\n"
		. "<tr><td><b>".$iden." : </b>&nbsp;<br /><input id=\"banlist_identifiant\" type=\"text\" name=\"identifiant\" value=\"" . $identifiant . "\" size=\"30\" maxlength=\"25\" /></td></tr>\n"
		. "<tr><td><b>"._PSEUDOBAN." : </b>&nbsp;<br /><input id=\"banlist_pseudo\" type=\"text\" name=\"pseudo\" value=\"".$pseudo."\" size=\"30\" /></td></tr>\n"
		. "<tr><td><b>"._RAISONBAN." : </b>&nbsp;<br /><SELECT id=\"banlist_raison\" name=\"raison\">\n"
		. "<OPTION VALUE=\"".$raison1."\">".$raison1."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison2."\">".$raison2."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison3."\">".$raison3."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison4."\">".$raison4."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison5."\">".$raison5."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison6."\">".$raison6."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison7."\">".$raison7."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison8."\">".$raison8."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison9."\">".$raison9."</OPTION>\n"
		. "<OPTION VALUE=\"".$raison10."\">".$raison10."</OPTION>\n"
		. "</td></tr>\n"
		. "<tr><td><b>"._SERVERBAN." : </b>&nbsp;<br /><SELECT id=\"banlist_serveur\" name=\"serveur\">\n"
		. "<OPTION VALUE=\"".$serveur1."\">".$serveur1."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur2."\">".$serveur2."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur3."\">".$serveur3."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur4."\">".$serveur4."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur5."\">".$serveur5."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur6."\">".$serveur6."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur7."\">".$serveur7."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur8."\">".$serveur8."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur9."\">".$serveur9."</OPTION>\n"
		. "<OPTION VALUE=\"".$serveur10."\">".$serveur10."</OPTION>\n"
		. "</td></tr>\n"
		. "<tr><td><b>"._LIENBAN." : </b>&nbsp;<br /><input type=\"text\" name=\"record\" value=\"$record\" size=\"40\" /></td></tr>\n"
		. "<tr><td align=\"center\"><br /><input type=\"submit\" class=\"bouton\" value=\""._MODIFBAN."\" /></td></tr></table></form><br />\n"
		. "<br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Admin\"><b>" . _BACK . "</b></a> ]</div><br /><br />\n";
	}

	function add($identifiant, $pseudo, $raison, $serveur, $date, $record)
    {
		global $nuked, $user;

		$sql=mysql_query("SELECT * FROM ".BANLIST_TABLE." WHERE identifiant = '" . $identifiant . "'");
		$count = mysql_num_rows($sql);

		if($count == 0)
		{
	    	$date = time();
		    $admin = printSecuTags( $user[2]);
		    $identifiant = printSecuTags($identifiant);
		    $pseudo = printSecuTags($pseudo);
		    $raison = printSecuTags($raison);
		    $serveur = printSecuTags($serveur);
		    $record = printSecuTags($record);

		    $add = mysql_query("INSERT INTO " . BANLIST_TABLE . " ( `id` , `identifiant` , `pseudo` , `raison` , `serveur` , `admin` , `date`, `record` ) VALUES ( '' , '" . $identifiant . "' , '" . $pseudo . "' , '" . $raison . "' , '" . $serveur . "' , '" . $user[2] . "' , '" . time() . "', '" . $record . "' )");

			$sql=mysql_query("SELECT * FROM ".BANLIST_CONFIG_TABLE." where id='1'" ); 
			list($id, $iden) = mysql_fetch_array($sql);

	        echo "<div class=\"notification success png_bg\">\n"
	           . "<div>\n"
	           . _THXBAN." " . $user[2]. "<br /> "._ADDOK." "._ADDOK4." <b>".$raison."</b> "._ADDOK5." <b>".$serveur."</b><br />"._ADDOK2." ".$iden.": <b>".$identifiant."</b><br /> "._ADDOK3." <b>".$pseudo."</b><br /> "._LIENBAN." : <b>".$record."</b>\n"
	           . "</div>\n"
	           . "</div>\n";

		    redirect("index.php?file=Banlist&page=admin&op=gestion", 5);
		}else{
		?>
			<div class="notification error png_bg">
			<div><?php echo _DEJABAN; ?><br /><div style="text-align:center;"><a href="javascript:history.back()"><b><?php echo _BACK; ?></b></a></div></div>
			</div>
		<?php
		}	
	}

	function add_modif($id, $identifiant, $pseudo, $raison, $serveur, $date, $record)
    {
		global $nuked;

	    $identifiant = printSecuTags($identifiant);
	    $pseudo = printSecuTags($pseudo);
	    $raison = printSecuTags($raison);
	    $serveur = printSecuTags($serveur);
	    $record = printSecuTags($record);

	    $upd = mysql_query("UPDATE " . BANLIST_TABLE . " SET identifiant='".$identifiant."', pseudo='".$pseudo."', raison='".$raison."', serveur='".$serveur."', record='".$record."' WHERE id='".$id."' "); 	

        echo "<div class=\"notification success png_bg\">\n"
           . "<div>\n"
           . _ADDOK6 . "\n"
           . "</div>\n"
           . "</div>\n";

	    redirect("index.php?file=Banlist&page=admin&op=gestion", 2);    	
	}

    function gestion()
    {
		global $nuked, $user;

		$sql=mysql_query("SELECT * FROM ".BANLIST_CONFIG_TABLE." where id='1'" ); 
		list($id, $iden) = mysql_fetch_array($sql);


        echo "<script type=\"text/javascript\">\n"
           . "<!--\n"
           . "\n"
           . "function del_ban(pseudo, id)\n"
           . "{\n"
           . "if (confirm('" . _DELETEBAN . " '+pseudo+' ! " . _CONFIRM . "'))\n"
           . "{document.location.href = 'index.php?file=Banlist&page=admin&op=del&mid='+id;}\n"
           . "}\n"
           . "\n"
           . "// -->\n"
           . "</script>\n";

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINBANLIST. "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Banlist.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "<b><a href=\"index.php?file=Banlist&amp;page=admin\">" . _ADMBAN0 . "</a></b> | "
	           . "" . _ADMBAN1 . " | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=pref\">" . _ADMBAN2 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=banned\">"._ADMBAN3."</a></b>\n"
	           . "</div><br />\n";

	     echo "<table style=\"margin-left: auto;margin-right: auto; text-align: center;\" width=\"90%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		. "<tr>\n"
		. "<td style=\"width: 5%;\"><b>N°</b></td>\n"
		. "<td style=\"width: 20%;\"><b>" . $iden . "</b></td>\n"
		. "<td style=\"width: 30%;\"><b>"._PSEUDOBAN."</b></td>\n"
		. "<td style=\"width: 15%;\"><b>"._RAISONBAN."</b></td>\n"
		. "<td style=\"width: 10%;\"><b>"._DATE."</b></td>\n"
		. "<td style=\"width: 5%;\"><b>&nbsp;</b></td>\n"
		. "<td style=\"width: 5%;\"><b>&nbsp;</b></td>\n"
		. "<td style=\"width: 5%;\"><b>&nbsp;</b></td></tr>\n";

		$sql = mysql_query("SELECT id, identifiant, pseudo, raison, admin, date FROM " . BANLIST_TABLE . " ORDER BY id DESC");
		$count = mysql_num_rows($sql);
		while (list($id, $identifiant, $pseudo, $raison, $admin, $date) = mysql_fetch_array($sql))
		{
		    echo "<tr>\n"
		    . "<td style=\"width: 5%;\">" . $id . "</td>\n"
		    . "<td style=\"width: 20%;\">" . $identifiant . "</td>\n"
		    . "<td style=\"width: 30%;\">" . $pseudo . "</td>\n"
		    . "<td style=\"width: 15%;\">" . $raison . "</td>\n"
		    . "<td style=\"width: 10%;\">" . $day . "</td>\n"
		    . "<td style=\"width: 5%;\"><a href='index.php?file=Banlist&page=admin&op=details&mid=".$id."'><img style=\"border: 0;\" src=\"modules/Banlist/images/plusinfo.gif\" alt=\"\" title=\""._PLUSINFOS."\" /></a></td>\n"
		    . "<td style=\"width: 5%;\"><a href='index.php?file=Banlist&page=admin&op=modif&mid=".$id."'><img style=\"border: 0;\" src=\"modules/Banlist/images/edit.gif\" alt=\"\" title=\""._MODIFBAN."\" /></a></td>\n"
		    . "<td style=\"width: 5%;\"><a href=\"#\" onclick=\"javascript:del_ban('".mysql_real_escape_string(stripslashes($pseudo))."', '".$id."');\"><img style=\"border: 0;\" src=\"modules/Banlist/images/del.gif\" alt=\"\" title=\""._DELETEBAN."\" /></a></td></tr>\n";
		}
		echo "</table><br />\n";

		if ($count == 0) echo "<div style=\"text-align: center;\">"._NOBAN."</div><br /><br />\n";

		echo"<div style=\"text-align: center;\">[ <a href=\"index.php?file=Banlist&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
    }

    function banned()
    {
		global $nuked, $user;

		$sql=mysql_query("SELECT * FROM ".BANLIST_CONFIG_TABLE." where id='1'" ); 
		list($id, $iden) = mysql_fetch_array($sql);

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINBANLIST. "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Banlist.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "<b><a href=\"index.php?file=Banlist&amp;page=admin\">" . _ADMBAN0 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=gestion\">" . _ADMBAN1 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=pref\">" . _ADMBAN2 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=banned\">"._ADMBAN3."</a></b>\n"
	           . "</div><br />\n";

	     echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor2 . ";border: 0px solid " . $bgcolor3 . ";\" width=\"90%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		. "<tr>\n"
		. "<td style=\"width: 25%;\" align=\"center\"></td></tr>\n";

		$sql = mysql_query("SELECT id, identifiant FROM " . BANLIST_TABLE . " ORDER BY id DESC");
		$count = mysql_num_rows($sql);
		while (list($id, $identifiant) = mysql_fetch_array($sql))
		{
		    echo "<tr>\n"
		    . "<td style=\"width: 25%;\" align=\"left\">" . $identifiant . "</td></tr>\n";
		}
		echo "</table><br />\n";

		if ($count == 0) echo "<div style=\"text-align: center;\">"._NOBAN."</div><br /><br />\n";

		echo"<div style=\"text-align: center;\">[ <a href=\"index.php?file=Banlist&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
    }

    function del($mid)
    {
		$sql = mysql_query("DELETE FROM " . BANLIST_TABLE . " WHERE id = '" . $mid . "'");

        echo "<div class=\"notification success png_bg\">\n"
           . "<div>\n"
           . _BANDELETE . "\n"
           . "</div>\n"
           . "</div>\n";

		redirect("index.php?file=Banlist&page=admin&op=gestion", 2);
    }

    function details($mid)
    {
		global $nuked, $user ;
		
		$sql = mysql_query("SELECT * FROM ".BANLIST_TABLE." WHERE id = '" . $mid . "'");
		list($id, $identifiant, $pseudo, $raison, $admin, $date, $serveur, $record) = mysql_fetch_array($sql);

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINBANLIST. "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Banlist.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "" . _ADMBAN0 . " | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=gestion\">" . _ADMBAN1 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=pref\">" . _ADMBAN2 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=banned\">"._ADMBAN3."</a></b>\n"
	           . "</div><br />\n";

		echo "<br /><br /><center><big><b>"._INFOBAN." ".$pseudo."</b></big></center><br /><br />\n"
		. "<table align=center border=0 width=400 ><tr><td><b>"._IDENTBAN." :</b> ".$identifiant."</td></tr>\n"
		. "<tr><td><b>"._PSEUDOBAN." : </b>".$pseudo."</td></tr>\n"
		. "<tr><td><b>"._BANFOR." : </b>".$raison."</td></tr>\n"
		. "<tr><td><b>"._BYADMIN." : </b>".$admin."</td></tr>\n"
		. "<tr><td><b>"._ATTHE." : </b>" . nkdate($date) . "</td></tr>\n"
		. "<tr><td><b>"._SERVERBAN." : </b>".$serveur."</td></tr>\n"
		. "<tr><td><b>"._LIENBAN." : </b><a href='".$record."'>".$record."</a></td></tr></table><br />\n";

		echo"<div style=\"text-align: center;\">[ <a href=\"index.php?file=Banlist&page=admin&op=gestion\"><b>" . _BACK . "</b></a> ]</div><br />\n";	
    }

	function pref()
	{
		global $nuked, $bgcolor3;	 

		$sql = mysql_query("SELECT * FROM ".BANLIST_CONFIG_TABLE." where id='1'" ); 
		list($id, $iden, $raison1, $raison2, $raison3, $raison4, $raison5, $raison6, $raison7, $raison8, $raison9, $raison10, $serveur1, $serveur2, $serveur3, $serveur4, $serveur5, $serveur6, $serveur7, $serveur8, $serveur9, $serveur10) = mysql_fetch_array($sql);

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINBANLIST. "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Banlist.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	           . "<b><a href=\"index.php?file=Banlist&amp;page=admin\">" . _ADMBAN0 . "</a></b> | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=gestion\">" . _ADMBAN1 . "</a></b> | "
	           . "" . _ADMBAN2 . " | "
	           . "<b><a href=\"index.php?file=Banlist&page=admin&op=banned\">"._ADMBAN3."</a></b>\n"
	           . "</div><br />\n";

	     echo "<form method=\"post\" action=\"index.php?file=Banlist&page=admin&op=add_pref\">\n"
		. "<table style=\"text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
		. "<tr><td colspan=2><b>"._IDENTIFICATIONBAN."</b></td></tr>\n"
		. "<tr><td>"._TYPEOFIDENTBAN." : <input  type=\"text\" name=\"iden\" size=\"26\" value=\"$iden\" /></td></tr>\n"
		. "</table><br />\n"
		. "<table style=\"text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
		. "<tr><td colspan=2><b>"._RAISONBAN2."</b></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 1 : <input  type=\"text\" name=\"raison1\" size=\"26\" value=\"".$raison1."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 2 : <input  type=\"text\" name=\"raison2\" size=\"26\" value=\"".$raison2."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 3 : <input  type=\"text\" name=\"raison3\" size=\"26\" value=\"".$raison3."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 4 : <input  type=\"text\" name=\"raison4\" size=\"26\" value=\"".$raison4."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 5 : <input  type=\"text\" name=\"raison5\" size=\"26\" value=\"".$raison5."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 6 : <input  type=\"text\" name=\"raison6\" size=\"26\" value=\"".$raison6."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 7 : <input  type=\"text\" name=\"raison7\" size=\"26\" value=\"".$raison7."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 8 : <input  type=\"text\" name=\"raison8\" size=\"26\" value=\"".$raison8."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 9 : <input  type=\"text\" name=\"raison9\" size=\"26\" value=\"".$raison9."\" /></td></tr>\n"
		. "<tr><td>"._RAISONBAN." 10 : <input  type=\"text\" name=\"raison10\" size=\"26\" value=\"".$raison10."\" /></td></tr>\n"
		. "</table><br />\n"
		. "<table style=\"text-align: left;\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n"
		. "<tr><td colspan=2><b>"._SERVERONBAN."</b></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 1 : <input  type=\"text\" name=\"serveur1\" size=\"70\" value=\"".$serveur1."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 2 : <input  type=\"text\" name=\"serveur2\" size=\"70\" value=\"".$serveur2."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 3 : <input  type=\"text\" name=\"serveur3\" size=\"70\" value=\"".$serveur3."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 4 : <input  type=\"text\" name=\"serveur4\" size=\"70\" value=\"".$serveur4."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 5 : <input  type=\"text\" name=\"serveur5\" size=\"70\" value=\"".$serveur5."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 6 : <input  type=\"text\" name=\"serveur6\" size=\"70\" value=\"".$serveur6."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 7 : <input  type=\"text\" name=\"serveur7\" size=\"70\" value=\"".$serveur7."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 8 : <input  type=\"text\" name=\"serveur8\" size=\"70\" value=\"".$serveur8."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 9 : <input  type=\"text\" name=\"serveur9\" size=\"70\" value=\"".$serveur9."\" /></td></tr>\n"
		. "<tr><td>"._SERVERBAN." 10 : <input  type=\"text\" name=\"serveur10\" size=\"70\" value=\"".$serveur10."\" /></td></tr>\n"
		. "<tr><td colspan=2 align=\"center\"><br /><input type=\"submit\" class=\"bouton\" value=\""._SAVE."\" /></td></tr></table></form><br />\n"
		. "</td></tr></table>\n"
		. "<br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Banlist&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
	}


	function add_pref($iden, $raison1, $raison2, $raison3, $raison4, $raison5, $raison6, $raison7, $raison8, $raison9, $raison10, $serveur1, $serveur2, $serveur3, $serveur4, $serveur5, $serveur6, $serveur7, $serveur8, $serveur9, $serveur10)
    {
		global $nuked, $user;
	 
	    $iden = printSecuTags($iden);
	    $raison1 = printSecuTags($raison1);
	    $raison2 = printSecuTags($raison2);
	    $raison3 = printSecuTags($raison3);
	    $raison4 = printSecuTags($raison4);
	    $raison5 = printSecuTags($raison5);
	    $raison6 = printSecuTags($raison6);
	    $raison7 = printSecuTags($raison7);
	    $raison8 = printSecuTags($raison8);
	    $raison9 = printSecuTags($raison9);
	    $raison10 = printSecuTags($raison10);

	    $serveur1 = printSecuTags($serveur1);
	    $serveur2 = printSecuTags($serveur2);
	    $serveur3 = printSecuTags($serveur3);
	    $serveur4 = printSecuTags($serveur4);
	    $serveur5 = printSecuTags($serveur5);
	    $serveur6 = printSecuTags($serveur6);
	    $serveur7 = printSecuTags($serveur7);
	    $serveur8 = printSecuTags($serveur8);
	    $serveur9 = printSecuTags($serveur9);
	    $serveur10 = printSecuTags($serveur10);

		$add=mysql_query("UPDATE ".BANLIST_CONFIG_TABLE." SET iden='$iden', raison1='$raison1', raison2='$raison2', raison3='$raison3', raison4='$raison4', raison5='$raison5', raison6='$raison6', raison7='$raison7', raison8='$raison8', raison9='$raison9', raison10='$raison10', serveur1='$serveur1', serveur2='$serveur2', serveur3='$serveur3', serveur4='$serveur4', serveur5='$serveur5', serveur6='$serveur6', serveur7='$serveur7', serveur8='$serveur8', serveur9='$serveur9', serveur10='$serveur10' WHERE id=1"); 	
		$add = mysql_query("INSERT INTO ".BANLIST_CONFIG_TABLE." ( `id` , `iden` , `raison1` , `raison2` , `raison3` , `raison4` , `raison5`, `raison6` , `raison7` , `raison8` , `raison9` , `raison10`, `serveur1` , `serveur2` , `serveur3` , `serveur4` , `serveur5`, `serveur6` , `serveur7` , `serveur8` , `serveur9` , `serveur10` ) 
		VALUES ( '1' , '" . $iden . "' , '" . $raison1 . "' , '" . $raison2 . "' , '" . $raison3 . "' , '" . $raison4 . "' , '" . $raison5 . "' , '" . $raison6 . "' , '" . $raison7 . "' , '" . $raison8 . "' , '" . $raison9 . "' , '" . $raison10 . "', '" . $serveur1 . "' , '" . $serveur2 . "' , '" . $serveur3 . "' , '" . $serveur4 . "' , '" . $serveur5 . "' , '" . $serveur6 . "' , '" . $serveur7 . "' , '" . $serveur8 . "' , '" . $serveur9 . "' , '" . $serveur10 . "'  )");


        echo "<div class=\"notification success png_bg\">\n"
           . "<div>\n"
           . _BANPREFOK . "\n"
           . "</div>\n"
           . "</div>\n";

	    redirect("index.php?file=Banlist&page=admin&op=pref", 2);
 	}

    switch($_REQUEST['op'])
    {
		case "del":
			admintop();
			del($_REQUEST['mid']);
			adminfoot();
		break;

		case "details":
			admintop();
			details($_REQUEST['mid']);
			adminfoot();
		break;

		case "gestion":
			admintop();
			gestion();
			adminfoot();
		break;

		case "banned":
			admintop();
			banned();
			adminfoot();
		break;

		case "modif":
			admintop();
			modif($_REQUEST['mid']);
			adminfoot();
		break;

		case"add":
			admintop();
			add($_REQUEST['identifiant'], $_REQUEST['pseudo'], $_REQUEST['raison'], $_REQUEST['serveur'], $_REQUEST['date'], $_REQUEST['record']);
			adminfoot();
		break;


		case"add_modif":
			admintop();
			add_modif($_REQUEST['id'], $_REQUEST['identifiant'], $_REQUEST['pseudo'], $_REQUEST['raison'], $_REQUEST['serveur'], $_REQUEST['date'], $_REQUEST['record']);
			adminfoot();
		break;

		case"pref":
			admintop();
			pref($_REQUEST['iden'], $_REQUEST['raison1'], $_REQUEST['raison2'], $_REQUEST['raison3'], $_REQUEST['raison4'], $_REQUEST['raison5'], $_REQUEST['raison6'], $_REQUEST['raison7'], $_REQUEST['raison8'], $_REQUEST['raison9'], $_REQUEST['raison10'], $_REQUEST['serveur1'], $_REQUEST['serveur2'], $_REQUEST['serveur3'], $_REQUEST['serveur4'], $_REQUEST['serveur5'], $_REQUEST['serveur6'], $_REQUEST['serveur7'], $_REQUEST['serveur8'], $_REQUEST['serveur9'], $_REQUEST['serveur10']);
			adminfoot();
		break;

		case"add_pref":
			admintop();
			add_pref($_REQUEST['iden'], $_REQUEST['raison1'], $_REQUEST['raison2'], $_REQUEST['raison3'], $_REQUEST['raison4'], $_REQUEST['raison5'], $_REQUEST['raison6'], $_REQUEST['raison7'], $_REQUEST['raison8'], $_REQUEST['raison9'], $_REQUEST['raison10'], $_REQUEST['serveur1'], $_REQUEST['serveur2'], $_REQUEST['serveur3'], $_REQUEST['serveur4'], $_REQUEST['serveur5'], $_REQUEST['serveur6'], $_REQUEST['serveur7'], $_REQUEST['serveur8'], $_REQUEST['serveur9'], $_REQUEST['serveur10']);
			adminfoot();
		break;

		default:
			admintop();
	        main();
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