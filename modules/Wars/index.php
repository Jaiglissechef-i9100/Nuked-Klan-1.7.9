<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die('<div style="text-align:center;">You cannot open this page directly</div>');

global $nuked, $language, $user;
translate('modules/Wars/lang/' . $language . '.lang.php');

$visiteur = !$user ? 0 : $user[1];
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1){
    compteur('Wars');

    function index(){
        global $bgcolor1, $bgcolor2, $bgcolor3, $nuked, $theme, $language;

        opentable();

        $sql = mysql_query('SELECT warid FROM '.WARS_TABLE.' WHERE etat = 1');
        $nb_matchs = mysql_num_rows($sql);

        if ($nb_matchs > 0){
            $sql_victory = mysql_query('SELECT warid FROM '.WARS_TABLE.' WHERE etat = 1 AND tscore_team > tscore_adv');
            $nb_victory = mysql_num_rows($sql_victory);
    
            $sql_defeat = mysql_query('SELECT warid FROM '.WARS_TABLE.' WHERE etat = 1 AND tscore_adv > tscore_team');
            $nb_defeat = mysql_num_rows($sql_defeat);
    
            $nb_nul = $nb_matchs - ($nb_victory + $nb_defeat);
        }
        else{
            $nb_victory = 0;
            $nb_defeat = 0;
            $nb_nul = 0;
        }

        $nb_wars = $nuked['max_wars'];
        
        if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        
        $start = $_REQUEST['p'] * $nb_wars - $nb_wars;

        if ($nb_matchs == 0){
            echo '<br /><div style="text-align: center"><big><b>'._MATCHES.' - '.$nuked['name'].'</b></big></div>
                    <br /><div style="text-align: center;">'._NOMATCH.'</div><br />';
        } 
        else{
            $sql2 = mysql_query('SELECT A.titre, B.team FROM '.TEAM_TABLE.' AS A LEFT JOIN '.WARS_TABLE.' AS B ON A.cid = B.team WHERE B.etat = 1 GROUP BY B.team ORDER BY A.ordre, A.titre');
            $nb_team = mysql_num_rows($sql2);

            if (!$_REQUEST['tid'] && $nb_team > 1){
                while (list($team_name, $team) = mysql_fetch_array($sql2)){
                    if ($team_name != ''){
                        $team_name = printSecuTags($team_name);
                    }
                    else{
                        $team_name = $nuked['name'];
                    } 

                    echo '<br /><div style="text-align: center"><big><b>'._MATCHES.' - </b></big><a href="index.php?file=Wars&amp;tid='.$team.'"><b><big>'.$team_name.'</b></big></a></div>
                            <table style="margin-left: auto;margin-right: auto;text-align: left;background: '.$bgcolor2.';border: 1px solid '.$bgcolor3.';" width="100%" cellpadding="2" cellspacing="1">
                            <tr style="background: '.$bgcolor3.'">
                            <td style="width: 5%;">&nbsp;</td>
                            <td style="width: 10%;"><b>'._DATE.'</b></td>
                            <td style="width: 30%;text-align:center;"><b>'._OPPONENT.'</b></td>
                            <td style="width: 15%;text-align:center;"><b>'._TYPE.'</b></td>
                            <td style="width: 15%;text-align:center;"><b>'._RESULT.'</b></td>
                            <td style="width: 10%;text-align:center;"><b>'._DETAILS.'</b></td></tr>';

                    $sql6 = mysql_query('SELECT warid FROM '.WARS_TABLE.' WHERE etat = 1 AND team = \''.$team.'\' ');
                    $count = mysql_num_rows($sql6);

                    $sql4 = mysql_query('SELECT warid, adversaire, url_adv, pays_adv, type, game, date_jour, date_mois, date_an, tscore_team, tscore_adv FROM '.WARS_TABLE.' WHERE etat = 1 AND team = '.$team.' ORDER BY date_an DESC, date_mois DESC, date_jour DESC LIMIT 0, 10');
                    while (list($war_id, $adv_name, $adv_url, $pays_adv, $type, $game, $jour, $mois, $an, $score_team, $score_adv) = mysql_fetch_array($sql4)){
                        $adv_name = printSecuTags($adv_name);
                        $type = printSecuTags($type);
                        $style = printSecuTags($style);

                        list ($pays, $ext) = explode ('.', $pays_adv);

                        if ($language == 'french'){
                            $date = $jour . '/' . $mois . '/' . $an;
                        } 
                        else{
                            $date = $mois . '/' . $jour . '/' . $an;
                        } 

                        if ($score_team > $score_adv){
                            $color = '#009900';
                        } 
                        else if ($score_team < $score_adv){
                            $color = '#990000';
                        } 
                        else{
                            $color = '#3333FF';
                        } 

                        if ($j == 0){
                            $bg = $bgcolor2;
                            $j++;
                        } 
                        else{
                            $bg = $bgcolor1;
                            $j = 0;
                        } 

                        $sql5 = mysql_query('SELECT name, icon FROM ' . GAMES_TABLE . ' WHERE id = \'' . $game . '\' ');
                        list($game_name, $icon) = mysql_fetch_array($sql5);
                        $game_name = printSecuTags($game_name);

                        if ($icon != '' && is_file($icon)){
                            $icone = $icon;
                        } 
                        else{
                            $icone = 'images/games/nk.gif';
                        } 

                        echo '<tr style="background: '. $bg . '">
                                <td style="width: 5%;text-align:center;">&nbsp;<img src="' . $icone . '" alt="" title="' . $game_name . '" /></td>
                                <td style="width: 10%;text-align:center;">' . $date . '</td>
                                <td style="width: 30%;text-align:center;"><img src="images/flags/' . $pays_adv . '" alt="" title="' . $pays . '" /> ';

                        if ($adv_url != ''){
                            echo '<a href="' . $adv_url . '" onclick="window.open(this.href); return false;">' . $adv_name . '</a>';
                        } 
                        else{
                            echo $adv_name;
                        } 

                        if (is_file('themes/' . $theme . '/images/report.png')){
                            $img = 'themes/' . $theme . '/images/report.png';
                        } 
                        else{
                            $img = 'modules/Wars/images/report.png';
                        } 

                        echo '</td><td style="width: 15%;text-align:center;">' . $type . '</td>
                                <td style="background: ' . $color . ';width: 15%;text-align:center;"><span style="color: #FFFFFF;"><b>' . $score_team . '/' . $score_adv . '</b></span></td>
                                <td style="width: 10%;text-align:center;"><a href="index.php?file=Wars&amp;op=detail&amp;war_id=' . $war_id . '"><img style="border: 0;" src="' . $img . '" alt="" /></a></td></tr>';
                    } 
                    echo '</table>';

                    if ($count > 10){
                        echo '<div style="text-align: right;"><a href="index.php?file=Wars&amp;tid=' . $team . '">' . _MORE . '</a></div>';
                    } 
                    $j = 0;
                } 
            } 
            else{
                $nb_wars = $nuked['max_wars'];
                
                if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
                
                $start = $_REQUEST['p'] * $nb_wars - $nb_wars;

                if (!$_REQUEST['tid'] && $team > 0){
                    $_REQUEST['tid'] = $team;
                } 

                if ($_REQUEST['tid'] != ''){
                    $sql6 = mysql_query('SELECT titre FROM ' . TEAM_TABLE . ' WHERE cid = \'' . $_REQUEST['tid'] . '\' ');
                    list($team_name, $team) = mysql_fetch_array($sql6);
                    $team_name = printSecuTags($team_name);
                    $and = 'AND team = \'' . $_REQUEST['tid'] . '\' ';
                    $sql7 = mysql_query('SELECT warid FROM ' . WARS_TABLE . ' WHERE etat = 1 AND team = \'' . $_REQUEST['tid'] . '\' ');
                    $count = mysql_num_rows($sql7);
                } 
                else{
                    $team_name = $nuked['name'];
                    $and = '';
                    $count = $nb_matchs;
                } 

                echo '<br /><div style="text-align: center;"><big><b>' . _MATCHES . ' - ' . $team_name . '</b></big></div>';

                if (!$_REQUEST['orderby']){
                    $_REQUEST['orderby'] = 'date';
                } 

                if ($_REQUEST['orderby'] == 'date'){
                    $order = 'ORDER BY date_an DESC, date_mois DESC, date_jour DESC';
                } 
                else if ($_REQUEST['orderby'] == 'adver'){
                    $order = 'ORDER BY adversaire';
                } 
                else if ($_REQUEST['orderby'] == 'game'){
                    $order = 'ORDER BY game';
                } 
                else if ($_REQUEST['orderby'] == 'type'){
                    $order = 'ORDER BY type';
                } 
                else if ($_REQUEST['orderby'] == 'style'){
                    $order = 'ORDER BY style';
                } 
                else{
                    $order = 'ORDER BY date_an DESC, date_mois DESC, date_jour DESC';
                } 

                if ($count > 1){
                    echo '<br /><table width="100%"><tr><td style="text-align:right;">' . _ORDERBY . ' : </b>';

                    if ($_REQUEST['orderby'] == 'date'){
                        echo '<b>' . _DATE . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Wars&amp;tid=' . $_REQUEST['tid'] . '&amp;orderby=date">' . _DATE . '</a> | ';
                    } 

                    if ($_REQUEST['orderby'] == 'adver'){
                        echo '<b>' . _OPPONENT . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Wars&amp;tid=' . $_REQUEST['tid'] . '&amp;orderby=adver">' . _OPPONENT . '</a> | ';
                    } 

                    if ($_REQUEST['orderby'] == 'game'){
                        echo '<b>' . _GAME . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Wars&amp;tid=' . $_REQUEST['tid'] . '&amp;orderby=game">' . _GAME . '</a> | ';
                    }

                    if ($_REQUEST['orderby'] == 'type'){
                        echo '<b>' . _TYPE . '</b> | ';
                    } 
                    else{
                        echo '<a href="index.php?file=Wars&amp;tid=' . $_REQUEST['tid'] . '&amp;orderby=type">' . _TYPE . '</a> | ';
                    }

                    echo '</td></tr></table>';
                } 

                if ($count > $nb_wars){
                    $url_page = 'index.php?file=Wars&amp;tid=' . $_REQUEST['tid'] . '&amp;orderby=' . $_REQUEST['orderby'];
                    number($count, $nb_wars, $url_page);
                } 
    
                echo '<table style="margin-left: auto;margin-right: auto;text-align: left;background: ' . $bgcolor2 . ';border: 1px solid ' . $bgcolor3 . ';" width="100%" cellpadding="2" cellspacing="1">
                <tr style="background: ' . $bgcolor3 . '">
                <td style="width: 5%;">&nbsp;</td>
                <td style="width: 10%;"><b>' . _DATE . '</b></td>
                <td style="width: 30%;text-align:center;"><b>' . _OPPONENT . '</b></td>
                <td style="width: 15%;text-align:center;"><b>' . _TYPE . '</b></td>
                <td style="width: 15%;text-align:center;"><b>' . _RESULT . '</b></td>
                <td style="width: 10%;text-align:center;"><b>' . _DETAILS . '</b></td></tr>';

                $sql4 = mysql_query('SELECT warid, adversaire, url_adv, pays_adv, type, game, date_jour, date_mois, date_an, tscore_team, tscore_adv FROM ' . WARS_TABLE . ' WHERE etat = 1 ' . $and . $order . ' LIMIT ' . $start . ',' . $nb_wars.' ');
                while (list($war_id, $adv_name, $adv_url, $pays_adv, $type, $game, $jour, $mois, $an, $score_team, $score_adv) = mysql_fetch_array($sql4)){
                    $adv_name = printSecuTags($adv_name);
                    $type = printSecuTags($type);
                    
                    list ($pays, $ext) = explode ('.', $pays_adv);

                    if ($language == 'french'){
                        $date = $jour . '/' . $mois . '/' . $an;
                    } 
                    else{
                        $date = $mois . '/' . $jour . '/' . $an;
                    } 

                    if ($score_team > $score_adv){
                        $color = '#009900';
                    } 
                    else if ($score_team < $score_adv){
                        $color = '#990000';
                    } 
                    else{
                        $color = '#3333FF';
                    } 

                    if ($j == 0){
                        $bg = $bgcolor2;
                        $j++;
                    } 
                    else{
                        $bg = $bgcolor1;
                        $j = 0;
                    } 

                    $sql5 = mysql_query('SELECT name, icon FROM ' . GAMES_TABLE . ' WHERE id = \'' . $game . '\' ');
                    list($game_name, $icon) = mysql_fetch_array($sql5);
                    $game_name = printSecuTags($game_name);

                    if ($icon != '' && is_file($icon)){
                        $icone = $icon;
                    } 
                    else{
                        $icone = 'images/games/nk.gif';
                    }

                    echo '<tr style="background: '. $bg . '">
                            <td style="width: 5%;">&nbsp;<img src="' . $icone . '" alt="" title="' . $game_name . '" /></td>
                            <td style="width: 10%;text-align:center;">' . $date . '</td>
                            <td style="width: 30%;text-align:center;"><img src="images/flags/' . $pays_adv . '" alt="" title="' . $pays . '" />';
                            
                    if ($adv_url != ''){
                        echo '<a href="' . $adv_url . '" onclick="window.open(this.href); return false;">' . $adv_name . '</a>';
                    } 
                    else{
                        echo $adv_name;
                    } 

                    if (is_file('themes/' . $theme . '/images/report.png')){
                        $img = 'themes/' . $theme . '/images/report.png';
                    } 
                    else{
                        $img = 'modules/Wars/images/report.png';
                    } 

                    echo '</td><td style="width: 15%;text-align:center;">' . $type . '';

				
      /*   $sqlmap = mysql_query('SELECT map FROM ' . WARS_TABLE . ' WHERE warid = \'' . $war_id . '\' ');
		list($map) = mysql_fetch_array($sqlmap);
		$map = explode('|', $map);;
		$sizemap = count($map);
		echo  '<table><tr><td>' . $type . '</td><td><table>';
		for ($nbr=0; $nbr <= $sizemap; $nbr++){
			echo '<tr><td><img src="images/maps/' . $map[$nbr-1] . '.jpg" height="30" title="' . $map[$nbr-1] . '"></td></tr>';
		}
		echo  '</table></td></tr></table>'; */

					echo'</td>
                    <td style="background: ' . $color . ';width: 15%;text-align:center;"><span style="color: #FFFFFF;"><b>' . $score_team . '/' . $score_adv . '</b></span></td>
                    <td style="width: 10%;text-align:center;"><a href="index.php?file=Wars&amp;op=detail&amp;war_id=' . $war_id . '"><img style="border: 0;" src="' . $img . '" alt="" /></a></td></tr>';
                }
                
                echo '</table>';

                if ($count > $nb_wars){
                    $url_page = 'index.php?file=Wars&amp;tid=' . $_REQUEST['tid'] . '&amp;orderby=' . $_REQUEST['orderby'];
                    number($count, $nb_wars, $url_page);
                } 
            } 
        } 

        if ($nb_matchs > 0){
            if ($nb_matchs > 1) $war = _MATCHES; else $war = _MATCH;
            echo '<br /><div style="text-align: center;"><small><b>' . $nb_matchs . '</b> ' . $war . ' : <b><span style="color: #009900;">' . $nb_victory . '</span></b> ' . _WIN . ' - <b><span style="color: #990000;">' . $nb_defeat . '</span></b> ' . _LOST . ' - <b><span style="color: #3333FF;">' . $nb_nul . '</span></b> ' . _DRAW . '</small></div><br />';
        }

        if ($_REQUEST['p'] == 1 OR !isset($_REQUEST['p'])){
            $sqlx = mysql_query("SELECT warid FROM " . WARS_TABLE . " WHERE etat = 0");
            $nb_matchs2 = mysql_num_rows($sqlx);

            if ($nb_matchs2 > 0){
                echo '<br /><div style="text-align: center;"><big><b>' . _NEXTMATCHES . '</b></big></div><br />';
                
                echo '<table style="margin-left: auto;margin-right: auto;text-align: left;background: ' . $bgcolor2 . ';border: 1px solid ' . $bgcolor3 . ';" width="100%" cellpadding="2" cellspacing="1">
                        <tr style="background: ' . $bgcolor3 . '">
                        <td style="width: 5%;">&nbsp;</td>
                        <td style="width: 10%;text-align:center;"><b>' . _DATE . '</b></td>
                        <td style="width: 30%;text-align:center;"><b>' . _OPPONENT . '</b></td>
                        <td style="width: 20%;text-align:center;"><b>' . _TYPE . '</b></td>
                        <td style="width: 15%;text-align:center;"><b>' . _DETAILS2 . '</b></td>';

                $sql4x = mysql_query('SELECT warid, adversaire, url_adv, pays_adv, type, game, date_jour, date_mois, date_an, tscore_team, tscore_adv FROM ' . WARS_TABLE . ' WHERE etat = 0 ' . $and . $order . ' LIMIT ' . $start . ',' . $nb_wars.' ');
                while (list($war_id, $adv_name, $adv_url, $pays_adv, $type, $game, $jour, $mois, $an, $score_team, $score_adv) = mysql_fetch_array($sql4x)){
                    $adv_name = printSecuTags($adv_name);
                    $type = printSecuTags($type);

                    list ($pays, $ext) = explode ('.', $pays_adv);

                    if ($language == 'french'){
                        $date = $jour . '/' . $mois . '/' . $an;
                    } 
                    else{
                        $date = $mois . '/' . $jour . '/' . $an;
                    } 

                    if ($score_team > $score_adv){
                        $color = '#009900';
                    } 
                    else if ($score_team < $score_adv){
                        $color = '#990000';
                    } 
                    else{
                        $color = '#3333FF';
                    } 

                    if ($j == 0){
                        $bg = $bgcolor2;
                        $j++;
                    } 
                    else{
                        $bg = $bgcolor1;
                        $j = 0;
                    } 

                    $sql5 = mysql_query('SELECT name, icon FROM ' . GAMES_TABLE . ' WHERE id = \'' . $game . '\' ');
                    list($game_name, $icon) = mysql_fetch_array($sql5);
                    $game_name = printSecuTags($game_name);

                    if ($icon != '' && is_file($icon)){
                        $icone = $icon;
                    } 
                    else{
                        $icone = 'images/games/nk.gif';
                    }

                    echo '<tr style="background: '. $bg . '">
                            <td style="width: 5%;text-align:center;">&nbsp;<img src="' . $icone . '" alt="" title="' . $game_name . '" /></td>
                            <td style="width: 10%;text-align:center;">' . $date . '</td>
                            <td style="width: 30%;text-align:center;"><img src="images/flags/' . $pays_adv . '" alt="" title="' . $pays . '" />';
                    
                    if ($adv_url != ''){
                        echo '<a href="' . $adv_url . '" onclick="window.open(this.href); return false;">' . $adv_name . '</a>';
                    } 
                    else{
                        echo $adv_name;
                    } 

                    if (is_file('themes/' . $theme . '/images/report.png')){
                        $img = 'themes/' . $theme . '/images/report.png';
                    } 
                    else{
                        $img = 'modules/Wars/images/report.png';
                    } 

                    echo '</td><td style="width: 20%;text-align:center;">' . $type . '</td>
                            <td style="width: 15%;text-align:center;"><a href="index.php?file=Wars&amp;op=detail&amp;war_id=' . $war_id . '"><img style="border: 0;" src="' . $img . '" alt="" /></a></td>';
                } 
                echo '</table>';
            }
        }
        closetable();
    } 

    function detail($war_id){
        global $nuked, $user, $visiteur, $language, $bgcolor1, $bgcolor2, $bgcolor3;

        opentable();

        echo '<script type="text/javascript"><!--'."\n"
        . 'document.write(\'<link rel="stylesheet" type="text/css" href="media/shadowbox/shadowbox.css">\');'."\n"
        . '--></script>'."\n"
        . '<script type="text/javascript" src="media/shadowbox/shadowbox.js"></script>'."\n"
        . '<script type="text/javascript">'."\n"
        . 'Shadowbox.init();'."\n"
        . '</script>'."\n";

        $sql = mysql_query('SELECT warid, etat, team, game, adversaire, url_adv, pays_adv, date_jour, date_mois, date_an, heure, type, style, tscore_team, tscore_adv, map, score_adv, score_team, report, auteur, url_league FROM ' . WARS_TABLE . ' WHERE warid = \'' . $war_id . '\' ');
         if(mysql_num_rows($sql) <= 0){
            redirect('index.php?file=404', 0);
            exit();
        } 
        
        list($warid, $etat, $team, $game, $adv_name, $adv_url, $pays_adv, $jour, $mois, $an, $heure, $type, $style, $tscore_team, $tscore_adv, $map, $score_team, $score_adv, $report, $auteur, $url_league) = mysql_fetch_array($sql);
        list ($pays, $ext) = explode ('.', $pays_adv);    
		
        $sqlico = mysql_query('SELECT name, icon FROM ' . GAMES_TABLE . ' WHERE id = \'' . $game . '\' ');
 		list($name_game, $icon) = mysql_fetch_array($sqlico);
		
		$adv_name = printSecuTags($adv_name);
        $type = printSecuTags($type);
        $style = printSecuTags($style);
        $score_adv = printSecuTags($score_adv);
        $score_team = printSecuTags($score_team);
        $map = explode('|', $map);;
        $score_team = explode('|', $score_team);;
        $score_adv = explode('|', $score_adv);;

        if ($language == 'french'){
            $date = $jour . '/' . $mois . '/' . $an;
        } 
        else{
            $date = $mois . '/' . $jour. '/' . $an;
        } 

        if ($team > 0){
            $sql_team = mysql_query('SELECT titre FROM ' . TEAM_TABLE . ' WHERE cid = \'' . $team . '\' ');
            list($team_name) = mysql_fetch_array($sql_team);
            $team_name = printSecuTags($team_name);
        } 
        else{
            $team_name = $nuked['name'];
        }

        if ($visiteur >= admin_mod('Wars')){
            ?>
            <script type="text/javascript">
            function delmatch(adversaire, id){
                if (confirm('<?php echo _DELETEMATCH; ?>'+adversaire+' ! <?php echo _CONFIRM; ?>')){
                    document.location.href = 'index.php?file=Wars&page=admin&op=del_war&war_id='+id;
                }
            }
            </script>
            <?php
		
            echo '<div style="text-align: right;"><a href="index.php?file=Wars&amp;page=admin&amp;op=match&amp;do=edit&amp;war_id=' . $war_id . '"><img style="border: 0;" src="images/edition.gif" alt="" title="' . _EDIT . '" /></a>
                    &nbsp;<a href="javascript:delmatch(\''. mysql_real_escape_string(stripslashes($adv_name)) . '\', \'' . $war_id . '\');"><img style="border: 0;" src="images/delete.gif" alt="" title="' . _DEL . '" /></a>&nbsp;</div>';
        } 

		echo '<br /><table style="margin-left: auto;margin-right: auto;text-align: left;" width="90%" border="0" cellpadding="3" cellspacing="3">
			<tr><td width="30%" style="text-align:center;"><H1><b>' . $team_name . '</b></H1><br/><img style="min-width:100px;min-height:100px;max-width:100px;max-height:100px;" src="images/logo_eq.png"></td>
			<td width="30%" style="text-align:center;"><img src="'.$icon.'"><br /><H2>' . $type . '</H2><br /><H1>' . _VS . '</H1><br />';
        if($etat != 0){
            if ($tscore_team < $tscore_adv){
                echo '<H1><span style="color: #990000;"><b>' . $tscore_team . '</b></span> - <span style="color: #009900;"><b>' . $tscore_adv . '</b></span></H1>';
            } 
            else if ($tscore_team > $tscore_adv){
                echo '<H1><span style="color: #009900;"><b>' . $tscore_team . '</b></span> - <span style="color: #990000;"><b>' . $tscore_adv . '</b></span></H1>';
            } 
            else{
                echo '<H1><b>' . $tscore_team . ' - ' . $tscore_adv . '</b></H1>';
            }
        }			
			echo'<br /><H1>' . $date . '<br />' . $heure . '</H1></td>
			<td width="30%" style="text-align:center;"><H1><b>';
        if ($adv_url != ''){
			$adv_name = '<a href="' . $adv_url . '" onclick="window.open(this.href); return false;">' . $adv_name . '</a>';
        } 
        else{
            $adv_name = "$adv_name";
        }
		if ($style == '') {
			echo'' . $adv_name . '</b></H1><br/><img style="min-width:100px;min-height:100px;max-width:100px;max-height:100px;" src="images/noimagefile.gif"></td></tr>';
		} else {
			echo'' . $adv_name . '</b></H1><br/><img style="min-width:100px;min-height:100px;max-width:100px;max-height:100px;" src="'.$style.'"></td></tr>';
		}
		$size = count($map);			
			
if ($size == 1) {

			echo'<tr><td style="text-align:center;" valign="top" colspan="3"><H2>' . $map[0] . '<br/><img src="images/maps/' . $name_game . '/' . $map[0] . '.jpg"></H2><br/>';
			echo'</td></tr>';

}

if ($size >= 2) {			
			echo'<tr><td style="text-align:center;" valign="top" rowspan="2"><H2>' . $map[0] . '<br/><img src="images/maps/' . $name_game . '/' . $map[0] . '.jpg"></H2><br/>';
				if ($etat != 0){
					if ($score_team[0] > $score_adv[0]){
						echo '<H1><span style="color: #990000;"><b>' . $score_adv[0] . '</b></span> - <span style="color: #009900;"><b>' . $score_team[0] . '</b></span></H1><br />';
					} 
					else if ($score_team[0] < $score_adv[0]){
						echo '<H1><span style="color: #009900;"><b>' . $score_adv[0] . '</b></span> - <span style="color: #990000;"><b>' . $score_team[0] . '</b></span></H1><br />';
					} 
					else{
						echo '<H1><b>' . $score_team[0] . ' - ' . $score_adv[0] . '</b></H1><br />';
					} 
				}			
			echo'</td>
			<td height="30"></td>
			<td style="text-align:center;" valign="top" rowspan="2"><H2>' . $map[1] . '<br/><img src="images/maps/' . $name_game . '/' . $map[1] . '.jpg"></H2><br/>';
				if ($etat != 0){
					if ($score_team[1] > $score_adv[1]){
						echo '<H1><span style="color: #990000;"><b>' . $score_adv[1] . '</b></span> - <span style="color: #009900;"><b>' . $score_team[1] . '</b></span></H1><br />';
					} 
					else if ($score_team[1] < $score_adv[1]){
						echo '<H1><span style="color: #009900;"><b>' . $score_adv[1] . '</b></span> - <span style="color: #990000;"><b>' . $score_team[1] . '</b></span></H1><br />';
					} 
					else{
						echo '<H1><b>' . $score_team[1] . ' - ' . $score_adv[1] . '</b></H1><br />';
					} 
				}
			echo'</td></tr><tr>
			<td style="text-align:center;">';
if ($size > 2) {
			echo'<H2>' . $map[2] . '<br/><img src="images/maps/' . $name_game . '/' . $map[2] . '.jpg"></H2><br/>';
				if ($etat != 0){
					if ($score_team[2] > $score_adv[2]){
						echo '<H1><span style="color: #990000;"><b>' . $score_adv[2] . '</b></span> - <span style="color: #009900;"><b>' . $score_team[2] . '</b></span></H1><br />';
					} 
					else if ($score_team[2] < $score_adv[2]){
						echo '<H1><span style="color: #009900;"><b>' . $score_adv[2] . '</b></span> - <span style="color: #990000;"><b>' . $score_team[2] . '</b></span></H1><br />';
					} 
					else{
						echo '<H1><b>' . $score_team[2] . ' - ' . $score_adv[2] . '</b></H1><br />';
					} 
				}
}
			echo'</td></tr>';
}

echo'</table>';

if ($size > 3) {			
			echo'<center><table>';

        for ($nbr=4; $nbr <= $size; $nbr++){

			echo'<tr><td style="text-align:center;" valign="top"><H1>' . $map[$nbr-1] . '<br/><img src="images/maps/' . $name_game . '/' . $map[$nbr-1] . '.jpg"></H2><br/>';
				if ($etat != 0){
					if ($score_team[$nbr-1] < $score_adv[$nbr-1]){
						echo '<H1><span style="color: #990000;"><b>' . $score_adv[$nbr-1] . '</b></span> - <span style="color: #009900;"><b>' . $score_team[$nbr-1] . '</b></span></H1><br />';
					} 
					else if ($score_team[$nbr-1] > $score_adv[$nbr-1]){
						echo '<H1><span style="color: #009900;"><b>' . $score_adv[$nbr-1] . '</b></span> - <span style="color: #990000;"><b>' . $score_team[$nbr-1] . '</b></span></H1><br />';
					} 
					else{
						echo '<H1><b>' . $score_team[$nbr-1] . ' - ' . $score_adv[$nbr-1] . '</b></H1><br />';
					} 
				}			
			echo'</td></tr>';

		}

		echo'</table></center>';
}

        $sql = mysql_query('SELECT active FROM ' . $nuked['prefix'] . '_comment_mod WHERE module = \'wars\' ');
        list($active) = mysql_fetch_array($sql);
                
        if($active ==1 && $visiteur >= nivo_mod('Comment') && nivo_mod('Comment') > -1){
        echo '<table style="margin-left: auto;margin-right: auto;text-align: left;" width="80%" border="0" cellspacing="3" cellpadding="3"><tr><td>';

            include ('modules/Comment/index.php');
            com_index('match', $war_id);

            echo '</td></tr></table>';
        }
        closetable();
    } 

    switch ($_REQUEST['op']){
        case 'index':
            index();
            break;

        case 'detail':
            detail($_REQUEST['war_id']);
            break;

        default:
            index();
            break;
    } 

} 
else if ($level_access == -1){
    opentable();
    echo '<br /><br /><div style="text-align: center;">' . _MODULEOFF . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a><br /><br /></div>';
    closetable();
} 
else if ($level_access == 1 && $visiteur == 0){
    opentable();
    echo '<br /><br /><div style="text-align: center;">' . _USERENTRANCE . '<br /><br /><b><a href="index.php?file=User&amp;op=login_screen">' . _LOGINUSER . '</a> | <a href="index.php?file=User&amp;op=reg_screen">' . _REGISTERUSER . '</a></b><br /><br /></div>';
    closetable();
} 
else{
    opentable();
    echo '<br /><br /><div style="text-align: center;">' . _NOENTRANCE . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a><br /><br /></div>';
    closetable();
} 
?>