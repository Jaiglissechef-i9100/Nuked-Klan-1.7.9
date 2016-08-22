<?php

////////////////////////////////////////////////
//	Module creer par Maxxi		                //
//	http://Nuked-Host.tk                      //
//  ----------------------------------------- //
//	Module 1.0 par Tassin                     //
//  Module mis à jour pour la 1.7.9 par YurtY //
//  www.nkhelp.fr                             //
//	Module V2.0 & 3.0 par Zdav                //
//  www.nuked-klan.org                        //
////////////////////////////////////////////////

global $nuked, $language, $bgcolor3, $user;

translate("modules/Replays/lang/".$language.".lang.php");
include("modules/Replays/constants.php");

if (eregi("blok.php", $_SERVER['PHP_SELF']))
{
    die ("You cannot open this page directly");
} 

if(!$user) {
	$visiteur="0";
}
else {
	$visiteur=$user[1];
}

global $bgcolor1, $bgcolor2, $bgcolor3;

echo"<table style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n";

$sql=mysql_query("SELECT id, titre, map, version, evenement, type, id_equipe, date_ajout, compteur, game FROM ".REPLAYSTABLE." ORDER BY id DESC LIMIT 0, 1 "); 
$nb_replays = mysql_num_rows($sql);

while (list($id, $titre, $map, $version, $evenement, $type, $id_equipe, $dateAjout, $compteur, $game) = mysql_fetch_array($sql)){
	
	$sql_com = mysql_query("SELECT count(id) FROM " . COMMENT_TABLE . " WHERE module='Replays' AND im_id = " . $id);
	list($num_com) = mysql_fetch_row($sql_com);
	
	$sql_vote = mysql_query("SELECT vote FROM " . VOTE_TABLE . " WHERE module='Replays' AND vid = " . $id);
	list($num_vote) = mysql_fetch_row($sql_vote);
	
		if($dateAjout != "") {
			$date = strftime("%x", $dateAjout);
		}

    $sql_game = mysql_query('SELECT name, icon FROM ' . GAMES_TABLE . ' WHERE id = \'' . $game . '\' ');
      list($game_name, $icon) = mysql_fetch_array($sql_game);
      $game_name = htmlentities($game_name);

      if ($icon != '' && is_file($icon)){
      $icone = $icon;
      } 
      else{
      $icone = 'images/games/nk.gif';
      } 


echo"<tr style=\"background:" . $bgcolor3 . "\">\n"
	."<td align=\"center\" width=\"30%\"><b><small>". $date ."</small></b></td>\n"
	."<td align=\"right\" width=\"70%\"><img src=\"" . $icone . "\" alt=\"\" title=\"" . $game_name . "\" width=\"15\" height=\"15\" align=\"left\"/><span style=\"float:left\"><small>&nbsp;". $version ."</small></span><img src=\"modules/Replays/images/comments.png\" width=\"15\" height=\"15\" alt=\"" . _COMBLOK . "\" title=\"" . _COMBLOK . "\" />" . $num_com . "&nbsp;<img src=\"modules/Replays/images/download_mini.png\" width=\"15\" height=\"15\" alt=\"" . _DLBLOK . "\" title=\"" . _DLBLOK . "\" />" . $compteur . "&nbsp;\n";
	
		
	if($num_vote != ""){
		if($num_vote >= 0 && $num_vote <=3) {
			$img_vote = "modules/Replays/images/orange_arrow_down.png";
		} else if($num_vote > 3 && $num_vote <= 6) {
			$img_vote = "modules/Replays/images/leftright_arrow.gif";
		} else {
			$img_vote = "modules/Replays/images/green_arrow_up.png";
		}
	} else {
		$num_vote = "-";
		$img_vote = "modules/Replays/images/orange_arrow_down.png";
	}
	
	echo "<img src=\"" . $img_vote . "\" width=\"15\" height=\"15\" title=\"(" . $num_vote . "/10)\" alt=\"(" . $num_vote . "/10)\" /></td>\n"
	."</tr>\n";	
	
    $sql_game = mysql_query('SELECT name, icon FROM ' . GAMES_TABLE . ' WHERE id = \'' . $game . '\' ');
      list($game_name, $icon) = mysql_fetch_array($sql_game);
      $game_name = htmlentities($game_name);

      if ($icon != '' && is_file($icon)){
      $icone = $icon;
      } 
      else{
      $icone = 'images/games/nk.gif';
      } 
	
	$sql_map = mysql_query("SELECT nom FROM " . MAPSTABLE . " WHERE image='" . $map . "'");
	$nb_maps = mysql_num_rows($sql_map);
	
	if($nb_maps == 0) {
		$img_name = _ERRORIMG;
		$img_file = "";
	} else {
		list($img_name) = mysql_fetch_row($sql_map);
		$img_file = "modules/Replays/images/maps/" . $map;
	}
	
	$rep_img = "modules/Replays/images/race/";

      $ligne0 = "";
      $ligne1 = "";
			$ligne2 = "";
			$ligne3 = "";
			$ligne4 = "";
      $ligne5 = "";
			$ligne6 = "";
			$ligne7 = "";
			if($type == 1) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, racejoueur1, racejoueur2 FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur3, $racejoueur1, $racejoueur3) = mysql_fetch_row($sql_joueurs);
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr>\n";
				$ligne2 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";
				$ligne3 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr>\n";
			}
			
			else if($type == 2) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr>\n";
				$ligne2 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";
				$ligne3 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr>\n";
			}
			
			else if($type == 3) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr>\n";
				$ligne2 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";
				$ligne3 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur5 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur6 . "</b></small></td></tr>\n";
			}
			
			else if($type == 4)  {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr>\n";
				$ligne2 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";				
				$ligne3 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur5 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur6 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur7 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur8 . "</b></small></td></tr>\n";
			}
	
			else if($type == 5) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
				$ligne1 ="<tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr>\n";
				$ligne2 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";
				$ligne3 ="<tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr>\n";
				$ligne4 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";				
				$ligne5 ="<tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur5 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur6 . "</b></small></td></tr>\n";				
			}

			else if($type == 6) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
				$ligne1 ="<tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr>\n";
				$ligne2 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";
				$ligne3 ="<tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr>\n";
				$ligne4 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";				
				$ligne5 ="<tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur5 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur6 . "</b></small></td></tr>\n";
				$ligne6 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";				
				$ligne7 ="<tr><td align=\"left\" style=\"color:#ffa32d\"><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur7 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#ffa32d\"><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur8 . "</b></small></td></tr>\n";								
			}	

			else if($type == 7) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, racejoueur1, racejoueur2, racejoueur3  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $racejoueur1, $racejoueur2, $racejoueur3) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">FFA</td></tr>\n";				
				$ligne1 ="<tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr>\n";
			}

			else if($type == 8) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">FFA</td></tr>\n";				
				$ligne1 ="<tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#ffa32d\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr>\n";
			}

			else if($type == 9) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">FFA</td></tr>\n";				
				$ligne1 ="<tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#ffa32d\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#fc58ff\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur5 . "</b></small></td></tr>\n";
			}

			else if($type == 10) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">FFA</td></tr>\n";				
				$ligne1 ="<tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#ffa32d\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#fc58ff\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur5 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#e4d544\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur6 . "</b></small></td></tr>\n";
			}

			else if($type == 11) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">FFA</td></tr>\n";				
				$ligne1 ="<tr><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#ffa32d\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#fc58ff\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur5 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#e4d544\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur6 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#4ab4e8\"><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur7 . "</b></small></td></tr><tr><td align=\"left\" style=\"color:#d88285\"><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur8 . "</b></small></td></tr>\n";
			}

			else if($type == 12)  {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, joueur9, joueur10, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8, racejoueur9, racejoueur10  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8, $racejoueur9, $racejoueur10) = mysql_fetch_row($sql_joueurs);
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur1 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur2 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur3 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur4 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur5 . "</b></small></td></tr>\n";
				$ligne2 = "<tr><td align=\"left\"style=\"background-color:#232d31;font-size:9px;color:#FFFFFF;padding:2px 0 2px 8px;\">VERSUS</td></tr>\n";				
				$ligne3 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur6 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur7 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur8 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur9 . "\" width=\"25\" height=\"25\" title=\"" . $joueur9 . "\" alt=\"" . $joueur9 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur9 . "</b></small></td></tr><tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur10 . "\" width=\"25\" height=\"25\" title=\"" . $joueur10 . "\" alt=\"" . $joueur10 . "\" style=\"vertical-align: middle;\"/><small>&nbsp;<b>" . $joueur10 . "</b></small></td></tr>\n";
			}



	
	if ($i == 0)
	{
		$bg = $bgcolor2;
		$i++;
	} 
	else
	{
		$bg = $bgcolor1;
		$i = 0;
	}
	
	echo "<tr onmouseover=\"this.style.background='url(modules/Replays/images/bg_block.png)';\"
onmouseout=\"this.style.background='" . $bg . "';\"onclick=\"document.location='index.php?file=Replays&amp;op=view&amp;id=" . $id . "'\"style=\"cursor: pointer; background: " . $bg . ";\">\n"
				."<td align=\"center\"><img style=\"cursor: pointer; padding-right:4px; padding-left:5px;  vertical-align: middle;\" src=\"" . $img_file . "\" width=\"100\" height=\"100\" onmouseOver=\"AffBulle('" . $img_name . "', '<img src=\'" . $img_file . "\'/>', 100);\" onmouseOut=\"HideBulle();\" /></td>\n"
				."<td align=\"center\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
			echo $ligne0;	
			echo $ligne1;	
			echo $ligne2;
			echo $ligne3;
			echo $ligne4;
			echo $ligne5;
			echo $ligne6;
			echo $ligne7
				."</table></td>\n"
        ."</tr>";
}

if($nb_replays == 0) {
	echo "<tr><td align=\"center\" colspan=\"8\">" . _NOREPLAYSINDB . "</td></tr>\n";
}

echo "</table>\n";





//partie basse

echo"<table style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" cellspacing=\"1\" cellpadding=\"2\">\n";

		
$sql=mysql_query("SELECT id, titre, map, version, evenement, type, id_equipe, date_ajout, compteur, game  FROM ".REPLAYSTABLE." ORDER BY id DESC LIMIT 1, 5 "); 
$nb_replays = mysql_num_rows($sql);

while (list($id, $titre, $map, $version, $evenement, $type, $id_equipe, $dateAjout, $compteur, $game) = mysql_fetch_array($sql)){
	
	$sql_com = mysql_query("SELECT count(id) FROM " . COMMENT_TABLE . " WHERE module='Replays' AND im_id = " . $id);
	list($num_com) = mysql_fetch_row($sql_com);
	
	$sql_vote = mysql_query("SELECT vote FROM " . VOTE_TABLE . " WHERE module='Replays' AND vid = " . $id);
	list($num_vote) = mysql_fetch_row($sql_vote);
	
		if($dateAjout != "") {
			$date = strftime("%x", $dateAjout);
		}

    $sql_game = mysql_query('SELECT name, icon FROM ' . GAMES_TABLE . ' WHERE id = \'' . $game . '\' ');
      list($game_name, $icon) = mysql_fetch_array($sql_game);
      $game_name = htmlentities($game_name);

      if ($icon != '' && is_file($icon)){
      $icone = $icon;
      } 
      else{
      $icone = 'images/games/nk.gif';
      }

echo"<tr style=\"background:" . $bgcolor3 . "\">\n"
	."<td align=\"center\" width=\"25%\"><b><small>". $date ."</small></b></td>\n"
	."<td align=\"right\" width=\"75%\"><img src=\"" . $icone . "\" alt=\"\" title=\"" . $game_name . "\" width=\"15\" height=\"15\" align=\"left\"/><span style=\"float:left\"><small>&nbsp;". $version ."</small></span><img src=\"modules/Replays/images/comments.png\" width=\"15\" height=\"15\" alt=\"" . _COMBLOK . "\" title=\"" . _COMBLOK . "\" />" . $num_com . "&nbsp;<img src=\"modules/Replays/images/download_mini.png\" width=\"15\" height=\"15\" alt=\"" . _DLBLOK . "\" title=\"" . _DLBLOK . "\" />" . $compteur . "&nbsp;\n";
	
		
	if($num_vote != ""){
		if($num_vote >= 0 && $num_vote <=3) {
			$img_vote = "modules/Replays/images/orange_arrow_down.png";
		} else if($num_vote > 3 && $num_vote <= 6) {
			$img_vote = "modules/Replays/images/leftright_arrow.gif";
		} else {
			$img_vote = "modules/Replays/images/green_arrow_up.png";
		}
	} else {
		$num_vote = "-";
		$img_vote = "modules/Replays/images/orange_arrow_down.png";
	}
	
	echo "<img src=\"" . $img_vote . "\" width=\"15\" height=\"15\" title=\"(" . $num_vote . "/10)\" alt=\"(" . $num_vote . "/10)\" /></td>\n"
	."</tr>\n";	
	
	
	$sql_map = mysql_query("SELECT nom FROM " . MAPSTABLE . " WHERE image='" . $map . "'");
	$nb_maps = mysql_num_rows($sql_map);
	
	if($nb_maps == 0) {
		$img_name = _ERRORIMG;
		$img_file = "";
	} else {
		list($img_name) = mysql_fetch_row($sql_map);
		$img_file = "modules/Replays/images/maps/" . $map;
	}
	
	$rep_img = "modules/Replays/images/race/";

      $ligne0 = "";	
      $ligne1 = "";
			$ligne2 = "";
			$ligne3 = "";
			$ligne4 = "";
			if($type == 1) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, racejoueur1, racejoueur2 FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur3, $racejoueur1, $racejoueur3) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			} 
			else if($type == 2) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}
			
			else if($type == 3) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}
			
			else if($type == 4) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

			else if($type == 5) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

			else if($type == 6) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

			else if($type == 7) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, racejoueur1, racejoueur2, racejoueur3 FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $racejoueur1, $racejoueur2, $racejoueur3) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

			else if($type == 8) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

			else if($type == 9) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

			else if($type == 10) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

			else if($type == 11) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

			else if($type == 12) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, joueur9, joueur10, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8, racejoueur9, racejoueur10  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8, $racejoueur9, $racejoueur10) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur9 . "\" width=\"25\" height=\"25\" title=\"" . $joueur9 . "\" alt=\"" . $joueur9 . "\" style=\"vertical-align: middle;\"/><img src=\"" . $rep_img . $racejoueur10 . "\" width=\"25\" height=\"25\" title=\"" . $joueur10 . "\" alt=\"" . $joueur10 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}

	
	if ($i == 0)
	{
		$bg = $bgcolor2;
		$i++;
	} 
	else
	{
		$bg = $bgcolor1;
		$i = 0;
	}
	
	echo "<tr onmouseover=\"this.style.background='url(modules/Replays/images/bg_block.png)';\"
onmouseout=\"this.style.background='" . $bg . "';\"onclick=\"document.location='index.php?file=Replays&amp;op=view&amp;id=" . $id . "'\"style=\"cursor: pointer; background: " . $bg . ";\">\n"
				."<td align=\"center\"><img style=\"cursor: pointer; vertical-align: middle;\" src=\"" . $img_file . "\" width=\"40\" height=\"40\" onmouseOver=\"AffBulle('" . $img_name . "', '<img src=\'" . $img_file . "\'/>', 100);\" onmouseOut=\"HideBulle();\" /></td>\n"
				."<td align=\"center\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
			echo $ligne0;	
			echo $ligne1;	
			echo $ligne2;
			echo $ligne3;
			echo $ligne4
				."</table></td>\n"
        ."</tr>";
}

if($nb_replays == 0) {
	echo "<tr><td align=\"center\" colspan=\"8\">" . _NOREPLAYSINDB . "</td></tr>\n";
}

echo "</table>\n";

echo "<div style=\"text-align: center;padding-top: 5px;\"><a href=\"index.php?file=Replays\">" . _OTHERREPLAYS . "</a></div>\n";

?>