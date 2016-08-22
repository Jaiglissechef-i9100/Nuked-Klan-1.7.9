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

if (!defined("INDEX_CHECK")) {
	die ("<center>You cannot open this page directly</center>");
}

global $nuked, $user, $language;

translate("modules/Replays/lang/".$language.".lang.php");
include("modules/Replays/constants.php");

if(!$user){
	$visiteur="0";
} else {
	$visiteur=$user[1];
}

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{
	function index()
	{
		global $nuked, $language, $bgcolor3, $bgcolor2, $bgcolor1, $visiteur;

		opentable();

		echo "<br/><div style=\"text-align: center;\"><h3><b>"._RECAPREPLAY."</b></h3></div>\n";
		
             $sql_nbrep = mysql_query("SELECT max_replays FROM ". $nuked['prefix'] ."_replays_config");
                list($maxreplays) = mysql_fetch_array($sql_nbrep);               
                $nb_replays = $maxreplays;
				
                if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
                $start = $_REQUEST['p'] * $nb_replays - $nb_replays;
                
                $sql7 = mysql_query('SELECT id FROM ' . REPLAYSTABLE . ' ');
                $count = mysql_num_rows($sql7);



                if (!$_REQUEST['orderby']){
                 $_REQUEST['orderby'] = 'date';
                } 

                if ($_REQUEST['orderby'] == 'date'){
                    $order = 'ORDER BY id DESC';
                }
                else if ($_REQUEST['orderby'] == 'game'){
                    $order = 'ORDER BY game DESC, id DESC';
                }                 
                else if ($_REQUEST['orderby'] == 'type'){
                    $order = 'ORDER BY type DESC, id DESC';
                }
                else if ($_REQUEST['orderby'] == 'map'){
                    $order = 'ORDER BY map DESC, id DESC';
                } 
                else if ($_REQUEST['orderby'] == 'download'){
                    $order = 'ORDER BY compteur DESC, id DESC';
                } 

                else if ($_REQUEST['orderby'] == 'event'){
                    $order = 'ORDER BY evenement DESC, id DESC';
                } 
                else{
                    $order = 'ORDER BY id DESC';
                } 

                if ($count > 1){
                    echo '<br /><table width="100%"><tr><td style="text-align:right;">' . _ORDERBY . ' : </b>';

                    if ($_REQUEST['orderby'] == 'date'){
                        echo '<b>' . _DATEREPLAY . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Replays&amp;orderby=date">' . _DATEREPLAY . '</a> | ';
                    }
                    
                    if ($_REQUEST['orderby'] == 'game'){
                        echo '<b>' . _GAMES . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Replays&amp;orderby=game">' . _GAMES . '</a> | ';
                    }

                    if ($_REQUEST['orderby'] == 'type'){
                        echo '<b>' . _TYPE . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Replays&amp;orderby=type">' . _TYPE . '</a> | ';
                    }
                                        
                    if ($_REQUEST['orderby'] == 'map'){
                        echo '<b>' . _MAP . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Replays&amp;orderby=map">' . _MAP . '</a> | ';
                    } 

                    if ($_REQUEST['orderby'] == 'download'){
                        echo '<b>' . _DOWNLOAD . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Replays&amp;orderby=download">' . _DOWNLOAD . '</a> | ';
                    }

                    if ($_REQUEST['orderby'] == 'event'){
                        echo '<b>' . _EVEN . '</b>';
                    } 
                    else{
                        echo '<a href="index.php?file=Replays&amp;orderby=event">' . _EVEN . '</a>';
                    }
					
                    echo '</td></tr></table>';
                } 

                if ($count > $nb_replays){
                    $url_page = 'index.php?file=Replays&amp;orderby=' . $_REQUEST['orderby'];
                    number($count, $nb_replays, $url_page);
                } 

		
			echo"<table style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\"><tr style=\"background:" . $bgcolor3 . "\">\n"
			."<td align=\"center\" width=\"4%\"><b>"._GAMES."</b></td>\n"			
			."<td align=\"center\" width=\"5%\"><b>"._MAP."</b></td>\n"
			."<td align=\"center\" width=\"30%\"><b>"._EQUIPES."</b></td>\n"
			."<td align=\"center\" width=\"8%\"><b>"._EVEN."</b></td>\n"	
			."<td align=\"center\" width=\"7%\"><b>Date</b></td>\n"			
			."<td align=\"center\" width=\"3%\"><img src=\"modules/Replays/images/comments.png\" width=\"16\" height=\"16\" alt=\"" . _COMBLOK . "\" title=\"" . _COMBLOK . "\" /></td>\n"
			."<td align=\"center\" width=\"3%\"><img src=\"modules/Replays/images/download_mini.png\" width=\"16\" height=\"16\" alt=\"" . _DLBLOK . "\" title=\"" . _DLBLOK . "\" /></td>\n"
			."<td align=\"center\" width=\"3%\"><img src=\"modules/Replays/images/star.png\" width=\"16\" height=\"16\" alt=\"" . _VOTEBLOK . "\" title=\"" . _VOTEBLOK . "\" /></td>\n"
			."</tr>\n";

		$sql=mysql_query("SELECT id, titre, map, version, evenement, type, id_equipe, date_ajout, compteur, game FROM ".REPLAYSTABLE."  " . $order . " LIMIT " . $start . "," . $nb_replays." "); 
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
			$rowspan = "";
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
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, racejoueur1, racejoueur2, racejoueur3  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $racejoueur1, $racejoueur2, $racejoueur3) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}
			else if($type == 8) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}
      else if($type == 9) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}
      else if($type == 10) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
			}
			else if($type == 11) {
				$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
				$ligne0 ="<tr><td align=\"left\" style=\"padding-bottom:2px;\"><b>" . $titre . "</b></td></tr>\n";
				$ligne1 ="<tr><td align=\"left\"><img src=\"" . $rep_img . $racejoueur1 . "\" width=\"25\" height=\"25\" title=\"" . $joueur1 . "\" alt=\"" . $joueur1 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"25\" height=\"25\" title=\"" . $joueur2 . "\" alt=\"" . $joueur2 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"25\" height=\"25\" title=\"" . $joueur3 . "\" alt=\"" . $joueur3 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"25\" height=\"25\" title=\"" . $joueur4 . "\" alt=\"" . $joueur4 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"25\" height=\"25\" title=\"" . $joueur5 . "\" alt=\"" . $joueur5 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"25\" height=\"25\" title=\"" . $joueur6 . "\" alt=\"" . $joueur6 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"25\" height=\"25\" title=\"" . $joueur7 . "\" alt=\"" . $joueur7 . "\" style=\"vertical-align: middle;\"/><small><small>&nbsp;VS&nbsp;</small></small><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"25\" height=\"25\" title=\"" . $joueur8 . "\" alt=\"" . $joueur8 . "\" style=\"vertical-align: middle;\"/></td></tr>\n";
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

        ."<td align=\"center\"><img src=\"" . $icone . "\" alt=\"\" title=\"" . $game_name . "\" /><br /><small><small>" . $version . "</small></small></td>\n"
				."<td align=\"center\"><img style=\"cursor: pointer; vertical-align: middle;\" src=\"" . $img_file . "\" width=\"40\" height=\"40\" onmouseOver=\"AffBulle('" . $img_name . "', '<img src=\'" . $img_file . "\'/>', 100);\" onmouseOut=\"HideBulle();\" /></td>\n"
				."<td align=\"center\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
			echo $ligne0;				
			echo $ligne1;	
			echo $ligne2;
			echo $ligne3;
			echo $ligne4
				."</table></td>\n"
				."<td align=\"center\">" . $evenement . "</td>\n"	
				."<td align=\"center\">" . $date . "</td>\n"				
				."<td align=\"center\">" . $num_com . "</td>\n"
				."<td align=\"center\">" . $compteur . "</td>\n"
				."<td align=\"center\">\n";
			
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
	
			echo "<img src=\"" . $img_vote . "\" width=\"16\" height=\"16\" title=\"(" . $num_vote . "/10)\" alt=\"(" . $num_vote . "/10)\" /></td>\n";
				
			echo "</tr>";
		}
		
		if($nb_replays == 0) {
			echo "<tr><td align=\"center\" colspan=\"8\">" . _NOREPLAYSINDB . "</td></tr>\n";
		}
		
		echo "</table>\n";
	
//fonction changement de page	
                if ($count > $nb_replays){
                    $url_page = 'index.php?file=Replays&amp;orderby=' . $_REQUEST['orderby'];
                    number($count, $nb_replays, $url_page);
                }	
//fin de la fonction
		
		if($visiteur >=1) {
			echo "<br/><hr style=\"border: 0;border-bottom: 1px solid ;width: 80%\"><br/><div style=\"text-align: center;\">\n"
			."<span id=\"add_rep\" style=\"cursor:pointer;\"><b>"._ADDREPLAY."</b>&nbsp;<img id=\"updown\" style=\"vertical-align:middle\" width=\"16\" height=\"16\" src=\"modules/Replays/images/down.png\"/></span></div><br/>\n"
			."<div style=\"display:none;margin-left: 7%;margin-right: 7%;padding: 15px;\" id=\"view_champ\">\n";
			add();
			echo "</div>";
		}
		
		echo "<script>
			$(document).ready(function() {
				$('#add_rep').click(function() {
					if($('#view_champ').is(\":hidden\")) {
						$('#view_champ').slideDown('slow', function(){
							$('#updown').attr('src','modules/Replays/images/up.png');
						});
					} else {
						$('#view_champ').slideUp('slow', function(){
							$('#updown').attr('src','modules/Replays/images/down.png');
						});
					}
				});
			});
			</script>";
		
		closetable();
	}
	
	function add()
	{
		global $nuked;
		
				define('EDITOR_CHECK', 1);
		
		$upload_max_filesize = @ini_get('upload_max_filesize');
		$file_uploads = @ini_get('file_uploads');
		
		if ($file_uploads == 1 && $upload_max_filesize != "")
		{
			list($maxfilesize) = split('M', $upload_max_filesize);
			$upload_status = "(" . _MAX . " : " . $maxfilesize . "&nbsp;" . _MO . ")";
		}
		else
		{
			$upload_status = "";
		}
		
		echo "<div style=\"text-align: center;\"><em>" . _OBLIGATOIRE . "</em></div><br />";
		
		echo "<link rel=\"stylesheet\" href=\"modules/Replays/css/style.css\" type=\"text/css\" media=\"screen\" />\n"
			."<script src=\"modules/Replays/js/jquery.js\" type=\"text/javascript\"></script>\n"
			."<script src=\"modules/Replays/js/function.js\" type=\"text/javascript\"></script>\n"			
			."<form onsubmit=\"return checkFile();\" method=\"post\" action=\"index.php?file=Replays&amp;op=add_ban\" enctype=\"multipart/form-data\">\n"
			."<div class=\"formulaire\">\n"
			."<div class=\"row\">\n"
			."<label for=\"titre\">" . _TITRE . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"titre\" size=\"25\" value=\"\" /> *</span>\n"
			."</div>\n"
 //Ajout du Jeu		
      ."<div class=\"row\">\n"
      ."<label for=\"game\">" . _GAME . "&nbsp:</label>\n"
      ."<span class=\"formw\"><select name=\"game\">\n";
              $sql3 = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
              while (list($id_game, $name) = mysql_fetch_array($sql3)){
                  $name = htmlentities($name);
                  if ($id_game == $game){
                      $checked4 = "selected=\"selected\"";
                  } 
                  else{
                      $checked4 = "";
                  }
                  echo "<option value=\"" . $id_game . "\" " . $checked4 . ">" . $name . "</option>\n";
              } 
    echo "</select></span></div>\n"		
 //Fin Ajout du jeu			
			."<div class=\"row\">\n"
			."<label for=\"map\">" . _NOMMAP . "&nbsp:</label>\n"
			."<span class=\"formw\"><select onchange=\"changeImageMap();\" id=\"map\" name=\"map\">\n";
		select_map();
		echo "</select></span></div>\n"
			."<div class=\"row\">\n"
			."<label class=\"imgMap\">" . _PREVIEWMAP . "&nbsp:</label>\n"
			."<span class=\"formw\"><div id=\"img_map\" style=\"width: 100px; height: 100px;\"></div></span>\n"
			."</div>\n"
			."<div class=\"row\">\n"
			."<label for=\"evenement\">" . _EVENEMENT . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"evenement\" size=\"25\" value=\"\" /> *</span>\n"
			."</div>\n"
			."<div class=\"row\">\n"
			."<label for=\"duree\">" . _DUREE . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"duree\" size=\"10\" value=\"\" />&nbsp;Min *</span>\n"
			."</div>\n"
			."<div class=\"row\">\n"
			."<label for=\"taille\">" . _TAILLE . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"taille\" size=\"10\" value=\"\" />&nbsp;Ko *</span>\n"
			."</div>\n"
			."<div class=\"row\">\n"
			."<label for=\"version\">" . _VERSION . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"version\" size=\"10\" value=\"\" /> *</span>\n"
			."</div>\n"
			."<div class=\"row\">\n"
			."<label for=\"url\">" . _URL . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" id=\"url\" name=\"url\" size=\"50\" value=\"\" /></span>\n"
			."</div>\n"
			."<div class=\"row\">\n"
			."<label for=\"url\">" . _UPFILE . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"file\" id=\"copy\" name=\"copy\" onChange=\"checkFile();\" />&nbsp;" . $upload_status . "&nbsp;<input class=\"checkbox\" type=\"checkbox\" name=\"ecrase_file\" value=\"1\" /> " . _REPLACE . "</span>\n"
			."</div>\n"
			."<div class=\"row\">\n"
			."<label for=\"type\">" . _TYPEREPLAY . "&nbsp:</label>\n"
			."<span class=\"formw\"><select onchange=\"changeType();\" id=\"typeReplay\" name=\"typeReplay\">\n";
		select_type();	
		echo "</select></span></div>\n"
      
      ."<div id=\"un\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur1\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur1\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(1)\" id=\"joueur1race\" name=\"joueur1race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race1\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur2\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur2\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(2)\" id=\"joueur2race\" name=\"joueur2race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race2\"></span> *</div></div>\n"
		
			."<div id=\"deux\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur3\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur3\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(3)\" id=\"joueur3race\" name=\"joueur3race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race3\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur4\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur4\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(4)\" id=\"joueur4race\" name=\"joueur4race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race4\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur5\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur5\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(5)\" id=\"joueur5race\" name=\"joueur5race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race5\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur6\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur6\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(6)\" id=\"joueur6race\" name=\"joueur6race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race6\"></span> *</div></div>\n"
			
			."<div id=\"trois\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur7\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur7\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(7)\" id=\"joueur7race\" name=\"joueur7race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race7\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur8\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur8\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(8)\" id=\"joueur8race\" name=\"joueur8race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race8\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur9\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur9\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(9)\" id=\"joueur9race\" name=\"joueur9race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race9\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur10\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur10\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(10)\" id=\"joueur10race\" name=\"joueur10race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race10\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur11\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur11\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(11)\" id=\"joueur11race\" name=\"joueur11race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race11\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur12\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur12\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(12)\" id=\"joueur12race\" name=\"joueur12race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race12\"></span> *</div></div>\n"
			
			."<div id=\"quatre\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur13\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur13\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(13)\" id=\"joueur13race\" name=\"joueur13race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race13\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur14\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur14\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(14)\" id=\"joueur14race\" name=\"joueur14race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race14\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur15\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur15\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(15)\" id=\"joueur15race\" name=\"joueur15race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race15\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur16\">" . _EQUIPE1JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur16\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(16)\" id=\"joueur16race\" name=\"joueur16race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race16\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur17\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur17\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(17)\" id=\"joueur17race\" name=\"joueur17race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race17\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur18\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur18\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(18)\" id=\"joueur18race\" name=\"joueur18race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race18\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur19\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur19\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(19)\" id=\"joueur19race\" name=\"joueur19race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race19\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur20\">" . _EQUIPE2JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur20\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(20)\" id=\"joueur20race\" name=\"joueur20race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race20\"></span> *</div></div>\n"

			."<div id=\"cinq\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur21\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur21\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(21)\" id=\"joueur21race\" name=\"joueur21race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race21\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur22\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur22\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(22)\" id=\"joueur22race\" name=\"joueur22race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race22\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur23\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur23\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(23)\" id=\"joueur23race\" name=\"joueur23race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race23\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur24\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur24\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(24)\" id=\"joueur24race\" name=\"joueur24race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race24\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur25\">" . _EQUIPE3JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur25\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(25)\" id=\"joueur25race\" name=\"joueur25race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race25\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur26\">" . _EQUIPE3JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur26\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(26)\" id=\"joueur26race\" name=\"joueur26race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race26\"></span> *</div></div>\n"

			."<div id=\"six\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur27\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur27\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(27)\" id=\"joueur27race\" name=\"joueur27race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race27\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur28\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur28\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(28)\" id=\"joueur28race\" name=\"joueur28race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race28\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur29\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur29\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(29)\" id=\"joueur29race\" name=\"joueur29race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race29\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur30\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur30\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(30)\" id=\"joueur30race\" name=\"joueur30race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race30\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur31\">" . _EQUIPE3JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur31\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(31)\" id=\"joueur31race\" name=\"joueur31race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race31\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur32\">" . _EQUIPE3JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur32\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(32)\" id=\"joueur32race\" name=\"joueur32race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race32\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur33\">" . _EQUIPE4JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur33\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(33)\" id=\"joueur33race\" name=\"joueur33race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race33\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur34\">" . _EQUIPE4JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur34\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(34)\" id=\"joueur34race\" name=\"joueur34race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race34\"></span> *</div></div>\n"

			."<div id=\"sept\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur35\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur35\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(35)\" id=\"joueur35race\" name=\"joueur35race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race35\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur36\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur36\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(36)\" id=\"joueur36race\" name=\"joueur36race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race36\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur37\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur37\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(37)\" id=\"joueur37race\" name=\"joueur37race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race37\"></span> *</div></div>\n"

			."<div id=\"huit\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur38\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur38\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(38)\" id=\"joueur38race\" name=\"joueur38race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race38\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur39\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur39\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(39)\" id=\"joueur39race\" name=\"joueur39race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race39\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur40\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur40\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(40)\" id=\"joueur40race\" name=\"joueur40race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race40\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur41\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur41\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(41)\" id=\"joueur41race\" name=\"joueur41race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race41\"></span> *</div></div>\n"

			."<div id=\"neuf\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur42\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur42\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(42)\" id=\"joueur42race\" name=\"joueur42race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race42\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur43\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur43\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(43)\" id=\"joueur43race\" name=\"joueur43race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race43\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur44\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur44\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(44)\" id=\"joueur44race\" name=\"joueur44race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race44\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur45\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur45\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(45)\" id=\"joueur45race\" name=\"joueur45race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race45\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur46\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur46\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(46)\" id=\"joueur46race\" name=\"joueur46race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race46\"></span> *</div></div>\n"

			."<div id=\"dix\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur47\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur47\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(47)\" id=\"joueur47race\" name=\"joueur47race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race47\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur48\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur48\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(48)\" id=\"joueur48race\" name=\"joueur48race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race48\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur49\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur49\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(49)\" id=\"joueur49race\" name=\"joueur49race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race49\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur50\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur50\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(50)\" id=\"joueur50race\" name=\"joueur50race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race50\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur51\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur51\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(51)\" id=\"joueur51race\" name=\"joueur51race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race51\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur52\">" . _JOUEUR6 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur52\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(52)\" id=\"joueur52race\" name=\"joueur52race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race52\"></span> *</div></div>\n"

			."<div id=\"onze\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur53\">" . _JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur53\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(53)\" id=\"joueur53race\" name=\"joueur53race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race53\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur54\">" . _JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur54\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(54)\" id=\"joueur54race\" name=\"joueur54race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race54\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur55\">" . _JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur55\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(55)\" id=\"joueur55race\" name=\"joueur55race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race55\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur56\">" . _JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur56\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(56)\" id=\"joueur56race\" name=\"joueur56race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race56\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur57\">" . _JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur57\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(57)\" id=\"joueur57race\" name=\"joueur57race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race57\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur58\">" . _JOUEUR6 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur58\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(58)\" id=\"joueur58race\" name=\"joueur58race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race58\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur59\">" . _JOUEUR7 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur59\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(59)\" id=\"joueur59race\" name=\"joueur59race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race59\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur60\">" . _JOUEUR8 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur60\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(60)\" id=\"joueur60race\" name=\"joueur60race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race60\"></span> *</div></div>\n"

			."<div id=\"douze\" style=\"display:none;\">\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur61\">" . _EQUIPE1JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur61\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(61)\" id=\"joueur61race\" name=\"joueur61race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race61\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur62\">" . _EQUIPE1JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur62\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(62)\" id=\"joueur62race\" name=\"joueur62race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race62\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur63\">" . _EQUIPE1JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur63\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(63)\" id=\"joueur63race\" name=\"joueur63race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race63\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur64\">" . _EQUIPE1JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur64\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(64)\" id=\"joueur64race\" name=\"joueur64race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race64\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur65\">" . _EQUIPE1JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur65\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(65)\" id=\"joueur65race\" name=\"joueur65race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race65\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur66\">" . _EQUIPE2JOUEUR1 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur66\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(66)\" id=\"joueur66race\" name=\"joueur66race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race66\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur67\">" . _EQUIPE2JOUEUR2 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur67\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(67)\" id=\"joueur67race\" name=\"joueur67race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race67\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur68\">" . _EQUIPE2JOUEUR3 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur68\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(68)\" id=\"joueur68race\" name=\"joueur68race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race68\"></span> *</div>\n"
      ."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur69\">" . _EQUIPE2JOUEUR4 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur69\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(69)\" id=\"joueur69race\" name=\"joueur69race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race69\"></span> *</div>\n"
			."<div class=\"row\">\n"
			."<label class=\"joueur\" for=\"joueur70\">" . _EQUIPE2JOUEUR5 . "&nbsp:</label>\n"
			."<span class=\"formw\"><input type=\"text\" name=\"joueur70\" size=\"25\" value=\"\" />&nbsp;<select onchange=\"changeImageRace(70)\" id=\"joueur70race\" name=\"joueur70race\"></span>\n";
		select_joueur();
		echo "</select>&nbsp;<span id=\"img_race70\"></span> *</div></div>\n"			
			
			."<div class=\"row\">\n"
			."<label for=\"titre\">" . _TEXTE . "&nbsp:</label>\n"
			."<span class=\"formw\"><textarea id=\"e_basic\" name=\"texte\" cols=\"40\" rows=\"10\"></textarea></span>\n"
			."</div>\n"
			."<div class=\"row\">\n"
			."<span class=\"formw\"><input type=\"submit\" value=\""._ADDREPLAYS."\"></span></div>\n"
			."</div></form>\n";

		echo "<script language=\"javascript\">
			changeImageRace(1);
			changeImageRace(2);
			changeImageRace(3);
			changeImageRace(4);
			changeImageRace(5);
			changeImageRace(6);
			changeImageRace(7);
			changeImageRace(8);
			changeImageRace(9);
			changeImageRace(10);
			changeImageRace(11);
			changeImageRace(12);
			changeImageRace(13);
			changeImageRace(14);
			changeImageRace(15);
			changeImageRace(16);
			changeImageRace(17);
			changeImageRace(18);
			changeImageRace(19);
			changeImageRace(20);
			changeImageRace(21);
			changeImageRace(22);
			changeImageRace(23);
			changeImageRace(24);
			changeImageRace(25);
			changeImageRace(26);
			changeImageRace(27);
			changeImageRace(28);
			changeImageRace(29);
			changeImageRace(30);
			changeImageRace(31);
			changeImageRace(32);
			changeImageRace(33);
			changeImageRace(34);
			changeImageRace(35);
			changeImageRace(36);
			changeImageRace(37);
			changeImageRace(38);
			changeImageRace(39);
			changeImageRace(40);
			changeImageRace(41);
			changeImageRace(42);
			changeImageRace(43);
			changeImageRace(44);
			changeImageRace(45);
			changeImageRace(46);
			changeImageRace(47);
			changeImageRace(48);
			changeImageRace(49);
			changeImageRace(50);
			changeImageRace(51);
			changeImageRace(52);
			changeImageRace(53);
			changeImageRace(54);
			changeImageRace(55);
			changeImageRace(56);
			changeImageRace(57);
			changeImageRace(58);
			changeImageRace(59);
			changeImageRace(60);
			changeImageRace(61);
			changeImageRace(62);
			changeImageRace(63);
			changeImageRace(64);
			changeImageRace(65);
			changeImageRace(66);
			changeImageRace(67);
			changeImageRace(68);
			changeImageRace(69);
			changeImageRace(70);
			changeImageMap();
			changeType();
		  </script>";

		echo "<br/><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Replays\"><b>"._BACK."</b></a> ]</div><br />";
	}

	function select_type($type) {
    global $nuked;

		$sql_config = mysql_query("SELECT 1vs1, 2vs2, 3vs3, 4vs4, 5vs5, 2vs2vs2, 2vs2vs2vs2, ffa3pl, ffa4pl, ffa5pl, ffa6pl, ffa8pl FROM ". $nuked['prefix'] ."_replays_config");
		list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12) = mysql_fetch_array($sql_config);
		
		$selected1 = "";
		$selected2 = "";
		$selected3 = "";
		$selected4 = "";
		$selected5 = "";
		$selected6 = "";
		$selected7 = "";
		$selected8 = "";
		$selected9 = "";
		$selected10 = "";
		$selected11 = "";
		$selected12 = "";
	
		
		if($type == "" || $type == "1") {
			$selected1 = "selected=\"selected\"";
			
		} else if($type == "2") {
			$selected2 = "selected=\"selected\"";
			
		} else if($type == "3") {
			$selected3 = "selected=\"selected\"";
			
		} else if($type == "4") {
			$selected4 = "selected=\"selected\"";

		} else if($type == "5") {
			$selected5 = "selected=\"selected\"";
		
		} else if($type == "6") {
			$selected6 = "selected=\"selected\"";
		
		} else if($type == "7") {
			$selected7 = "selected=\"selected\"";
		
		} else if($type == "8") {
			$selected8 = "selected=\"selected\"";
		
		} else if($type == "9") {
			$selected9 = "selected=\"selected\"";
		
		} else if($type == "10") {
			$selected10 = "selected=\"selected\"";

		} else if($type == "11") {
			$selected11 = "selected=\"selected\"";

		} else if($type == "12") {
			$selected12 = "selected=\"selected\"";

		} 
		if ($c1 == 'on'){echo "<option " . $selected1 . " value=\"1\">1 VS 1</option>";}
		if ($c2 == 'on'){echo "<option " . $selected2 . " value=\"2\">2 VS 2</option>";}
		if ($c3 == 'on'){echo "<option " . $selected3 . " value=\"3\">3 VS 3</option>";}
		if ($c4 == 'on'){echo "<option " . $selected4 . " value=\"4\">4 VS 4</option>";}
		if ($c5 == 'on'){echo "<option " . $selected12 . " value=\"12\">5 VS 5</option>";}		
		if ($c6 == 'on'){echo "<option " . $selected5 . " value=\"5\">2 VS 2 VS 2</option>";}
		if ($c7 == 'on'){echo "<option " . $selected6 . " value=\"6\">2 VS 2 VS 2 VS 2</option>";}
		if ($c8 == 'on'){echo "<option " . $selected7 . " value=\"7\">" . _FFA3PL . "</option>";}
		if ($c9 == 'on'){echo "<option " . $selected8 . " value=\"8\">" . _FFA4PL . "</option>";}
		if ($c10 == 'on'){echo "<option " . $selected9 . " value=\"9\">" . _FFA5PL . "</option>";}
		if ($c11 == 'on'){echo "<option " . $selected10 . " value=\"10\">" . _FFA6PL . "</option>";}
		if ($c12 == 'on'){echo "<option " . $selected11 . " value=\"11\">" . _FFA8PL . "</option>";}
	}

	function select_map($map) {
		
		global $nuked;
		
		$sql=mysql_query("SELECT nom, image FROM ".MAPSTABLE." ORDER BY id"); 
		
		while(list($nom, $image) = mysql_fetch_array($sql)){ 
			
			$selected = "";
			if($map == $image) {
				$selected = "selected=\"selected\"";
			}
			
			echo "<option " . $selected . " value=\"" . $image . "\">" . $nom . "</option>";
		}
	}

	function select_joueur($race) {
		global $nuked;
		
		$sql=mysql_query("SELECT nom, image FROM " . RACETABLE . " ORDER BY id"); 
		
		while(list($nom, $image) = mysql_fetch_array($sql)) { 
			
			$selected = "";
			if($race == $image) {
				$selected = "selected=\"selected\"";
			}
		
			echo"<option " . $selected . " value=\"" . $image . "\">" . $nom . "</option>";
		}
	}
	
	function add_ban($titre, $map, $evenement, $duree, $taille, $version, $url, $copy, $ecrase_file, $typeReplay, $game, $joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10, $joueur11, $joueur12, $joueur13, $joueur14, $joueur15, $joueur16, $joueur17, $joueur18, $joueur19, $joueur20, $joueur21, $joueur22, $joueur23, $joueur24, $joueur25, $joueur26, $joueur27, $joueur28, $joueur29, $joueur30, $joueur31, $joueur32, $joueur33, $joueur34, $joueur35, $joueur36, $joueur37, $joueur38, $joueur39, $joueur40, $joueur41, $joueur42, $joueur43, $joueur44, $joueur45, $joueur46, $joueur47, $joueur48, $joueur49, $joueur50, $joueur51, $joueur52, $joueur53, $joueur54, $joueur55, $joueur56, $joueur57, $joueur58, $joueur59, $joueur60, $joueur61, $joueur62, $joueur63, $joueur64, $joueur65, $joueur66, $joueur67, $joueur68, $joueur69, $joueur70, $joueur1race, $joueur2race, $joueur3race, $joueur4race, $joueur5race, $joueur6race, $joueur7race, $joueur8race, $joueur9race, $joueur10race, $joueur11race, $joueur12race, $joueur13race, $joueur14race, $joueur15race, $joueur16race, $joueur17race, $joueur18race, $joueur19race, $joueur20race, $joueur21race, $joueur22race, $joueur23race, $joueur24race, $joueur25race, $joueur26race, $joueur27race, $joueur28race, $joueur29race, $joueur30race, $joueur31race, $joueur32race, $joueur33race, $joueur34race, $joueur35race, $joueur36race, $joueur37race, $joueur38race, $joueur39race, $joueur40race, $joueur41race, $joueur42race, $joueur43race, $joueur44race, $joueur45race, $joueur46race, $joueur47race, $joueur48race, $joueur49race, $joueur50race, $joueur51race, $joueur52race, $joueur53race, $joueur54race, $joueur55race, $joueur56race, $joueur57race, $joueur58race, $joueur59race, $joueur60race, $joueur61race, $joueur62race, $joueur63race, $joueur64race, $joueur65race, $joueur66race, $joueur67race, $joueur68race, $joueur69race, $joueur70race, $texte)
	{
		global $nuked, $user;
		
		$error = false;
		$error_string = "<div style=\"text-align: center;\"><ul>";
		if(trim($titre) == "") {
			$error_string .= "<li>" . _NOTITRE . "</li>";
			$error = true;
		}
		
		if(trim($evenement) == "") {
			$error_string .="<li>" . _NOEVENT . "</li>";
			$error = true;
		}
		
		if(trim($duree) == "") {
			$error_string .="<li>" . _NODUREE . "</li>";
			$error = true;
		}
		
		if(trim($taille) == "" && $_FILES['copy']['name'] == "") {
			$error_string .="<li>" . _NOTAILLE . "</li>";
			$error = true;
		}
		
		if(trim($version) == "") {
			$error_string .="<li>" . _NOVERSION . "</li>";
			$error = true;
		}
		
		if($typeReplay == 1) {
			if(trim($joueur1) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur2) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 2) {
			if(trim($joueur3) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur4) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur5) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur6) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 3) {
			if(trim($joueur7) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur8) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur9) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur10) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur11) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur12) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 4) {
			if(trim($joueur13) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur14) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur15) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur16) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur17) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur18) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur19) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur20) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 5) {
			if(trim($joueur21) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur22) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur23) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur24) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur25) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur26) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}			
		} else if($typeReplay == 6) {
			if(trim($joueur27) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur28) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur29) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur30) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur31) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur32) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur33) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur34) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
    } else if($typeReplay == 7) {
			if(trim($joueur35) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur36) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur37) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 8) {
			if(trim($joueur38) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur39) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur40) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur41) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 9) {
			if(trim($joueur42) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur43) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur44) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur45) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur46) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
		} else if($typeReplay == 10) {
			if(trim($joueur47) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur48) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur49) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur50) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur51) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur52) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}			
		} else if($typeReplay == 11) {
			if(trim($joueur53) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur54) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur55) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur56) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur57) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur58) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur59) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur60) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
    } else if($typeReplay == 12) {
			if(trim($joueur61) == "") {
				$error_string .="<li>" . _NOJOUEUR1 . "</li>";
				$error = true;
			}
			
			if(trim($joueur62) == "") {
				$error_string .="<li>" . _NOJOUEUR2 . "</li>";
				$error = true;
			}
			
			if(trim($joueur63) == "") {
				$error_string .="<li>" . _NOJOUEUR3 . "</li>";
				$error = true;
			}
			
			if(trim($joueur64) == "") {
				$error_string .="<li>" . _NOJOUEUR4 . "</li>";
				$error = true;
			}
			
			if(trim($joueur65) == "") {
				$error_string .="<li>" . _NOJOUEUR5 . "</li>";
				$error = true;
			}
			
			if(trim($joueur66) == "") {
				$error_string .="<li>" . _NOJOUEUR6 . "</li>";
				$error = true;
			}
			
			if(trim($joueur67) == "") {
				$error_string .="<li>" . _NOJOUEUR7 . "</li>";
				$error = true;
			}
			
			if(trim($joueur68) == "") {
				$error_string .="<li>" . _NOJOUEUR8 . "</li>";
				$error = true;
			}
			
			if(trim($joueur69) == "") {
				$error_string .="<li>" . _NOJOUEUR9 . "</li>";
				$error = true;
			}
			
			if(trim($joueur70) == "") {
				$error_string .="<li>" . _NOJOUEUR10 . "</li>";
				$error = true;
			}
    }
		
		$error_string .="</ul><br/><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div>";
		
		if($error) {
			echo $error_string;
		} else {
		
			// Upload du fichier si il est fourni
			$racine_up = "upload/Replays/";
			$racine_down = "";
			
			if(!is_dir("upload/Replays")) {
				mkdir("upload/Replays");
			}

			if ($_FILES['copy']['name'] != "")
			{
				$filename = $_FILES['copy']['name'];
				$filesize = $_FILES['copy']['size'];
				$taille = $filesize / 1024;
				$taille = (round($taille * 100)) / 100;

				$url_file = $racine_up . $filename;

				if (!is_file($url_file)  || $ecrase_file == 1)
				{
					if (!eregi("\.php", $filename) && !eregi("\.htm", $filename) && !eregi("\.[a-z]htm", $filename) && $filename != ".htaccess")
					{
						move_uploaded_file($_FILES['copy']['tmp_name'], $url_file) or die ("Upload file failed !!!");
						@chmod ($url_file, 0644);
					}
					else
					{
						echo "<br /><br /><div style=\"text-align: center;\">Unauthorized file !!!</div><br /><br />";
						redirect("index.php?file=Replays", 2);
						closetable();
						footer();
						exit();
					}
				}
				else
				{
					$deja_file = 1;
				}

				$url_full = $racine_down . $url_file;
				$url_full = $url_file;

				$url = $url_full;
			}
			
			if ($deja_file == 1)
			{
				echo "<br /><br /><div style=\"text-align: center;\">" . _DEJAFILE;
				echo "<br />" . _REPLACEIT . "<br /><br /><a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a></div><br /><br />";
			} else {
				if($typeReplay == 1) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, racejoueur1, racejoueur2) VALUES('" . $joueur1 . "', '" . $joueur2 . "', '" . $joueur1race . "', '" . $joueur2race . "')");
				} else if($typeReplay == 2) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4) VALUES('" . $joueur3 . "', '" . $joueur4 . "', '" . $joueur5 . "', '" . $joueur6 . "', '" . $joueur3race . "', '" . $joueur4race . "', '" . $joueur5race . "', '" . $joueur6race . "')");
				} else if($typeReplay == 3) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6) VALUES('" . $joueur7 . "', '" . $joueur8 . "', '" . $joueur9 . "', '" . $joueur10 . "', '" . $joueur11 .  "', '" . $joueur12 .  "', '" . $joueur7race . "', '" . $joueur8race .  "', '" . $joueur9race .  "', '" . $joueur10race . "', '" . $joueur11race . "', '" . $joueur12race . "')");
				} else if($typeReplay == 4){
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8) VALUES('" . $joueur13 . "', '" . $joueur14 . "', '" . $joueur15 . "', '" . $joueur16 . "', '" . $joueur17 . "', '" . $joueur18 . "', '" . $joueur19 . "', '" . $joueur20 .  "', '" . $joueur13race . "', '" . $joueur14race .  "', '" . $joueur15race . "', '" . $joueur16race .  "', '" . $joueur17race . "', '" . $joueur18race . "', '" . $joueur19race . "', '" . $joueur20race . "')");
				} else if($typeReplay == 5) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6) VALUES('" . $joueur21 . "', '" . $joueur22 . "', '" . $joueur23 . "', '" . $joueur24 . "', '" . $joueur25 .  "', '" . $joueur26 .  "', '" . $joueur21race . "', '" . $joueur22race .  "', '" . $joueur23race .  "', '" . $joueur24race . "', '" . $joueur25race . "', '" . $joueur26race . "')");				
				} else if($typeReplay == 6) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8) VALUES('" . $joueur27 . "', '" . $joueur28 . "', '" . $joueur29 . "', '" . $joueur30 . "', '" . $joueur31 . "', '" . $joueur32 . "', '" . $joueur33 . "', '" . $joueur34 .  "', '" . $joueur27race . "', '" . $joueur28race .  "', '" . $joueur29race . "', '" . $joueur30race .  "', '" . $joueur31race . "', '" . $joueur32race . "', '" . $joueur33race . "', '" . $joueur34race . "')");
				} else if($typeReplay == 7) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, racejoueur1, racejoueur2, racejoueur3) VALUES('" . $joueur35 . "', '" . $joueur36 . "', '" . $joueur37 . "', '" . $joueur35race . "', '" . $joueur36race . "', '" . $joueur37race . "')");
				} else if($typeReplay == 8) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4) VALUES('" . $joueur38 . "', '" . $joueur39 . "', '" . $joueur40 . "', '" . $joueur41 . "', '" . $joueur38race . "', '" . $joueur39race . "', '" . $joueur40race . "', '" . $joueur41race . "')");
				} else if($typeReplay == 9) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5) VALUES('" . $joueur42 . "', '" . $joueur43 . "', '" . $joueur44 . "', '" . $joueur45 . "', '" . $joueur46 . "', '" . $joueur42race . "', '" . $joueur43race . "', '" . $joueur44race . "', '" . $joueur45race . "', '" . $joueur46race . "')");
				} else if($typeReplay == 10) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6) VALUES('" . $joueur47 . "', '" . $joueur48 . "', '" . $joueur49 . "', '" . $joueur50 . "', '" . $joueur51 .  "', '" . $joueur52 .  "', '" . $joueur47race . "', '" . $joueur48race .  "', '" . $joueur49race .  "', '" . $joueur50race . "', '" . $joueur51race . "', '" . $joueur52race . "')");				
				} else if($typeReplay == 11) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8) VALUES('" . $joueur53 . "', '" . $joueur54 . "', '" . $joueur55 . "', '" . $joueur56 . "', '" . $joueur57 . "', '" . $joueur58 . "', '" . $joueur59 . "', '" . $joueur60 .  "', '" . $joueur53race . "', '" . $joueur54race .  "', '" . $joueur55race . "', '" . $joueur56race .  "', '" . $joueur57race . "', '" . $joueur58race . "', '" . $joueur59race . "', '" . $joueur60race . "')");
				} else if($typeReplay == 12) {
					$add_equipe = mysql_query("INSERT INTO " . EQUIPESTABLE . "(joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, joueur9, joueur10, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8, racejoueur9, racejoueur10) VALUES('" . $joueur61 . "', '" . $joueur62 . "', '" . $joueur63 . "', '" . $joueur64 . "', '" . $joueur65 . "', '" . $joueur66 . "', '" . $joueur67 . "', '" . $joueur68 . "', '" . $joueur69 . "', '" . $joueur70 .  "', '" . $joueur61race . "', '" . $joueur62race .  "', '" . $joueur63race . "', '" . $joueur64race .  "', '" . $joueur65race .  "', '" . $joueur66race .  "', '" . $joueur67race . "', '" . $joueur68race . "', '" . $joueur69race . "', '" . $joueur70race . "')");
				}
				
				
				
				$id_equipe = mysql_insert_id();
				$auj = time();
			$add=mysql_query("INSERT INTO " . REPLAYSTABLE . "(titre, texte, evenement, map, duree, taille, version, url, id_equipe, type, id_user, date_ajout, game) VALUES ('" . $titre . "', '" . $texte . "', '" . $evenement . "', '" . $map . "', '" . $duree . "', '" . $taille . "', '" . $version . "', '" . $url . "', " . $id_equipe . ", " . $typeReplay . ", '" . $user[0] . "', '" . $auj . "', '" . $game . "')");
				
				echo "<br /><br /><div style=\"text-align: center;\">" . _REPLAYADDSUCCESS . "</div><br /><br />";

				redirect("index.php?file=Replays", 2);
			}
		}
	}

	function view($id)
	{
		global $nuked, $language, $bgcolor3, $bgcolor2, $bgcolor1;
		
		include ("modules/Vote/index.php");
		
		opentable();
		
		$sql=mysql_query("SELECT titre, texte, evenement, map, duree , taille, version, id_equipe, type, id_user, date_ajout, game FROM " . REPLAYSTABLE . " WHERE id='" . $id . "'" ); 
		
		list($titre, $texte, $evenement, $map, $duree , $taille, $version, $id_equipe, $type, $idUser, $dateAjout, $game) = mysql_fetch_row($sql);

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
			$img_file = "modules/Replays/images/noreplay.gif";
		} else {
			list($img_name) = mysql_fetch_row($sql_map);
			$img_file = "modules/Replays/images/maps/" . $map;
		}
		
		if($type == 1) {
			$typeReplay = "1 VS 1";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, racejoueur1, racejoueur2 FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur3, $racejoueur1, $racejoueur3) = mysql_fetch_row($sql_joueurs);
		} else if($type == 2) {
			$typeReplay = "2 VS 2";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
		} else if($type == 3) {
			$typeReplay = "3 VS 3";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
		} else if($type == 4){
			$typeReplay = "4 VS 4";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
		} else if($type == 5) {
			$typeReplay = "2 VS 2 VS 2";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
			list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
		} else if($type == 6) {
			$typeReplay = "2 VS 2 VS 2 VS 2";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
		} else if($type == 7) {
			$typeReplay = "" . _FFA3PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, racejoueur1, racejoueur2, racejoueur3  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $racejoueur1, $racejoueur2, $racejoueur3) = mysql_fetch_row($sql_joueurs);
		} else if($type == 8) {
			$typeReplay = "" . _FFA4PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, racejoueur1, racejoueur2, racejoueur3, racejoueur4  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4) = mysql_fetch_row($sql_joueurs);
		} else if($type == 9) {
			$typeReplay = "" . _FFA5PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5) = mysql_fetch_row($sql_joueurs);
		} else if($type == 10) {
			$typeReplay = "" . _FFA6PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6) = mysql_fetch_row($sql_joueurs);
		} else if($type == 11) {
			$typeReplay = "" . _FFA8PL . "";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8) = mysql_fetch_row($sql_joueurs);
		} else if($type == 12) {
			$typeReplay = "5 VS 5";
			$sql_joueurs = mysql_query("SELECT joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, joueur9, joueur10, racejoueur1, racejoueur2, racejoueur3, racejoueur4, racejoueur5, racejoueur6, racejoueur7, racejoueur8, racejoueur9, racejoueur10  FROM " . EQUIPESTABLE . " WHERE id = " . $id_equipe);
				list($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10, $racejoueur1, $racejoueur2, $racejoueur3, $racejoueur4, $racejoueur5, $racejoueur6, $racejoueur7, $racejoueur8, $racejoueur9, $racejoueur10) = mysql_fetch_row($sql_joueurs);
		} 
		
		$sql_user = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id='" . $idUser . "'");
		list($pseudo) = mysql_fetch_row($sql_user);
		
		if($dateAjout != "") {
			$date = strftime("%x", $dateAjout);
		}
		
		$rep_img = "modules/Replays/images/race/";
		
		echo "<br /><table width=\"100%\" border=\"0\" cellspacing=\"3\" cellpadding=\"3\">\n"
			."<tr><td style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" align=\"center\">\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
			."<tr><td style=\"width: 5%;\">&nbsp;</td>\n"
			."<td style=\"width: 90%;\" align=\"center\"><big><b>" . $titre . "</b></big></td></tr></table></td></tr>\n"
			."<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td width=\"33%\"><b>" . _GAME . "</b>&nbsp;:&nbsp;<img src=\"" . $icone . "\" alt=\"\" title=\"" . $game_name . "\" /></td>\n"			
			."<td width=\"33%\"><b>" . _MAP . "</b>&nbsp;:&nbsp;" . $img_name . "</td>\n"
			."<td width=\"33%\"><b>" . _EVENEMENT . "</b>&nbsp;:&nbsp;" . $evenement . "</td></tr>\n"
			."<tr><td width=\"33%\"><b>" . _VERSION . "</b>&nbsp;:&nbsp;" . $version . "</td>\n"
			."<td width=\"33%\"><b>" . _DUREE . "</b>&nbsp;:&nbsp;" . $duree . "&nbsp;Min</td>\n"
			."<td width=\"33%\"><b>" . _TYPEREPLAY . "</b>&nbsp;:&nbsp;" . $typeReplay . "</td></tr>\n"
			."<tr><td width=\"33%\"><b>" . _AUTHOR . "</b>&nbsp;:&nbsp;" . $pseudo . "</td>\n"
			."<td width=\"33%\"><b>" . _DATEADDED . "</b>&nbsp;:&nbsp;" . $date . "</td>\n"
			."<td width=\"33%\">\n";
		vote_index("Replays", $id);
		echo "</td></tr></table></td></tr>\n";
			
		$rowspan = "";
		$ligne2 = "";
		$ligne3 = "";
		$ligne4 = "";
		$ligne5 = "";		
		
		if($type == 1) {
			$rowspan = "rowspan=\"1\"";
		
			
		echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur3 . "</td></tr>\n"
			."</table></fieldset>\n";
			
			
		}	else if($type == 2) {
			$rowspan = "rowspan=\"2\"";
			$ligne2 = "<tr><td align=\"right\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur4 . "</td></tr>\n";
		
			
		echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur3 . "</td></tr>\n";
		echo $ligne2
			."</table></fieldset>\n";
			
			
		}	else if($type == 3) {
			$rowspan = "rowspan=\"3\"";
			$ligne2 = "<tr><td align=\"right\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur5 . "</td></tr>\n";
			$ligne3 = "<tr><td align=\"right\">" . $joueur3 . "&nbsp;<img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur6 . "</td></tr>\n";
		
			echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur4 . "</td></tr>\n";
		echo $ligne2;
		echo $ligne3
			."</table></fieldset>\n";
			
			
		}	else if($type == 4){
			$rowspan = "rowspan=\"4\"";
			$ligne2 = "<tr><td align=\"right\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur6 . "</td></tr>\n";
			$ligne3 = "<tr><td align=\"right\">" . $joueur3 . "&nbsp;<img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur7 . "</td></tr>\n";
			$ligne4 = "<tr><td align=\"right\">" . $joueur4 . "&nbsp;<img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur8 . "</td></tr>\n";
		
			echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur5 . "</td></tr>\n";
		echo $ligne2;
		echo $ligne3;
		echo $ligne4
			."</table></fieldset>\n";
			
			
		}		else if($type == 5) {
			$rowspan = "rowspan=\"3\"";
			$ligne2 = "<tr><td align=\"right\" style=\"color:#6d73ff\">" . $joueur3 . "&nbsp;<img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur4 . "</td></tr>\n";
			$ligne3 = "<tr><td align=\"right\" style=\"color:#6fdf4d\">" . $joueur5 . "&nbsp;<img src=\"" . $rep_img . $racejoueur5 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur6 . "</td></tr>\n";
		
			echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\" style=\"color:#c662fa\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur2 . "</td></tr>\n";
		echo $ligne2;
		echo $ligne3
			."</table></fieldset>\n";
			
			
		}	else if($type == 6){
			$rowspan = "rowspan=\"4\"";
			$ligne2 = "<tr><td align=\"right\" style=\"color:#6d73ff\">" . $joueur3 . "&nbsp;<img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur4 . "</td></tr>\n";
			$ligne3 = "<tr><td align=\"right\" style=\"color:#6fdf4d\">" . $joueur5 . "&nbsp;<img src=\"" . $rep_img . $racejoueur5 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#6fdf4d\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur6 . "</td></tr>\n";
			$ligne4 = "<tr><td align=\"right\" style=\"color:#ffa32d\">" . $joueur7 . "&nbsp;<img src=\"" . $rep_img . $racejoueur7 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#ffa32d\"><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur8 . "</td></tr>\n";
		
			echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\" style=\"color:#c662fa\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\" style=\"color:#c662fa\"><img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur2 . "</td></tr>\n";
		echo $ligne2;
		echo $ligne3;
		echo $ligne4
			."</table></fieldset>\n";
			
			
		}	else if($type == 7) {
			$rowspan = "rowspan=\"2\"";
			$ligne2 = "<tr><td align=\"right\" style=\"color:#6fdf4d\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\">&nbsp;</td></tr>\n";
		
			
		echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\" style=\"color:#c662fa\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur3 . "</td></tr>\n";
		echo $ligne2
			."</table></fieldset>\n";
			
			
		}	else if($type == 8) {
			$rowspan = "rowspan=\"2\"";
			$ligne2 = "<tr><td align=\"right\" style=\"color:#6fdf4d\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#ffa32d\"><img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur4 . "</td></tr>\n";
		
			
		echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\" style=\"color:#c662fa\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\" style=\"color:#6d73ff\"><img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur3 . "</td></tr>\n";
		echo $ligne2
			."</table></fieldset>\n";
			
			
		}	else if($type == 9){
			$rowspan = "rowspan=\"4\"";
			$ligne2 = "<tr><td align=\"right\" style=\"color:#6d73ff\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\">&nbsp;</td></tr>\n";
			$ligne3 = "<tr><td align=\"right\" style=\"color:#6fdf4d\">" . $joueur3 . "&nbsp;<img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\">&nbsp;</td></tr>\n";
			$ligne4 = "<tr><td align=\"right\" style=\"color:#ffa32d\">" . $joueur4 . "&nbsp;<img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\">&nbsp;</td></tr>\n";
		
			echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\" style=\"color:#c662fa\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\"style=\"color:#fc58ff\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur5 . "</td></tr>\n";
		echo $ligne2;
		echo $ligne3;
		echo $ligne4
			."</table></fieldset>\n";
			
			
		}	else if($type == 10){
			$rowspan = "rowspan=\"4\"";
			$ligne2 = "<tr><td align=\"right\" style=\"color:#6d73ff\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#e4d544\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur6 . "</td></tr>\n";
			$ligne3 = "<tr><td align=\"right\" style=\"color:#6fdf4d\">" . $joueur3 . "&nbsp;<img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\">&nbsp;</td></tr>\n";
			$ligne4 = "<tr><td align=\"right\" style=\"color:#ffa32d\">" . $joueur4 . "&nbsp;<img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\">&nbsp;</td></tr>\n";
		
			echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\" style=\"color:#c662fa\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\"style=\"color:#fc58ff\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur5 . "</td></tr>\n";
		echo $ligne2;
		echo $ligne3;
		echo $ligne4
			."</table></fieldset>\n";
			
			
		}	else if($type == 11){
			$rowspan = "rowspan=\"4\"";
			$ligne2 = "<tr><td align=\"right\" style=\"color:#6d73ff\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#e4d544\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur6 . "</td></tr>\n";
			$ligne3 = "<tr><td align=\"right\" style=\"color:#6fdf4d\">" . $joueur3 . "&nbsp;<img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#4ab4e8\"><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur7 . "</td></tr>\n";
			$ligne4 = "<tr><td align=\"right\" style=\"color:#ffa32d\">" . $joueur4 . "&nbsp;<img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\" style=\"color:#d88285\"><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur8 . "</td></tr>\n";
		
			echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\" style=\"color:#c662fa\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\"style=\"color:#fc58ff\"><img src=\"" . $rep_img . $racejoueur5 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur5 . "</td></tr>\n";
		echo $ligne2;
		echo $ligne3;
		echo $ligne4
			."</table></fieldset>\n";
			
			
		}	else if($type == 12){
			$rowspan = "rowspan=\"5\"";
			$ligne2 = "<tr><td align=\"right\">" . $joueur2 . "&nbsp;<img src=\"" . $rep_img . $racejoueur2 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur7 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur7 . "</td></tr>\n";
			$ligne3 = "<tr><td align=\"right\">" . $joueur3 . "&nbsp;<img src=\"" . $rep_img . $racejoueur3 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur8 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur8 . "</td></tr>\n";
			$ligne4 = "<tr><td align=\"right\">" . $joueur4 . "&nbsp;<img src=\"" . $rep_img . $racejoueur4 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur9 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur9 . "</td></tr>\n";
			$ligne5 = "<tr><td align=\"right\">" . $joueur5 . "&nbsp;<img src=\"" . $rep_img . $racejoueur5 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur10 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur10 . "</td></tr>\n";
		
			echo "<tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n"
			."<fieldset style=\"margin: 20px 0;width: 70%;-moz-border-radius: 5px;-webkit-border-radius: 5px;\"><legend style=\"font-weight: bold;\">" . _EQUIPES . "</legend>\n"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
			."<tr><td align=\"right\">" . $joueur1 . "&nbsp;<img src=\"" . $rep_img . $racejoueur1 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/></td><td " . $rowspan . " align=\"center\"><img src=\"" . $img_file . "\" width=\"200\" height=\"200\" title=\"" . $img_name . "\" /></td><td align=\"left\"><img src=\"" . $rep_img . $racejoueur6 . "\" width=\"42\" height=\"42\" style=\"vertical-align: middle;\"/>&nbsp;" . $joueur6 . "</td></tr>\n";
		echo $ligne2;
		echo $ligne3;
		echo $ligne4;
		echo $ligne5		
			."</table></fieldset>\n";
			
			
		}	
			
			
			
    $texte = secu_html(html_entity_decode($texte));			
		if(trim($texte) != "") {
			echo "<hr style=\"border: 0; border-bottom: 1px dashed;width: 80%;\"/><div style=\"width: 50%;\">" . $texte . "</div><br/>\n";
		}
		include ("modules/Comment/index.php");
		 
		
		echo "</tr><tr style=\"background: " . $bgcolor1 . ";\"><td align=\"center\" style=\"border: 1px dashed " . $bgcolor3 . ";\">\n";
		com_index("Replays", $id);
		echo "<br/><br/><a href=\"#\" onclick=\"javascript:window.open('index.php?file=Replays&amp;op=do_dl&amp;dl_id=" . $id . "','Replays','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=360,height=200,top=30,left=0'); return false;\" ><img style=\"border: 0;\" src=\"modules/Replays/images/download.png\" width=\"48\" height=\"48\" title=\"" . _DL . "\"/></a>\n";
		
		if ($taille != "" && $taille < 1000) 
		{
			$size = $taille . "&nbsp;" . _KO;
		}
		else if ($taille != "" && $taille >= 1000 && $taille < 1000000)
		{
			$taille = $taille / 1000;
			$taille = (round($taille * 100)) / 100;
			$size = $taille. "&nbsp;" . _MO;
		}
		else if ($taille != "" && $taille >= 1000000) {
			$taille = $taille / 1000000;
			$taille = (round($taille * 100)) / 100;
			$size = $taille. "&nbsp;" . _GO;
		}	
		else
		{
			$size = "N/A";
		}
		
		echo "<br/><em>(". _TAILLE ."&nbsp;:&nbsp;" . $size . ")</em></td></tr>\n";

		echo "</table\n";
		
		echo "<br/><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Replays\"><b>"._BACK."</b></a> ]</div><br />";
		closetable();
	}
	
	function do_dl($id) {
		
		global $nuked;
		
		$sql_compteur = mysql_query("SELECT url, compteur FROM " . REPLAYSTABLE . " WHERE id=" . $id);
        list($url, $compteur) = mysql_fetch_row($sql_compteur);
		
		$new_compteur = $compteur + 1;
        $upd = mysql_query("UPDATE " . REPLAYSTABLE . " SET compteur = '" . $new_compteur . "' WHERE id = '" . $id . "'");
		
		header("location: " . $url);
	}

	switch($_REQUEST['op'])
	{
		case "main":
		index();
		break;

		case "view":
		view($_REQUEST['id']);
		break;
		
		case "add_ban":
		opentable();
		add_ban($_REQUEST['titre'], $_REQUEST['map'], $_REQUEST['evenement'], $_REQUEST['duree'], $_REQUEST['taille'], $_REQUEST['version'], $_REQUEST['url'], $_REQUEST['copy'], $_REQUEST['ecrase_file'], $_REQUEST['typeReplay'], $_REQUEST['game'], $_REQUEST['joueur1'], $_REQUEST['joueur2'], $_REQUEST['joueur3'], $_REQUEST['joueur4'], $_REQUEST['joueur5'], $_REQUEST['joueur6'], $_REQUEST['joueur7'], $_REQUEST['joueur8'], $_REQUEST['joueur9'], $_REQUEST['joueur10'], $_REQUEST['joueur11'], $_REQUEST['joueur12'], $_REQUEST['joueur13'], $_REQUEST['joueur14'], $_REQUEST['joueur15'], $_REQUEST['joueur16'], $_REQUEST['joueur17'], $_REQUEST['joueur18'], $_REQUEST['joueur19'], $_REQUEST['joueur20'], $_REQUEST['joueur21'], $_REQUEST['joueur22'], $_REQUEST['joueur23'], $_REQUEST['joueur24'], $_REQUEST['joueur25'], $_REQUEST['joueur26'], $_REQUEST['joueur27'], $_REQUEST['joueur28'], $_REQUEST['joueur29'], $_REQUEST['joueur30'], $_REQUEST['joueur31'], $_REQUEST['joueur32'], $_REQUEST['joueur33'], $_REQUEST['joueur34'], $_REQUEST['joueur35'], $_REQUEST['joueur36'], $_REQUEST['joueur37'], $_REQUEST['joueur38'], $_REQUEST['joueur39'], $_REQUEST['joueur40'], $_REQUEST['joueur41'], $_REQUEST['joueur42'], $_REQUEST['joueur43'], $_REQUEST['joueur44'], $_REQUEST['joueur45'], $_REQUEST['joueur46'], $_REQUEST['joueur47'], $_REQUEST['joueur48'], $_REQUEST['joueur49'], $_REQUEST['joueur50'], $_REQUEST['joueur51'], $_REQUEST['joueur52'], $_REQUEST['joueur53'], $_REQUEST['joueur54'], $_REQUEST['joueur55'], $_REQUEST['joueur56'], $_REQUEST['joueur57'], $_REQUEST['joueur58'], $_REQUEST['joueur59'], $_REQUEST['joueur60'], $_REQUEST['joueur61'], $_REQUEST['joueur62'], $_REQUEST['joueur63'], $_REQUEST['joueur64'], $_REQUEST['joueur65'], $_REQUEST['joueur66'], $_REQUEST['joueur67'], $_REQUEST['joueur68'], $_REQUEST['joueur69'], $_REQUEST['joueur70'], $_REQUEST['joueur1race'], $_REQUEST['joueur2race'], $_REQUEST['joueur3race'], $_REQUEST['joueur4race'], $_REQUEST['joueur5race'], $_REQUEST['joueur6race'], $_REQUEST['joueur7race'], $_REQUEST['joueur8race'], $_REQUEST['joueur9race'], $_REQUEST['joueur10race'], $_REQUEST['joueur11race'], $_REQUEST['joueur12race'], $_REQUEST['joueur13race'], $_REQUEST['joueur14race'], $_REQUEST['joueur15race'], $_REQUEST['joueur16race'], $_REQUEST['joueur17race'], $_REQUEST['joueur18race'], $_REQUEST['joueur19race'], $_REQUEST['joueur20race'], $_REQUEST['joueur21race'], $_REQUEST['joueur22race'], $_REQUEST['joueur23race'], $_REQUEST['joueur24race'], $_REQUEST['joueur25race'], $_REQUEST['joueur26race'], $_REQUEST['joueur27race'], $_REQUEST['joueur28race'], $_REQUEST['joueur29race'], $_REQUEST['joueur30race'], $_REQUEST['joueur31race'], $_REQUEST['joueur32race'], $_REQUEST['joueur33race'], $_REQUEST['joueur34race'], $_REQUEST['joueur35race'], $_REQUEST['joueur36race'], $_REQUEST['joueur37race'], $_REQUEST['joueur38race'], $_REQUEST['joueur39race'], $_REQUEST['joueur40race'], $_REQUEST['joueur41race'], $_REQUEST['joueur42race'], $_REQUEST['joueur43race'], $_REQUEST['joueur44race'], $_REQUEST['joueur45race'], $_REQUEST['joueur46race'], $_REQUEST['joueur47race'], $_REQUEST['joueur48race'], $_REQUEST['joueur49race'], $_REQUEST['joueur50race'], $_REQUEST['joueur51race'], $_REQUEST['joueur52race'], $_REQUEST['joueur53race'], $_REQUEST['joueur54race'], $_REQUEST['joueur55race'], $_REQUEST['joueur56race'], $_REQUEST['joueur57race'], $_REQUEST['joueur58race'], $_REQUEST['joueur59race'], $_REQUEST['joueur60race'], $_REQUEST['joueur61race'], $_REQUEST['joueur62race'], $_REQUEST['joueur63race'], $_REQUEST['joueur64race'], $_REQUEST['joueur65race'], $_REQUEST['joueur66race'], $_REQUEST['joueur67race'], $_REQUEST['joueur68race'], $_REQUEST['joueur69race'], $_REQUEST['joueur70race'], $_REQUEST['texte']);
		closetable();
		break;
		
		case "do_dl":
		opentable();
		do_dl($_REQUEST['dl_id']);
		closetable();
		break;
		
		default:
		index();
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