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
	// Affiche la totalité des maps
	function view_maps() {
		//Déclaration de la langue utilisé pour le multi langue
		global $language, $nuked, $bgcolor1, $bgcolor2, $bgcolor3;
		include("modules/Strats/lang/".$language.".lang.php");
	
		// Titre de la page
		echo ('<br><center><big><b>'._CHOOSEMAP.'</b></big></center><br>');
	
		// Insertion de la nouvelle map
		if ($_POST['strattitle'] != null) {

			// insertion de la nouvelle strategie
			$result = mysql_query("
				INSERT INTO ".$nuked['prefix']."_strats_map (map_name)
				VALUES ('" . $_POST[strattitle] . "')
			");

			if ($result != null)
				echo(_MAPADDED."<br>");
		}

		// Effacement d'une map
		if ($_REQUEST['delete'] != null) {
			// Effacement des strats de la map
			$result = mysql_query("
				DELETE FROM ".$nuked['prefix']."_strat WHERE strat_map_id = '" . $_REQUEST['delete']."'
			");
			// Effacement d'une map
			$result = mysql_query("
				DELETE FROM ".$nuked['prefix']."_strats_map WHERE strat_map_id = '" . $_REQUEST['delete']."'
			");
			echo(_MAPDELETED);
		}
	
		// Ouverture du tableau principal
		echo( "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3
  	     		. ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr style=\"background: " . $bgcolor3 . ";\">\n");
			echo ("<td><b>"._MAP."</b></td><td width='25%' align='center'><b>"._NBSTRATS."</b></td><td width='25%' align='center'><b>"._DELETE."</b></td>");
		echo ("</tr>");

		// Contenu du tableau
		$maps=mysql_query("
			SELECT * FROM ".$nuked['prefix']."_strats_map ORDER BY map_name
		");
		if (!empty($maps)) {
			while ($map = mysql_fetch_array($maps)) {
				$nb_strats = mysql_query("

					SELECT count(*) FROM ".$nuked['prefix']."_strat WHERE strat_map_id = ".$map[strat_map_id]."
				");
				$nb = mysql_fetch_array($nb_strats);
			
				echo('
					<tr><td>
						<a href="index.php?file=Strats&page=admin&op=view_map&map_id='.$map[0].'">
							'.$map[1] .'</a><br>
					</td>
					<td align="center">
						'.$nb["0"] . ' ' . _STRATS .'
					</td>
					<td align="center">
						<a href="index.php?file=Strats&page=admin&delete='.$map[0].'">
							<img src="modules/Strats/images/delete.gif" border=0>
						</a>
					</td>
					</tr>
				');
				if ($map = mysql_fetch_array($maps)) {
					$nb_strats = mysql_query("
		
						SELECT count(*) FROM ".$nuked['prefix']."_strat WHERE strat_map_id = ".$map[strat_map_id]."
					");
					$nb = mysql_fetch_array($nb_strats);
			
					echo('
						<tr style="background:'  . $bgcolor1 . '";\">
						<td>
							<a href="index.php?file=Strats&page=admin&op=view_map&map_id='.$map[0].'">
								'.$map[1] .'</a><br>
						</td>
						<td align="center">
							'.$nb["0"] . ' ' . _STRATS .'
						</td>
						<td align="center">
							<a href="index.php?file=Strats&page=admin&delete='.$map[0].'">
								<img src="modules/Strats/images/delete.gif" border=0>
							</a>
						</td>
						</tr>
					');
				}
			}
		}
		// Fermeture du tableau
		echo ("</table>");

		// Formulaire d'insertion de map
		echo ("<br>");
		echo ("<b><big>"._ADDMAP."</big></b><br><br>");
		echo( "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3
	       		. ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr style=\"background: " . $bgcolor3 . ";\">\n");
		echo ("<td width='25%' align='center'><b>"._ADDMAP."</b></td><td><b>"._ENTERINFO."</b></td>");
		echo ("</tr>");

		echo ('<form action="" method="post">');
		echo ('<tr><td align = "right">');
		echo (_MAPNAME.' :</td>');
		echo ('<td><input type="text" name="strattitle" value="'.$_POST["strattitle"].'"></td>');
		echo ('</tr>');
	
		echo ('<tr><td align="right">');
		echo (_SUBMIT.' :</td><td><input type="submit" value="'._SUBMIT.'"></td></tr>');
		echo ('</form>');

		echo ('</table>');
	}

	// Affiche les strategies d'une map
	function view_map() {
		// On inclus le fichier langue
		// Et on definie les variables globales
		global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3;
		include("modules/Strats/lang/".$language.".lang.php");

		// Titre de la page
	
		echo ('<br><center><big><b>'._WELCOMESTRATS.'</b></big></center><br>');

		// Insertion d'une nouvelle strategie
		if ($_POST['strattitle'] != null) {

			$filename = $_FILES['fichiernom']['name'];
			if ($filename != "") {
				$date = time();
				$file_forum = explode(".", $filename);
        $end = count($file_forum) - 1;
        $ext = $file_forum[$end];
        
        if (eregi("php", $ext) || eregi("htm", $ext)) $type = "txt";
        else $type = $ext;
        $file_name = $date . "." . $type;
        $url_file = "upload/Strats/" . $file_name;
        if (!eregi("swf", $type)) move_uploaded_file($_FILES['fichiernom']['tmp_name'], $url_file) or die ("<br /><br /><div style=\"text-align: center;\"><big><b>" . _UPLOADFAILED . "</b></big></div><br /><br />");
        @chmod ($url_file, 0644);
				$file = $url_file;
			} else {
				$file = $_POST[stratpic];
			}

			$_POST[strattext] = secu_html(html_entity_decode($_POST[strattext]));
			
			// insertion de la nouvelle strategie
			$result = mysql_query("
				INSERT INTO ".$nuked['prefix']."_strat (strat_map_id, text, title, picture)
				VALUES ('" . $_REQUEST[map_id] . "','".$_POST[strattext]."','" . $_POST[strattitle] . "','".$file."')
			");

			if ($result != null)
				echo(_STRATADDED."<br>");
		}

		// Suppression d'une strategie

		if ($_REQUEST['delete'] != null) {
			$result  = mysql_query ("
				DELETE FROM ".$nuked['prefix']."_strat WHERE strat_id = '".$_REQUEST['delete']."'
			");
		}
	
		// Affichage du tableau principal

		$result = mysql_query ("
			SELECT map_name FROM ".$nuked['prefix']."_strats_map WHERE strat_map_id = $_REQUEST[map_id]
		");
		$map = mysql_fetch_array($result);

		echo( "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3
  	     		. ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr style=\"background: " . $bgcolor3 . ";\">\n");
		echo ("<td><b>"._MAP." : ".$map[map_name]."</b></td><td align='center' width=25%><b>"._ACTION."</b></td></tr>");

		// Iteration des lignes contenant les strats pour la map en cours

		$strats=mysql_query("
			SELECT * FROM ".$nuked['prefix']."_strat WHERE strat_map_id= $_REQUEST[map_id]
			ORDER BY title
		");

		while ($strat = mysql_fetch_array($strats)) {
			echo('
				<tr><td>
					'.$strat[title].'</td>
				<td align="center">
					<a href="index.php?file=Strats&page=admin&op=edit_strat&strat_id='.$strat[strat_id].'">
						<img src="modules/Strats/images/edit.gif" border=0>
					</a>
					<a href="index.php?file=Strats&page=admin&op=view_map&map_id='.$_REQUEST[map_id].'&delete='.$strat[strat_id].'">
					<img src="modules/Strats/images/delete.gif" border=0>
					</a>'.'
				</td> </tr>
			');  
			if ($strat = mysql_fetch_array($strats)) {
				echo('
					<tr style="background:'  . $bgcolor1 . '";\">
					<td>
						'.$strat[title].'</td>
					<td align="center">
						<a href="index.php?file=Strats&page=admin&op=edit_strat&strat_id='.$strat[strat_id].'">
							<img src="modules/Strats/images/edit.gif" border=0>
						</a>
						<a href="index.php?file=Strats&page=admin&op=view_map&map_id='.$_REQUEST[map_id].'&delete='.$strat[strat_id].'">
						<img src="modules/Strats/images/delete.gif" border=0>
						</a>'.'
					</td> </tr>
				');  
			
			}
		}


		// Fermeture du tableau principal
		echo ('</table>');


		// Possibilité d'ajouter une strategie pour la map en cours
		echo ('<br><b><big>'._ADDSTRAT.'</big></b><br><br>');
		echo( "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3
  	     		. ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr style=\"background: " . $bgcolor3 . ";\">\n");
		echo ("<td width='25%' align='center'><b>"._ADDSTRAT."</b></td><td><b>"._ENTERINFO."</b></td>");
		echo ("</tr>");
		echo ('<form action="" method="post" enctype="multipart/form-data">');
		echo ('<tr>');
		echo ('<td align="right">'._STRATNAME.' :</td><td><input type="text" name="strattitle" value="'.$_POST["strattitle"].'"></td>');
		echo ('</tr><tr valign="top">');
		echo ('<td align="right">'._STRATTEXT.' :</td><td><textarea class="editoradvanced" name="strattext" cols="60" rows="10">'.$_POST["strattext"].'</textarea></td>');
		echo ('</tr><tr>');
		echo ('<td align="right">'._STRATPIC.' :</td><td><input type="field" name="stratpic" value="'.$_POST["stratpic"].'"><br><input type="file" name="fichiernom" size="30"></td>');
		echo ('</tr><tr>');
		echo ('<td align="right">'._ADDSTRAT.' :</td><td><input type="submit" value="'._SUBMIT.'"</td>');
		echo ('</tr>');
		echo ('</form>');

		echo('</table>');

		// Fin de la page
		echo("<br>");
		echo ("<center>[ <a href='index.php?file=Strats&page=admin'>"._GOBACK."</a> ]</center>");
	}

	function edit_strat() {
		//Déclaration de la langue utilisé pour le multi langue
		global $language, $nuked, $bgcolor2, $bgcolor3;
		include("modules/Strats/lang/".$language.".lang.php");
	 	echo ('<br><CENTER><b><big>'._EDITSTRAT.'</big></b></CENTER><br><br>');
	
		// Edition de la strategie
		if ($_POST['strattitle'] != null) {

			$filename = $_FILES['fichiernom']['name'];
			if ($filename != "") {
				$date = time();
				$file_forum = explode(".", $filename);
        $end = count($file_forum) - 1;
        $ext = $file_forum[$end];
        
        if (eregi("php", $ext) || eregi("htm", $ext)) $type = "txt";
        else $type = $ext;
        $file_name = $date . "." . $type;
        $url_file = "upload/Strats/" . $file_name;
        if (!eregi("swf", $type)) move_uploaded_file($_FILES['fichiernom']['tmp_name'], $url_file) or die ("<br /><br /><div style=\"text-align: center;\"><big><b>" . _UPLOADFAILED . "</b></big></div><br /><br />");
        @chmod ($url_file, 0644);
				$file = $url_file;
			} else {
				$file = $_POST[stratpic];
			}

			$_POST[strattext] = secu_html(html_entity_decode($_POST[strattext]));

			// modification de la strategie
			$result = mysql_query("
				UPDATE ".$nuked['prefix']."_strat
				SET
					title = '".$_POST[strattitle]."',
					text = '".$_POST[strattext]."',
					picture = '".$file."'
				WHERE
					strat_id = '".$_REQUEST[strat_id]."'

			");

			if ($result != null)
				echo(_STRATUPDATED."<br>");
		}


		// Iteration des lignes contenant les strats pour la map en cours
		$strats=mysql_query("
			SELECT * FROM ".$nuked['prefix']."_strat WHERE strat_id= $_REQUEST[strat_id]
		");

		$strat = mysql_fetch_array($strats);

		// Possibilité d'ajouter une strategie pour la map en cours

		echo( "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3
    	   		. ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr style=\"background: " . $bgcolor3 . ";\">\n");
		echo ("<td width='25%' align='center'>"._ADDMAP."</td><td>"._ENTERINFO."</td>");
		echo ("</tr>");
		echo ('<form action="" method="post" enctype="multipart/form-data">');
		echo ('<tr>');
		echo ('<td align="right">'._STRATNAME.' :</td><td><input type="text" name="strattitle" value="'.$strat["title"].'"></td>');
		echo ('</tr><tr valign="top">');
		echo ('<td align="right">'._STRATTEXT.' :</td><td><textarea class="editoradvanced" name="strattext" cols="60" rows="10">'.$strat["text"].'</textarea></td>');
		echo ('</tr><tr>');
		echo ('<td align="right">'._STRATPIC.' :</td><td><input type="field" name="stratpic" value="'.$strat["picture"].'"><br><input type="file" name="fichiernom" size="20"></td>');
		echo ('</tr><tr>');
		echo ('<td align="right">'._SUBMIT.' :</td><td><input type="submit" value="'._UPDATE.'"</td>');
		echo ('</tr>');
		echo ('</form>');

		echo('</table>');

		// Fin de la page
		echo("<br>");
		echo ("<center>[ <a href='index.php?file=Strats&page=admin&op=view_map&map_id=".$strat[strat_map_id]."'>"._GOBACK."</a> ]</center>");}

	switch($_GET['op'])
	{
  	  case"view_map":
    	view_map();
	    break;

	    case"edit_strat":
  	  edit_strat();
    	break;

	    default:
  	  view_maps();
    	break;
	}
} 
else if ($level_admin == -1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
} 
else if ($visiteur > 1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
} 
else
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
}  

adminfoot();
?>
