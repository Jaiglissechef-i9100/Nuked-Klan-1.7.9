<?php
//-------------------------------------------------------------------------//
// Nuked-KlaN - Portal PHP //
// http://www.nuked-klan.org //
//-------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify //
// it under the terms of the GNU General Public License as published by //
// the Free Software Foundation; either version 2 of the License. //
//-------------------------------------------------------------------------//


// On vérifie que l'accès a cette page se fait par l'index

	if (!defined("INDEX_CHECK")) {
	die ("<center>You cannot open this page directly</center>");
	}

global $user;

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
	// Page affichant les maps travaillées
	function view_maps() {
		//Déclaration de la langue utilisé pour le multi langue
		global $nuked,$language, $bgcolor1, $bgcolor2, $bgcolor3;

		// On inclus le fichier langue
		include("modules/Strats/lang/".$language.".lang.php");

		// Titre de la page
		echo ('<br><center><big><b>'._STRATS.'</b></big></center><br>');
	
		// Ouverture du tableau principal
		echo( "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3
    	   		. ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr style=\"background: " . $bgcolor3 . ";\">\n");
		echo ("<td><b>"._MAPS."</b></td><td align='center' width=25%><b>"._STRATSNUMBER."</b></td>");
		echo ("</tr>");

		// Contenu du tableau
		$strats=mysql_query("
			SELECT * FROM ".$nuked['prefix']."_strats_map ORDER BY map_name
		");

		while ($strat = mysql_fetch_array($strats)) {
		$nb_strats = mysql_query("
			SELECT count(*)
		        FROM ".$nuked['prefix']."_strat WHERE strat_map_id = $strat[strat_map_id]
			");
			$nb = mysql_fetch_array($nb_strats);
			echo('
				<tr>
					<td>
						<a href="index.php?file=Strats&op=view_strats&strat_map_id='.$strat[strat_map_id].'">'.$strat[map_name].'</a>
					</td>
					<td align="center">'.$nb["0"].'</td>
				</tr>
			');
			if ($strat = mysql_fetch_array($strats)) {
			$nb_strats = mysql_query("
				SELECT count(*)
		    	    FROM ".$nuked['prefix']."_strat WHERE strat_map_id = $strat[strat_map_id]
			");
			$nb = mysql_fetch_array($nb_strats);			
				echo('
					<tr style="background:'  . $bgcolor1 . '";\">
						<td>
							<a href="index.php?file=Strats&op=view_strats&strat_map_id='.$strat[strat_map_id].'">'.$strat[map_name].'</a>
						</td>
						<td align="center">'.$nb["0"].'</td>
					</tr>
				');		}
		}	

		// Fermeture du tableau
		echo("</table>");
	}

	// Page affichant les startegies pour une map donnée
	function view_strats() {
		//Déclaration de la langue utilisé pour le multi langue
		global $nuked,$language, $bgcolor1, $bgcolor2, $bgcolor3;

		// On inclus le fichier langue
		include("modules/Strats/lang/".$language.".lang.php");

		// Titre de la page
		echo ('<br><center><big><b>'._MAPSTRATS.'</b></big></center><br>');
	
		// Ouverture du tableau principal
		$maps = mysql_query("
			SELECT * FROM ".$nuked['prefix']."_strats_map WHERE strat_map_id = ".$_REQUEST[strat_map_id]
		);
		$map = mysql_fetch_array($maps);

		echo( "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3
    	   		. ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr style=\"background: " . $bgcolor3 . ";\">\n");
		echo ("<td><b>"._MAP." : ".$map[map_name]."</b></td>");
		echo ("</tr>");

		// Contenu du tableau
		$strats=mysql_query("
			SELECT * FROM ".$nuked['prefix']."_strat WHERE strat_map_id = ".$_REQUEST[strat_map_id]."
		        ORDER BY title
		");
		while ($strat = mysql_fetch_array($strats)) {
			echo('
				<tr>
				<td >
					<a href="index.php?file=Strats&op=view_strat&strat_id='.$strat[strat_id].'">'.$strat[title].'</a>
				</td>
				</tr>
			');
			if ($strat = mysql_fetch_array($strats)) {
			echo('
				<tr style="background:'  . $bgcolor1 . '";\">
				<td >
					<a href="index.php?file=Strats&op=view_strat&strat_id='.$strat[strat_id].'">'.$strat[title].'</a>
				</td>
				</tr>
			');
			}

		}	

		// Fermeture du tableau
		echo("</table>");

		// Fin de la page
		echo ("<br><center>[ <a href='index.php?file=Strats'>"._GOBACK."</a> ]</center>");

	}

	// Fonction affichant une strategie
	function view_strat() {
		//Déclaration de la langue utilisé pour le multi langue
		global $nuked,$language, $bgcolor2, $bgcolor3;

		// On inclus le fichier langue
		include("modules/Strats/lang/".$language.".lang.php");

		// Titre de la page
		echo ('<br><center><big><b>'._STRAT.'</b></big></center><br>');
	
		// Ouverture du tableau principal
		echo( "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3
       			. ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr style=\"background: " . $bgcolor3 . ";\">\n");
		echo ("<td><b>"._MAP."</b></td>");
		echo ("</tr>");

		// Contenu du tableau
		$strats=mysql_query("
			SELECT * 
			FROM ".$nuked['prefix']."_strat WHERE strat_id = ".$_REQUEST[strat_id]
		);

		$strat = mysql_fetch_array($strats);
		$strat_text = htmlentities($strat[text]);
		$strat_text = nk_CSS($strat_text);
		$strat_text = preg_replace("`&lt;`i", "<", $strat_text);
    $strat_text = preg_replace("`&gt;`i", ">", $strat_text);
	
		echo ('
			<tr>
			<td>
				<b>'.$strat[title].'</b>
			</td>
			</tr>
			<tr>
			<td>
				<a href="'.$strat[picture].'" target=blank>
					<img src="'.$strat[picture].'" width=100 height=100 border=0>
				</a>
			</td>
			</tr>
			<tr>
			<td>
				'.$strat_text.'
			</td>
			</tr>
		');
	

		// Fermeture du tableau
		echo("</table>");

		// Fin de la page
		echo ("<br><center>[ <a href='index.php?file=Strats&op=view_strats&strat_map_id=".$strat[strat_map_id]."'>"._GOBACK."</a> ]</center>");
	}

	switch($_GET['op'])
	{
  	  case"view_strats":
    	view_strats();
	    break;

    	case"view_strat":
	    view_strat();
  	  break;

	    default:
  	  view_maps();
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
