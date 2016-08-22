<?php
//-------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify   //
//  it under the terms of the GNU General Public License as published by   //
//  the Free Software Foundation; either version 2 of the License.         //
//-------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
} 

global $user,$nuked, $language;
translate("modules/Faqs/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");

admintop();

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
    function main_cat()
    {
	global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3;

        echo "<script type=\"text/javascript\">\n"
	. "<!--\n"
	. "\n"
	. "function delcat(titre, id)\n"
	. "{\n"
	. "if (confirm('" . _DELETEFAQS . " '+titre+' ! " . _CONFIRM . "'))\n"
	. "{document.location.href = 'index.php?file=Faqs&page=admin&op=del_cat&cid='+id;}\n"
	. "}\n"
    	. "\n"
	. "// -->\n"
	. "</script>\n";

  	echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>" . _ADMINFAQS . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Faqs.php\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"
	. "<div style=\"text-align: center;\"><b><a href=\"index.php?file=Faqs&amp;page=admin\">" . _FAQS . "</a> | "
	. "<a href=\"index.php?file=Faqs&amp;page=admin&amp;op=add_faqs\">" . _ADDQUESTION . "</a> | "
	. "</b>" . _CATMANAGEMENT . "<b></div><br />\n"
	. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;background: \"#CCCCCC \";border: 1px solid " . $bgcolor3 . ";\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
	. "<tr style=\"background: \"#E9E9E9\";\">\n"
	. "<td style=\"width: 60%;\" align=\"center\"><b>" . _CAT . "</b></td>\n"
	. "<td style=\"width: 20%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
	. "<td style=\"width: 20%;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";

        $i = 0;
        $sql = mysql_query("SELECT cid, titre FROM " . $nuked['prefix'] . "_faqs_cat ORDER BY titre");
        $nbcat = mysql_num_rows($sql);

        if ($nbcat > 0)
        {
	    while(list($cid, $titre) = mysql_fetch_row($sql))
	    {
                $titre = stripslashes($titre);
                $titre = htmlentities($titre);

                if ($i == 0)
                {
                    $bg = "";
                    $i++;
                } 
                else
                {
                    $bg = "";
                    $i = 0;
                } 

                echo "<tr style=\"background: " . $bg . ";\">\n"
                . "<td style=\"width: 60%;\" align=\"center\">" . $titre . "</td>\n"
                . "<td style=\"width: 20%;\" align=\"center\"><a href=\"index.php?file=Faqs&amp;page=admin&amp;op=edit_cat&amp;cid=" . $cid . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISCAT . "\" /></a></td>\n"
                . "<td style=\"width: 20%;\" align=\"center\"><a href=\"javascript:delcat('" . addslashes($titre) . "', '" . $cid . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISCAT . "\" /></a></td></tr>\n";
	    }
        } 
        else
	{
            echo "<tr><td align=\"center\" colspan=\"3\">" . _NOCATINDB . "</td></tr>\n";
	}

        echo "</table><br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Faqs&amp;page=admin&amp;op=add_cat\"><b>" . _ADDCAT . "</b></a> ]</div>\n"
	 . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Faqs&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
    }


    function add_cat()
    {
	global $language;

  	echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>" . _ADMINFAQS . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Faqs.php\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"
	. "<form method=\"post\" action=\"index.php?file=Faqs&amp;page=admin&amp;op=send_cat\">\n"
	. "<table  style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n"
	. "<tr><td><b>" . _TITLE . " :</b> <input type=\"text\" name=\"titre\" size=\"30\" /></td></tr></table>\n"
	. "<div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _CREATECAT . "\" /></div>\n"
	. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Faqs&amp;page=admin&amp;op=main_cat\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
    }


    function send_cat($titre)
    {
	global $nuked;

        $titre = addslashes($titre);

        $sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_faqs_cat ( `cid` , `titre` ) VALUES ( '' , '" . $titre . "' )");
        echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "" . _CATADD . "\n"
		. "</div>\n"
		. "</div>\n";     
         redirect("index.php?file=Faqs&page=admin&op=main_cat", 2);
    }


    function edit_cat($cid)
    {
	global $nuked, $language;

        $sql = mysql_query("SELECT titre FROM " . $nuked['prefix'] . "_faqs_cat WHERE cid = '" . $cid . "'");
        list($titre) = mysql_fetch_array($sql);
        $titre = stripslashes($titre);

   echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>" . _ADMINFAQS . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Faqs.php\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"	. "<form method=\"post\" action=\"index.php?file=Faqs&amp;page=admin&amp;op=modif_cat\">\n"
	. "<table  style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n"
	. "<tr><td><b>" . _TITLE . " :</b> <input type=\"text\" name=\"titre\" size=\"30\" value=\"" . $titre . "\" /></td></tr></table>\n"
	. "<div style=\"text-align: center;\"><br /><input type=\"hidden\" name=\"cid\" value=\"" . $cid . "\"><input type=\"submit\" value=\"" . _MODIFTHISCAT . "\" /></div>\n"
	. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Faqs&amp;page=admin&amp;op=main_cat\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
    }


    function modif_cat($cid,$titre)
    {
	global $nuked;

	$sql = mysql_query("UPDATE " . $nuked['prefix'] . "_faqs_cat SET titre = '" . $titre . "' WHERE cid = '" . $cid . "'");
	 echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "" . _CATMODIF . "\n"
		. "</div>\n"
		. "</div>\n";       
          redirect("index.php?file=Faqs&page=admin&op=main_cat", 2);
    }


    function del_cat($cid)
    {
	global $nuked;

	$sql = mysql_query("DELETE FROM " . $nuked['prefix'] . "_faqs_cat WHERE cid = '" . $cid . "'");
		 echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "" . _CATDEL . "\n"
		. "</div>\n"
		. "</div>\n";    
        redirect("index.php?file=Faqs&page=admin&op=main_cat", 2);
    }


    function select_faqs_cat()
    {
	global $nuked;

	$sql = mysql_query("SELECT cid, titre FROM " . $nuked['prefix'] . "_faqs_cat ORDER BY titre");
	while (list($cid, $titre) = mysql_fetch_row($sql)) 
	{
            $titre = stripslashes($titre);
            $titre = htmlentities($titre);

            echo "<option value=\"" . $cid . "\">" . $titre . "</option>\n";
	}
    }


    function main()
    {
        global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3, $p;

        $nb_faq = 30;

        $sql2 = mysql_query("SELECT id FROM " . $nuked['prefix'] . "_faqs");
        $count = mysql_num_rows($sql2);

        if (!$p) $p = 1;
        $start = $p * $nb_faq - $nb_faq;

        echo "<script type=\"text/javascript\">\n"
	. "<!--\n"
	. "\n"
	. "function delfaqs(titre, id)\n"
	. "{\n"
	. "if (confirm('" . _DELETEFAQS . " '+titre+' ! " . _CONFIRM . "'))\n"
	. "{document.location.href = 'index.php?file=Faqs&page=admin&op=del&faq_id='+id;}\n"
	. "}\n"
    	. "\n"
	. "// -->\n"
	. "</script>\n";

  	echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>" . _ADMINFAQS . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Faqs.php\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"	. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">" . _FAQS . "<b> | "
	. "<a href=\"index.php?file=Faqs&amp;page=admin&amp;op=add_faqs\">" . _ADDQUESTION . "</a> | "
	. "<a href=\"index.php?file=Faqs&page=admin&op=main_cat\">" . _CATMANAGEMENT . "</a></b></div><br />\n";

        if ($count > $nb_faq)
        {
            echo "<table width=\"100%\"><tr><td>";
            number($count, $nb_faq, "index.php?file=Faqs&amp;page=admin");
            echo"</td></tr></table>\n";
        } 

        echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
	. "<tr>\n"
	. "<td style=\"width: 40%;\" align=\"center\"><b>" . _QUESTIONS . "</b></td>\n"
	. "<td style=\"width: 30%;\" align=\"center\"><b>" . _CAT . "</b></td>\n"
	. "<td style=\"width: 15%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
	. "<td style=\"width: 15%;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";

        $sql = mysql_query("SELECT F.id, F.cat, F.questions, FC.cid, FC.titre  FROM " . $nuked['prefix'] . "_faqs AS F LEFT JOIN " . $nuked['prefix'] . "_faqs_cat AS FC ON FC.cid = F.cat ORDER BY F.id DESC LIMIT " . $start . ", " . $nb_faq);
        while (list($faq_id, $cat, $questions, $cid, $namecat) = mysql_fetch_array($sql))
        {
            $questions = stripslashes($questions);
            $namecat = stripslashes($namecat);

            $questions = htmlentities($questions);
            $namecat = htmlentities($namecat);

            if ($i == 0)
            {
                $bg = "";
                $i++;
            } 
            else
            {
                $bg = "";
                $i = 0;
            } 

            echo "<tr style=\"background: " . $bg . ";\">\n"
            . "<td style=\"width: 40%;\">&nbsp;" . $questions . "</td>\n"
            . "<td style=\"width: 30%;\" align=\"center\">" . $namecat . "</td>\n"
            . "<td style=\"width: 15%;\" align=\"center\"><a href=\"index.php?file=Faqs&amp;page=admin&amp;op=edit&amp;faq_id=" . $faq_id . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISQUESTION . "\" /></a></td>\n"
            . "<td style=\"width: 15%;\" align=\"center\"><a href=\"javascript:delfaqs('" . addslashes($questions) . "', '" . $faq_id . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISQUESTION . "\" /></a></td></tr>\n";
	}

	if($count == 0) echo"<tr><td colspan=\"4\" align=\"center\">" . _NOFAQSINDB . "</td></tr>\n";

        echo "</table>\n";

        if ($count > $nb_faq)
        {
            echo "<table width=\"100%\"><tr><td>";
            number($count, $nb_faq, "index.php?file=Faqs&amp;page=admin");
            echo "</td></tr></table>";
        } 
        echo "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
    } 


    function add_faqs()
    {
	global $language;

  	echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>" . _ADMINFAQS . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Faqs.php\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"
	. "<div style=\"text-align: center;\"><b><a href=\"index.php?file=Faqs&amp;page=admin\">" . _FAQS . "</a> | "
	. "</b>" . _ADDQUESTION . "<b> | "
	. "<a href=\"index.php?file=Faqs&page=admin&op=main_cat\">" . _CATMANAGEMENT . "</a></b></div><br />\n"
	. "<form method=\"post\" action=\"index.php?file=Faqs&amp;page=admin&amp;op=do_add\">\n"
	. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
	. "<tr><td><b>" . _QUESTIONS . " :</b> <input type=\"text\" name=\"questions\" size=\"50\" /></td></tr>\n"
	. "<tr><td><b>"._CAT." :</b> <select name=\"cat\">";

	select_faqs_cat();

        echo "</select></td></tr>\n"
	. "<tr><td align=\"center\">\n";

	echo "</td></tr><tr><td align=\"center\">\n";

        echo "</td></tr><tr><td><b>" . _ANSWERS . " : </b><br />\n"
	. "<textarea class=\"editor\" name=\"reponses\" rows=\"15\" cols=\"70\" ></textarea></td></tr>\n"
	. "<tr><td>&nbsp;</td></tr>\n"
	. "<tr><td align=\"center\"><input type=\"submit\" value=\"" . _ADDQUESTION . "\" /></td></tr>\n"
	. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Faqs&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
    }


    function do_add($cat, $questions, $reponses)
    {
	global $nuked;

	$questions = addslashes($questions);
	$reponses = addslashes($reponses);

	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_faqs ( `id` , `questions` , `reponses` , `cat` )  VALUES ( '' , '" . $questions . "' , '" . $reponses . "' , '" . $cat . "' )");
		 echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "" . _QUESTIONADD . "\n"
		. "</div>\n"
		. "</div>\n";    
        redirect("index.php?file=Faqs&page=admin", 2);
    }


    function edit($faq_id)
    {
	global $nuked, $language;

	$sql = mysql_query("SELECT questions, reponses, cat FROM " . $nuked['prefix'] . "_faqs WHERE id = '" . $faq_id . "'");
	list($questions, $reponses, $cat) = mysql_fetch_array($sql);

	$questions = stripslashes($questions);
	$reponses = stripslashes($reponses);

	$sql2 = mysql_query("SELECT titre FROM " . $nuked['prefix'] . "_faqs_cat WHERE cid = '" . $cat . "'");
	list($categorie) = mysql_fetch_array($sql2);
	$categorie = stripslashes($categorie);

   echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>" . _ADMINFAQS . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Faqs.php\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"	. "<form method=\"post\" action=\"index.php?file=Faqs&amp;page=admin&amp;op=do_edit\" >\n"
	. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
	. "<tr><td><b>" . _QUESTIONS . " :</b> <input type=\"text\" name=\"questions\" size=\"50\" value=\"" . $questions . "\" /></td></tr>\n"
	. "<tr><td><b>"._CAT." :</b> <select name=\"cat\"><option value=\"" . $cat . "\">" . $categorie . "</option>\n";

	select_faqs_cat();

        echo "</select></td></tr>\n"
	. "<tr><td align=\"center\">\n";

	echo "</td></tr><tr><td align=\"center\">\n";

        echo "</td></tr><tr><td><b>" . _ANSWERS . " : </b><br />\n"
	. "<textarea class=\"editor\" name=\"reponses\" rows=\"15\" cols=\"70\" >" . $reponses . "</textarea></td></tr>\n"
	. "<tr><td>&nbsp;<input type=\"hidden\" name=\"faq_id\" value=\"" . $faq_id . "\"></td></tr>\n"
	. "<tr><td align=\"center\"><input type=\"submit\" value=\"" . _EDITTHISQUESTION . "\" /></td></tr>\n"
	. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Faqs&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
    }


    function do_edit($faq_id, $cat, $questions, $reponses)
    {
	global $nuked;

	$questions = addslashes($questions);
	$reponses = addslashes($reponses);

	$sql = mysql_query("UPDATE " . $nuked['prefix'] . "_faqs SET questions = '" . $questions . "', reponses = '" . $reponses . "', cat = '" . $cat . "' WHERE id = '" . $faq_id . "'");
		echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "" . _QUESTIONMODIF . "\n"
		. "</div>\n"
		. "</div>\n";     
        redirect("index.php?file=Faqs&page=admin", 2);
    }


    function del($faq_id)
    {
    	global $nuked;

	$sql = mysql_query("DELETE FROM " . $nuked['prefix'] . "_faqs WHERE id = '" . $faq_id . "'");
		echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "" . _QUESTIONDEL . "\n"
		. "</div>\n"
		. "</div>\n";     
        redirect("index.php?file=Faqs&page=admin", 2);
    }


    switch ($_REQUEST['op'])
    {	
	case "main":
        main();
       	break;
	
	case "add_faqs":
	add_faqs();
	break;
	
	case "do_add":
	do_add($_REQUEST['cat'], $_REQUEST['questions'], $_REQUEST['reponses']);
	break;

	case "edit":
	edit($_REQUEST['faq_id']);
	break;

	case "do_edit":
	do_edit($_REQUEST['faq_id'], $_REQUEST['cat'], $_REQUEST['questions'], $_REQUEST['reponses']);
	break;

	case "del":
	del($_REQUEST['faq_id']);
	break;
	
	case "send_cat":
	send_cat($_REQUEST['titre']);
	break;

	case "add_cat":
	add_cat();
	break;

	case "main_cat":
	main_cat();
	break;

	case "edit_cat":
	edit_cat($_REQUEST['cid']);
	break;

	case "modif_cat":
	modif_cat($_REQUEST['cid'], $_REQUEST['titre'], $_REQUEST['description']);
	break;

	case "del_cat":
	del_cat($_REQUEST['cid']);
	break;
	
     	default:
       	main();
	break;
    }

} 
else if ($level_admin == -1)
{
    echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
}
else if ($visiteur > 1)
{
    echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
}
else
{
    echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
}	 

adminfoot();
	
?>