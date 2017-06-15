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

global $nuked, $language, $user;
translate("modules/Faqs/lang/" . $language . ".lang.php");

if (!$user)
{
    $visiteur = 0;
} 
else
{
    $visiteur = $user[1];
} 
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

    compteur("Faqs");
    
    function index()
    {
    	global $nuked, $query, $cat, $bgcolor3, $bgcolor2, $bgcolor1, $theme;

	opentable();

	include("modules/Faqs/config.php");

        $nb_mess_guest = 20;

        $sqlfaqs = mysql_query("SELECT id FROM " . $nuked['prefix'] . "_faqs ");
        $countfaqs = mysql_num_rows($sqlfaqs);

        if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_mess_guest - $nb_mess_guest;
       

		 
	if ($query != "") 
	{
            $query = trim($query);
            $query = addslashes($query);
	}

	if ($faqs_title != "") $f_title = $faqs_title;
	else $f_title = "<img style=\"vertical-align: middle;\" alt=\"" . _FAQS . "\" src=\"modules/Faqs/images/faqs.png\" /><span style=\"font-family: 'Josefin Sans', sans-serif; font-size: large; margin-left:7px;\">" . _FAQS2 . "</span>";

	echo "<br /><form method=\"get\" action=\"index.php\"><table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\">\n"
	. "<tr><td style=\"width: 50%;\" align=\"center\" valign=\"top\"><big><b>" . $f_title . "</b></big><br />" . $faqs_desc . "</td>\n";

	echo "</td></tr></table>\n";
	if ($_REQUEST['query'] != " "&& $cat != "") $where = "WHERE (questions LIKE '%" . $_REQUEST['query'] . "%' OR reponses LIKE '%" . $_REQUEST['query'] . "%') AND cat = '" . $cat . "'";
	else if ($_REQUEST['query'] != "") $where = "WHERE questions LIKE '%" . $_REQUEST['query'] . "%' OR reponses LIKE '%" . $_REQUEST['query'] . "%'";
	else if ($_REQUEST['cat'] != "") $where = "WHERE cat = '" . $_REQUEST['cat'] . "'";
	else $where = "";

     if ($_REQUEST['cat'] != "")
	{ 
	$sql = mysql_query("SELECT titre FROM " . $nuked['prefix'] . "_faqs_cat WHERE cid = '" . $_REQUEST['cat'] . "'");
	list($titre) = mysql_fetch_row($sql);
 	    $orderby = "ORDER BY id DESC LIMIT " . $start . ", " . $nb_mess_guest."";
	    $title = "<i>" . _CAT . "</i>&nbsp;<b>" . $titre . "</b>";
	}
	else
	{ 
	    $orderby = "ORDER BY " . $faqs_orderby." DESC LIMIT " . $start . ", " . $nb_mess_guest." ";
	    $title =  "(" . _LASTQUESTIONS . ")";
    }
    
    
    	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"4\">\n"
	. "<tr><td><a name=\"top\"></a><big><b>" . _QUESTIONS . " :</b></big>&nbsp;" . $title . "</td></tr></table>\n";

	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"95%\"><tr><td>\n";

	$i = 0;
	$sql2 = mysql_query("SELECT id, questions FROM " . $nuked['prefix'] . "_faqs " . $where . " " . $orderby);
	$count = mysql_num_rows($sql2);

	if ($count > 0)
	{
		    echo '<table style="margin: auto" cellspacing="15" cellpadding="5">'."\n";

           $sql_cat = mysql_query('SELECT cid, titre, image FROM ' . $nuked['prefix'] . '_faqs_cat ORDER BY cid DESC LIMIT ' . $start . ', ' . $nb_mess_guest.'');
          
            $test = 0;
            while (list($cid, $titre, $image) = mysql_fetch_array($sql_cat)){
               
            if ( $image ) { $afficheimagecat = $image; } else { $afficheimagecat = 'modules/Faqs/images/no_screenshot.gif'; }
            if ( $image ) { $affichetitlecat = 'Catégorie&nbsp;'.$titre.''; } else { $affichetitlecat = 'Pas d\'image pour la catégorie '.$titre.''; }
            
                if ($cid != $last_cid){
                    $test++;
                    if ($test == 1) echo '<tr>';

                    echo '<td valign="top"><img title="'.$affichetitlecat.'" style="outline: none; border: 2px solid outset '.$bgcolor1.';border-top-left-radius: 45px; border-top-right-radius: 45px; border-bottom-right-radius: 45px; border-bottom-left-radius: 45px; padding: 2px; width: 40px; height: 40px; margin-right: 5px; background: '.$bgcolor2.';" src="' . $afficheimagecat . '" alt="'.$titre.'" /><a href="index.php?file=Faqs&amp;op=categorie&cat=' . $cid . '"><b style="font-family: \'Josefin Sans\', sans-serif;">' . printSecuTags($titre) . '</b></a>';

                    $sql2 = mysql_query('SELECT cat FROM ' . $nuked['prefix'] . '_faqs WHERE cat = ' . $cid);
                    $nb_lk = mysql_num_rows($sql2);

                    if ($nb_lk > 0) echo '<span style="font-family: \'Josefin Sans\', sans-serif;">&nbsp;(' . $nb_lk . ')</span>'."\n";
                    
                    else echo '<br />';

                    $t = 0;
                    
                    $sql_subcat = mysql_query('SELECT id, questions, date FROM ' . $nuked['prefix'] . '_faqs WHERE cat = ' . $cid . ' ORDER BY date LIMIT 0, 6');
                    while (list($sub_cat_id, $sub_cat_titre, $date) = mysql_fetch_array($sql_subcat)){
                    	
             $newsdate = time() - 84400;
             $att = "";

             if ($date!="" && $date > $newsdate) $att = "&nbsp;<img alt=\"new\" src=\"/modules/Faqs/images/index_new.png\" style=\"vertical-align: middle;\" />";

                        $sub_cat_titre = printSecuTags($sub_cat_titre);
                        $t++;
                        if ($t <= 5) echo '<br /><a href="index.php?file=Faqs&amp;op=categorie&cat=' . $cid . '#faq-' . $sub_cat_id . '">' . $sub_cat_titre . '</a>' . $att . '';
                        else echo '<a href="index.php?file=Faqs&amp;op=categorie&cat=' . $cid . '">...</a>';
                    }
                    
                    echo '</td>',"\n";

                    if ($test == 2){
                        $test = 0;
                        echo '</tr>'."\n";
                    }

                    $last_cid = $cid;
                }
            }

            if ($test == 1) echo '</tr>'."\n";
            echo '</table>'."\n";

	    echo "</td></tr></table><br /><br />\n";
   	}  
	else
	{
		echo "<div style=\"text-align: center;\"><b>". _NOQUESTIONS . "</b></div></td></tr></table><br />\n";
	} 
   
		     if ($countfaqs > $nb_mess_guest)
        {
            number($countfaqs, $nb_mess_guest, "index.php?file=Faqs");
        }

	echo "<table style=\"background: " . $bgcolor3 . ";margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"5\">\n";
	

	$i = 0;
	$sql2 = mysql_query("SELECT id, questions FROM " . $nuked['prefix'] . "_faqs " . $where . " " . $orderby);
	$count = mysql_num_rows($sql2);
    echo '<div id="questions"><ul>';
    
	if ($count > 0)
	{
	    while (list($id, $questions) = mysql_fetch_row($sql2)) 
	    {
                $questions = stripslashes($questions);
                $questions = html_entity_decode($questions);
                $i++;	
					
                $imgQ = "<img src=\"modules/Faqs/images/question.png\" alt=\"" . _QUESTION . "\" title=\"" . _QUESTION . "\" style=\"margin-bottom:-2px;\"/>";

	    }

	    echo "</table><table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"4\">\n"
	    . "</table>\n";
        
		echo '<div class="containernono">';
	    $img = "<img style=\"vertical-align:middle;\" src=\"modules/Faqs/images/reponse.png\" alt=\"\" />";

	    $sql3 = mysql_query("SELECT id, questions, reponses, cat FROM " . $nuked['prefix'] . "_faqs " . $where . " " . $orderby);
	    while (list($rid, $rquestions, $reponses, $cat) = mysql_fetch_row($sql3)) 
            {
		$rquestions = stripslashes($rquestions);
        $rquestions = html_entity_decode($rquestions);
		$reponses = stripslashes($reponses);
        $reponses = html_entity_decode($reponses);

        $sqlcat = mysql_query("SELECT titre, image FROM " . $nuked['prefix'] . "_faqs_cat WHERE cid = '" . $cat . "'");
		list($titre, $image) = mysql_fetch_array($sqlcat);
		if ( $image ) 
		{
		$affichecat = ''.$image.'';
		} 
		else 
		{
		$affichecat = 'modules/Faqs/images/reponse.png'; 
		}
		$pdffriend = "&nbsp;<a href=\"#\" onclick=\"javascript:window.open('index.php?file=Faqs&amp;nuked_nude=index&amp;op=pdf&amp;rid=" . $rid . "','projet','toolbar=yes,location=no,directories=no,scrollbars=yes,resizable=yes')\"><img src=\"modules/Faqs/images/pdf_file.png\" alt=\"Imprimer en pdf\" style=\"vertical-align:middle;\" width=\"20\" height=\"20\" border=\"0\" /></a>";
			
		echo '<h5 id="faq-'.$rid.'" class="header-h5 clear">
        <img id="img-1" class="img" src="'.$affichecat.'" alt="'.$titre.'" />
        <span class="question">'.$rquestions.'</span>
        <a href="index.php?file=Faqs&amp;op=sendfriend&amp;rid='.$rid.'" class="hint  hint--top" data-hint="Envoyer a un ami(e)"><img src="modules/Faqs/images/mail_send.png" alt="Envoyer a un ami(e)" style="vertical-align:middle;" width="18" height="18" border="0" /></a> 
	    &nbsp;'.$pdffriend.'
        </h5>
        <div id="faq-p'.$rid.'" class="faq-p radiusAndShadow">'.$reponses.'</div>';

	    }
	    echo '<div class="last-faq-p"></div></div>';

	}
	else
	{
		echo "<div style=\"text-align: center;\"><b>". _NOQUESTIONS . "</b></div></td></tr></table><br />\n";
	}

	closetable();
    }

    function categorie($cat){
        global $nuked;

        include("modules/Faqs/config.php");
        opentable();

        $sql = mysql_query('SELECT titre FROM ' . $nuked['prefix'] . '_faqs_cat WHERE cid = ' . $cat);
        if(mysql_num_rows($sql) <= 0){
            redirect('index.php?file=404', 0);
            exit();
        }

        list($cat_titre) = mysql_fetch_array($sql);

        $cat_titre = printSecuTags($cat_titre);
        
        echo "<br /><img style=\"vertical-align: middle;\" alt=\"" . _FAQS . "\" src=\"modules/Faqs/images/faqs.png\" /><span style=\"font-family: 'Josefin Sans', sans-serif; font-size: large; margin-left:7px;\">" . _FAQS2 . "&nbsp;de&nbsp;<b>" . $cat_titre . "</b></span><br />\n";


    	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"4\">\n"
	       . "<tr><td><a name=\"top\"></a><a style=\"font-family: 'Sofadi One', cursive;\" href=\"index.php?file=Faqs\">Retour à l'index de la FAQ</a></td></tr></table>\n";

	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"95%\">\n"
   	   . "<tr><td>\n";

	$i = 0;
	$sql2 = mysql_query("SELECT id, questions FROM " . $nuked['prefix'] . "_faqs WHERE cat = " . $cat . " ");
	$count = mysql_num_rows($sql2);

	if ($count > 0)
	{
		    echo '<table style="margin: auto" cellspacing="15" cellpadding="5">'."\n";


          $sql_subcat = mysql_query('SELECT id, questions FROM ' . $nuked['prefix'] . '_faqs WHERE cat = ' . $cat . ' ORDER BY date ');
          while (list($sub_cat_id, $sub_cat_titre) = mysql_fetch_array($sql_subcat)){
                        $sub_cat_titre = printSecuTags($sub_cat_titre);
                        
                         echo '<br /><a href="index.php?file=Faqs&amp;op=categorie&cat=' . $cat . '#faq-' . $sub_cat_id . '">' . $sub_cat_titre . '</a>';
                        
                    }
                    

          

            if ($test == 1) echo '</tr>'."\n";
            echo '</table>'."\n";

	    echo "</td></tr></table><br /><br />\n";
   	}  
	else
	{
		echo "<div style=\"text-align: center;\"><b>". _NOQUESTIONS . "</b></div></td></tr></table><br />\n";
	} 

		echo '<div class="containernono">';
	    $img = "<img style=\"vertical-align:middle;\" src=\"modules/Faqs/images/reponse.png\" alt=\"\" />";

	    $sql3 = mysql_query("SELECT id, questions, reponses, cat FROM " . $nuked['prefix'] . "_faqs WHERE cat = " . $cat . " ORDER BY questions");
	    while (list($rid, $rquestions, $reponses, $cat) = mysql_fetch_row($sql3)) 
            {
		$rquestions = stripslashes($rquestions);
        $rquestions = html_entity_decode($rquestions);
		$reponses = stripslashes($reponses);
        $reponses = html_entity_decode($reponses);

        $sqlcat = mysql_query("SELECT titre, image FROM " . $nuked['prefix'] . "_faqs_cat WHERE cid = '" . $cat . "'");
		list($titre, $image) = mysql_fetch_array($sqlcat);
		if ( $image ) 
		{
		$affichecat = ''.$image.'';
		} 
		else 
		{
		$affichecat = 'modules/Faqs/images/reponse.png'; 
		}
		$pdffriend = "&nbsp;<a href=\"#\" onclick=\"javascript:window.open('index.php?file=Faqs&amp;nuked_nude=index&amp;op=pdf&amp;rid=" . $rid . "','projet','toolbar=yes,location=no,directories=no,scrollbars=yes,resizable=yes')\"><img src=\"modules/Faqs/images/pdf_file.png\" alt=\"Imprimer en pdf\" style=\"vertical-align:middle;\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		
		echo '<h5 id="faq-'.$rid.'" class="header-h5 clear">
        <img id="img-1" class="img" src="'.$affichecat.'" alt="'.$titre.'" />
        <span class="question">'.$rquestions.'</span>
        <a href="index.php?file=Faqs&amp;op=sendfriend&amp;rid='.$rid.'" class="hint  hint--top" data-hint="Envoyer a un ami(e)"><img src="modules/Faqs/images/mail_send.png" alt="Envoyer a un ami(e)" style="vertical-align:middle;" width="18" height="18" border="0" /></a> 
	    &nbsp;'.$pdffriend.'
        </h5>
        <div id="faq-p'.$rid.'" class="faq-p radiusAndShadow">'.$reponses.'</div>';

	    }
	    echo '<div class="last-faq-p"></div></div>';

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

        $sql = mysql_query("SELECT questions, cat FROM " . $nuked['prefix'] . "_faqs WHERE id = '" . $rid . "'");
        list($questions, $cat) = mysql_fetch_array($sql);
        
        $questions = stripslashes($questions);
        
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
		." <input type=\"hidden\" name=\"cat\" value=\"" . $cat . "\" />\n"
		." <input type=\"submit\" value=\"" . _SEND . "\" /></td></tr></table></form><br />\n";

        closetable();
    }

    function sendnews($questions, $rid, $comment, $cat, $mail, $pseudo)
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
			$corps = $pseudo . " (IP : " . $user_ip . ") " . _READNEWS . " " . $questions . ", " . _NEWSURL . "\r\n" . $nuked['url'] . "/index.php?file=Faqs&amp;op=categorie&amp;cat=" . $cat . "#" . $rid . "\r\n\r\n" . _YCOMMENT . " : " . $comment . "\r\n\r\n\r\n" . $nuked['name'] . " - " . $nuked['slogan'];
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
		
        $sql = mysql_query("SELECT id, questions, reponses, cat FROM " . $nuked['prefix'] . "_faqs WHERE id = '" . $rid . "'");
        list($id, $title, $text, $cat) = mysql_fetch_row($sql);

        $text = "<br />" . $text;

        $text = str_replace("&quot;", "\"", $text);
        $text = str_replace("&#039;", "'", $text);
        $text = str_replace("&agrave;", "à", $text);
        $text = str_replace("&acirc;", "â", $text);
        $text = str_replace("&eacute;", "é", $text);
        $text = str_replace("&egrave;", "è", $text);
        $text = str_replace("&ecirc;", "ê", $text);
        $text = str_replace("&ucirc;", "û", $text);
        $text = @html_entity_decode($text);
        $text = preg_replace('#\r\n\t#', '', $text);
        $text = str_replace('<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>', '</page><page>', $text);

        $articleurl = $nuked['url'] . "/index.php?file=Faqs&amp;op=categorie&amp;cat=" . $cat . "#faq-" . $rid;

        $sitename = $nuked['name'] . " - " . $nuked['slogan'];

        $texte = '<page><h1>'.$title.'</h1><hr />'.$text.'<hr />'.$sitename.'<br />'.$articleurl.'</page>';
        $_REQUEST['file'] = $sitename.'_'.$title;
        $_REQUEST['file'] = str_replace(' ','_',$_REQUEST['file']);
        $_REQUEST['file'] .= '.pdf';

        // convert in PDF
        require_once('Includes/html2pdf/html2pdf.class.php');
        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
            $html2pdf->setDefaultFont('dejavusans');
            $html2pdf->writeHTML(utf8_encode($texte), isset($_GET['vuehtml']));
            $html2pdf->Output($title.'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
		/* 
		if ($language == "french" && strpos("WIN", PHP_OS)) setlocale (LC_TIME, "french");
		else if ($language == "french" && strpos("BSD", PHP_OS)) setlocale (LC_TIME, "fr_FR.ISO8859-1");
		else if ($language == "french") setlocale (LC_TIME, "fr_FR");
		else setlocale (LC_TIME, $language);

        $sql = mysql_query("SELECT id, questions, reponses, cat FROM " . $nuked['prefix'] . "_faqs WHERE id = '" . $rid . "'");
        list($id, $questions, $reponses, $cat) = mysql_fetch_row($sql);
        
        
        $heure = strftime("%H:%M", $date);
        $text = $content . "<br><br>" . $suite;
      
        $articleurl = $nuked['url'] . "/index.php?file=Faqs&amp;op=categorie&amp;cat=" . $cat . "#faq-" . $rid ;

        include ('Includes/html2pdf/html2pdf.class.php');
        
        $sitename  = html_entity_decode($sitename);
		$questions = @html_entity_decode($questions);
		$questions = stripslashes($questions);
		
		$reponses = stripslashes($reponses);
		$reponses = @html_entity_decode($reponses);
		
        $sitename = $nuked['name'] . " - " . $questions;
        
		$texte = "<h1>".$questions."</h1><hr />".$reponses."<hr />".$sitename."<br />".$articleurl;
		$_REQUEST['file'] = $sitename."_".$questions;
		$_REQUEST['file'] = str_replace(' ','_',$_REQUEST['file']);
		$_REQUEST['file'] .= ".pdf";
		
		$pdf = new HTML2PDF('P','A4','fr');
		$pdf->WriteHTML($texte);
		$pdf->Output($_REQUEST['file']);
		*/
    }

    switch($_REQUEST['op'])
    {
    case 'categorie':
    categorie($_REQUEST['cat']);
    break;
            
    case"pdf":
    pdf($_REQUEST['rid']);
    break;
    
    case"sendfriend":
    sendfriend($_REQUEST['rid']);
    break;
    
    case"sendnews":
    sendnews($_REQUEST['questions'], $_REQUEST['rid'], $_REQUEST['comment'], $_REQUEST['cat'], $_REQUEST['mail'], $_REQUEST['pseudo']);
    break;
    
	default:
	index();
	break;
    }

} 
else if ($level_access == -1)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    closetable();
} 
else if ($level_access == 1 && $visiteur == 0)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | "
    . "<a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b></div><br /><br />";
    closetable();
} 
else
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    closetable();
} 

?>