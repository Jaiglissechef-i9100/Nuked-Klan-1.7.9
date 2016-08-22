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
defined("INDEX_CHECK") or die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");

global $nuked, $language, $user;
translate("modules/Paypal/lang/" . $language . ".lang.php");

$visiteur = $user ? $user[1] : 0;

{
			$sql2 = mysql_query("SELECT email, nom, montantdons, logo, affiche, cible, copy FROM ". $nuked['prefix'] ."_paypal");
			list($email, $nom, $montantdons, $logo, $affiche, $cible, $copy ) = mysql_fetch_array($sql2);
			
			$req = mysql_query("SELECT COUNT(*), SUM(montant) FROM ". $nuked['prefix'] ."_paypal_accepte ");
			list($count, $somme) = mysql_fetch_array($req);
	
		$nb         = nbvisiteur();
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
		$demande = 0;
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
            . " <tr><td width=\"55%\">" . _CIBLEA . "</td><td style=\"text-align:right\">" . $demande . " &#8364;</td></tr>\n"
            . " <tr><td>" . _DONA . "</td><td style=\"text-align:right\">" . $recu . " &#8364;</td></tr>\n"
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
            . " </table></center><br />\n";
			}}
			
		
         echo "<form id=\"BlocPayPalJS\" style=\"display:none\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" onsubmit=\"return VerifMontantBloc();\">\n"
		 //echo "<form id=\"BlocPayPalJS\" style=\"display:none\" action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\" onsubmit=\"return VerifMontantBloc();\">\n"
		 // a utilisé pour les teste
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
			    <input type=\"text\" id=\"BlocAmount\" name=\"amount\" size=\"6\" value=\"0\"/>&euro;<br />
			    <br />
			    <input type=\"image\" src=\"" . $logo . "\" style=\"border: none;\" name=\"submit\" alt=\"PayPal - Dons !\" />
			    </p>
			    </form>
			    <div id=\"BlocPayPalNoJS\" style=\"display:block;font-weight:bold;margin:20px auto\">Veuillez activer le javascript.<br />Merci.</div>
				
				<div style=\"display:none\" class=\"copyrightpaypal\">" . $copy . "</div>
                <style type=\"text/css\">
                .copyrightpaypal { position: relative; top: 99%; left: 99%; color: #000;} 
                </style>
		        
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
				alert(\"" . _ALERT1 . "\"); 
				return false;
			}
else
			{
				if(ElId==0)
			{
				alert(\"" . _ALERT2 . "\");
				return false;
			}
else
				return true;
			}
			}
				</script>\n";

	 
}
?>