<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// Ce programme n'est pas un logiciel libre.                                //
// Vous pouvez donc pas le redistribuer et / ou modifier                    //
// Module Partenaire Flash pour NK 1.7.9  RC6                               //
// Créer par Stive @ PalaceWaR.eu / nk-create.com                           //
// Version 3.00 Compressé                                                   //
// Dernier teste effectue le 10/03/2012 02h10 Version Beta                  //
// -------------------------------------------------------------------------//
defined("INDEX_CHECK") or  die ("<div style=\"text-align: center;\">Vous ne pouvez pas ouvrir cette page directement</div>");

global $nuked, $user, $language;
translate("modules/Partenaire/lang/" . $language . ".lang.php");
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
	include ("modules/Vote/index.php");
    compteur("Partenaire");

    function index()
    {
		global $nuked,$user, $bgcolor1, $bgcolor2, $bgcolor3;
		
echo  " <table style=\"background:" . $bgcolor3 . ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">\n"
    . " <tr style=\"background:" . $bgcolor3 . "\";>\n"
    . " <td style=\"width: 20%;\"align=\"center\"><b>" . _BANNIERE . "</b></td>\n"
    . " <td style=\"width: 25;\"align=\"center\"><b>" . _SITE . "</b></td>\n"
    . " <td style=\"width: 50%;\"align=\"center\"><b>" . _DESCRIPTION . "</b></td></tr>\n";
	
	$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
	while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
	unset($sql_config, $row);
	
	$nb_max = $config['max_partenaire'];
	if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
	$start = $_REQUEST['p'] * $nb_max - $nb_max;
	
	$verif  = strlen($config['copy']);
	$verif = $verif - 16;
	$config['nocopy'] = htmlspecialchars_decode ($config['nocopy']);
    $config['copy'] = htmlspecialchars_decode ($config['copy']);

	$sql = mysql_query("SELECT id, logo460, logo80, site, date, description, liens, valide, petitdesc FROM ". $nuked['prefix'] ."_partenaire WHERE valide ='"._OUI."' and logo80 !='' ORDER BY id DESC LIMIT ". $start .", ". $nb_max ."") or die(mysql_error());;
	$compteur = mysql_num_rows($sql);
		if ($compteur == "0"){ echo  " <tr style=\"background: " . $bgcolor2 . ";\">\n"
	. " <td colspan=\"3\" align=\"center\">" . _NOPART1 . "</td>\n";}	
	while($row = mysql_fetch_assoc($sql))	 
	{
	$row['date'] = nkDate($row['date']);
echo  " <tr style=\"background: " . $bgcolor2 . ";\">\n"
	. " <td style=\"width: 20%; height: 50px;vertical-align:middle;\" align=\"center\"><img style=\"vertical-align:middle;\" src=\"" . $row['logo80'] . "\" alt=\"\" title=\"" . $row['site'] . "\" /></td>\n"
	. " <td style=\"width: 25%;\" align=\"center\"><a href=\"" . $row['liens'] . "\" onclick=\"window.open(this.href); return false;\">" . $row['site'] . "</a></td>\n"
	. " <td style=\"width: 50%;\"><font style=\"margin-left:10px;\">" . $row['petitdesc'] . "</font>
	    <div style=\"float:right;font-size: 9px;font-style: italic;margin-top: 3px;margin-right: 5px;\"><a href=\"index.php?file=Partenaire&op=voir&id=" . $row['id'] . "\">" . _SUITE . "</a></div></td>\n";
	}
echo  " <tr style=\"background: " . $bgcolor3 . ";\">\n"
	. " <td colspan=\"3\"align=\"center\">\n";
echo  " <div style=\"float:left;margin-left: 5px;\"> \n";
	        $page = mysql_query("SELECT id FROM ". $nuked['prefix'] ."_partenaire WHERE valide ='"._OUI."'");
	        $compteur = mysql_num_rows($page);
			if ($compteur > $nb_max) {
            $url = "index.php?file=Partenaire";
            number($compteur, $nb_max, $url);
            }
echo  " </div>\n";
if ($user[2] != "") {
echo "<a href=\"index.php?file=Partenaire&op=proposer\">" . _PROPOSERU . "</a>\n"; }
echo "<span style=\"float:right;margin-right: 5px;display:none;\">" . $config['copy'] . "</span></td>\n";
echo  " </tr></table>\n";			

	}
    function main()
    {
		global $nuked,$user, $bgcolor1, $bgcolor2, $bgcolor3;
		
echo  " <table style=\"background:" . $bgcolor3 . ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">\n"
    . " <tr style=\"background:" . $bgcolor3 . "\";>\n"
    . " <td style=\"width: 50%;\"align=\"center\"><b>" . _BANNIERE . "</b></td>\n"
    . " <td style=\"width: 50%;\"align=\"center\"><b>" . _DESCRIPTION . "</b></td></tr>\n";
	
	$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
	while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
	unset($sql_config, $row);
	
	$nb_max = $config['max_partenaire'];
	if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
	$start = $_REQUEST['p'] * $nb_max - $nb_max;
	
	$verif  = strlen($config['copy']);
	$verif = $verif - 16;
	$config['nocopy'] = htmlspecialchars_decode ($config['nocopy']);
    $config['copy'] = htmlspecialchars_decode ($config['copy']);

	$sql = mysql_query("SELECT id, logo460, site, date, description, liens, valide, petitdesc FROM ". $nuked['prefix'] ."_partenaire WHERE valide ='"._OUI."' and logo460 !='' ORDER BY id DESC LIMIT ". $start .", ". $nb_max ."") or die(mysql_error());;
	$compteur = mysql_num_rows($sql);
		if ($compteur == "0"){ echo  " <tr style=\"background: " . $bgcolor2 . ";\">\n"
	. " <td colspan=\"3\" align=\"center\">" . _NOPART1 . "</td>\n";}	
	while($row = mysql_fetch_assoc($sql))	 
	{
	$row['date'] = nkDate($row['date']);
echo  " <tr style=\"background: " . $bgcolor2 . ";\">\n"
	. " <td style=\"width: 50%; height: 70px;vertical-align:middle;\" align=\"center\"><img style=\"vertical-align:middle;\" src=\"" . $row['logo460'] . "\" alt=\"\" title=\"" . $row['site'] . "\" /></td>\n"
	. " <td style=\"width: 50%;\"><font style=\"margin-left:10px;\">" . $row['petitdesc'] . "</font>
	    <div style=\"float:right;font-size: 9px;font-style: italic;margin-top: 3px;margin-right: 5px;\"><a href=\"index.php?file=Partenaire&op=voir&id=" . $row['id'] . "\">" . _SUITE . "</a></div></td>\n";
	} 
echo  " <tr style=\"background: " . $bgcolor3 . ";\">\n"
	. " <td colspan=\"3\"align=\"center\">\n";
echo  " <div style=\"float:left;margin-left: 5px;\"> \n";
	        $page = mysql_query("SELECT id FROM ". $nuked['prefix'] ."_partenaire WHERE valide ='"._OUI."'");
	        $compteur = mysql_num_rows($page);
			if ($compteur > $nb_max) {
            $url = "index.php?file=Partenaire";
            number($compteur, $nb_max, $url);
            }
echo  " </div>\n";
if ($user[2] != "") {
echo "<a href=\"index.php?file=Partenaire&op=proposer\">" . _PROPOSERU . "</a>\n"; }
echo "<span style=\"float:right;margin-right: 5px;display:none;\">" . $config['copy'] . "</span></td>\n";
echo  " </tr></table>\n";			

	}

    function proposer()
    {
		global $nuked, $bgcolor1, $bgcolor2, $bgcolor3;
		
		$nuked['name'] = stripslashes($nuked['name']);
		$nuked['description'] = stripslashes($nuked['description']);
		
		$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
	    while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
	    unset($sql_config, $row);

		define('_XHTML460','&lt;a href=&quot;' . $nuked['url'] . '&quot; onclick=&quot;window.open(this.href); return false;&quot;&gt;&lt;img src=&quot;' . $config['votrelogo460'] . '&quot; alt=&quot;' . htmlentities($nuked['description']) . '&quot; title=&quot;' . htmlentities($nuked['name']) . '&quot; /&gt;&lt;/a&gt;');

		define('_XHTML80','&lt;a href=&quot;' . $nuked['url'] . '&quot; onclick=&quot;window.open(this.href); return false;&quot;&gt;&lt;img src=&quot;' . $config['votrelogo80'] . '&quot; alt=&quot;' . htmlentities($nuked['description']) . '&quot; title=&quot;' . htmlentities($nuked['name']) . '&quot; /&gt;&lt;/a&gt;');
		
		
echo  " <script type=\"text/javascript\">
		function textCounter(field,counter,maxlimit,linecounter) {
		var fieldWidth =  parseInt(field.offsetWidth);
		var charcnt = field.value.length;
		if (charcnt > maxlimit) { 
		field.value = field.value.substring(0, maxlimit);
	}
		else { 
		var percentage = parseInt(100 - (( maxlimit - charcnt) * 100)/maxlimit) ;
		document.getElementById(counter).style.width =  parseInt((fieldWidth*percentage)/100)+\"px\";
		document.getElementById(counter).innerHTML=\"\"+percentage+\"%\"

		setcolor(document.getElementById(counter),percentage,\"color\");
	}
}
		function setcolor(obj,percentage,prop){
		obj.style[prop] = \"rgb(100%,\"+(100-percentage)+\"%,\"+(100-percentage)+\"%)\";
}
		function testevide()
		{
		if(document.getElementById('site').value == '')
		{ 
		alert(\"" . _NOSITE . "\");
		return false;
		}
else
		{
		if(document.getElementById('liens').value == '')
		{
		alert(\"" . _NOLIENS . "\");
		return false;
		}	
else
		return true;
		}
		}
		</script>\n";


		define('EDITOR_CHECK', 1);

echo  " <form  method=\"post\" onsubmit=\"return testevide(); backslash('part_texte');\" action=\"index.php?file=Partenaire&op=send_propos\" enctype=\"multipart/form-data\"\">\n"
    . " <table width=\"100%\" border=\"0\" cellspacing=\"3\" cellpadding=\"3\">\n"
    . " <tr><td style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" align=\"center\">\n"
    . " <form method=\"post\" action=\"index.php?file=Partenaire&op=send_propos\" enctype=\"multipart/form-data\" onsubmit=\"backslash('part_texte');\">\n"	
    . " <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
	. " <tr><td style=\"width: 5%;\">&nbsp;</td>\n"
	. " <td style=\"width: 90%;\" align=\"center\"><big><b>" . _PROPO . "</b></big></td>\n"
	. " <td style=\"width: 5%;\" align=\"center\"></td></tr></table></td></tr>\n"
	
    . " <tr style=\"background: " . $bgcolor1 . ";\" ><td style=\"border: 1px dashed " . $bgcolor3 . ";\">&nbsp;<b>" . _NOMSITE . " :</b><br />&nbsp;
	    <input type=\"text\" name=\"site\" id=\"site\" size=\"40\" /><br />
        <b>&nbsp;" . _WEBSITE . " :</b><br />&nbsp;
	    <input type=\"text\"  name=\"liens\" size=\"40\" id=\"liens\"  /><br />\n";
		if ($config['taille1'] == _OUI)
		{
echo  " <b>&nbsp;" . _URLLOGO . " :</b><br />&nbsp;
		<input type=\"text\" name=\"linklogo\" id=\"logo\" size=\"40\" value=\"http://\" /><br />\n";
		if ($config['upload'] == On)
		{
echo  " <b>&nbsp;" . _UPLOGO . " :</b><br />&nbsp;
		<input type=\"file\" size=\"26\" id=\"uplogo\" name=\"logosup\" /><br />\n"; }
		}
		if ($config['taille2'] == _OUI)
		{
echo  " <b>&nbsp;" . _URLLOGO1 . " :</b><br />&nbsp;
		<input type=\"text\" name=\"linklogo1\" id=\"logo1\" size=\"40\" value=\"http://\" /><br />\n";
		if ($config['upload'] == On)
		{
echo  " <b>&nbsp;" . _UPLOGO1 . " :</b><br />&nbsp;
		<input type=\"file\" size=\"26\" id=\"uplogo1\" name=\"logosup1\" /><br />\n"; }
		}
echo  " <b>&nbsp;" . _DESCRSIMPLE . " :</b><br />&nbsp;
		<input type=\"text\" name=\"petitdesc\" size=\"40\" maxlength=\"".$config['petitdesc']."\" onKeyDown=\"textCounter(this,'progressbar1',".$config['petitdesc'].")\" onKeyUp=\"textCounter(this,'progressbar1',".$config['petitdesc'].")\" onFocus=\"textCounter(this,'progressbar1',".$config['petitdesc'].")\"\"/><span id=\"progressbar1\"></span><br />
		<b>&nbsp;" . _DESCRIPTION . " :</b><div align=\"center\">
		<textarea id=\"e_basic\" name=\"description\" 
		onselect=\"storeCaret('part_texte');\" onclick=\"storeCaret('part_texte');\" onmouseover=\"champ_survol.value=\"\"\" onkeyup=\"storeCaret('part_texte');\"></textarea></div><br /></td></tr>
        <tr style=\"background: " . $bgcolor1 . ";\" ><td style=\"border: 1px dashed " . $bgcolor3 . ";\" align=\"center\"><big><b>" . _NOTRE . "</b></big><br />\n";
		if ($config['taille2'] == _OUI)
		{
echo  " <img style=\"margin-top:10px;\" src=\"" . $config['votrelogo80'] . "\" alt=\"\" title=\"" . htmlentities($nuked['name']) . "\" /><br />
        <textarea cols=\"60\" rows=\"4\" readonly=\"readonly\">" . _XHTML80 . "</textarea>\n";
		}
		if ($config['taille1'] == _OUI)
		{
echo  " <img style=\"margin-top:10px;\" src=\"" . $config['votrelogo460'] . "\" alt=\"\" title=\"" . htmlentities($nuked['name']) . "\" />
        <textarea cols=\"60\" rows=\"4\" readonly=\"readonly\">" . _XHTML460 . "</textarea>\n";
		}		
echo  " </td></tr>
		<tr><td align=\"center\"><br /><input type=\"submit\" value=\"" . _PROPOPART . "\" /></td></tr></td></tr></table>\n";

echo "</td></tr></table></form>\n";
	}

    function send_propos($site, $liens, $linklogo, $logosup ,$linklogo1, $logosup1, $petitdesc, $description)
		{
		global $nuked, $user;

		$description = html_entity_decode($description);
		$description = mysql_real_escape_string(stripslashes($description));
		($linklogo === "http://") ? $linklogo = "" : $linklogo;
		($liens === "http://") ? $liens = "" : $liens;
		$author = $user[2];
		$date = time();
		
		$dossier = "upload/Partenaire/";
		
		if ($_FILES['logosup']['name'] != "") {
			$screenname = $_FILES['logosup']['name'];
			$ext = pathinfo($_FILES['logosup']['name'], PATHINFO_EXTENSION);
			$filename2 = str_replace($ext, "", $screenname);
			$url_logo = $dossier . $filename2 . $ext;

			if (!is_file($url_logo)) {
				if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
					move_uploaded_file($_FILES['logosup']['tmp_name'], $url_logo) or die ("" . FAILEDUP . "");
					@chmod ($url_logo, 0644);
				} else {
					echo "<div class=\"notification error png_bg\">\n"
					   . "<div>\n"
					   . "<div style=\"text-align: center;\">" . FAILEDUP1 . "</div><br />\n"
					   . "</div></div>\n";
					redirect("index.php?file=Partenaire&op=proposer", 2);
					adminfoot();
					footer();
					die;
				}
			} 

			$url_full_logo = $url_logo;
			$linklogo = $url_full_logo;
		}

		if ($_FILES['logosup1']['name'] != "") {
			$screenname1 = $_FILES['logosup1']['name'];
			$ext = pathinfo($_FILES['logosup1']['name'], PATHINFO_EXTENSION);
			$filename2 = str_replace($ext, "", $screenname1);
			$url_logo1 = $dossier . $filename2 . $ext;

			if (!is_file($url_logo1) || $effacer_logo1 == 1) {
				if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
					move_uploaded_file($_FILES['logosup1']['tmp_name'], $url_logo1) or die ("" . FAILEDUP . "");
					@chmod ($url_logo, 0644);
				} else {
					echo "<div class=\"notification error png_bg\">\n"
					   . "<div>\n"
					   . "<div style=\"text-align: center;\">" . FAILEDUP1 . "</div><br />\n"
					   . "</div></div>\n";
					redirect("index.php?file=Partenaire&page=admin&op=add", 2);
					adminfoot();
					footer();
					die;
				}
			} 

			$url_full_logo1 = $url_logo1;
			$linklogo1 = $url_full_logo1;
			
		}
			
		 $sql = mysql_query("INSERT INTO ". $nuked['prefix'] ."_partenaire ( `id`, `author`, `logo460`, `logo80`, `site`, `date`, `description`, `liens`, `valide`, `petitdesc` ) VALUES ( '' , '" . $author . "' , '" . $linklogo . "' , '" . $linklogo1 . "' , '" . $site . "' , '" . $date . "' , '" . $description . "' , '" . $liens . "' , 'Non', '" . $petitdesc . "' )");
		 $texte = " " . $author . "" . _NOTIFNEWPART . ""; 
		 $upd = mysql_query("INSERT INTO ". $nuked['prefix'] ."_notification  (`date` , `type` , `texte`)  VALUES ('".$date."', '4', '".$texte."')");
	 
	   echo "<br /><br /><div style=\"text-align: center; font-weight:bold;\">"._PARTESEND."</div><br /><br />";
			redirect("index.php?file=Partenaire",2);
	     }
		
    function voir($id)
    {
        global $nuked, $user, $visiteur, $bgcolor3, $bgcolor2, $bgcolor1;
echo " <table width=\"100%\" border=\"0\" cellspacing=\"3\" cellpadding=\"3\">\n"
	. "<tr><td style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" align=\"center\">\n";
	
        $sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
        while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
        unset($sql_config, $row);
		
        $verif  = strlen($config['copy']);
        $verif = $verif - 16;
        $config['nocopy'] = htmlspecialchars_decode ($config['nocopy']);
        $config['copy'] = htmlspecialchars_decode ($config['copy']);

        $sql = mysql_query("SELECT id, author, logo460, logo80, site, date, description, liens FROM ". $nuked['prefix'] ."_partenaire WHERE id ='". $id ."'");
        if(mysql_num_rows($sql) <= 0){
        redirect("index.php?file=404", 0);
        exit();
        }
        list($id, $auteur, $logo460, $logo80, $site, $date, $desc, $liens) = mysql_fetch_row($sql);
	    $date = nkDate($date);
		$site = htmlentities($site);
        $auteur = htmlentities($auteur);
	
echo " <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
	. "<tr><td style=\"width: 5%;\">&nbsp;</td>\n"
	. "<td style=\"width: 90%;\" align=\"center\"><big><b>" . $site . "</b></big></td>\n"
	. "<td style=\"width: 5%;\" align=\"center\">
	   <a href=\"#\" onclick=\"javascript:window.open('" . $liens . "')\"><img style=\"border: 0;\" src=\"images/indicator.gif\" alt=\"\" title=\"" . $site . "\" /></a></td></tr></table></td></tr>\n";

echo " <tr style=\"background: " . $bgcolor1 . ";\"><td style=\"border: 1px dashed " . $bgcolor3 . ";\"><b>" . _AUTHOR . " :</b> " . $auteur . "</td></tr>\n"
	. "<tr style=\"background: " . $bgcolor1 . ";\"><td style=\"border: 1px dashed " . $bgcolor3 . ";\"><b>" . _ADDTHE . " :</b> " . $date . "</td></tr>\n"
	. "<tr style=\"background: " . $bgcolor1 . ";\"><td style=\"border: 1px dashed " . $bgcolor3 . ";\"><b>" . _SITEWEB . " :</b> <a href=\"#\" onclick=\"javascript:window.open('" . $liens . "')\">" . $liens . "</a></td></tr>\n";
	        if($visiteur >= nivo_mod('Vote') && nivo_mod('Vote') > -1){
            echo "<tr style=\"background: " . $bgcolor1 . ";\"><td style=\"border: 1px dashed " . $bgcolor3 . ";\">";
            vote_index("Partenaire", $id);
            echo "</td></tr>";
        }
echo " <tr style=\"background: " . $bgcolor1 . ";\"><td style=\"border: 1px dashed " . $bgcolor3 . ";\"><b>" . _DESC . " :</b><br />" . $desc . "</td></tr>\n"
	. "<tr style=\"background: " . $bgcolor1 . ";\"><td style=\"border: 1px dashed " . $bgcolor3 . ";\"><b>" . _LOGO . " :</b><br />\n";
	if ($config['taille2'] == _OUI) { if ($logo460 != ""){ echo "<img style=\"margin-left:10px;\" src=\"" . $logo460 . "\" alt=\"\" title=\"" . $site . "\" />\n"; } }
	if ($config['taille1'] == _OUI) { if ($logo80 != ""){ echo "<img style=\"margin-left:10px;margin-bottom:15px;\" src=\"" . $logo80 . "\" alt=\"\" title=\"" . $site . "\" />\n"; } }
	   echo "</td></tr>\n";

	
echo "</table>\n";
echo "</td></tr></table>\n";	
	}

    switch ($_REQUEST['op']) {
		
            case "index":
            opentable();
            index();
            closetable();
            break;
			
            case "main":
            opentable();
            main();
            closetable();
            break;
			
            case "proposer":
            opentable();
            proposer($_REQUEST['id']);
            closetable();
            break;
			
			case "send_propos":
			opentable();
            send_propos($_REQUEST['site'], $_REQUEST['liens'], $_REQUEST['linklogo'], $_REQUEST['$logosup'], $_REQUEST['linklogo1'], $_REQUEST['$logosup1'], $_REQUEST['petitdesc'], $_REQUEST['description']);
			closetable();
            break;

            case "voir":
            opentable();
            voir($_REQUEST['id']);
            closetable();
            break;

            default:
            opentable();
            index();
            closetable();
            break;
    }

} else if ($level_access == -1) {
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
} else if ($level_access == 1 && $visiteur == 0) {
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | <a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b><br /><br /></div>";
    closetable();
} else {
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
}

?>