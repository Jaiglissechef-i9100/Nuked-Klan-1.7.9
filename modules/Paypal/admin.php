<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// Module Dons Paypal Pour NK 1.7.9 RC6                                     //
// Créer par Stive @ PalaceWaR.eu                                           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $user, $language;
translate("modules/Paypal/lang/" . $language . ".lang.php");
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
    function main()
	{
        global $nuked, $language;
		
             echo "<div class=\"content-box\">\n"
				. "<div class=\"content-box-header\"><h3>" . _ADMINPAYPAL . "</h3>\n"
				. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Paypal.php\" rel=\"modal\">\n"
				. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
				. "</div></div>\n"
				. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b>" . _OPPDONS . " </b>| "
				. "<a href=\"index.php?file=Paypal&amp;page=admin&amp;op=oppbloc\">" . _OPPBLOCK . "</a> |  "
				. "<a href=\"index.php?file=Paypal&amp;page=admin&amp;op=message\">" . _MESSA . "</a> |  "
				. "<a href=\"index.php?file=Paypal&amp;page=admin&amp;op=flash\">" . _FlASH . "</a> |
				   <a href=\"javascript:del();\" style=\"color:#F00\" >". _1DELETE."</a></div><br />\n";
				
				
		$sql2 = mysql_query("SELECT email, nom, montantdons, logo, affiche, cible, copy FROM ". $nuked['prefix'] ."_paypal");
		list($email, $nom, $montantdons, $logo, $affiche, $cible, $copy) = mysql_fetch_array($sql2);
		
		$req = mysql_query("SELECT COUNT(*), SUM(montant) FROM ". $nuked['prefix'] ."_paypal_accepte ");
		list($count, $somme) = mysql_fetch_array($req);
		
		$sql3 = mysql_query("SELECT var3, var2, var5, var4, var8, var6, var7, flaw, flah FROM ". $nuked['prefix'] ."_paypal_flash");
		list($var3, $var2, $var5, $var4, $var8, $var6, $var7, $flaw, $flah) = mysql_fetch_array($sql3);

		$demande	= $montantdons;
		$recu       = $somme;
		$verif      = strlen($copy);
	
		if ($somme =='')
		{ $recu = 0;
		}
		if ($montantdons =='')
		{
		$pourcent = 0;
		$pourcent100 = 0;
		}
		elseif ($montantdons =='0')
		{ 
		$pourcent = 0;
		$pourcent100 = 0;
		}
		else
		{
		$pourcent   = round(($recu/$demande)*100,2);
		$pourcent100   = round(($recu/$demande)*100);
		}
		
		$var1         = $pourcent100;

		if ($affiche =='Simple')
		{
		echo  " <center>\n";
		    if ($cible =='oui')
			{
		 echo " <table width=\"60%\">\n"
            . " <tr><td width=\"55%\">Cible :</td><td style=\"text-align:right\">" . $demande . " &#8364;</td></tr>\n"
            . " <tr><td>Dons acquis :</td><td style=\"text-align:right\">" . $recu . " &#8364;</td></tr>\n"
            . " </table>\n";
			}
         echo " <table style=\"border:none; width:60%;\">\n"
			. " <body>\n" 
			. " <tr><td style=\"padding: 0px; background-image: url(modules/Paypal/img/barrebg.gif); background-repeat: repeat-x;\">\n"
			. " <img src=\"modules/Paypal/img/barre".($pourcent > 66 ? "vert" : ($pourcent > 33 ? "jaune" : "rouge")).".gif\" alt=\"bargraph\" style=\"height: 15px; width:".$pourcent100."%\" />\n" 
			. " <br />\n"
			. " <p style=\"text-align: center;\">".$pourcent."%</p>\n" 
			. " </td>\n"
			. " </tr>\n"
			. " </body>\n" 
			. " </table></center>\n";
			}
			elseif ($affiche =='Flash')
			{
				$sql4 = mysql_query("SELECT flash FROM ". $nuked['prefix'] ."_paypal");
		        list($flash) = mysql_fetch_array($sql4);			
            if ($flash =='flash1')
			{
			if ($cible =='oui')
			{
		 echo " <center><table width=\"60%\">\n"
            . " <tr><td width=\"55%\">" . _CIBLEA . "</td><td style=\"text-align:right\">" . $demande . " &#8364;</td></tr>\n"
            . " <tr><td>" . _DONA. "</td><td style=\"text-align:right\">" . $recu . " &#8364;</td></tr>\n"
            . " </table></center>\n";
			}
			include("modules/Paypal/flash/barre1.php");
			}
			elseif ($flash =='flash2')
			{
			if ($cible =='oui')
			{
		 echo " <center><table width=\"60%\">\n"
            . " <tr><td width=\"55%\">" . _CIBLEA . "</td><td style=\"text-align:right\">" . $demande . " &#8364;</td></tr>\n"
            . " <tr><td>" . _DONA. "</td><td style=\"text-align:right\">" . $recu . " &#8364;</td></tr>\n"
            . " </table></center>\n";
			}
			include("modules/Paypal/flash/barre2.php");
			}
			elseif ($flash =='flash3')
			{
			if ($cible =='oui')
			{
		 echo " <center><table width=\"60%\">\n"
            . " <tr><td width=\"55%\">" . _CIBLEA . "</td><td style=\"text-align:right\">" . $demande . " &#8364;</td></tr>\n"
            . " <tr><td>" . _DONA. "</td><td style=\"text-align:right\">" . $recu . " &#8364;</td></tr>\n"
            . " </table></center>\n";
			}
			include("modules/Paypal/flash/barre3.php");
			}
			elseif ($flash =='flash4')
			{
			if ($cible =='oui')
			{
		 echo " <center><table width=\"60%\">\n"
            . " <tr><td width=\"55%\">" . _CIBLEA . "</td><td style=\"text-align:right\">" . $demande . " &#8364;</td></tr>\n"
            . " <tr><td>" . _DONA. "</td><td style=\"text-align:right\">" . $recu . " &#8364;</td></tr>\n"
            . " </table></center>\n";
			}
			include("modules/Paypal/flash/barre4.php");
			}	
			}
			elseif ($affiche =='Aucun')
			{			if ($cible =='oui')
			{
		 echo " <center><table width=\"60%\">\n"
            . " <tr><td width=\"55%\">" . _CIBLEA . "</td><td style=\"text-align:right\">" . $demande . " &#8364;</td></tr>\n"
            . " <tr><td>" . _DONA. "</td><td style=\"text-align:right\">" . $recu . " &#8364;</td></tr>\n"
            . " </table></center>\n";
			}}
	
        echo  "<form id=\"BlocPayPalJS\" style=\"display:none\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" onsubmit=\"return VerifMontantBloc();\">\n"
		    . "<form id=\"BlocPayPalJS\" style=\"display:none\" action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\" onsubmit=\"return VerifMontantBloc();\">\n"
        	. "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />\n"
		   	. "<input type=\"hidden\" name=\"business\" value=\"". $email ."\" />\n"
		   	. "<input type=\"hidden\" name=\"item_name\" value=\"". $nom  ."\" />\n"
		   	. "<input type=\"hidden\" name=\"currency_code\" value=\"EUR\" />\n"
		    . "<input type=\"hidden\" name=\"tax\" value=\"0\" />\n"
			. "<input name=\"notify_url\" type=\"hidden\" value=\"" . $nuked[url] . "/index.php?file=Paypal&page=mysql\" />\n"
		    . "<input type=\"hidden\" name=\"bn\" value=\"IC_Sample\" />\n";
			
			
		if ($user[2])
		{
		echo   " <input type=\"hidden\" name=\"on0\" value=\"" . $user[2] . "\" />
			     <input name=\"custom\" type=\"hidden\" value=\"" . $user[0] . "\" />\n";
		}
		else
		{
		echo  " <input type=\"hidden\" name=\"on0\" value=\"Anonyme\" />\n";
		}
		echo  " <input type=\"hidden\" name=\"return\" value=\"" . $nuked[url] . "/index.php?file=Paypal&page=ok\" />
			    <input type=\"hidden\" name=\"cancel\" value=\"" . $nuked[url] . "/index.php?file=Paypal&page=ko\" />
			    <p style=\"text-align:center;\">
			    <input type=\"text\" id=\"BlocAmount\" name=\"amount\" disabled=\"disabled\" size=\"6\" value=\"0\" onmouseover=\"if(this.value==0)this.value=\'\';\" onmouseout=\"if(this.value==\'\' || this.value==0)this.value=0;\" />&euro;<br />
			    <br />
			    <input type=\"image\" src=\"" . $logo . "\" style=\"border: none;\" name=\"submit\" alt=\"PayPal - Dons !\" />
			    </p>
			    </form>
			    <div id=\"BlocPayPalNoJS\" style=\"display:block;font-weight:bold;margin:20px auto\">Veuillez activer le javascript.<br />Merci.</div>
		        </center>
		        
				<script type=\"text/javascript\">
				document.getElementById(\"BlocPayPalNoJS\").style.display = \"none\";
				document.getElementById(\"BlocPayPalJS\").style.display = \"block\"
				function VerifMontantBloc()
			{
				var ElId = document.getElementById(\"BlocAmount\").value;
				var reg = new RegExp(\"^[0-9]+$\");
				var test = reg.test(ElId);
				if(!test)
			{ 
				alert(\"" . _ALERT1 . "e\"); 
				return false;
			}
else
			{
				if(ElId==0)
			{
				alert(\"" . _NODONS . "\");
				return false;
			}
else
				return true;
			}
			}
				</script>
				<hr />\n";
			
			 echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 25%;\" align=\"center\"><b>" . _NICK . "</b></td>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _MONTANT . "</b></td>\n"
			. "<td style=\"width: 25%;\" align=\"center\"><b>" . _DATE . "</b></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";	
			
			 $sql = mysql_query("SELECT id, autor, autor_id, date, montant FROM ". $nuked['prefix'] ."_paypal_accepte ORDER BY id");
		while (list($id, $auteur, $autor_id, $date, $montant) = mysql_fetch_row($sql)) {
			
			
            $date = nkDate($date);
            $auteur = htmlspecialchars($auteur);

            if($autor_id != "")
			
			{
                $sql_member = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $autor_id . "'");
                $test = mysql_num_rows($sql_member);
            }

            if($autor_id != "" && $test > 0)
			
			{
                list($autor) = mysql_fetch_array($sql_member);
            }
			
            else
			{
                $autor = $auteur;
            }

			
            echo "<tr><td style=\"width: 25%;\" align=\"center\">" . $autor . "</td>
			      <td style=\"width: 25%;\" align=\"center\">" . $montant . " &#8364;</td>
				  <td style=\"width: 20%;\"align=\"center\">" . $date . "</td>
				  <td style=\"width: 15%;\" align=\"center\">
			      <img style=\"border: 0;\" src=\"modules/Paypal/img/edit.gif\" alt=\"\" /></a></td>
				  <td style=\"width: 15%;\" align=\"center\"><img style=\"border: 0;\" src=\"modules/Paypal/img/del.gif\" alt=\"\" /></a></td></tr>\n"; 
				  
					
		  }
			echo "</table>\n"
			
				. "<div style=\"margin: 12px\">\n"
			    . "<div class=\"notification information png_bg\">\n"
	            . " <a onclick=\"del();return false\" href=\"#\" class=\"close\">\n"
			    . "<img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Close this notification\" alt=\"close\"></a><div>" ._INFO1. "</div></div>\n"
                . " </div>\n";

				  
			echo "<div class=\"copyrightpaypal\">" . $copy . "</div>
			<style type=\"text/css\">
			.copyrightpaypal { position: relative; top: 99%; left: 99%; color: #000;} 
			</style>\n";
				
		     echo "<script type=\"text/javascript\">\n"
				. "<!--\n"
				. "\n"
				. "function del()\n"
				. "{\n"
				. "if (confirm('" . _DELETE . "'))\n"
				. "{document.location.href = 'index.php?file=Paypal&page=admin&op=del';}\n"
				. "}\n"
				. "\n"
				. "// -->\n"
				. "</script>\n";
						
		  }
		  
	
	function logo()
	{
			$dir = 'modules/Paypal/img/boutons/';
			$valide_extensions = array('jpg', 'jpeg', 'gif', 'png');
			$Ressource = opendir($dir);
			while($fichier = readdir($Ressource))
			  {
			$berk = array('.', '..');
		
			$dirlogo = $dir.$fichier;
			
			$idcorrige = ''. $dirlogo .'';
			$idcorrige = str_replace('modules/Paypal/img/boutons/' ,'logo - ',$idcorrige);
	
			if(!in_array($fichier, $berk) && !is_dir($test_Fichier))
		{
			$ext = pathinfo($fichier,  PATHINFO_EXTENSION);
	
			if(in_array($ext, $valide_extensions))
			{
	echo '<option value='. $dirlogo .'>'. $idcorrige .'</option>'."\n";
			}
			  }
		}
	}
	
	function oppbloc()
		  {
	global $nuked, $language;

				$sql = mysql_query("SELECT email, nom, montantdons, logo, affiche, flash, cible FROM ". $nuked['prefix'] ."_paypal");
				list($email, $nom, $montantdons, $logo, $affiche, $flash, $cible) = mysql_fetch_array($sql);
				
				$req = mysql_query("SELECT COUNT(*), SUM(montant) FROM ". $nuked['prefix'] ."_paypal_accepte ");
				list($count, $somme) = mysql_fetch_array($req);
				
			echo "<div class=\"content-box\">\n"
				. "<div class=\"content-box-header\"><h3>" . _ADMINPAYPAL . "</h3>\n"
				. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Paypal.php\" rel=\"modal\">\n"
				. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
				. "</div></div>\n"
				. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><a href=\"index.php?file=Paypal&amp;page=admin&amp;op=main\">" . _OPPDONS . "</a> | "
				. "<b>" . _OPPBLOCK . "</b> | <a href=\"index.php?file=Paypal&amp;page=admin&amp;op=message\">" . _MESSA . "</a> | "
				. "<a href=\"index.php?file=Paypal&amp;page=admin&amp;op=flash\">" . _FlASH . "</a> | "
				. "<a href=\"javascript:del();\" style=\"color:#F00\" >". _1DELETE."</a>"
				
				. "<form method=\"post\" action=\"index.php?file=Paypal&amp;page=admin&amp;op=send_paypal\" enctype=\"multipart/form-data\" onsubmit=\"backslash('opp_texte');\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
				
				. "<tr><td width=\"15%\"><b>" . _EMAIL . "</b></td><td><input type=\"text\" name=\"email\" size=\"40\" value=\"" . $email . "\" /></td></tr>\n"
				. "<tr><td><b>" . _NOM . " </b></td><td><input type=\"text\" name=\"nom\" size=\"40\" value=\"" . $nom . "\"/></td></tr>\n"
				. "<tr><td><b>" . _MONTANTDESDONS . " </b></td><td><input type=\"text\" value=\"" . $montantdons . "\" name=\"montantdons\" size=\"5\" /> - &#8364;</td></tr>\n"
				. "<tr><td><b>" . _MONTANTRECOLTE . " </b></td><td><input type=\"text\" disabled size=\"5\" value=\"". $somme. "\" /> - &#8364;</td></tr>\n"
				. "<tr><td><b>" . _CIBLE . " </b></td><td><select name=\"cible\"><option>oui</option><option>non</option></select></td></tr>\n"
				. "<tr><td><b>" . _AFFICHE . " </b></td><td><select name=\"affiche\"><option>Flash</option><option>Simple</option><option>Aucun</option></select></td></tr>\n"
				. "<tr><td>\n"
					
		        . "<form name=\"logo\">\n";
			
		  if ($logo =='')
		  {
			  echo "<select name=\"logo\" onchange=\"document.getElementById('logovide').src=this.value;\">\n";
		  }
		  else
		  {
			  echo "<select name=\"logo\" onchange=\"document.getElementById('". $logo . "').src=this.value;\">\n";
		  }
		  
				logo();
				
		      echo "</select>\n";
		  if ($logo =='')
		  {
		      echo "</td><td><img id=\"logovide\" src=\"images/loading.gif\">\n";
		  }
		  else
		  {
			  echo "</td><td><img id=\"".$logo."\" src=\"".$logo."\">\n";
		  }
		      echo "</td></tr><tr><td align=\"center\">\n"
				
                . "<tr><td><b>" . _CHOIXFLASH . " </b></td><td>\n"
                . " <label><input type=\"radio\" name=\"flash\" value=\"flash1\"/>\n"
				. " <a href=\"/modules/Paypal/flash/barre1_img.php\" rel=\"modal\">" . _BARRE1 . "\n"
				. " <img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _BARRE1 . "\" /></a></label>\n"

                . " <label><input type=\"radio\" name=\"flash\" value=\"flash2\"/>\n"
				. " <a href=\"/modules/Paypal/flash/barre2_img.php\" rel=\"modal\">" . _BARRE2 . "\n"
				. " <img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _BARRE2 . "\" /></a></label>\n"
				
			    . " <label><input type=\"radio\" name=\"flash\" value=\"flash3\"/>\n"
				. " <a href=\"/modules/Paypal/flash/barre3_img.php\" rel=\"modal\">" . _BARRE3 . "\n"
				. " <img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _BARRE3 . "\" /></a></label>\n"
				
				. " <label><input type=\"radio\" name=\"flash\" value=\"flash4\"/>\n"
				. " <a href=\"/modules/Paypal/flash/barre4_img.php\" rel=\"modal\">" . _BARRE4 . "\n"
				. " <img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _BARRE4 . "\" /></a></label>\n"
				
				. "<div style=\"margin: 12px\">\n"
			    . "<div class=\"notification attention png_bg\">\n"
	            . " <a href=\"#\" class=\"close\">\n"
			    . "<img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Close this notification\" alt=\"close\"></a><div>" ._INFO2. "</div></div>\n"
                . " </div>\n"
				
				. "<tr><td align=\"center\"><input type=\"submit\" value=\"" . _ADDTHISFILE . "\" /></td></tr>\n"
				. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Paypal&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";

			echo "<script type=\"text/javascript\">\n"
				. "<!--\n"
				. "\n"
				. "function del()\n"
				. "{\n"
				. "if (confirm('" . _DELETE . "'))\n"
				. "{document.location.href = 'index.php?file=Paypal&page=admin&op=del';}\n"
				. "}\n"
				. "\n"
				. "// -->\n"
				. "</script>\n";
	}
	
	function send_paypal($email, $nom, $montantdons, $logo, $affiche, $flash, $cible) {
		
		global $nuked, $user;
		
				$sql = mysql_query("UPDATE $nuked[prefix]_paypal SET email='$email', nom='$nom', montantdons='$montantdons', logo='$logo', affiche='$affiche', flash='$flash', cible='$cible' WHERE id='1'");
				
				$description = html_entity_decode($description);
				$description = mysql_real_escape_string(stripslashes($description));
			
				$texteaction = "". _ACTIONADDPAYPAL ."".$titre."". _ACTIONADDPAYPAL2 ."";
				$acdate = time();
				$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
				echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _MODIFPAYPAL . "\n"
				. "</div>\n"
				. "</div>\n";
				redirect("index.php?file=Paypal&page=admin",2);
		
		}

	function message()
	{
		  global $nuked, $language, $user;
	      $sql = mysql_query("SELECT ok, ko FROM ". $nuked['prefix'] ."_paypal");
		  list($ok, $ko) = mysql_fetch_array($sql);
	
	             echo "<div class=\"content-box\">\n"
				. "<div class=\"content-box-header\"><h3>" . _ADMINPAYPAL . "</h3>\n"
				. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Paypal_variable.php\" rel=\"modal\">\n"
				. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
				. "</div></div>\n"
				. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
				. "<div style=\"text-align: center;\"><a href=\"index.php?file=Paypal&amp;page=admin&amp;op=main\">" . _OPPDONS . "</a> | "
				. "<a href=\"index.php?file=Paypal&amp;page=admin&amp;op=oppbloc\">" . _OPPBLOCK . "</a></b> |  "
				. "<b>" . _MESSA . "</b> | "
				. "<a href=\"index.php?file=Paypal&amp;page=admin&amp;op=flash\">" . _FlASH . "</a> | "
				. "<a href=\"javascript:del();\" style=\"color:#F00\" >". _1DELETE."</a></b></div><br />\n"
				
			    . "<form method=\"post\" action=\"index.php?file=Paypal&amp;page=admin&amp;op=send_message\" enctype=\"multipart/form-data\" onsubmit=\"backslash('ok_texte');backslash('ko_texte');\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
				
				. "<tr><td align=\"center\"><b>" . _DESCROK . " :</b><br />\n"
				. "<textarea class=\"editor\" id=\"ok_texte\" name=\"ok\" rows=\"10\" cols=\"65\" 
				onselect=\"storeCaret('ok_texte');\" onclick=\"storeCaret('ok_texte');\" onkeyup=\"storeCaret('ok_texte');\">" . $ok . "</textarea></td></tr>\n";
				
				echo "<tr><td align=\"center\"><b>" . _DESCRKO . " :</b><br />\n"
				. "<textarea class=\"editor\" id=\"ko_texte\" name=\"ko\" rows=\"10\" cols=\"65\"
				onselect=\"storeCaret('ko_texte');\" onclick=\"storeCaret('ko_texte');\" onkeyup=\"storeCaret('ko_texte');\">" . $ko . "</textarea></td></tr>\n"
				
				
				. "<tr><td align=\"center\"><input type=\"submit\" value=\"" . _ADDTHISFILE . "\" /></td></tr>\n"
				. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Paypal&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
	
			echo "<script type=\"text/javascript\">\n"
				. "<!--\n"
				. "\n"
				. "function del()\n"
				. "{\n"
				. "if (confirm('" . _DELETE . "'))\n"
				. "{document.location.href = 'index.php?file=Paypal&page=admin&op=del';}\n"
				. "}\n"
				. "\n"
				. "// -->\n"
				. "</script>\n";
	
	}
	
	function send_message($ok, $ko)
	{		
		global $nuked, $user;
				
				$ok = html_entity_decode($ok);
				$ko = html_entity_decode($ko);
				$ok = mysql_real_escape_string(stripslashes($ok));
				$ko = mysql_real_escape_string(stripslashes($ko));
				
				$sql = mysql_query("UPDATE $nuked[prefix]_paypal SET ok='$ok', ko='$ko' WHERE id='1'");
			
				
				$texteaction = "". _ACTIONADDPAYPAL ."".$titre."". _ACTIONADDPAYPAL3 ."";
				$acdate = time();
				$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
				echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _MODIFPAYPAL . "\n"
				. "</div>\n"
				. "</div>\n";
				redirect("index.php?file=Paypal&page=admin",2);
	}

    function flash()
    {
		global $nuked, $language;

				$sql = mysql_query("SELECT flash, affiche FROM ". $nuked['prefix'] ."_paypal WHERE id='1'");
				list($flash, $affiche ) = mysql_fetch_array($sql);
				
			 echo "<div class=\"content-box\">\n"
				. "<div class=\"content-box-header\"><h3>" . _ADMINPAYPAL . "</h3>\n"
				. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Paypal_flash.php\" rel=\"modal\">\n"
				. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
				. "</div></div>\n"
				. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
				. "<div style=\"text-align: center;\"><a href=\"index.php?file=Paypal&amp;page=admin&amp;op=main\">" . _OPPDONS . "</a> | "
				. "<a href=\"index.php?file=Paypal&amp;page=admin&amp;op=oppbloc\">" . _OPPBLOCK . "</a></b> |  "
				. "<a href=\"index.php?file=Paypal&amp;page=admin&amp;op=message\">" . _MESSA . "</a> | "
				. "<b>" . _FlASH . "</b> | "
				. "<a href=\"javascript:del();\" style=\"color:#F00\" >". _1DELETE."</a></b></div><br />\n";
				
				if ($affiche =='Simple')
				{
			 echo "<div style=\"margin: 12px\">\n"
			    . "<div class=\"notification attention png_bg\">\n"
	            . " <a href=\"#\" class=\"close\">\n"
			    . "<img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Close this notification\" alt=\"close\"></a><div>" . _FLASIMPLE . "</div></div>\n";
				}
				elseif ($flash =='flash1')
				{
				$sql = mysql_query("SELECT var3, var2, var5, var4, var8, var6, var7, flaw, flah FROM ". $nuked['prefix'] ."_paypal_flash WHERE id='1'");
				list($var3, $var2, $var5, $var4, $var8, $var6, $var7, $flaw, $flah ) = mysql_fetch_array($sql);
						  		
			echo "<form method=\"post\" action=\"index.php?file=Paypal&amp;page=admin&amp;op=send_flash1\" enctype=\"multipart/form-data\" onsubmit=\"backslash('ok_flash');\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			    . "<tr><td width=\"15%\"><b>" . _BARREN1 . "</b></td><td>\n"
				. "<tr><td><b>" . _HAUTEURFLA . "</b></td><td><input type=\"text\" name=\"flah\" size=\"3\" maxlength=\"3\" value=\"" . $flah . "\" /> px</td></tr>\n"
				. "<tr><td><b>" . _LARGEURFLA . "</b></td><td><input type=\"text\" name=\"flaw\" size=\"3\" maxlength=\"3\" value=\"" . $flaw . "\" /> px</td></tr><tr><td></tr></td>\n"
				. "<tr><td><b>" . _HAUTEUR . "</b></td><td><input type=\"text\" name=\"var3\" size=\"3\" maxlength=\"3\" value=\"" . $var3 . "\" /> px</td></tr>\n"
				. "<tr><td><b>" . _LARGEUR . " </b></td><td><input type=\"text\" name=\"var2\" size=\"3\" maxlength=\"3\" value=\"" . $var2 . "\"/> px</td></tr>\n"
				. "<tr><td><b>" . _ARRONDIS . " </b></td><td><input type=\"text\" name=\"var5\" size=\"3\" maxlength=\"3\" value=\"" . $var5 . "\"/></td></tr>\n"
				. "<tr><td><b>" . _VITESSE . " </b></td><td><input type=\"text\" name=\"var4\" size=\"3\" maxlength=\"1\" value=\"" . $var4 . "\"/> 5max</td></tr>\n"
				. "<tr><td><b>" . _INCLINAISON . " </b></td><td><input type=\"text\" name=\"var8\" size=\"3\" maxlength=\"3\" value=\"" . $var8 . "\"/></td></tr>\n"
				. "<tr><td><b>" . _REFLETTAILLE . " </b></td><td><input type=\"text\" name=\"var6\" size=\"3\" maxlength=\"3\" value=\"" . $var6 . "\"/> %</td></tr>\n"
				. "<tr><td><b>" . _REFLETTRANS . " </b></td><td><input type=\"text\" name=\"var7\" size=\"3\" maxlength=\"3\" value=\"" . $var7 . "\"/> %</td></tr>\n";
				}
					
				elseif ($flash =='flash2')
				{
				$sql = mysql_query("SELECT flaw, flah FROM ". $nuked['prefix'] ."_paypal_flash WHERE id='2'");
				list($flaw, $flah ) = mysql_fetch_array($sql);
				
			echo "<form method=\"post\" action=\"index.php?file=Paypal&amp;page=admin&amp;op=send_flash2\" enctype=\"multipart/form-data\" onsubmit=\"backslash('ok_flash');\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			    . "<tr><td width=\"15%\"><b>" . _BARREN2 . "</b></td><td>\n"
				. "<tr><td><b>" . _HAUTEURFLA . "</b></td><td><input type=\"text\" name=\"flah\" size=\"3\" maxlength=\"3\" value=\"" . $flah . "\" /> px</td></tr>\n"
				. "<tr><td><b>" . _LARGEURFLA . "</b></td><td><input type=\"text\" name=\"flaw\" size=\"3\" maxlength=\"3\" value=\"" . $flaw . "\" /> px</td></tr><tr><td></tr></td>\n";
				}
				
				elseif ($flash =='flash3')
				{
				
			echo "<form method=\"post\" action=\"index.php?file=Paypal&amp;page=admin&amp;op=send_flash3\" enctype=\"multipart/form-data\" onsubmit=\"backslash('ok_flash');\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			    . "<tr><td width=\"15%\"><b>" . _BARREN3 . "</b></td><td>\n"
				. "<tr><td></td><td>\n"
				. "<div style=\"margin: 12px\">\n"
			    . "<div class=\"notification attention png_bg\">\n"
	            . " <a href=\"#\" class=\"close\">\n"
			    . "<img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Close this notification\" alt=\"close\"></a><div>" . _AUCUNFLASH . "</div></div>\n"
                . " </div></td></tr>\n";
				}
				
				elseif ($flash =='flash4')
				{
					
				$sql = mysql_query("SELECT  var3, var2, var5, var4, var8, var6, var7, flaw, flah FROM ". $nuked['prefix'] ."_paypal_flash WHERE id='4'");
				list($var3, $var2, $var5, $var4, $var8, $var6, $var7, $flaw, $flah ) = mysql_fetch_array($sql);
						  		
			echo "<form method=\"post\" action=\"index.php?file=Paypal&amp;page=admin&amp;op=send_flash4\" enctype=\"multipart/form-data\" onsubmit=\"backslash('ok_flash');\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			    . "<tr><td width=\"15%\"><b>" . _BARREN4 . "</b></td><td>\n"
				. "<tr><td><b>" . _HAUTEURFLA . "</b></td><td><input type=\"text\" name=\"flah\" size=\"3\" maxlength=\"3\" value=\"" . $flah . "\" /> px</td></tr>\n"
				. "<tr><td><b>" . _LARGEURFLA . "</b></td><td><input type=\"text\" name=\"flaw\" size=\"3\" maxlength=\"3\" value=\"" . $flaw . "\" /> px</td></tr><tr><td></tr></td>\n"
				. "<tr><td><b>" . _SYMBOLINT . "</b></td><td><input type=\"text\" name=\"var3\" size=\"3\" maxlength=\"3\" value=\"" . $var3 . "\" /> on - off \n"
				. "<a href=\"/modules/Paypal/flash/barre4_img_1.php\" rel=\"modal\">" . _SCREEN . "\n"
				. "<img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _SCREEN . "\" /></a></td></tr>\n"
				. "<tr><td><b>" . _SYMBOLD . " </b></td><td><input type=\"text\" name=\"var7\" size=\"3\" maxlength=\"3\" value=\"" . $var7 . "\"/> on - off \n"
				. "<a href=\"/modules/Paypal/flash/barre4_img_7.php\" rel=\"modal\">" . _SCREEN . "\n"
				. "<img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _SCREEN . "\" /></a></td></tr>\n"
				. "<tr><td><b>" . _EXTFLA . " </b></td><td><input type=\"text\" name=\"var2\" size=\"3\" maxlength=\"3\" value=\"" . $var2 . "\"/> on - off \n"
				. "<a href=\"/modules/Paypal/flash/barre4_img_2.php\" rel=\"modal\">" . _SCREEN . "\n"
				. "<img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _SCREEN . "\" /></a></td></tr>\n"
				. "<tr><td><b>" . _MILLIEUFLA . " </b></td><td><input type=\"text\" name=\"var5\" size=\"3\" maxlength=\"3\" value=\"" . $var5 . "\"/> on - off \n"
				. "<a href=\"/modules/Paypal/flash/barre4_img_3.php\" rel=\"modal\">" . _SCREEN . "\n"
				. "<img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _SCREEN . "\" /></a></td></tr>\n"
				. "<tr><td><b>" . _INTFLA . " </b></td><td><input type=\"text\" name=\"var4\" size=\"3\" maxlength=\"3\" value=\"" . $var4 . "\"/> on - off \n"
				. "<a href=\"/modules/Paypal/flash/barre4_img_4.php\" rel=\"modal\">" . _SCREEN . "\n"
				. "<img style=\"border: 0;\" src=\"/modules/Paypal/img/Apercu.gif\" alt=\"\" title=\"" . _SCREEN . "\" /></a></td></tr>\n"
				. "<tr><td><b>" . _TEXTE . " </b></td><td><input type=\"text\" name=\"var8\" size=\"3\" maxlength=\"3\" value=\"" . $var8 . "\"/> on - off</td></tr>\n"
				. "<tr><td><b>" . _FLOUEFLA . " </b></td><td><input type=\"text\" name=\"var6\" size=\"3\" maxlength=\"3\" value=\"" . $var6 . "\"/> on - off</td></tr>\n";
				}
			
			echo "<tr><td></td><td><input type=\"submit\" value=\"" . _ADDTHISFILE . "\" /></td></tr>\n"
				. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Paypal&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
				
	}
	
function send_flash1 ($var3, $var2, $var5, $var4, $var8, $var6, $var7,$flaw, $flah)
	{
					
		global $nuked, $user;
		
				$sql = mysql_query("UPDATE $nuked[prefix]_paypal_flash SET var3='$var3', var2='$var2', var5='$var5', var4='$var4', var8='$var8', var6='$var6', var7='$var7', flaw='$flaw', flah='$flah'");	
				
				$texteaction = "". _ACTIONADDPAYPAL ."".$titre."". _ACTIONADDPAYPAL4 ."";
				$acdate = time();
				$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
				echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _MODIFPAYPAL . "\n"
				. "</div>\n"
				. "</div>\n";
				redirect("index.php?file=Paypal&page=admin",2);
	
	}
	
	function send_flash2 ($flaw, $flah)
	{
					
		global $nuked, $user;
		
				$sql = mysql_query("UPDATE $nuked[prefix]_paypal_flash SET flaw='$flaw', flah='$flah' WHERE id='2'");	
				
				$texteaction = "". _ACTIONADDPAYPAL ."".$titre."". _ACTIONADDPAYPAL4 ."";
				$acdate = time();
				$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
				echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _MODIFPAYPAL . "\n"
				. "</div>\n"
				. "</div>\n";
				redirect("index.php?file=Paypal&page=admin",2);
	
	}
	function send_flash3 ()
	{
		
				$texteaction = "". _ACTIONADDPAYPAL ."".$titre."". _ACTIONADDPAYPAL4 ."";
				$acdate = time();
				$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
				echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _MODIFPAYPAL . "\n"
				. "</div>\n"
				. "</div>\n";
				redirect("index.php?file=Paypal&page=admin",2);
	
	}
	function send_flash4 ($var3, $var2, $var5, $var4, $var8, $var6, $var7,$flaw, $flah)
	{
					
		global $nuked, $user;
		
				$sql = mysql_query("UPDATE $nuked[prefix]_paypal_flash SET var3='$var3', var2='$var2', var5='$var5', var4='$var4', var8='$var8', var6='$var6', var7='$var7', flaw='$flaw', flah='$flah' WHERE id='4'");	
				
				$texteaction = "". _ACTIONADDPAYPAL ."".$titre."". _ACTIONADDPAYPAL4 ."";
				$acdate = time();
				$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
				echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _MODIFPAYPAL . "\n"
				. "</div>\n"
				. "</div>\n";
				redirect("index.php?file=Paypal&page=admin",2);
	
	}

    function del()
    {
        global $nuked, $user;

				$sql = mysql_query('DELETE FROM ' . $nuked['prefix'] . '_paypal_accepte');
				
				$texteaction = _ACTIONDELPAYPAL;
				$acdate = time();
				$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		
				echo "<div class=\"notification success png_bg\">\n"
					. "<div>\n"
					. "" . _VIDER . "\n"
					. "</div>\n"
					. "</div>\n";
		
				redirect("index.php?file=Paypal&page=admin", 2);
    }


    switch ($_REQUEST['op'])
    {	
	        case "del":
            del();
            break;
	
		    case "main":
            main();
            break;
			
			case "flash":
            flash();
            break;
			
			case "send_flash1":
			send_flash1($_REQUEST['var3'], $_REQUEST['var2'], $_REQUEST['var5'], $_REQUEST['var4'], $_REQUEST['var8'], $_REQUEST['var6'], $_REQUEST['var7'], $_REQUEST['flaw'], $_REQUEST['flah']);
			break;
			
			case "send_flash2":
			send_flash2($_REQUEST['flaw'], $_REQUEST['flah']);
			break;
			
			case "send_flash3":
			send_flash3();
			break;
			
			case "send_flash4":
			send_flash4($_REQUEST['var3'], $_REQUEST['var2'], $_REQUEST['var5'], $_REQUEST['var4'], $_REQUEST['var8'], $_REQUEST['var6'], $_REQUEST['var7'], $_REQUEST['flaw'], $_REQUEST['flah']);
			break;

		    case "send_paypal":
			send_paypal($_REQUEST['email'], $_REQUEST['nom'], $_REQUEST['montantdons'], $_REQUEST['logo'], $_REQUEST['affiche'], $_REQUEST['flash'], $_REQUEST['cible']);
			break;
		    
			case "send_message":
			send_message($_REQUEST['ok'], $_REQUEST['ko']);
			break;
			
			case "oppbloc":
            oppbloc();
            break;
			
			case "message":
            message();
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