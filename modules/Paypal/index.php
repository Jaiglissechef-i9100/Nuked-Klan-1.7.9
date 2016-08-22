<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $nuked, $user, $language;
translate("modules/Paypal/lang/" . $language . ".lang.php");

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
    compteur("Paypal");

    function index()
    {
		global $bgcolor1, $bgcolor2, $bgcolor3, $theme, $nuked, $language, $user;

        {
			$sql2 = mysql_query("SELECT email, nom, montantdons, logo, affiche, cible, copy FROM ". $nuked['prefix'] ."_paypal");
			list($email, $nom, $montantdons, $logo, $affiche, $cible, $copy) = mysql_fetch_array($sql2);
		
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
	
		}

	     echo "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" cellpadding=\"2\" cellspacing=\"1\">\n"
            . "<tr style=\"background: " . $bgcolor3 . ";\">\n"
			. "<td style=\"width: 50%;\" align=\"center\"><b>" . _NICK . "</b></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><b>" . _MONTANT . "</b></td>\n"
			. "<td style=\"width: 25%;\" align=\"center\"><b>" . _DATE . "</b></td></tr>\n";
			
			 $sql = mysql_query("SELECT id, autor, autor_id, date, montant FROM ". $nuked['prefix'] ."_paypal_accepte ORDER BY id");
		while (list($id, $auteur, $autor_id, $date, $montant) = mysql_fetch_row($sql))
		{
			
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

            echo "<tr><td style=\"width: 50%;\" align=\"center\">" . $autor . "</td>
				  <td style=\"width: 15%;\" align=\"center\">" . $montant . " &#8364;</td>
				  <td style=\"width: 25%;\"align=\"center\">" . $date . "</td></tr>\n";
					
		}
		
		
							echo "</table>\n";

echo "<div class=\"copyrightpaypal\">" . $copy . "</div>
<style type=\"text/css\">
.copyrightpaypal { position: relative; top: 99%; left: 99%; color: #000;} 
</style>\n";
		}


    switch ($_REQUEST['op'])
    {
            default:
            opentable();
            index();
            closetable();
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