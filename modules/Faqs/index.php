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

global $nuked, $user, $language;
translate("modules/Faqs/lang/" . $language . ".lang.php");

if ($user)
{
    $visiteur = $user[1];
}
else
{
    $visiteur = 0;
}

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{
	compteur("Faqs");
    function index()
    {
    	global $nuked, $query, $cat, $bgcolor3, $bgcolor2, $bgcolor1;

	opentable();

	include("modules/Faqs/config.php");

	if ($query != "") 
	{
            $query = trim($query);
            $query = addslashes($query);
	}

	if ($faqs_title != "") $f_title = $faqs_title;
	else $f_title = "<img style=\"vertical-align: middle;\" alt=\"" . _FAQS . "\" src=\"modules/Faqs/images/faqs.png\" /><em><span style=\"font-family: book antiqua,palatino; font-size: large; margin-left:7px;\">" . _FAQS2 . "</span></em>";

	echo "<br /><form method=\"get\" action=\"index.php\"><table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\">\n"
	. "<tr><td style=\"width: 50%;\" align=\"center\" valign=\"top\"><big><b>" . $f_title . "</b></big><br />" . $faqs_desc . "</td>\n"
	. "<td style=\"width: 50%;\" align=\"right\"><b>" . _SEARCH . " :</b> <input type=\"hidden\" name=\"file\" value=\"Faqs\" /><input type=\"text\" name=\"query\" size=\"25\" value=\"" . stripslashes($query) . "\" /><br />\n"
	. "<b>" . _CAT . " : </b><select style=\"margin-top: 4px;\" name=\"cat\" onchange=\"document.location='index.php?file=Faqs&amp;query=" . urlencode($query) . "&amp;cat='+this.options[this.selectedIndex].value;\"><option value=\"\">" . _ALLCAT . "</option>";

	$cat_name = "";
	$sql = mysql_query("SELECT cid, titre FROM " . $nuked['prefix'] . "_faqs_cat ORDER BY titre");
	while (list($cid, $titre) = mysql_fetch_row($sql)) 
	{
            $titre = stripslashes($titre);
            $titre = htmlentities($titre);

            if ($cid == $cat) 
	    {
		$selected = "selected=\"selected\"";
		$cat_name = $titre;
	    }
            else
	    {
		$selected = "";
	    }
            echo "<option value=\"" . $cid . "\" " . $selected . ">" . $titre . "</option>\n";
	}

	echo"</select></td></tr></table></form>\n";
	
	if ($_REQUEST['query'] != " "&& $cat != "") $where = "WHERE (questions LIKE '%" . $_REQUEST['query'] . "%' OR reponses LIKE '%" . $_REQUEST['query'] . "%') AND cat = '" . $cat . "'";
	else if ($_REQUEST['query'] != "") $where = "WHERE questions LIKE '%" . $_REQUEST['query'] . "%' OR reponses LIKE '%" . $_REQUEST['query'] . "%'";
	else if ($_REQUEST['cat'] != "") $where = "WHERE cat = '" . $_REQUEST['cat'] . "'";
	else $where = "";

	if ($query == "" && $cat == "")
	{
	    $orderby = "ORDER BY id DESC LIMIT 0, 10";
	    $title = "(" . _LASTQUESTIONS . ")";
	}
	else
	{ 
	    $orderby = "ORDER BY " . $faqs_orderby;
	    $title = "";
	}

	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"4\">\n"
	. "<tr><td><a name=\"top\"></a><big><b>" . _QUESTIONS . " :</b></big>&nbsp;" . $title . "</td></tr></table>\n";

	echo "<table style=\"background: " . $bgcolor3 . ";margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"5\">\n"
	. "<tr style=\"background: " . $bgcolor1 . ";\"><td>\n";

	$i = 0;
	$sql2 = mysql_query("SELECT id, questions FROM " . $nuked['prefix'] . "_faqs " . $where . " " . $orderby);
	$count = mysql_num_rows($sql2);

	if ($count > 0)
	{
	    while (list($id, $questions) = mysql_fetch_row($sql2)) 
	    {
                $questions = mysql_real_escape_string(stripslashes($questions));
                $questions = secu_html(html_entity_decode($questions));
                $i++;		

                echo $i . "  - <a href=\"#" . $id . "\" title=\"" . _CLICTOVIEWANSWER . "\"><b>" . $questions . "</b></a><br />";
	    }

	    echo "</td></tr></table><br /><br />\n"
	    . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"4\">\n"
	    . "<tr><td><big><b>" . _ANSWERS . " :</b></big></td></tr></table>\n";

	    $img = "<img src=\"modules/Faqs/images/question.png\" alt=\"" . _QUESTION . "\" title=\"" . _QUESTION . "\" style=\"margin-bottom:-2px;\"/>";

	    $sql3 = mysql_query("SELECT id, questions, reponses FROM " . $nuked['prefix'] . "_faqs " . $where . " " . $orderby);
	    while (list($rid, $rquestions, $reponses) = mysql_fetch_row($sql3)) 
            {
		$rquestions = mysql_real_escape_string(stripslashes($rquestions));
		$rquestions = secu_html(html_entity_decode($rquestions));

//		$reponses = mysql_real_escape_string(stripslashes($reponses));
		$reponses = secu_html(html_entity_decode($reponses));
		//$reponses = trunc_hyperlink($reponses);

		echo "<a name=\"" . $rid . "\"></a><table style=\"background: " . $bgcolor3 . ";margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"4\">\n"
		. "<tr style=\"background: " . $bgcolor2 . ";\"><td>" . $img . "&nbsp;<big><b>" . $rquestions . "</b></big><br />" . $reponses . "</td></tr>\n"
		. "<tr style=\"background: " . $bgcolor1 . ";\"><td><a href=\"#top\"><img src=\"modules/Faqs/images/totop.png\" alt=\"" . _TOTOP . "\" title=\"" . _TOTOP . "\"/></a>&nbsp;&nbsp; <a href=\"index.php?file=Faqs&amp;op=sendfriend&amp;rid=".$rid."\"><img src=\"modules/Faqs/images/mail_send.png\" alt=\"" . _SENDTOAFRIEND . "\" title=\"" . _SENDTOAFRIEND . "\" /></a>
		&nbsp;&nbsp; <a href=\"index.php?file=Faqs&amp;nuked_nude=index&amp;op=pdf&amp;rid=".$rid."\"><img src=\"modules/Faqs/images/pdf_file.png\" alt=\"" . _PRINTTOPDF . "\" title=\"" . _PRINTTOPDF . "\" /></a></td></tr></table><br />";	
	    }
	}
	else
	{
		echo "<div style=\"text-align: center;\"><b>". _NOQUESTIONS . "</b></div></td></tr></table><br />\n";
	}

	closetable();
    }
    function sendfriend($rid)
    {
        global $nuked, $user, $captcha;

        opentable();

        echo "<script type=\"text/javascript\">\n"
		."<!--\n"
		."\n"
		. "function verifchamps()\n"
		. "{\n"
		. "\n"
		. "if (document.REQUESTElementById('sf_pseudo').value.length == 0)\n"
		. "{\n"
		. "alert('" . _NONICK . "');\n"
		. "return false;\n"
		. "}\n"
		. "\n"
		. "if (document.REQUESTElementById('sf_mail').value.indexOf('@') == -1)\n"
		. "{\n"
		. "alert('" . _BADMAIL . "');\n"
		. "return false;\n"
		. "}\n"
		. "\n"
		. "return true;\n"
		. "}\n"
		."\n"
		. "// -->\n"
		. "</script>\n";

        $sql = mysql_query("SELECT questions FROM " . $nuked['prefix'] . "_faqs WHERE id = '" . $rid . "'");
        list($questions) = mysql_fetch_array($sql);

                $questions = mysql_real_escape_string(stripslashes($questions));
                $questions = secu_html(html_entity_decode($questions));

        echo "<form method=\"post\" action=\"index.php?file=Faqs\" onsubmit=\"return verifchamps()\">\n"
		. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"60%\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\">\n"
		. "<tr><td align=\"center\"><br /><big><b>" . _FSEND . "</b></big><br /><br />" . _YOUSUBMIT . " :<br /><br />\n"
		. "<b>" . $questions . "</b><br /><br /></td></tr><tr><td align=\"left\">\n"
		. "<b>" . _YNICK . " : </b>&nbsp;<input type=\"text\" id=\"sf_pseudo\" name=\"pseudo\" value=\"" . $user[2] . "\" size=\"20\" /></td></tr>\n"
		. "<tr><td><b>" . _FMAIL . " : </b>&nbsp;<input type=\"text\" id=\"sf_mail\" name=\"mail\" value=\"mail@gmail.com\" size=\"25\" /></td></tr>\n"
    . "<tr><td><b>" . _YCOMMENT . " : </b><br /><textarea name=\"comment\" style=\"width:100%;\" rows=\"10\"></textarea></td></tr>\n";

		if ($captcha == 1) create_captcha(1);

		echo "<tr><td align=\"center\"><input type=\"hidden\" name=\"op\" value=\"sendnews\" />\n"
		. "<input type=\"hidden\" name=\"rid\" value=\"" . $rid . "\" />\n"
		." <input type=\"hidden\" name=\"questions\" value=\"" . $questions . "\" />\n"
		." <input type=\"submit\" value=\"" . _SEND . "\" /></td></tr></table></form><br />\n";

        closetable();
    }

    function sendnews($questions, $rid, $comment, $mail, $pseudo)
    {
        global $nuked, $captcha,$user_ip;

        opentable();

		if ($captcha == 1 && !ValidCaptchaCode($_POST['code_confirm']))
		{
			echo "<div style=\"text-align: center;\"><br /><br />" . _BADCODECONFIRM . "<br /><br /><a href=\"javascript:history.back()\">[ <b>" . _BACK . "</b> ]</a></div>";
		}
		else
		{
	        $date2 = time();
	        $date2 = strftime("%x %H:%M", $date2);


	        $mail = trim($mail);
	        $pseudo = trim($pseudo);

			$subject = $nuked['name'] . ", " . $date2;
			$corps = $pseudo . " (IP : " . $user_ip . ") " . _READNEWS . " " . $questions . ", " . _NEWSURL . "\r\n" . $nuked['url'] . "/index.php?file=Faqs#" . $rid . "\r\n\r\n" . _YCOMMENT . " : " . $comment . "\r\n\r\n\r\n" . $nuked['name'] . " - " . $nuked['slogan'];
			$from = "From: " . $nuked['name'] . " <" . $nuked['mail'] . ">\r\nReply-To: " . $nuked['mail'];

			$subject = @html_entity_decode($subject);
			$corps = @html_entity_decode($corps);
			$from = @html_entity_decode($from);

			mail($mail, $subject, $corps, $from);

	        echo "<div style=\"text-align: center;\"><br />" . _SENDFMAIL . "<br /><br /></div>";
	        redirect("index.php?file=Faqs", 2);
		}
        closetable();
    }
    
        function pdf($rid)
    {
        global $nuked, $language;

		if ($language == "french" && strpos("WIN", PHP_OS)) setlocale (LC_TIME, "french");
		else if ($language == "french" && strpos("BSD", PHP_OS)) setlocale (LC_TIME, "fr_FR.ISO8859-1");
		else if ($language == "french") setlocale (LC_TIME, "fr_FR");
		else setlocale (LC_TIME, $language);

        $sql = mysql_query("SELECT id, questions, reponses, cat FROM " . $nuked['prefix'] . "_faqs WHERE id = '" . $rid . "'");
        list($id, $questions, $reponses, $cat) = mysql_fetch_row($sql);

        $heure = strftime("%H:%M", $date);
        $text = $content . "<br><br>" . $suite;
      
        $articleurl = $nuked['url'] . "/index.php?file=Faqs#" . $rid ;

        include ('Includes/html2pdf/html2pdf.class.php');
        
        $sitename  = @html_entity_decode($sitename);
        $questions = stripslashes($questions);
        $questions = htmlentities($questions);
        $reponses = secu_html(html_entity_decode($reponses));
        $sitename = $nuked['name'] . " - " . $questions;
        
		$texte = "<h1>".$questions."</h1><hr />".$reponses."<hr />".$sitename."<br />".$articleurl;
		$_REQUEST['file'] = $sitename."_".$questions;
		$_REQUEST['file'] = str_replace(' ','_',$_REQUEST['file']);
		$_REQUEST['file'] .= ".pdf";
		
		$pdf = new HTML2PDF('P','A4','fr');
		$pdf->WriteHTML($texte);
		$pdf->Output($_REQUEST['file']);
    }
    
    switch ($_REQUEST['op'])
    {
	default:
	index();
	break;
	
	case"pdf":
    pdf($_REQUEST['rid']);
    break;
    
    case"sendfriend":
    sendfriend($_REQUEST['rid']);
    break;
    
    case"sendnews":
    sendnews($_REQUEST['questions'], $_REQUEST['rid'], $_REQUEST['comment'], $_REQUEST['mail'], $_REQUEST['pseudo']);
    break;
    }


}
else if ($level_access == -1)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
}
else if ($level_access == 1 && $visiteur == 0)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | <a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b><br /><br /></div>";
    closetable();
}
else
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
}

?>