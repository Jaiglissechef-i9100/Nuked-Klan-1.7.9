<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// Ce programme n'est pas un logiciel libre.                                //
// Vous pouvez donc pas le redistribuer et / ou modifier                    //
// Module Partenaire Flash pour NK 1.7.9  RC6                               //
// Créer par Stive @ PalaceWaR.eu / nk-create.com                           //
// Version 1.00 Compressé                                                   //
// Dernier teste effectue le 07/03/2012 13h00 Version Beta                  //
// -------------------------------------------------------------------------//
defined("INDEX_CHECK") or  die ("<div style=\"text-align: center;\">Vous ne pouvez pas ouvrir cette page directement</div>");

global $user, $language;
translate("modules/Partenaire/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");
admintop();
$visiteur = (!$user) ? 0 : $user[1];
$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1){
         
		function main()
	    {
        global $nuked, $user;
		
        echo "<script type=\"text/javascript\">\n"
           . "<!--\n"
           . "\n"
           . "function del_part(site, id)\n"
           . "{\n"
           . "if (confirm('" . _DELETEPART . " '+site+' ! " . _CONFIRM . "'))\n"
           . "{document.location.href = 'index.php?file=Partenaire&page=admin&op=del_part&id='+id;}\n"
           . "}\n"
           . "\n"
           . "// -->\n"
           . "</script>\n";
		   
		   	$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
	        while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
	        unset($sql_config, $row);
		
		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINPARTENAIRE . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/theme.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b>" . _ADMINVALID . "</b> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=attente\">" . _ADMINAVALIDE . "</a> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=add\">" . _ADD . "</a> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=pref\">" . _CONFIG . "</a><br><br />\n";
			
		 echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _BANNIERE . "</b></td>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _NOM . "</b></td>\n"
			. "<td style=\"width: 30%;\" align=\"center\"><b>" . _DATE . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _NONVALIDE . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _EDITER . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";	
			
		 $sql = mysql_query("SELECT id, author, logo460, logo80, site, date, description, liens, valide FROM ". $nuked['prefix'] ."_partenaire WHERE valide ='"._OUI."' ORDER BY id DESC") or die(mysql_error());;
		 $compteur = mysql_num_rows($sql);
		 while($row = mysql_fetch_assoc($sql))		 
		{
		 $row['date'] = nkDate($row['date']);
		 
		 echo "<tr><td style=\"width: 20%;\" align=\"center\">\n";	
		 if ($config['taille1'] == _OUI)
		 {
		 if ($row['logo460'] != ""){ echo "<img width=\"88\" height=\"31\" style=\"vertical-align:middle;\" src=\"" . $row['logo460'] . "\" alt=\"\" title=\"" . $row['site'] . "\" />\n"; }
		 }
		 if ($config['taille2'] == _OUI)
		 {
		 if ($row['logo80'] != ""){ echo "<img width=\"88\" height=\"31\" style=\"vertical-align:middle;\" src=\"" . $row['logo80'] . "\" alt=\"\" title=\"" . $row['site'] . "\" />\n"; }
		 }
		 echo "</td><td style=\"width: 20%;\" align=\"center\"><a href=\"" . $row['liens'] . "\">" . $row['site'] . "</a></td>\n"
			. "<td style=\"width: 30%;\"align=\"center\">" . $row['date'] . "</td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=nonvalide&amp;id=" . mysql_real_escape_string($row['id']) . "\">
			   <img style=\"border: 0;\" src=\"images/partnok.png\" alt=\"\" title=\"" . _ATTENTE . "\" /></a></td>\n"
            . "<td style=\"width: 10%;\" align=\"center\"><a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=edit_part&amp;id=" . $row['id'] . "\">
			   <img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISPART . "\" /></a></td>\n"
            . "<td align=\"center\"><a href=\"javascript:del_part('" . mysql_real_escape_string(stripslashes($row['site'])) . "', '" . $row['id'] . "');\">
			   <img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELPART . "\" /></a></td></tr>\n";	  
	    }
		if ($compteur == 0)
	    {
		 echo "<tr><td colspan=\"5\"><div align=\"center\">" . _NOPART . "</div></td></tr>\n";
	    }
		echo "</table>\n";
		
	    $fichier = "http://www.palacewar.eu/Nuked-Klan/miseajour.xml";
	    $lienscreate = @fopen("".$fichier."", "r");
	    if ($lienscreate == false ){
	    echo "<div style=\"margin: 12px\"><div class=\"notification information png_bg\"><div>" . _INFO1 . "</div></div></div>\n";
	    } else {
	    $fichier = "http://www.palacewar.eu/Nuked-Klan/miseajour.xml";
	    $dom = new DOMDocument();
	    if (!$dom->load($fichier)) {}
	    $itemList = $dom->getElementsByTagName('item');
	    foreach ($itemList as $item) {
	    $version = $item->getElementsByTagName('version');
	    $version = $version->item(0)->nodeValue;
	    if ($config['version'] >=  $version ) { echo "<div style=\"margin: 12px\"><div class=\"notification information png_bg\"><div>" . _INFO1 . "<span style=\"text-align:right;float:right;\">".$config['version']."</span></div></div></div>\n"; }
	    else { echo "<div style=\"margin: 12px\"><div class=\"notification attention png_bg\"><div>" . _ALERTMAJ . "".$config['version']."" . _ALERTMAJ1 . "" . $version  . "</div></div></div>\n"; }}}
	    }

		function attente()
	    {
        global $nuked, $user;
		
        echo "<script type=\"text/javascript\">\n"
			. "<!--\n"
		    . "\n"
		    . "function del_part(site, id)\n"
		    . "{\n"
		    . "if (confirm('" . _DELETEPART . " '+site+' ! " . _CONFIRM . "'))\n"
		    . "{document.location.href = 'index.php?file=Partenaire&page=admin&op=del_part&id='+id;}\n"
		    . "}\n"
		    . "\n"
		    . "// -->\n"
		    . "</script>\n";
			
		   	$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
	        while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
	        unset($sql_config, $row);
		
		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINPARTENAIRE . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/theme.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<a href=\"index.php?file=Partenaire&page=admin\">" . _ADMINVALID . "</a> | \n"
			. "<b>" . _ADMINAVALIDE . "</b> | \n"
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=add\">" . _ADD . "</a> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=pref\">" . _CONFIG . "</a><br><br />\n";
			
		 echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _BANNIERE . "</b></td>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _NOM . "</b></td>\n"
			. "<td style=\"width: 30%;\" align=\"center\"><b>" . _DATE . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _VALIDE . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _EDITER . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";	
			
		 $sql = mysql_query("SELECT id, author, logo460, logo80, site, date, description, liens, valide FROM ". $nuked['prefix'] ."_partenaire WHERE valide ='"._NON."' ORDER BY id DESC") or die(mysql_error());;
		 $compteur = mysql_num_rows($sql);
		 while($row = mysql_fetch_assoc($sql))		 
		{
		 $row['date'] = nkDate($row['date']);
		 
		 echo "<tr><td style=\"width: 20%;\" align=\"center\">\n";	
		 if ($config['taille1'] == _OUI){
		 echo "<img width=\"88\" height=\"31\" style=\"vertical-align:middle;\" src=\"" . $row['logo460'] . "\" alt=\"\" title=\"" . $row['site'] . "\" />\n";
		 }
		 if ($config['taille2'] == _OUI){
		 echo "<img width=\"88\" height=\"31\" style=\"vertical-align:middle;\" src=\"" . $row['logo80'] . "\" alt=\"\" title=\"" . $row['site'] . "\" />\n";
		 }
		 echo "</td><td style=\"width: 20%;\" align=\"center\"><a href=\"" . $row['liens'] . "\">" . $row['site'] . "</a></td>\n"
			. " <td style=\"width: 30%;\"align=\"center\">" . $row['date'] . "</td>\n"
		    . "<td style=\"width: 10%;\" align=\"center\"><a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=valide&amp;id=" . mysql_real_escape_string($row['id']) . "\">
			   <img style=\"border: 0;\" src=\"images/partok.png\" alt=\"\" title=\"" . _VALIDOK . "\" /></a></td>\n"
            . "<td style=\"width: 10%;\" align=\"center\"><a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=edit_part&amp;id=" . $row['id'] . "\">
			   <img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISPART . "\" /></a></td>\n"
            . "<td align=\"center\"><a href=\"javascript:del_part('" . mysql_real_escape_string(stripslashes($row['site'])) . "', '" . $row['id'] . "');\">
			   <img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELPART . "\" /></a></td></tr>\n";	  
	    }
		if ($compteur == 0)
	    {
		 echo "<tr><td colspan=\"5\"><div align=\"center\">" . _NOPARTA . "</div></td></tr>\n";
	    }
		echo "</table>\n";
		
		$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
	    while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
	    unset($sql_config, $row);
       
	    $fichier = "http://www.palacewar.eu/Nuked-Klan/miseajour.xml";
	    $lienscreate = @fopen("".$fichier."", "r");
	    if ($lienscreate == false ){
	    echo "<div style=\"margin: 12px\"><div class=\"notification information png_bg\"><div>" . _INFO1 . "</div></div></div>\n";
	    } else {
	    $fichier = "http://www.palacewar.eu/Nuked-Klan/miseajour.xml";
	    $dom = new DOMDocument();
	    if (!$dom->load($fichier)) {}
	    $itemList = $dom->getElementsByTagName('item');
	    foreach ($itemList as $item) {
	    $version = $item->getElementsByTagName('version');
	    $version = $version->item(0)->nodeValue;
	    if ($config['version'] >=  $version ) { echo "<div style=\"margin: 12px\"><div class=\"notification information png_bg\"><div>" . _INFO1 . "<span style=\"text-align:right;float:right;\">".$config['version']."</span></div></div></div>\n"; }
	    else { echo "<div style=\"margin: 12px\"><div class=\"notification attention png_bg\"><div>" . _ALERTMAJ . "".$config['version']."" . _ALERTMAJ1 . "" . $version  . "</div></div></div>\n"; }}}
	    }

		function pref()
	    {
        global $nuked, $user;
		
		echo  " <script type=\"text/javascript\">
        function ValideForm() {
		if((document.getElementById('var1').checked == true) && (document.getElementById('var2').checked == false)) {document.getElementById('btmvalide').disabled = false }
		if((document.getElementById('var1').checked == false) && (document.getElementById('var2').checked == true)) {document.getElementById('btmvalide').disabled = false }
		if((document.getElementById('var1').checked == true) && (document.getElementById('var2').checked == true)) {document.getElementById('btmvalide').disabled = false }
		if((document.getElementById('var1').checked == false) && (document.getElementById('var2').checked == false)) {document.getElementById('btmvalide').disabled = true }
        }</script>\n";

		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINPARTENAIRE . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/theme.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<a href=\"index.php?file=Partenaire&page=admin\">" . _ADMINVALID . "</a> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=attente\">" . _ADMINAVALIDE . "</a> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=add\">" . _ADD . "</a> | "
			. "<b>" . _CONFIG . "</b><br /><br />\n";
			
			$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
			while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
			unset($sql_config, $row);
			
	        (empty($config['widht'])) || (empty($config['height'])) ? $taille = $config['taille'] : $taille = "" . $config['widht'] . " * " . $config['height'] . "";
			 if ($config['taille1'] == "Oui"){$checked1  = "checked=\"checked\"";}
			 if ($config['taille2'] == "Oui"){$checked2 = "checked=\"checked\"";}
			 if ($config['upload'] == "On"){$checked3 = "checked=\"checked\"";}

		 echo "<form method=\"post\" action=\"index.php?file=Partenaire&amp;page=admin&amp;op=send_pref\"\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			
			. "<tr><td width=\"10%\"><b>" . _TAILLE460 . "</b></td><td width=\"10%\">
			   <input type=\"checkbox\" name=\"taille1\" id=\"var1\" onClick=\"ValideForm()\" value=\"Oui\" " . $checked1 . "></td><td width=\"10%\"></td>
			   <td >" . _TAILLEHELP460 . "</td></tr>\n"
			   
			. "<tr><td><b>" . _TAILLE80 . "</b></td><td>
			   <input type=\"checkbox\" name=\"taille2\" id=\"var2\" onClick=\"ValideForm()\" value=\"Oui\" " . $checked2 . "></td><td></td>
			   <td>" . _TAILLEHELP80 . "</td></tr>\n"
			   
			. "<tr><td><b>" . _UPLOAD . "</b></td><td>
			   <input type=\"checkbox\" name=\"upload\" value=\"On\" " . $checked3 . "></td><td></td>
			   <td>" . _UPLOADHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _POSITIONX . "</b></td><td><input disabled maxlength=\"4\" type=\"text\" style=\"text-align:center\" name=\"positionX\" size=\"5\" value=\"" . $config['positionX'] . "\" /></td><td></td>
			   <td>" . _POSITIONXHELP . "</td></tr>\n"
			
			. "<tr><td><b>" . _POSITIONY . "</b></td><td><input disabled maxlength=\"4\" type=\"text\" style=\"text-align:center\" name=\"positionY\" size=\"5\" value=\"" . $config['positionY'] . "\" /></td><td></td>
			   <td>" . _POSITIONYHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _EASINGIN . "</b></td><td><select name=\"easingIn\"><option>" . $config['easingIn'] . "</option>
			   <option>Elastic.easeOut</option><option>Back.easeOut</option><option>Bounce.easeOut</option>
			   <option>Circ.easeOut</option><option>Cubic.easeOut</option><option>Expo.easeOut</option>
			   <option>Quad.easeOut</option><option>Quint.easeOut</option><option>Linear.easeNone</option>
			   </select></td><td><select name=\"easingIn1\"><option>" . $config['easingIn1'] . "</option>
			   <option>Elastic.easeOut</option><option>Back.easeOut</option><option>Bounce.easeOut</option>
			   <option>Circ.easeOut</option><option>Cubic.easeOut</option><option>Expo.easeOut</option>
			   <option>Quad.easeOut</option><option>Quint.easeOut</option><option>Linear.easeNone</option>
			   </select></td><td>" . _EASINGINHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _EASINGOUT . "</b></td><td><select name=\"easingOut\"><option>" . $config['easingOut'] . "</option>
			   <option>Elastic.easeOut</option><option>Back.easeOut</option><option>Bounce.easeOut</option>
			   <option>Circ.easeOut</option><option>Cubic.easeOut</option><option>Expo.easeOut</option>
			   <option>Quad.easeOut</option><option>Quint.easeOut</option><option>Linear.easeNone</option>
			   </select></td><td><select name=\"easingOut1\"><option>" . $config['easingOut1'] . "</option>
			   <option>Elastic.easeOut</option><option>Back.easeOut</option><option>Bounce.easeOut</option>
			   <option>Circ.easeOut</option><option>Cubic.easeOut</option><option>Expo.easeOut</option>
			   <option>Quad.easeOut</option><option>Quint.easeOut</option><option>Linear.easeNone</option>
			   </select></td><td>" . _EASINGOUTHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _TRANSTYPE . "</b></td><td><select name=\"transition\"><option>" . $config['transition'] . "</option>
			   <option>Blur</option><option>Alpha</option><option>Rotation Y</option>
			   <option>Rotation X</option></select></td><td><select name=\"transition1\"><option>" . $config['transition1'] . "</option>
			   <option>Blur</option><option>Alpha</option><option>Rotation Y</option>
			   <option>Rotation X</option></select></td><td>" . _TRANSTYPEHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _BLUREFFET . "</b></td><td><input maxlength=\"3\" type=\"text\" style=\"text-align:center\" name=\"blurvalue\" size=\"3\" value=\"" . $config['blurvalue'] . "\" /></td>
			   <td><input maxlength=\"3\" type=\"text\" style=\"text-align:center\" name=\"blurvalue1\" size=\"3\" value=\"" . $config['blurvalue1'] . "\" /></td><td>" . _BLUREFFETHELP . "</td></tr>\n"

			. "<tr><td><b>" . _OPENHTML . "</b></td><td><select name=\"openIn\"><option>" . $config['openIn'] . "</option><option>Self</option><option>New</option></select></td>
			   <td><select name=\"openIn1\"><option>" . $config['openIn1'] . "</option><option>Self</option><option>New</option></select></td><td>" . _OPENHTMLHELP . "</td></tr>\n"
			
			. "<tr><td><b>" . _TEMPS . "</b></td><td><select name=\"speed\"><option>" . $config['speed'] . "</option>
			   <option>500</option><option>750</option><option>1000</option>
			   <option>1250</option><option>1500</option><option>1750</option>
			   <option>2000</option><option>2250</option><option>2500</option>
			   <option>2750</option><option>3000</option><option>3250</option>
			   <option>3500</option><option>3750</option><option>4000</option>
			   <option>4250</option><option>4500</option><option>4750</option>
			   <option>5000</option></select></td>
			   <td><select name=\"speed1\"><option>" . $config['speed1'] . "</option>
			   <option>500</option><option>750</option><option>1000</option>
			   <option>1250</option><option>1500</option><option>1750</option>
			   <option>2000</option><option>2250</option><option>2500</option>
			   <option>2750</option><option>3000</option><option>3250</option>
			   <option>3500</option><option>3750</option><option>4000</option>
			   <option>4250</option><option>4500</option><option>4750</option>
			   <option>5000</option>
			   </select></td><td>" . _TEMPSHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _TWEENTIME . "</b></td><td><select name=\"tweentime\"><option>" . $config['tweentime'] . "</option>
			   <option>1</option><option>2</option><option>3</option>
			   <option>4</option><option>5</option><option>6</option>
			   <option>7</option><option>8</option><option>9</option>
			   </select></td><td><select name=\"tweentime1\"><option>" . $config['tweentime1'] . "</option>
			   <option>1</option><option>2</option><option>3</option>
			   <option>4</option><option>5</option><option>6</option>
			   <option>7</option><option>8</option><option>9</option>
			   </select></td><td>" . _TWEENTIMEHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _TWEENTIMEIN . "</b></td><td><select name=\"tweentimeIn\"><option>" . $config['tweentimeIn'] . "</option>
			   <option>1</option><option>2</option><option>3</option>
			   <option>4</option><option>5</option><option>6</option>
			   <option>7</option><option>8</option><option>9</option>
			   </select></td><td><select name=\"tweentimeIn1\"><option>" . $config['tweentimeIn1'] . "</option>
			   <option>1</option><option>2</option><option>3</option>
			   <option>4</option><option>5</option><option>6</option>
			   <option>7</option><option>8</option><option>9</option>
			   </select></td><td>" . _TWEENTIMEINHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _TAILLETEXTEDESC . "</b></td><td><input maxlength=\"3\" type=\"text\" style=\"text-align:center\" name=\"petitdesc\" size=\"5\" value=\"" . $config['petitdesc'] . "\" /></td>
			   <td><input maxlength=\"3\" type=\"text\" style=\"text-align:center\" name=\"petitdesc1\" size=\"5\" value=\"" . $config['petitdesc1'] . "\" /></td>
			   <td>" . _TAILLETEXTEDESCHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _NOMBREBAN . "</b></td><td><input maxlength=\"3\" type=\"text\" style=\"text-align:center\" name=\"max_partenaire\" size=\"5\" value=\"" . $config['max_partenaire'] . "\" /></td>
			   <td><input maxlength=\"3\" type=\"text\" style=\"text-align:center\" name=\"max_partenaire1\" size=\"5\" value=\"" . $config['max_partenaire1'] . "\" /></td>
			   <td>" . _NOMBREBANHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _MYLOGO . "</b></td><td colspan=\"2\"><input type=\"text\" style=\"text-align:center\" name=\"votrelogo460\" size=\"55\" value=\"" . $config['votrelogo460'] . "\" /></td>
			   <td>" . _MYLOGOHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _MYLOGO1 . "</b></td><td colspan=\"2\"><input type=\"text\" style=\"text-align:center\" name=\"votrelogo80\" size=\"55\" value=\"" . $config['votrelogo80'] . "\" /></td>
			   <td>" . _MYLOGOHELP1 . "</td></tr>\n"
			   
			. "<tr><td align=\"center\"><input type=\"submit\" id=\"btmvalide\"  value=\"" . _MODIFPREF . "\" /></td></tr>\n"
			. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Partenaire&page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
		}
		
		function valide($id)
		{
        global $nuked;
		
        $sql = mysql_query("UPDATE ". $nuked["prefix"] ."_partenaire SET `valide` = '"._OUI."' WHERE id=". mysql_real_escape_string($id) ." ");
		
		 echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _VALIDSENDOK . "\n"
			. "</div>\n"
			. "</div>\n";
                
		redirect("index.php?file=Partenaire&page=admin",2);
		
		}

		function nonvalide($id)
		{
        global $nuked;
		
        $sql = mysql_query("UPDATE ". $nuked["prefix"] ."_partenaire SET `valide` = '"._NON."' WHERE id=". mysql_real_escape_string($id) ." ");
		
		 echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _VALIDSENDNOK . "\n"
			. "</div>\n"
			. "</div>\n";
                
		redirect("index.php?file=Partenaire&page=admin",2);
		
		}

		function send_pref()
		{
        global $nuked, $user;
		
        if ($_REQUEST['taille1'] != "Oui") $_REQUEST['taille1'] = "Non";
        if ($_REQUEST['taille2'] != "Oui") $_REQUEST['taille2'] = "Non";
		if ($_REQUEST['upload'] != "On") $_REQUEST['upload'] = "Off";

        $sql = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
        while (list($sql_nom, $sql_valeur) = mysql_fetch_array($sql))
        {		
            $default_config[$sql_nom] = $sql_valeur;
            $new[$sql_nom] = (isset($_REQUEST[$sql_nom])) ? $_REQUEST[$sql_nom] : $default_config[$sql_nom];
            $new_value = mysql_real_escape_string(stripslashes($new[$sql_nom]));
            $upd = mysql_query("UPDATE ". $nuked['prefix'] ."_partenaire_config SET valeur = '" . $new_value . "' WHERE nom = '" . $sql_nom . "'");
        }
		
		 echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _PREFSENDOK . "\n"
			. "</div>\n"
			. "</div>\n";
                
		redirect("index.php?file=Partenaire&page=admin",2);
		
		}
		
		function add()
	    {
        global $nuked, $user;
		
		$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
	    while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
	    unset($sql_config, $row);
				
		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINPARTENAIRE . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/theme.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<a href=\"index.php?file=Partenaire&page=admin\">" . _ADMINVALID . "</a> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=attente\">" . _ADMINAVALIDE . "</a> | "
			. "<b>" . _ADD . "</b> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=pref\">" . _CONFIG . "</a></b><br /><br />\n";
			
		 echo "<form method=\"post\" action=\"index.php?file=Partenaire&amp;page=admin&amp;op=send_add\" enctype=\"multipart/form-data\" onsubmit=\"backslash('desc_texte');\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			
			. "<tr><td width=\"15%\"><b>" . _NOM . "</b></td><td width=\"15%\">
			   <input type=\"text\" style=\"text-align:center\" maxlength=\"20\" name=\"site\" size=\"35\" value=\"\" /></td>
			   <td>" . _NOMHELP . "</td></tr>\n"
			   
			. "<tr><td width=\"15%\"><b>" . _WEB . "</b></td><td width=\"15%\">
			   <input type=\"text\" maxlength=\"35\" name=\"liens\" size=\"35\" value=\"http://\" /></td>
			   <td>" . _WEBHELP . "</td></tr>\n"
			   
			. "<tr><td width=\"15%\"><b>" . _WEBMASTER . "</b></td><td width=\"15%\">
			   <input type=\"text\" style=\"text-align:center\" maxlength=\"20\" name=\"author\" size=\"35\" value=\"\" /></td>
			   <td>" . _WEBMASTERHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _LOGOPART . " :</b></td><td><input type=\"text\" name=\"linklogo\" size=\"35\" value=\"http://\" /></td></tr>\n";
		 if ($config['upload'] == On)
		 {
		 echo "<tr><td><b>" . _UPLOGO . " :</b></td><td><input type=\"file\" name=\"logosup\" /></td><td><input class=\"checkbox\" type=\"checkbox\" name=\"effacer_logo\" value=\"1\" checked/> " . _REPLACE . "</td></tr>\n";
		 }

		 echo "<tr><td><b>" . _LOGOPART1 . " :</b></td><td><input type=\"text\" name=\"linklogo1\" size=\"35\" value=\"http://\" /></td></tr>\n";
		 if ($config['upload'] == On)
		 {
		 echo "<tr><td><b>" . _UPLOGO . " :</b></td><td><input type=\"file\" name=\"logosup1\" /></td><td><input class=\"checkbox\" type=\"checkbox\" name=\"effacer_logo1\" value=\"1\" checked/> " . _REPLACE . "</td></tr>\n";
		 }
			   
		 echo "<tr><td><b>" . _DESCRSIMPLE . " :</b></td><td><input type=\"text\" name=\"petitdesc\" size=\"35\" maxlength=\"".$config['petitdesc']."\" value=\"\" /></td>
			<td>" . _DESCRSIMPLEHELP . "</td></tr>\n"

			. "<tr><td><b>" . _DESCR . "</b></td>"
            . "<td colspan=\"2\"><textarea class=\"editor\" name=\"description\" cols=\"30\" rows=\"10\"onselect=\"storeCaret('desc_texte');\" onclick=\"storeCaret('desc_texte');\" onkeyup=\"storeCaret('desc_texte');\"></textarea></td></tr>\n"
			   
			. "<tr><td align=\"center\"><input type=\"submit\" value=\"" . _ADDPART . "\" /></td></tr>\n"
			. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Partenaire&page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
		}

		function send_add($site, $liens, $author, $linklogo, $logosup, $effacer_logo, $linklogo1, $logosup1, $effacer_logo1, $petitdesc, $description)
	    {
		 global $nuked, $user;

		 $description = html_entity_decode($description);
		 $description = mysql_real_escape_string(stripslashes($description));
		 ($linklogo === "http://") ? $linklogo = "" : $linklogo;
		 ($linklogo1 === "http://") ? $linklogo1 = "" : $linklogo1;
		 ($liens === "http://") ? $liens = "" : $liens;
		 $author = mysql_real_escape_string(stripslashes($author));
		 $date = time();

		 if (empty($liens)) 
		 {
		 echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. "" . _NOTIFFAILURL . "\n"
			. "</div>\n"
			. "</div>\n";
			redirect("index.php?file=Partenaire&page=admin&op=add",2);
		 }
		 if (empty($site)) 
		 {
		 echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. "" . _NOTIFFAILNOM . "\n"
			. "</div>\n"
			. "</div>\n";
			redirect("index.php?file=Partenaire&page=admin&op=add",2);
		 }
		 
		 if (empty($_FILES['logosup']['name']) XOR ($linklogo)) 
		 {
		 echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. "" . _NOTIFFAILLOGO . "\n"
			. "</div>\n"
			. "</div>\n";
			redirect("index.php?file=Partenaire&page=admin&op=add",2);
		 }
		 else
		 {
		$dossier = "upload/Partenaire/";
		
		if ($_FILES['logosup']['name'] != "") {
			$screenname = $_FILES['logosup']['name'];
			$ext = pathinfo($_FILES['logosup']['name'], PATHINFO_EXTENSION);
			$filename2 = str_replace($ext, "", $screenname);
			$url_logo = $dossier . $filename2 . $ext;

			if (!is_file($url_logo) || $effacer_logo == 1) {
				if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
					move_uploaded_file($_FILES['logosup']['tmp_name'], $url_logo) or die ("" . FAILEDUP . "");
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
						
		 $sql = mysql_query("INSERT INTO ". $nuked['prefix'] ."_partenaire ( `id`, `author`, `logo460`, `logo80`, `site`, `date`, `description`, `liens`, `valide`, `petitdesc` ) VALUES ( '' , '" . $author . "' , '" . $linklogo . "' , '" . $linklogo1 . "' , '" . $site . "' , '" . $date . "' , '" . $description . "' , '" . $liens . "' , 'Oui', '" . $petitdesc ."')");
			 
		 $texteaction = "". _PARTSEND ."" . $site . "";
		 $acdate = time();
		 $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		 
	    echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _NOTIFSEND . "\n"
			. "</div>\n"
			. "</div>\n";
			
			redirect("index.php?file=Partenaire&page=admin",2);
	     }
		}

		function edit_part($id)
	    {
        global $nuked, $user;
		
		$description = html_entity_decode($description);
		$description = mysql_real_escape_string(stripslashes($description));
		
		$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
	    while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
	    unset($sql_config, $row);
		
		$sql = mysql_query("SELECT id, author, logo460, logo80, site, description, liens, petitdesc FROM ". $nuked['prefix'] ."_partenaire WHERE id = '" . $id . "'");
		list($id, $author, $logo460, $logo80, $site, $description, $liens, $petitdesc) = mysql_fetch_array($sql);
				
		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINPARTENAIRE . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/theme.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
			. "<a href=\"index.php?file=Partenaire&page=admin\">" . _ADMINVALID . "</a> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=attente\">" . _ADMINAVALIDE . "</a> | "
			. "<b>" . _ADD . "</b> | "
			. "<a href=\"index.php?file=Partenaire&amp;page=admin&amp;op=pref\">" . _CONFIG . "</a></b><br /><br />\n";
			
		 echo "<form method=\"post\" action=\"index.php?file=Partenaire&amp;page=admin&amp;op=send_edit\" enctype=\"multipart/form-data\" onsubmit=\"backslash('desc_texte');\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			
			. "<tr><td width=\"15%\"><b>" . _NOM . "</b></td><td width=\"15%\">
			   <input type=\"text\" style=\"text-align:center\" maxlength=\"20\" name=\"site\" size=\"35\" value=\"". $site ."\" /></td>
			   <td>" . _NOMHELP . "</td></tr>\n"
			   
			. "<tr><td width=\"15%\"><b>" . _WEB . "</b></td><td width=\"15%\">
			   <input type=\"text\" maxlength=\"35\" name=\"liens\" size=\"35\" value=\"". $liens ."\" /></td>
			   <td>" . _WEBHELP . "</td></tr>\n"
			   
			. "<tr><td width=\"15%\"><b>" . _WEBMASTER . "</b></td><td width=\"15%\">
			   <input type=\"text\" style=\"text-align:center\" maxlength=\"20\" name=\"author\" size=\"35\" value=\"". $author ."\" /></td>
			   <td>" . _WEBMASTERHELP . "</td></tr>\n"
			   
			. "<tr><td><b>" . _LOGOPART . " :</b></td><td><input type=\"text\" name=\"linklogo\" size=\"35\" value=\"". $logo460 ."\" /></td></tr>\n";
		 if ($config['upload'] == On)
		 {
		 echo "<tr><td><b>" . _UPLOGO . " :</b></td><td><input type=\"file\" name=\"logosup\" /></td></tr>\n";
		 }	   
		 echo "<tr><td><b>" . _LOGOPART1 . " :</b></td><td><input type=\"text\" name=\"linklogo1\" size=\"35\" value=\"". $logo80 ."\" /></td></tr>\n";
		 if ($config['upload'] == On)
		 {
		 echo "<tr><td><b>" . _UPLOGO1 . " :</b></td><td><input type=\"file\" name=\"logosup1\" /></td></tr>\n";	   
		 }	   
		 echo "<tr><td><b>" . _DESCRSIMPLE . " :</b></td><td><input type=\"text\" name=\"petitdesc\" size=\"35\" maxlength=\"".$config['petitdesc']."\" value=\"". $petitdesc ."\" /></td>
			<td>" . _DESCRSIMPLEHELP . "</td></tr>\n"

			. "<tr><td><b>" . _DESCR . "</b></td>"
            . "<td colspan=\"2\"><textarea class=\"editor\" name=\"description\" cols=\"30\" rows=\"10\" onselect=\"storeCaret('desc_texte');\" onclick=\"storeCaret('desc_texte');\" onkeyup=\"storeCaret('desc_texte');\">". $description ."</textarea></td></tr>\n"
			   
			. "<tr><td align=\"center\"><input type=\"hidden\" name=\"id\" value=\"" . $id . "\" /><input type=\"submit\" value=\"" . _MODIFPART . "\" /></td></tr>\n"
			. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Partenaire&page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
		}
		function send_edit($id, $site, $liens, $author, $linklogo, $logosup, $linklogo1, $logosup1, $petitdesc, $description)
	    {
		 global $nuked, $user;
		 


		 $description = html_entity_decode($description);
		 $description = mysql_real_escape_string(stripslashes($description));
		 ($linklogo === "http://") ? $linklogo = "" : $linklogo;
		 ($linklogo1 === "http://") ? $linklogo1 = "" : $linklogo1;
		 ($liens === "http://") ? $liens = "" : $liens;
		 
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
					redirect("index.php?file=Partenaire&page=admin&op=add", 2);
					adminfoot();
					footer();
					die;
				}
			} 

			$url_full_logo = $url_logo;
			$linklogo = $url_full_logo;
		}
		
		if ($_FILES['logosup1']['name'] != "") {
			$screenname = $_FILES['logosup1']['name'];
			$ext = pathinfo($_FILES['logosup1']['name'], PATHINFO_EXTENSION);
			$filename2 = str_replace($ext, "", $screenname);
			$url_logo1 = $dossier . $filename2 . $ext;

			if (!is_file($url_logo)) {
				if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
					move_uploaded_file($_FILES['logosup1']['tmp_name'], $url_logo1) or die ("" . FAILEDUP . "");
					@chmod ($url_logo1, 0644);
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
		
        $sql = mysql_query("UPDATE ". $nuked["prefix"] ."_partenaire SET `author` = '".$author."', `logo460` = '".$linklogo."', `logo80` = '".$linklogo1."', `site` = '".$site."', `description` = '".$description."', `liens` = '".$liens."', `petitdesc` = '".$petitdesc."' WHERE id=". mysql_real_escape_string($id) ." ");

		 $texteaction = "". _PARTMODIF ."" . $site . "";
		 $acdate = time();
		 $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		 
	    echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _NOTIFSEND . "\n"
			. "</div>\n"
			. "</div>\n";
			
			redirect("index.php?file=Partenaire&page=admin",2);
	     }

    function del_part($id)
	{
        global $nuked, $user;
		
		$sql = mysql_query("SELECT site FROM ". $nuked['prefix'] ."_partenaire WHERE id = '" . $id . "'");
        list($var1) = mysql_fetch_array($sql);

		$date = nkDate($date);
        $del = mysql_query("DELETE FROM ". $nuked['prefix'] ."_partenaire WHERE id = '" . $id . "'");

        $texteaction = "". _ACTIONDELPART ."". $var1 .".";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");

        echo "<div class=\"notification success png_bg\">\n"
                . "<div>\n"
                . "" . _PARTDELOK . "\n"
                . "</div>\n"
                . "</div>\n";
                
			redirect("index.php?file=Partenaire&page=admin",2);
		}
    function maj()
    {
        $fichier = "http://www.palacewar.eu/Nuked-Klan/miseajour.xml";
		$lienscreate = @fopen("".$fichier."", "r");
		if ($lienscreate == false ){} else 
		{$fichier = "http://www.palacewar.eu/Nuked-Klan/miseajour.xml";
		$dom = new DOMDocument();
		if (!$dom->load($fichier)) {}
		$itemList = $dom->getElementsByTagName('item');
		foreach ($itemList as $item) {
		$version = $item->getElementsByTagName('version');
        echo $version->item(0)->nodeValue; }
}
    }
    switch ($_REQUEST['op']){

		    case "main":
            main();
            break;
			
		    case "attente":
            attente();
            break;
			
		    case "pref":
            pref();
            break;
			
			case "send_pref":
            send_pref($_POST);
            break;		

			case "add":
            add();
            break;
			
			case "valide":
            valide($_REQUEST['id']);
            break;
			
			case "edit_part":
            edit_part($_REQUEST['id']);
            break;
			
			case "nonvalide":
            nonvalide($_REQUEST['id']);
            break;
			
			case "send_add":
            send_add($_REQUEST['site'], $_REQUEST['liens'], $_REQUEST['author'], $_REQUEST['linklogo'], $_REQUEST['logosup'], $_REQUEST['effacer_logo'], $_REQUEST['linklogo1'], $_REQUEST['logosup1'], $_REQUEST['effacer_logo1'], $_REQUEST['petitdesc'], $_REQUEST['description']);
            break;

			case "send_edit":
		    send_edit($_REQUEST['id'], $_REQUEST['site'], $_REQUEST['liens'], $_REQUEST['author'], $_REQUEST['linklogo'], $_REQUEST['logosup'], $_REQUEST['linklogo1'], $_REQUEST['logosup1'] , $_REQUEST['petitdesc'], $_REQUEST['description']);     
            break;
			
			case "del_part":
            del_part($_REQUEST['id']);
            break;
			
	        default:
            main();
            break;
    }
}
else if ($level_admin == -1){
    echo "<div class=\"notification error png_bg\">\n"
			. "<div>\n"
			. "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
			. "</div>\n"
			. "</div>\n";
}
else if ($visiteur > 1){
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